<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class DisplayprofileResource extends BaseResource
{
    public function displayProfileAdd(array $input = []): XiboResponse
    {
        return $this->call('displayProfileAdd', $input);
    }

    public function displayProfileCopy(array $input = []): XiboResponse
    {
        return $this->call('displayProfileCopy', $input);
    }

    public function displayProfileDelete(array $input = []): XiboResponse
    {
        return $this->call('displayProfileDelete', $input);
    }

    public function displayProfileEdit(array $input = []): XiboResponse
    {
        return $this->call('displayProfileEdit', $input);
    }

    public function displayProfileSearch(array $input = []): XiboResponse
    {
        return $this->call('displayProfileSearch', $input);
    }

    public function displayProfileSearchById(array $input = []): XiboResponse
    {
        return $this->call('displayProfileSearchById', $input);
    }

}
