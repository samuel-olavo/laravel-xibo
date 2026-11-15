<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class FolderResource extends BaseResource
{
    public function folderAdd(array $input = []): XiboResponse
    {
        return $this->call('folderAdd', $input);
    }

    public function folderDelete(array $input = []): XiboResponse
    {
        return $this->call('folderDelete', $input);
    }

    public function folderEdit(array $input = []): XiboResponse
    {
        return $this->call('folderEdit', $input);
    }

    public function folderSearch(array $input = []): XiboResponse
    {
        return $this->call('folderSearch', $input);
    }

    public function folderSearchById(array $input = []): XiboResponse
    {
        return $this->call('folderSearchById', $input);
    }

}
