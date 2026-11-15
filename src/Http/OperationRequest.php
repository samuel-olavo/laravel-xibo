<?php

namespace SamuelOlavo\LaravelXibo\Http;

use InvalidArgumentException;

final readonly class OperationRequest
{
    public function __construct(
        public array $path = [],
        public array $query = [],
        public array $headers = [],
        public array $body = [],
        public array $files = [],
        public mixed $sink = null,
    ) {}

    public static function fromArray(array $input): self
    {
        foreach (['path', 'query', 'headers', 'body', 'files'] as $key) {
            if (isset($input[$key]) && ! is_array($input[$key])) {
                throw new InvalidArgumentException("Xibo request [{$key}] must be an array.");
            }
        }

        return new self(
            $input['path'] ?? [],
            $input['query'] ?? [],
            $input['headers'] ?? [],
            $input['body'] ?? [],
            $input['files'] ?? [],
            $input['sink'] ?? null,
        );
    }
}
