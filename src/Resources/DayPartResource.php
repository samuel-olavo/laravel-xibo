<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class DayPartResource extends BaseResource
{
    public function dayPartAdd(array $input = []): XiboResponse
    {
        return $this->call('dayPartAdd', $input);
    }

    public function dayPartDelete(array $input = []): XiboResponse
    {
        return $this->call('dayPartDelete', $input);
    }

    public function dayPartEdit(array $input = []): XiboResponse
    {
        return $this->call('dayPartEdit', $input);
    }

    public function dayPartSearch(array $input = []): XiboResponse
    {
        return $this->call('dayPartSearch', $input);
    }

    public function dayPartSearchById(array $input = []): XiboResponse
    {
        return $this->call('dayPartSearchById', $input);
    }

}
