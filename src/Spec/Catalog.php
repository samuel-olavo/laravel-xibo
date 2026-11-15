<?php

namespace SamuelOlavo\LaravelXibo\Spec;

use SamuelOlavo\LaravelXibo\Exceptions\InvalidSpecification;
use SamuelOlavo\LaravelXibo\Exceptions\OperationUnavailable;

final class Catalog
{
    /** @var array<string, Operation> */
    private array $operations = [];

    public function add(Operation $operation): void
    {
        if (isset($this->operations[$operation->id])) {
            throw new InvalidSpecification("Duplicate Xibo operation ID [{$operation->id}].");
        }

        $this->operations[$operation->id] = $operation;
    }

    public function operation(string $operationId): Operation
    {
        return $this->operations[$operationId]
            ?? throw new OperationUnavailable("Xibo operation [{$operationId}] is unavailable for this CMS.");
    }

    public function has(string $operationId): bool
    {
        return isset($this->operations[$operationId]);
    }

    /** @return array<string, Operation> */
    public function all(): array
    {
        return $this->operations;
    }
}
