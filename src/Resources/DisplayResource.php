<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class DisplayResource extends BaseResource
{
    public function displayDefaultLayout(array $input = []): XiboResponse
    {
        return $this->call('displayDefaultLayout', $input);
    }

    public function displayDelete(array $input = []): XiboResponse
    {
        return $this->call('displayDelete', $input);
    }

    public function displayEdit(array $input = []): XiboResponse
    {
        return $this->call('displayEdit', $input);
    }

    public function displayLicenceCheck(array $input = []): XiboResponse
    {
        return $this->call('displayLicenceCheck', $input);
    }

    public function displayPurgeAll(array $input = []): XiboResponse
    {
        return $this->call('displayPurgeAll', $input);
    }

    public function displayRequestScreenshot(array $input = []): XiboResponse
    {
        return $this->call('displayRequestScreenshot', $input);
    }

    public function displaySearch(array $input = []): XiboResponse
    {
        return $this->call('displaySearch', $input);
    }

    public function displaySearchById(array $input = []): XiboResponse
    {
        return $this->call('DisplaySearchById', $input);
    }

    public function displayStatus(array $input = []): XiboResponse
    {
        return $this->call('displayStatus', $input);
    }

    public function displayToggleAuthorise(array $input = []): XiboResponse
    {
        return $this->call('displayToggleAuthorise', $input);
    }

    public function displayWakeOnLan(array $input = []): XiboResponse
    {
        return $this->call('displayWakeOnLan', $input);
    }

}
