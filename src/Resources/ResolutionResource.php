<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class ResolutionResource extends BaseResource
{
    public function resolutionAdd(array $input = []): XiboResponse
    {
        return $this->call('resolutionAdd', $input);
    }

    public function resolutionDelete(array $input = []): XiboResponse
    {
        return $this->call('resolutionDelete', $input);
    }

    public function resolutionEdit(array $input = []): XiboResponse
    {
        return $this->call('resolutionEdit', $input);
    }

    public function resolutionSearch(array $input = []): XiboResponse
    {
        return $this->call('resolutionSearch', $input);
    }

    public function resolutionSearchById(array $input = []): XiboResponse
    {
        return $this->call('resolutionSearchById', $input);
    }

}
