<?php

namespace SamuelOlavo\LaravelXibo;

use SamuelOlavo\LaravelXibo\Connections\ConnectionConfig;
use SamuelOlavo\LaravelXibo\Http\Executor;
use SamuelOlavo\LaravelXibo\Http\OperationRequest;
use SamuelOlavo\LaravelXibo\Http\XiboResponse;
use SamuelOlavo\LaravelXibo\Spec\Operation;
use SamuelOlavo\LaravelXibo\Spec\Repository;
use SamuelOlavo\LaravelXibo\Resources\ResourceAccessors;

final class XiboClient
{
    use ResourceAccessors;

    public function __construct(
        private readonly ConnectionConfig $config,
        private readonly Repository $specifications,
        private readonly Executor $executor,
    ) {}

    public function config(): ConnectionConfig
    {
        return $this->config;
    }

    public function call(string $operationId, array $input = []): XiboResponse
    {
        $operation = $this->specifications->for($this->config)->operation($operationId);

        return $this->executor->execute($this->config, $operation, OperationRequest::fromArray($input));
    }

    public function request(string $method, string $path, array $input = []): XiboResponse
    {
        if (! preg_match('~^/[A-Za-z0-9_/{}/.\-]+$~', $path) || str_contains($path, '..') || str_starts_with($path, '//')) {
            throw new \InvalidArgumentException('Raw Xibo path must be a relative API path.');
        }
        $method = strtoupper($method);
        if (! in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            throw new \InvalidArgumentException('Unsupported Xibo HTTP method.');
        }
        $operation = new Operation("raw:{$method}:{$path}", $method, $path, [], null, [], []);

        return $this->executor->execute($this->config, $operation, OperationRequest::fromArray($input));
    }
}
