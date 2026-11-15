<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class MiscResource extends BaseResource
{
    public function about(array $input = []): XiboResponse
    {
        return $this->call('about', $input);
    }

    public function clock(array $input = []): XiboResponse
    {
        return $this->call('clock', $input);
    }

    public function helpPageLinks(array $input = []): XiboResponse
    {
        return $this->call('helpPageLinks', $input);
    }

}
