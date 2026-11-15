<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class FontResource extends BaseResource
{
    public function fontDelete(array $input = []): XiboResponse
    {
        return $this->call('fontDelete', $input);
    }

    public function fontDetails(array $input = []): XiboResponse
    {
        return $this->call('fontDetails', $input);
    }

    public function fontDownload(array $input = []): XiboResponse
    {
        return $this->call('fontDownload', $input);
    }

    public function fontSearch(array $input = []): XiboResponse
    {
        return $this->call('fontSearch', $input);
    }

    public function fontSearchById(array $input = []): XiboResponse
    {
        return $this->call('fontSearchById', $input);
    }

    public function fontUpload(array $input = []): XiboResponse
    {
        return $this->call('fontUpload', $input);
    }

}
