<?php

namespace SamuelOlavo\LaravelXibo\Tests\Unit;

use PHPUnit\Framework\TestCase;
use SamuelOlavo\LaravelXibo\Exceptions\InvalidSpecification;
use SamuelOlavo\LaravelXibo\Exceptions\OperationUnavailable;
use SamuelOlavo\LaravelXibo\Spec\Normalizer;

final class SpecNormalizerTest extends TestCase
{
    public function test_swagger_two_form_fields_and_query_parameters_are_preserved(): void
    {
        $catalog = (new Normalizer())->normalize($this->fixture('swagger2.json'));
        $search = $catalog->operation('layoutSearch');
        $edit = $catalog->operation('layoutEdit');

        self::assertSame('GET', $search->method);
        self::assertSame('/layout', $search->path);
        self::assertSame('query', $search->parameters[0]['in']);
        self::assertSame('application/x-www-form-urlencoded', $edit->requestMediaType);
        self::assertSame('name', $edit->bodyProperties[0]['name']);
        self::assertTrue($catalog->has('layoutEdit'));
    }

    public function test_openapi_three_request_body_and_path_parameter_are_preserved(): void
    {
        $catalog = (new Normalizer())->normalize($this->fixture('openapi3.json'));
        $upload = $catalog->operation('libraryAdd');

        self::assertSame('POST', $upload->method);
        self::assertSame('multipart/form-data', $upload->requestMediaType);
        self::assertSame('files', $upload->bodyProperties[0]['name']);
        self::assertSame(['files'], $upload->requiredBodyProperties);
        self::assertSame('path', $catalog->operation('layoutStatus')->parameters[0]['in']);
    }

    public function test_swagger_two_file_field_selects_multipart_even_without_consumes(): void
    {
        $document = $this->fixture('swagger2.json');
        $document['paths']['/library']['post'] = [
            'operationId' => 'libraryAdd',
            'parameters' => [['name' => 'files', 'in' => 'formData', 'type' => 'file', 'required' => true]],
        ];

        $operation = (new Normalizer())->normalize($document)->operation('libraryAdd');

        self::assertSame('multipart/form-data', $operation->requestMediaType);
        self::assertSame(['files'], $operation->requiredBodyProperties);
    }

    public function test_swagger_two_body_parameter_selects_json_and_required_field(): void
    {
        $operation = (new Normalizer())->normalize($this->fixture('swagger-body.json'))->operation('widgetSaveElements');

        self::assertSame('application/json', $operation->requestMediaType);
        self::assertSame(['elements'], $operation->requiredBodyProperties);
        self::assertSame('elements', $operation->bodyProperties[0]['name']);
    }

    public function test_duplicate_operation_ids_keep_both_routes_callable(): void
    {
        $document = $this->fixture('swagger2.json');
        $document['paths']['/duplicate']['get'] = ['operationId' => 'layoutSearch'];

        $catalog = (new Normalizer())->normalize($document);

        self::assertCount(3, $catalog->all());
        self::assertSame('/layout', $catalog->operation('layoutSearch')->path);
        self::assertSame('/duplicate', $catalog->operation('get:/duplicate')->path);
    }

    public function test_missing_operation_id_gets_a_stable_fallback(): void
    {
        $document = $this->fixture('swagger2.json');
        unset($document['paths']['/layout']['get']['operationId']);

        self::assertTrue((new Normalizer())->normalize($document)->has('get:/layout'));
    }

    public function test_invalid_document_and_unknown_operation_fail_clearly(): void
    {
        $this->expectException(InvalidSpecification::class);
        (new Normalizer())->normalize(['paths' => []]);
    }

    public function test_unknown_operation_throws_operation_unavailable(): void
    {
        $catalog = (new Normalizer())->normalize($this->fixture('swagger2.json'));

        $this->expectException(OperationUnavailable::class);
        $catalog->operation('notThere');
    }

    private function fixture(string $file): array
    {
        return json_decode(file_get_contents(__DIR__.'/../Fixtures/'.$file), true, flags: JSON_THROW_ON_ERROR);
    }
}
