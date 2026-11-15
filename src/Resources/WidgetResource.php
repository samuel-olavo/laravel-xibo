<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class WidgetResource extends BaseResource
{
    public function addWidget(array $input = []): XiboResponse
    {
        return $this->call('addWidget', $input);
    }

    public function addWidgetData(array $input = []): XiboResponse
    {
        return $this->call('addWidgetData', $input);
    }

    public function deleteWidgetData(array $input = []): XiboResponse
    {
        return $this->call('deleteWidgetData', $input);
    }

    public function editWidget(array $input = []): XiboResponse
    {
        return $this->call('editWidget', $input);
    }

    public function editWidgetData(array $input = []): XiboResponse
    {
        return $this->call('editWidgetData', $input);
    }

    public function getWidgetData(array $input = []): XiboResponse
    {
        return $this->call('getWidgetData', $input);
    }

    public function orderWidgetData(array $input = []): XiboResponse
    {
        return $this->call('orderWidgetData', $input);
    }

    public function widgetAssignedAudioEdit(array $input = []): XiboResponse
    {
        return $this->call('WidgetAssignedAudioEdit', $input);
    }

    public function widgetAssignedExpiryEdit(array $input = []): XiboResponse
    {
        return $this->call('WidgetAssignedExpiryEdit', $input);
    }

    public function widgetAssignedRegionSet(array $input = []): XiboResponse
    {
        return $this->call('WidgetAssignedRegionSet', $input);
    }

    public function widgetAudioDelete(array $input = []): XiboResponse
    {
        return $this->call('WidgetAudioDelete', $input);
    }

    public function widgetDelete(array $input = []): XiboResponse
    {
        return $this->call('WidgetDelete', $input);
    }

    public function widgetEditTransition(array $input = []): XiboResponse
    {
        return $this->call('WidgetEditTransition', $input);
    }

    public function widgetGetDataType(array $input = []): XiboResponse
    {
        return $this->call('widgetGetDataType', $input);
    }

    public function widgetSaveElements(array $input = []): XiboResponse
    {
        return $this->call('widgetSaveElements', $input);
    }

}
