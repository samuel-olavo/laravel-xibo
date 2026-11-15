<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class PlayerSoftwareResource extends BaseResource
{
    public function playerSoftwareDelete(array $input = []): XiboResponse
    {
        return $this->call('playerSoftwareDelete', $input);
    }

    public function playerSoftwareMeta(array $input = []): XiboResponse
    {
        return $this->call('playerSoftwareMeta', $input);
    }

    public function playerSoftwareSearch(array $input = []): XiboResponse
    {
        return $this->call('playerSoftwareSearch', $input);
    }

    public function playerSoftwareSearchById(array $input = []): XiboResponse
    {
        return $this->call('playerSoftwareSearchById', $input);
    }

    public function playersoftwareDownload(array $input = []): XiboResponse
    {
        return $this->call('playersoftwareDownload', $input);
    }

    public function playersoftwareEdit(array $input = []): XiboResponse
    {
        return $this->call('playersoftwareEdit', $input);
    }

    public function playersoftwareUpload(array $input = []): XiboResponse
    {
        return $this->call('playersoftwareUpload', $input);
    }

}
