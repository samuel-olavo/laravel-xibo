<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class TemplateResource extends BaseResource
{
    public function templateAdd(array $input = []): XiboResponse
    {
        return $this->call('templateAdd', $input);
    }

    public function templateAddFromLayout(array $input = []): XiboResponse
    {
        return $this->call('template.add.from.layout', $input);
    }

    public function templateSearch(array $input = []): XiboResponse
    {
        return $this->call('templateSearch', $input);
    }

    public function templateSearchAll(array $input = []): XiboResponse
    {
        return $this->call('templateSearchAll', $input);
    }

    public function templateSearchById(array $input = []): XiboResponse
    {
        return $this->call('templateSearchById', $input);
    }

}
