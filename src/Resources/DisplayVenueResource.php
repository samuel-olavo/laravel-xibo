<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class DisplayVenueResource extends BaseResource
{
    public function displayVenueSearch(array $input = []): XiboResponse
    {
        return $this->call('displayVenueSearch', $input);
    }

}
