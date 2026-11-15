<?php

namespace SamuelOlavo\LaravelXibo\Exceptions;

use RuntimeException;
use SamuelOlavo\LaravelXibo\Http\XiboResponse;

final class XiboRequestFailed extends RuntimeException
{
    public function __construct(private readonly XiboResponse $response, string $message)
    {
        parent::__construct($message, $response->status());
    }

    public function status(): int
    {
        return $this->response->status();
    }

    public function response(): XiboResponse
    {
        return $this->response;
    }
}
