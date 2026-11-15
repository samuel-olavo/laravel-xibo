<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class CommandResource extends BaseResource
{
    public function commandAdd(array $input = []): XiboResponse
    {
        return $this->call('commandAdd', $input);
    }

    public function commandDelete(array $input = []): XiboResponse
    {
        return $this->call('commandDelete', $input);
    }

    public function commandEdit(array $input = []): XiboResponse
    {
        return $this->call('commandEdit', $input);
    }

    public function commandSearch(array $input = []): XiboResponse
    {
        return $this->call('commandSearch', $input);
    }

    public function commandSearchById(array $input = []): XiboResponse
    {
        return $this->call('commandSearchById', $input);
    }

}
