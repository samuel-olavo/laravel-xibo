<?php

namespace SamuelOlavo\LaravelXibo\Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use SamuelOlavo\LaravelXibo\Connections\ConnectionManager;
use SamuelOlavo\LaravelXibo\Exceptions\XiboRequestFailed;
use SamuelOlavo\LaravelXibo\Tests\TestCase;

final class OperationExecutionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config()->set('xibo.default', 'main');
        config()->set('xibo.connections.main', [
            'url' => 'https://cms.example',
            'version' => '4.5',
            'token' => 'test-token',
            'specification_path' => __DIR__.'/../Fixtures/openapi3.json',
        ]);
    }

    public function test_get_uses_path_query_and_bearer_token(): void
    {
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) {
                return Http::response('', 503);
            }
            self::assertSame('GET', $request->method());
            self::assertSame('https://cms.example/api/layout/status/42?embed=regions', $request->url());
            self::assertSame('Bearer test-token', $request->header('Authorization')[0]);
            return Http::response(['layoutId' => 42]);
        });

        $result = app(ConnectionManager::class)->connection()->call('layoutStatus', [
            'path' => ['layoutId' => 42],
            'query' => ['embed' => 'regions'],
        ]);

        self::assertSame(42, $result->json('layoutId'));
    }

    public function test_missing_required_path_parameter_is_rejected_before_operation_request(): void
    {
        Http::fake(['*' => Http::response('', 503)]);

        $this->expectException(\InvalidArgumentException::class);
        app(ConnectionManager::class)->connection()->call('layoutStatus');
    }

    public function test_form_encoded_put_uses_xibo_required_content_type(): void
    {
        $fixture = __DIR__.'/../Fixtures/swagger2.json';
        config()->set('xibo.connections.main.specification_path', $fixture);
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            self::assertSame('PUT', $request->method());
            self::assertStringContainsString('application/x-www-form-urlencoded', $request->header('Content-Type')[0]);
            self::assertSame('name=Updated', $request->body());
            return Http::response(['layoutId' => 7]);
        });

        $result = app(ConnectionManager::class)->connection()->call('layoutEdit', [
            'path' => ['layoutId' => 7], 'body' => ['name' => 'Updated'],
        ]);
        self::assertSame(7, $result->json('layoutId'));
    }

    public function test_static_token_unauthorized_response_is_not_retried(): void
    {
        Http::fake(function (Request $request) {
            return str_ends_with($request->url(), '/swagger.json')
                ? Http::response('', 503)
                : Http::response(['error' => 'unauthorized'], 401);
        });

        try {
            app(ConnectionManager::class)->connection()->call('layoutStatus', ['path' => ['layoutId' => 1]]);
            self::fail('Expected XiboRequestFailed.');
        } catch (XiboRequestFailed $exception) {
            self::assertSame(401, $exception->status());
        }
        Http::assertSentCount(2);
    }

    public function test_raw_request_rejects_absolute_urls(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        app(ConnectionManager::class)->connection()->request('GET', 'https://evil.example/data');
    }

    public function test_multipart_upload_sends_the_file_and_form_fields(): void
    {
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            self::assertSame('POST', $request->method());
            self::assertStringContainsString('multipart/form-data', $request->header('Content-Type')[0]);
            self::assertStringContainsString('photo.png', $request->body());
            self::assertStringContainsString('sample-file', $request->body());
            return Http::response(['mediaId' => 12], 201);
        });

        $result = app(ConnectionManager::class)->connection()->call('libraryAdd', [
            'files' => ['files' => ['contents' => 'sample-file', 'filename' => 'photo.png']],
        ]);

        self::assertSame(201, $result->status());
    }

    public function test_unauthorized_client_credentials_token_is_refreshed_once(): void
    {
        config()->set('xibo.connections.main.token', null);
        config()->set('xibo.connections.main.client_id', 'id');
        config()->set('xibo.connections.main.client_secret', 'secret');
        $requests = 0;
        Http::fake(function (Request $request) use (&$requests) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            if (str_ends_with($request->url(), '/access_token')) {
                $requests++;
                return Http::response(['access_token' => 'token-'.$requests, 'expires_in' => 3600]);
            }
            $requests++;
            return $request->hasHeader('Authorization', 'Bearer token-1')
                ? Http::response(['error' => 'expired'], 401)
                : Http::response(['layoutId' => 42]);
        });

        $result = app(ConnectionManager::class)->connection()->call('layoutStatus', ['path' => ['layoutId' => 42]]);

        self::assertSame(42, $result->json('layoutId'));
        self::assertSame(4, $requests);
    }

    public function test_raw_request_rejects_parent_path_segments(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        app(ConnectionManager::class)->connection()->request('GET', '/../../secret');
    }

    public function test_optional_xibo_path_segment_can_be_omitted(): void
    {
        config()->set('xibo.connections.main.specification_path', __DIR__.'/../Fixtures/optional-path.json');
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            self::assertSame('https://cms.example/api/displaygroup/criteria', $request->url());
            return Http::response(['ok' => true]);
        });

        self::assertTrue(app(ConnectionManager::class)->connection()->call('displayGroupCriteria')->json('ok'));
    }

    public function test_form_array_name_does_not_become_a_nested_array(): void
    {
        config()->set('xibo.connections.main.specification_path', __DIR__.'/../Fixtures/form-array.json');
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            parse_str($request->body(), $parsed);
            self::assertSame(['10', '11'], $parsed['displayGroupIds']);
            return Http::response(['campaignId' => 3]);
        });

        app(ConnectionManager::class)->connection()->call('campaignEdit', [
            'path' => ['campaignId' => 3],
            'body' => ['displayGroupIds[]' => [10, 11]],
        ]);
    }

    public function test_failed_request_exposes_xibo_validation_details_and_headers(): void
    {
        Http::fake(function (Request $request) {
            return str_ends_with($request->url(), '/swagger.json')
                ? Http::response('', 503)
                : Http::response(['errors' => ['name' => 'Required']], 422, ['Retry-After' => '5']);
        });

        try {
            app(ConnectionManager::class)->connection()->call('layoutStatus', ['path' => ['layoutId' => 1]]);
            self::fail('Expected XiboRequestFailed.');
        } catch (XiboRequestFailed $exception) {
            self::assertSame(422, $exception->status());
            self::assertSame('Required', $exception->response()->json('errors.name'));
            self::assertSame('5', $exception->response()->headers()['Retry-After'][0]);
        }
    }

    public function test_swagger_body_only_put_sends_json(): void
    {
        config()->set('xibo.connections.main.specification_path', __DIR__.'/../Fixtures/swagger-body.json');
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            self::assertStringContainsString('application/json', $request->header('Content-Type')[0]);
            self::assertSame(['elements' => '[{"x":1}]'], json_decode($request->body(), true));
            return Http::response(['ok' => true]);
        });

        $response = app(ConnectionManager::class)->connection()->call('widgetSaveElements', [
            'path' => ['widgetId' => 7], 'body' => ['elements' => '[{"x":1}]'],
        ]);
        self::assertTrue($response->json('ok'));
    }

    public function test_required_query_is_checked_before_calling_xibo(): void
    {
        config()->set('xibo.connections.main.specification_path', __DIR__.'/../Fixtures/required-query.json');
        Http::fake(['*' => Http::response('', 503)]);

        $this->expectException(\InvalidArgumentException::class);
        app(ConnectionManager::class)->connection()->call('scheduleCalendarDataDisplayGroup', [
            'path' => ['displayGroupId' => 7],
        ]);
    }

    public function test_json_boolean_remains_a_boolean(): void
    {
        config()->set('xibo.connections.main.specification_path', __DIR__.'/../Fixtures/json-boolean.json');
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            self::assertSame(['enabled' => true], json_decode($request->body(), true));
            return Http::response(['ok' => true]);
        });

        app(ConnectionManager::class)->connection()->call('settingsSave', ['body' => ['enabled' => true]]);
    }

    public function test_swagger_two_query_array_uses_csv_serialization(): void
    {
        config()->set('xibo.connections.main.specification_path', __DIR__.'/../Fixtures/query-array-swagger2.json');
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            self::assertSame('displayIds=1%2C2', parse_url($request->url(), PHP_URL_QUERY));
            return Http::response([]);
        });

        app(ConnectionManager::class)->connection()->call('statsSearch', ['query' => ['displayIds' => [1, 2]]]);
    }

    public function test_openapi_three_query_array_repeats_name(): void
    {
        config()->set('xibo.connections.main.specification_path', __DIR__.'/../Fixtures/query-array-openapi3.json');
        Http::fake(function (Request $request) {
            if (str_ends_with($request->url(), '/swagger.json')) return Http::response('', 503);
            self::assertSame('displayIds=1&displayIds=2', parse_url($request->url(), PHP_URL_QUERY));
            return Http::response([]);
        });

        app(ConnectionManager::class)->connection()->call('statsSearch', ['query' => ['displayIds' => [1, 2]]]);
    }
}
