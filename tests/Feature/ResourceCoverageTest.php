<?php

namespace SamuelOlavo\LaravelXibo\Tests\Feature;

use Illuminate\Support\Facades\Http;
use SamuelOlavo\LaravelXibo\Connections\ConnectionManager;
use SamuelOlavo\LaravelXibo\Resources\OperationMap;
use SamuelOlavo\LaravelXibo\Spec\Normalizer;
use SamuelOlavo\LaravelXibo\Tests\TestCase;

final class ResourceCoverageTest extends TestCase
{
    public function test_each_operation_in_verified_specs_has_a_named_method(): void
    {
        $files = [__DIR__.'/../Fixtures/swagger2.json', __DIR__.'/../Fixtures/openapi3.json'];
        foreach (explode(':', (string) getenv('XIBO_SPEC_FILES')) as $file) {
            if ($file !== '') $files[] = $file;
        }
        $normalizer = new Normalizer();
        foreach ($files as $file) {
            $document = json_decode(file_get_contents($file), true, flags: JSON_THROW_ON_ERROR);
            $catalog = $normalizer->normalize($document);
            foreach ($catalog->all() as $id => $operation) {
                $entry = OperationMap::for($id);
                self::assertNotNull($entry, "Missing named method for {$id} in {$file}");
                self::assertTrue(method_exists($entry['class'], $entry['method']), "Missing {$id} method");
                $reflection = new \ReflectionClass($entry['class']);
                self::assertContains($reflection->getShortName().'.php', scandir(__DIR__.'/../../src/Resources'));
            }
        }
    }

    public function test_named_method_executes_the_current_cms_operation(): void
    {
        config()->set('xibo.connections.main', [
            'url' => 'https://cms.example', 'token' => 'token',
            'specification_path' => __DIR__.'/../Fixtures/openapi3.json',
        ]);
        Http::fake([
            'https://cms.example/swagger.json' => Http::response('', 503),
            'https://cms.example/api/layout/status/42' => Http::response(['layoutId' => 42]),
        ]);

        $client = app(ConnectionManager::class)->connection('main');
        self::assertSame(42, $client->layout()->layoutStatus(['path' => ['layoutId' => 42]])->json('layoutId'));
    }
}
