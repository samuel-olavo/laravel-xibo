<?php

namespace SamuelOlavo\LaravelXibo\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SamuelOlavo\LaravelXibo\XiboServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [XiboServiceProvider::class];
    }
}
