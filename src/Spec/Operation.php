<?php

namespace SamuelOlavo\LaravelXibo\Spec;

final readonly class Operation
{
    public function __construct(
        public string $id,
        public string $method,
        public string $path,
        public array $parameters,
        public ?string $requestMediaType,
        public array $bodyProperties,
        public array $requiredBodyProperties,
        public array $responseMediaTypes = [],
        public array $tags = [],
    ) {}
}
