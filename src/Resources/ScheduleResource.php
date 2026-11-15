<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class ScheduleResource extends BaseResource
{
    public function scheduleAdd(array $input = []): XiboResponse
    {
        return $this->call('scheduleAdd', $input);
    }

    public function scheduleCalendarData(array $input = []): XiboResponse
    {
        return $this->call('scheduleCalendarData', $input);
    }

    public function scheduleCalendarDataDisplayGroup(array $input = []): XiboResponse
    {
        return $this->call('scheduleCalendarDataDisplayGroup', $input);
    }

    public function scheduleDelete(array $input = []): XiboResponse
    {
        return $this->call('scheduleDelete', $input);
    }

    public function scheduleEdit(array $input = []): XiboResponse
    {
        return $this->call('scheduleEdit', $input);
    }

    public function scheduleSearch(array $input = []): XiboResponse
    {
        return $this->call('scheduleSearch', $input);
    }

    public function scheduleSearchById(array $input = []): XiboResponse
    {
        return $this->call('ScheduleSearchById', $input);
    }

    public function schedulerecurrenceDelete(array $input = []): XiboResponse
    {
        return $this->call('schedulerecurrenceDelete', $input);
    }

}
