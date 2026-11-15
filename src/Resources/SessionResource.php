<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class SessionResource extends BaseResource
{
    public function sessionLogout(array $input = []): XiboResponse
    {
        return $this->call('sessionLogout', $input);
    }

    public function sessionSearch(array $input = []): XiboResponse
    {
        return $this->call('sessionSearch', $input);
    }

}
