<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class SyncGroupResource extends BaseResource
{
    public function syncGroupAdd(array $input = []): XiboResponse
    {
        return $this->call('syncGroupAdd', $input);
    }

    public function syncGroupDelete(array $input = []): XiboResponse
    {
        return $this->call('syncGroupDelete', $input);
    }

    public function syncGroupDisplays(array $input = []): XiboResponse
    {
        return $this->call('syncGroupDisplays', $input);
    }

    public function syncGroupEdit(array $input = []): XiboResponse
    {
        return $this->call('syncGroupEdit', $input);
    }

    public function syncGroupMembers(array $input = []): XiboResponse
    {
        return $this->call('syncGroupMembers', $input);
    }

    public function syncGroupSearch(array $input = []): XiboResponse
    {
        return $this->call('syncGroupSearch', $input);
    }

    public function syncGroupSearchById(array $input = []): XiboResponse
    {
        return $this->call('syncGroupSearchById', $input);
    }

}
