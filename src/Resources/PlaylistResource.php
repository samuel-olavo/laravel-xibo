<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class PlaylistResource extends BaseResource
{
    public function convert(array $input = []): XiboResponse
    {
        return $this->call('convert', $input);
    }

    public function playlistAdd(array $input = []): XiboResponse
    {
        return $this->call('playlistAdd', $input);
    }

    public function playlistCopy(array $input = []): XiboResponse
    {
        return $this->call('playlistCopy', $input);
    }

    public function playlistDelete(array $input = []): XiboResponse
    {
        return $this->call('playlistDelete', $input);
    }

    public function playlistEdit(array $input = []): XiboResponse
    {
        return $this->call('playlistEdit', $input);
    }

    public function playlistLibraryAssign(array $input = []): XiboResponse
    {
        return $this->call('playlistLibraryAssign', $input);
    }

    public function playlistOrder(array $input = []): XiboResponse
    {
        return $this->call('playlistOrder', $input);
    }

    public function playlistSearch(array $input = []): XiboResponse
    {
        return $this->call('playlistSearch', $input);
    }

    public function playlistSearchById(array $input = []): XiboResponse
    {
        return $this->call('PlaylistSearchById', $input);
    }

    public function playlistSelectFolder(array $input = []): XiboResponse
    {
        return $this->call('playlistSelectFolder', $input);
    }

    public function playlistSetEnableStat(array $input = []): XiboResponse
    {
        return $this->call('playlistSetEnableStat', $input);
    }

    public function playlistUsageLayoutsReport(array $input = []): XiboResponse
    {
        return $this->call('playlistUsageLayoutsReport', $input);
    }

    public function playlistUsageReport(array $input = []): XiboResponse
    {
        return $this->call('playlistUsageReport', $input);
    }

}
