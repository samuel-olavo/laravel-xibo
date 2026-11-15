<?php

namespace SamuelOlavo\LaravelXibo\Tests\Feature;

use SamuelOlavo\LaravelXibo\Connections\ConnectionManager;
use SamuelOlavo\LaravelXibo\Tests\TestCase;

final class PackageRegistrationTest extends TestCase
{
    public function test_named_connections_keep_their_own_url_and_version(): void
    {
        config()->set('xibo.default', 'main');
        config()->set('xibo.connections', [
            'main' => ['url' => 'https://main.example', 'version' => '4.4', 'token' => 'first'],
            'other' => ['url' => 'https://other.example', 'version' => '4.5', 'token' => 'second'],
        ]);

        $manager = app(ConnectionManager::class);

        self::assertSame('https://main.example', $manager->connection()->config()->baseUrl());
        self::assertSame('4.4', $manager->connection()->config()->declaredVersion());
        self::assertSame('https://other.example', $manager->connection('other')->config()->baseUrl());
        self::assertSame('4.5', $manager->connection('other')->config()->declaredVersion());
    }

    public function test_unknown_connection_fails_before_network_access(): void
    {
        config()->set('xibo.connections', []);

        $this->expectException(\InvalidArgumentException::class);
        app(ConnectionManager::class)->connection('missing');
    }
}
