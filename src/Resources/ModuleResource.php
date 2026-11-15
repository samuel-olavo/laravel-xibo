<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class ModuleResource extends BaseResource
{
    public function getModuleProperties(array $input = []): XiboResponse
    {
        return $this->call('getModuleProperties', $input);
    }

    public function getModuleTemplateDataTypePropertiesId(array $input = []): XiboResponse
    {
        return $this->call('get:/module/template/{dataType}/properties/{id}', $input);
    }

    public function getModuleTemplateProperties(array $input = []): XiboResponse
    {
        return $this->call('getModuleTemplateProperties', $input);
    }

    public function moduleSearch(array $input = []): XiboResponse
    {
        return $this->call('moduleSearch', $input);
    }

    public function moduleSearchById(array $input = []): XiboResponse
    {
        return $this->call('ModuleSearchById', $input);
    }

    public function moduleTemplateSearch(array $input = []): XiboResponse
    {
        return $this->call('moduleTemplateSearch', $input);
    }

}
