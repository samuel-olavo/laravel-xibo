<?php

namespace SamuelOlavo\LaravelXibo\Spec;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SamuelOlavo\LaravelXibo\Connections\ConnectionConfig;
use SamuelOlavo\LaravelXibo\Exceptions\SpecificationUnavailable;

final class Repository
{
    public function __construct(private readonly Normalizer $normalizer) {}

    public function for(ConnectionConfig $connection): Catalog
    {
        $document = Cache::remember($this->cacheKey($connection), 3600, fn () => $this->fetch($connection));

        return $this->normalizer->normalize($document);
    }

    public function refresh(ConnectionConfig $connection): Catalog
    {
        $document = $this->fetch($connection);
        $catalog = $this->normalizer->normalize($document);
        Cache::put($this->cacheKey($connection), $document, 3600);

        return $catalog;
    }

    private function fetch(ConnectionConfig $connection): array
    {
        try {
            $response = Http::timeout(15)->withoutRedirecting()->get($connection->baseUrl().'/swagger.json');
            if ($response->successful() && is_array($response->json())) {
                $document = $response->json();
                $this->normalizer->normalize($document);
                $this->warnOnMajorMismatch($connection, $document);

                return $document;
            }
        } catch (\Throwable) {
            // A configured local specification may still be usable.
        }

        $path = $connection->specificationPath();
        if ($path !== null && is_file($path) && is_readable($path)) {
            $document = json_decode(file_get_contents($path), true);
            if (is_array($document)) {
                try {
                    $this->normalizer->normalize($document);
                    return $document;
                } catch (\SamuelOlavo\LaravelXibo\Exceptions\InvalidSpecification) {
                    // Report the configured file as unavailable rather than cache invalid data.
                }
            }
        }

        throw new SpecificationUnavailable("Cannot load the API specification for Xibo connection [{$connection->name()}].");
    }

    private function warnOnMajorMismatch(ConnectionConfig $connection, array $document): void
    {
        $declared = $connection->declaredVersion();
        $reported = $document['info']['version'] ?? null;
        if ($declared === null || ! is_string($reported)) {
            return;
        }
        $expectedMajor = explode('.', $declared)[0];
        $actualMajor = explode('.', $reported)[0];
        if (ctype_digit($expectedMajor) && ctype_digit($actualMajor) && $expectedMajor !== $actualMajor) {
            Log::warning('Xibo declared version differs from API specification major version.', [
                'connection' => $connection->name(),
                'declared' => $declared,
                'reported' => $reported,
            ]);
        }
    }

    private function cacheKey(ConnectionConfig $connection): string
    {
        return 'xibo:spec:'.hash('sha256', implode('|', [
            $connection->name(),
            $connection->baseUrl(),
            $connection->declaredVersion(),
            $connection->specificationPath(),
        ]));
    }
}
