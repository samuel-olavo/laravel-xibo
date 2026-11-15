<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class TagsResource extends BaseResource
{
    public function tagAdd(array $input = []): XiboResponse
    {
        return $this->call('tagAdd', $input);
    }

    public function tagDelete(array $input = []): XiboResponse
    {
        return $this->call('tagDelete', $input);
    }

    public function tagEdit(array $input = []): XiboResponse
    {
        return $this->call('tagEdit', $input);
    }

    public function tagEditMultiple(array $input = []): XiboResponse
    {
        return $this->call('tagEditMultiple', $input);
    }

    public function tagSearch(array $input = []): XiboResponse
    {
        return $this->call('tagSearch', $input);
    }

    public function tagSearchById(array $input = []): XiboResponse
    {
        return $this->call('TagSearchById', $input);
    }

    public function tagUsageReport(array $input = []): XiboResponse
    {
        return $this->call('TagUsageReport', $input);
    }

}
