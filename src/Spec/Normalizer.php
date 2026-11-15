<?php

namespace SamuelOlavo\LaravelXibo\Spec;

use SamuelOlavo\LaravelXibo\Exceptions\InvalidSpecification;

final class Normalizer
{
    private const METHODS = ['get', 'post', 'put', 'patch', 'delete', 'head', 'options'];

    public function normalize(array $document): Catalog
    {
        $swagger2 = ($document['swagger'] ?? null) === '2.0';
        $openapi3 = str_starts_with((string) ($document['openapi'] ?? ''), '3.');
        if ((! $swagger2 && ! $openapi3) || ! isset($document['paths']) || ! is_array($document['paths'])) {
            throw new InvalidSpecification('Expected a Swagger 2.0 or OpenAPI 3.x document with paths.');
        }

        $catalog = new Catalog();
        foreach ($document['paths'] as $path => $pathItem) {
            if (! is_array($pathItem)) {
                continue;
            }
            $pathParameters = $pathItem['parameters'] ?? [];
            foreach (self::METHODS as $method) {
                if (! isset($pathItem[$method]) || ! is_array($pathItem[$method])) {
                    continue;
                }
                $raw = $pathItem[$method];
                $id = (string) ($raw['operationId'] ?? "{$method}:{$path}");
                if ($catalog->has($id)) {
                    // Some Xibo 4.x specifications reuse operationId for distinct routes.
                    $id = "{$method}:{$path}";
                }
                $parameters = array_map(
                    fn ($item) => $this->resolve($document, $item),
                    array_merge($pathParameters, $raw['parameters'] ?? []),
                );

                $mediaType = null;
                $properties = [];
                $required = [];
                if ($swagger2) {
                    $bodyFields = array_values(array_filter($parameters, fn ($item) => ($item['in'] ?? '') === 'formData'));
                    $bodyParameters = array_values(array_filter($parameters, fn ($item) => ($item['in'] ?? '') === 'body'));
                    $parameters = array_values(array_filter($parameters, fn ($item) => ! in_array(($item['in'] ?? ''), ['formData', 'body'], true)));
                    if ($bodyFields) {
                        $hasFile = count(array_filter($bodyFields, fn ($item) => ($item['type'] ?? '') === 'file')) > 0;
                        $mediaType = ($raw['consumes'][0] ?? $document['consumes'][0]
                            ?? ($hasFile ? 'multipart/form-data' : 'application/x-www-form-urlencoded'));
                        $properties = $bodyFields;
                        $required = array_column(array_filter($bodyFields, fn ($item) => $item['required'] ?? false), 'name');
                    } elseif ($bodyParameters) {
                        $mediaType = $raw['consumes'][0] ?? $document['consumes'][0] ?? 'application/json';
                        foreach ($bodyParameters as $parameter) {
                            $properties[] = ['name' => $parameter['name'], 'required' => (bool) ($parameter['required'] ?? false)]
                                + $this->resolve($document, $parameter['schema'] ?? []);
                        }
                        $required = array_column(array_filter($bodyParameters, fn ($item) => $item['required'] ?? false), 'name');
                    }
                } elseif (isset($raw['requestBody'])) {
                    $body = $this->resolve($document, $raw['requestBody']);
                    $content = $body['content'] ?? [];
                    $mediaType = array_key_first($content);
                    if ($mediaType !== null) {
                        $schema = $this->resolve($document, $content[$mediaType]['schema'] ?? []);
                        $required = $schema['required'] ?? [];
                        foreach ($schema['properties'] ?? [] as $name => $definition) {
                            $properties[] = ['name' => $name, 'required' => in_array($name, $required, true)]
                                + $this->resolve($document, $definition);
                        }
                    }
                }

                $responses = [];
                foreach ($raw['responses'] ?? [] as $response) {
                    foreach (array_keys($response['content'] ?? []) as $type) {
                        $responses[$type] = true;
                    }
                }
                $catalog->add(new Operation(
                    $id,
                    strtoupper($method),
                    (string) $path,
                    $parameters,
                    $mediaType,
                    $properties,
                    $required,
                    array_keys($responses),
                    $raw['tags'] ?? [],
                ));
            }
        }

        return $catalog;
    }

    private function resolve(array $document, array $value): array
    {
        if (! isset($value['$ref'])) {
            return $value;
        }
        $ref = (string) $value['$ref'];
        if (! str_starts_with($ref, '#/')) {
            throw new InvalidSpecification("External reference [{$ref}] is not supported.");
        }
        $target = $document;
        foreach (explode('/', substr($ref, 2)) as $part) {
            $part = str_replace(['~1', '~0'], ['/', '~'], $part);
            if (! is_array($target) || ! array_key_exists($part, $target)) {
                throw new InvalidSpecification("Broken reference [{$ref}].");
            }
            $target = $target[$part];
        }
        return is_array($target) ? $target : throw new InvalidSpecification("Invalid reference [{$ref}].");
    }
}
