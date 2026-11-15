<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class StatisticsResource extends BaseResource
{
    public function getExportStatsCount(array $input = []): XiboResponse
    {
        return $this->call('getExportStatsCount', $input);
    }

    public function statsSearch(array $input = []): XiboResponse
    {
        return $this->call('statsSearch', $input);
    }

    public function timeDisconnectedSearch(array $input = []): XiboResponse
    {
        return $this->call('timeDisconnectedSearch', $input);
    }

}
