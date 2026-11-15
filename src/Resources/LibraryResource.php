<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class LibraryResource extends BaseResource
{
    public function libraryAdd(array $input = []): XiboResponse
    {
        return $this->call('libraryAdd', $input);
    }

    public function libraryDelete(array $input = []): XiboResponse
    {
        return $this->call('libraryDelete', $input);
    }

    public function libraryDownload(array $input = []): XiboResponse
    {
        return $this->call('libraryDownload', $input);
    }

    public function libraryEdit(array $input = []): XiboResponse
    {
        return $this->call('libraryEdit', $input);
    }

    public function librarySearch(array $input = []): XiboResponse
    {
        return $this->call('librarySearch', $input);
    }

    public function librarySearchAll(array $input = []): XiboResponse
    {
        return $this->call('librarySearchAll', $input);
    }

    public function librarySearchById(array $input = []): XiboResponse
    {
        return $this->call('librarySearchById', $input);
    }

    public function librarySelectFolder(array $input = []): XiboResponse
    {
        return $this->call('librarySelectFolder', $input);
    }

    public function libraryThumbnail(array $input = []): XiboResponse
    {
        return $this->call('libraryThumbnail', $input);
    }

    public function libraryTidy(array $input = []): XiboResponse
    {
        return $this->call('libraryTidy', $input);
    }

    public function libraryUsageLayoutsReport(array $input = []): XiboResponse
    {
        return $this->call('libraryUsageLayoutsReport', $input);
    }

    public function libraryUsageReport(array $input = []): XiboResponse
    {
        return $this->call('libraryUsageReport', $input);
    }

    public function mediaCopy(array $input = []): XiboResponse
    {
        return $this->call('mediaCopy', $input);
    }

    public function mediaIsUsed(array $input = []): XiboResponse
    {
        return $this->call('mediaIsUsed', $input);
    }

    public function mediaSetEnableStat(array $input = []): XiboResponse
    {
        return $this->call('mediaSetEnableStat', $input);
    }

    public function mediaTag(array $input = []): XiboResponse
    {
        return $this->call('mediaTag', $input);
    }

    public function mediaUntag(array $input = []): XiboResponse
    {
        return $this->call('mediaUntag', $input);
    }

    public function uploadFromUrl(array $input = []): XiboResponse
    {
        return $this->call('uploadFromUrl', $input);
    }

}
