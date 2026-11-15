<?php

namespace SamuelOlavo\LaravelXibo\Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use SamuelOlavo\LaravelXibo\Auth\TokenProvider;
use SamuelOlavo\LaravelXibo\Connections\ConnectionConfig;
use SamuelOlavo\LaravelXibo\Exceptions\AuthenticationFailed;
use SamuelOlavo\LaravelXibo\Tests\TestCase;

final class TokenProviderTest extends TestCase
{
    public function test_static_token_is_used_without_a_token_request(): void
    {
        Http::fake();
        $connection = ConnectionConfig::fromArray('main', ['url' => 'https://main.example', 'token' => 'given-token']);

        self::assertSame('given-token', app(TokenProvider::class)->token($connection));
        Http::assertNothingSent();
    }

    public function test_client_credentials_token_is_cached_and_separate_by_connection(): void
    {
        Cache::flush();
        Http::fake([
            'https://first.example/api/authorize/access_token' => Http::response(['access_token' => 'one', 'expires_in' => 3600]),
            'https://second.example/api/authorize/access_token' => Http::response(['access_token' => 'two', 'expires_in' => 3600]),
        ]);
        $first = ConnectionConfig::fromArray('first', ['url' => 'https://first.example', 'client_id' => 'a', 'client_secret' => 'secret-a']);
        $second = ConnectionConfig::fromArray('second', ['url' => 'https://second.example', 'client_id' => 'b', 'client_secret' => 'secret-b']);

        $provider = app(TokenProvider::class);
        self::assertSame('one', $provider->token($first));
        self::assertSame('one', $provider->token($first));
        self::assertSame('two', $provider->token($second));
        Http::assertSentCount(2);
    }

    public function test_refresh_requests_a_new_token(): void
    {
        Cache::flush();
        Http::fakeSequence()->push(['access_token' => 'old', 'expires_in' => 3600])->push(['access_token' => 'new', 'expires_in' => 3600]);
        $connection = ConnectionConfig::fromArray('main', ['url' => 'https://main.example', 'client_id' => 'a', 'client_secret' => 'b']);

        $provider = app(TokenProvider::class);
        self::assertSame('old', $provider->token($connection));
        self::assertSame('new', $provider->refresh($connection));
    }

    public function test_invalid_credentials_raise_authentication_error(): void
    {
        Cache::flush();
        Http::fake(['*' => Http::response(['error' => 'invalid_client'], 401)]);
        $connection = ConnectionConfig::fromArray('main', ['url' => 'https://main.example', 'client_id' => 'a', 'client_secret' => 'bad']);

        $this->expectException(AuthenticationFailed::class);
        app(TokenProvider::class)->token($connection);
    }
}
