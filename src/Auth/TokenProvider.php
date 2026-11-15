<?php

namespace SamuelOlavo\LaravelXibo\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use SamuelOlavo\LaravelXibo\Connections\ConnectionConfig;
use SamuelOlavo\LaravelXibo\Exceptions\AuthenticationFailed;

final class TokenProvider
{
    public function token(ConnectionConfig $connection): string
    {
        if ($connection->token() !== null) {
            return $connection->token();
        }

        $cached = Cache::get($this->cacheKey($connection));
        return is_string($cached) ? $cached : $this->refresh($connection);
    }

    public function refresh(ConnectionConfig $connection): string
    {
        if ($connection->token() !== null) {
            return $connection->token();
        }
        if ($connection->clientId() === null || $connection->clientSecret() === null) {
            throw new AuthenticationFailed("Xibo connection [{$connection->name()}] needs a token or client credentials.");
        }

        try {
            $response = Http::timeout(15)->asForm()->post($connection->baseUrl().'/api/authorize/access_token', [
                'grant_type' => 'client_credentials',
                'client_id' => $connection->clientId(),
                'client_secret' => $connection->clientSecret(),
            ]);
        } catch (\Throwable $exception) {
            throw new AuthenticationFailed("Could not authenticate Xibo connection [{$connection->name()}].", previous: $exception);
        }

        $token = $response->json('access_token');
        if (! $response->successful() || ! is_string($token) || $token === '') {
            throw new AuthenticationFailed("Could not authenticate Xibo connection [{$connection->name()}].");
        }

        $expiresIn = (int) $response->json('expires_in', 3600);
        Cache::put($this->cacheKey($connection), $token, max(1, $expiresIn - 30));

        return $token;
    }

    private function cacheKey(ConnectionConfig $connection): string
    {
        return 'xibo:token:'.hash('sha256', implode('|', [
            $connection->name(), $connection->baseUrl(), $connection->clientId(), $connection->clientSecret(),
        ]));
    }
}
