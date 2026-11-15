<?php

namespace SamuelOlavo\LaravelXibo\Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SamuelOlavo\LaravelXibo\Connections\ConnectionConfig;
use SamuelOlavo\LaravelXibo\Exceptions\SpecificationUnavailable;
use SamuelOlavo\LaravelXibo\Spec\Repository;
use SamuelOlavo\LaravelXibo\Tests\TestCase;

final class SpecificationRepositoryTest extends TestCase
{
    public function test_live_specification_is_loaded_and_cached_per_cms(): void
    {
        Cache::flush();
        $spec = json_decode(file_get_contents(__DIR__.'/../Fixtures/swagger2.json'), true);
        Http::fake(['https://main.example/swagger.json' => Http::response($spec)]);
        $connection = ConnectionConfig::fromArray('main', ['url' => 'https://main.example', 'version' => '4.4']);

        $repository = app(Repository::class);
        self::assertTrue($repository->for($connection)->has('layoutSearch'));
        self::assertTrue($repository->for($connection)->has('layoutEdit'));
        Http::assertSentCount(1);
    }

    public function test_local_specification_is_used_when_cms_is_unavailable(): void
    {
        Cache::flush();
        Http::fake(['*' => Http::response('', 503)]);
        $connection = ConnectionConfig::fromArray('offline', [
            'url' => 'https://offline.example',
            'version' => '4.5',
            'specification_path' => __DIR__.'/../Fixtures/openapi3.json',
        ]);

        self::assertTrue(app(Repository::class)->for($connection)->has('libraryAdd'));
    }

    public function test_unavailable_specification_without_fallback_fails(): void
    {
        Cache::flush();
        Http::fake(['*' => Http::response('', 503)]);
        $connection = ConnectionConfig::fromArray('offline', ['url' => 'https://offline.example']);

        $this->expectException(SpecificationUnavailable::class);
        app(Repository::class)->for($connection);
    }

    public function test_invalid_remote_json_uses_valid_local_fallback(): void
    {
        Cache::flush();
        Http::fake(['https://cms.example/swagger.json' => Http::response(['error' => 'Not configured'])]);
        $connection = ConnectionConfig::fromArray('main', [
            'url' => 'https://cms.example',
            'specification_path' => __DIR__.'/../Fixtures/openapi3.json',
        ]);

        $repository = app(Repository::class);
        self::assertTrue($repository->for($connection)->has('libraryAdd'));
        self::assertTrue($repository->for($connection)->has('libraryAdd'));
        Http::assertSentCount(1);
    }

    public function test_refresh_replaces_an_old_catalog(): void
    {
        Cache::flush();
        $old = json_decode(file_get_contents(__DIR__.'/../Fixtures/swagger2.json'), true);
        $new = json_decode(file_get_contents(__DIR__.'/../Fixtures/openapi3.json'), true);
        Http::fakeSequence()->push($old)->push($new);
        $connection = ConnectionConfig::fromArray('main', ['url' => 'https://main.example']);
        $repository = app(Repository::class);

        self::assertTrue($repository->for($connection)->has('layoutSearch'));
        self::assertTrue($repository->refresh($connection)->has('libraryAdd'));
        self::assertFalse($repository->for($connection)->has('layoutSearch'));
    }

    public function test_changing_the_local_specification_path_does_not_reuse_an_old_catalog(): void
    {
        Cache::flush();
        Http::fake(['*' => Http::response('', 503)]);
        $settings = ['url' => 'https://offline.example', 'version' => '4.5'];
        $first = ConnectionConfig::fromArray('main', $settings + [
            'specification_path' => __DIR__.'/../Fixtures/swagger2.json',
        ]);
        $second = ConnectionConfig::fromArray('main', $settings + [
            'specification_path' => __DIR__.'/../Fixtures/openapi3.json',
        ]);

        $repository = app(Repository::class);
        self::assertTrue($repository->for($first)->has('layoutSearch'));
        self::assertTrue($repository->for($second)->has('libraryAdd'));
    }

    public function test_only_a_real_major_version_mismatch_is_warned_about(): void
    {
        Cache::flush();
        $document = json_decode(file_get_contents(__DIR__.'/../Fixtures/swagger2.json'), true);
        $document['info']['version'] = '4.0';
        Http::fake(['*' => Http::response($document)]);
        Log::shouldReceive('warning')->once()->withArgs(fn (string $message, array $context) =>
            str_contains($message, 'major version')
            && $context['connection'] === 'mismatch'
            && $context['declared'] === '5.0'
            && $context['reported'] === '4.0'
        );

        $repository = app(Repository::class);
        self::assertTrue($repository->for(ConnectionConfig::fromArray('same-major', [
            'url' => 'https://same.example', 'version' => '4.4',
        ]))->has('layoutSearch'));
        self::assertTrue($repository->for(ConnectionConfig::fromArray('mismatch', [
            'url' => 'https://different.example', 'version' => '5.0',
        ]))->has('layoutSearch'));
    }
}
