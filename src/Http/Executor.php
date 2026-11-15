<?php

namespace SamuelOlavo\LaravelXibo\Http;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use SamuelOlavo\LaravelXibo\Auth\TokenProvider;
use SamuelOlavo\LaravelXibo\Connections\ConnectionConfig;
use SamuelOlavo\LaravelXibo\Exceptions\XiboRequestFailed;
use SamuelOlavo\LaravelXibo\Spec\Operation;

final class Executor
{
    public function __construct(private readonly TokenProvider $tokens) {}

    public function execute(ConnectionConfig $connection, Operation $operation, OperationRequest $input): XiboResponse
    {
        $path = $operation->path;
        foreach ($operation->parameters as $parameter) {
            if (($parameter['in'] ?? '') !== 'path') continue;
            $name = $parameter['name'];
            $optionalSegment = '[/{'.$name.'}]';
            if (str_contains($path, $optionalSegment)) {
                $replacement = array_key_exists($name, $input->path)
                    ? '/'.rawurlencode((string) $input->path[$name])
                    : '';
                $path = str_replace($optionalSegment, $replacement, $path);
                continue;
            }
            if (! array_key_exists($name, $input->path)) {
                throw new InvalidArgumentException("Missing Xibo path parameter [{$name}].");
            }
            $path = str_replace('{'.$name.'}', rawurlencode((string) $input->path[$name]), $path);
        }
        $lowerHeaders = array_change_key_case($input->headers, CASE_LOWER);
        foreach ($operation->parameters as $parameter) {
            if (! ($parameter['required'] ?? false)) continue;
            $name = (string) ($parameter['name'] ?? '');
            if (($parameter['in'] ?? '') === 'query' && ! array_key_exists($name, $input->query)) {
                throw new InvalidArgumentException("Missing Xibo query parameter [{$name}].");
            }
            if (($parameter['in'] ?? '') === 'header' && ! array_key_exists(strtolower($name), $lowerHeaders)) {
                throw new InvalidArgumentException("Missing Xibo header [{$name}].");
            }
        }
        if (preg_match('/\{[^}]+\}/', $path)) {
            throw new InvalidArgumentException('Missing Xibo path parameter.');
        }
        foreach ($operation->requiredBodyProperties as $name) {
            if (! array_key_exists($name, $input->body) && ! array_key_exists($name, $input->files)) {
                throw new InvalidArgumentException("Missing Xibo body field [{$name}].");
            }
        }

        $url = $connection->baseUrl().'/api/'.ltrim($path, '/');
        $query = $this->serializeQuery($operation, $input->query);
        if ($query !== '') $url .= '?'.$query;
        $response = $this->send($connection, $operation, $input, $url, $this->tokens->token($connection));
        if ($response->status() === 401 && $connection->token() === null) {
            $response = $this->send($connection, $operation, $input, $url, $this->tokens->refresh($connection));
        }
        if (! $response->successful()) {
            throw new XiboRequestFailed(new XiboResponse($response), "Xibo operation [{$operation->id}] failed with HTTP {$response->status()}.");
        }

        return new XiboResponse($response);
    }

    private function send(ConnectionConfig $connection, Operation $operation, OperationRequest $input, string $url, string $token): \Illuminate\Http\Client\Response
    {
        $request = Http::withToken($token)->timeout(60)->withoutRedirecting();
        if ($input->headers) $request = $request->withHeaders($input->headers);
        if ($input->sink !== null) $request = $request->withOptions(['sink' => $input->sink]);

        $body = $input->body;
        $type = $operation->requestMediaType;
        if ($input->files || $type === 'multipart/form-data') {
            $request = $request->asMultipart();
            foreach ($input->files as $name => $file) {
                if (is_string($file) && is_file($file)) {
                    $request->attach($name, fopen($file, 'rb'), basename($file));
                } elseif (is_resource($file)) {
                    $request->attach($name, $file);
                } elseif (is_array($file) && isset($file['contents'])) {
                    $request->attach($name, $file['contents'], $file['filename'] ?? null);
                } else {
                    throw new InvalidArgumentException("Invalid Xibo upload [{$name}].");
                }
            }
            return $request->send($operation->method, $url, ['multipart' => $this->normalizeValues($body)]);
        }
        if ($type === 'application/x-www-form-urlencoded' || ($operation->method === 'PUT' && $type === null)) {
            $formBody = [];
            foreach ($this->normalizeValues($body) as $name => $value) {
                $field = is_array($value) && str_ends_with((string) $name, '[]')
                    ? substr((string) $name, 0, -2)
                    : $name;
                $formBody[$field] = $value;
            }
            return $request->asForm()->send($operation->method, $url, ['form_params' => $formBody]);
        }
        if ($type === 'application/json' || $body) {
            return $request->asJson()->send($operation->method, $url, ['json' => $body]);
        }

        return $request->send($operation->method, $url);
    }

    private function normalizeValues(array $values): array
    {
        foreach ($values as $key => $value) {
            if (is_bool($value)) $values[$key] = $value ? '1' : '0';
        }
        return $values;
    }

    private function serializeQuery(Operation $operation, array $values): string
    {
        $pairs = [];
        foreach ($values as $name => $value) {
            $parameter = null;
            foreach ($operation->parameters as $candidate) {
                if (($candidate['in'] ?? '') === 'query' && ($candidate['name'] ?? '') === $name) {
                    $parameter = $candidate;
                    break;
                }
            }
            $items = is_array($value) ? array_values($value) : [$value];
            $isArray = is_array($value) && (($parameter['schema']['type'] ?? $parameter['type'] ?? '') === 'array');
            if ($isArray) {
                $format = $parameter['collectionFormat'] ?? null;
                $style = $parameter['style'] ?? 'form';
                $explode = $parameter['explode'] ?? ! isset($parameter['type']);
                if ($format === 'csv' || ($format === null && isset($parameter['type'])) || ! $explode) {
                    $items = [implode(',', array_map($this->scalar(...), $items))];
                } elseif ($style === 'spaceDelimited') {
                    $items = [implode(' ', array_map($this->scalar(...), $items))];
                } elseif ($style === 'pipeDelimited') {
                    $items = [implode('|', array_map($this->scalar(...), $items))];
                }
            }
            foreach ($items as $item) {
                $pairs[] = rawurlencode((string) $name).'='.rawurlencode($this->scalar($item));
            }
        }

        return implode('&', $pairs);
    }

    private function scalar(mixed $value): string
    {
        return is_bool($value) ? ($value ? '1' : '0') : (string) $value;
    }
}
