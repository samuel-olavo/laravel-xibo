<?php

namespace SamuelOlavo\LaravelXibo\Http;

use Illuminate\Http\Client\Response;

final readonly class XiboResponse
{
    public function __construct(private Response $response) {}

    public function status(): int { return $this->response->status(); }
    public function headers(): array { return $this->response->headers(); }
    public function body(): string { return $this->response->body(); }
    public function json(?string $key = null, mixed $default = null): mixed
    {
        return $this->response->json($key, $default);
    }
}
