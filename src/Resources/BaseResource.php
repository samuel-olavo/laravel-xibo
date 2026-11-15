<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;
use SamuelOlavo\LaravelXibo\XiboClient;

abstract class BaseResource
{
    public function __construct(protected readonly XiboClient $client) {}

    protected function call(string $operationId, array $input = []): XiboResponse
    {
        return $this->client->call($operationId, $input);
    }
}
