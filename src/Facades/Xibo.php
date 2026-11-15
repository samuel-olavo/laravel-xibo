<?php

namespace SamuelOlavo\LaravelXibo\Facades;

use Illuminate\Support\Facades\Facade;

final class Xibo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'xibo';
    }
}
