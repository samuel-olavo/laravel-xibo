<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class DisplayGroupResource extends BaseResource
{
    public function displayGroupActionChangeLayout(array $input = []): XiboResponse
    {
        return $this->call('displayGroupActionChangeLayout', $input);
    }

    public function displayGroupActionClearStatsAndLogs(array $input = []): XiboResponse
    {
        return $this->call('displayGroupActionClearStatsAndLogs', $input);
    }

    public function displayGroupActionCollectNow(array $input = []): XiboResponse
    {
        return $this->call('displayGroupActionCollectNow', $input);
    }

    public function displayGroupActionCommand(array $input = []): XiboResponse
    {
        return $this->call('displayGroupActionCommand', $input);
    }

    public function displayGroupActionOverlayLayout(array $input = []): XiboResponse
    {
        return $this->call('displayGroupActionOverlayLayout', $input);
    }

    public function displayGroupActionRevertToSchedule(array $input = []): XiboResponse
    {
        return $this->call('displayGroupActionRevertToSchedule', $input);
    }

    public function displayGroupActionTriggerWebhook(array $input = []): XiboResponse
    {
        return $this->call('displayGroupActionTriggerWebhook', $input);
    }

    public function displayGroupAdd(array $input = []): XiboResponse
    {
        return $this->call('displayGroupAdd', $input);
    }

    public function displayGroupCopy(array $input = []): XiboResponse
    {
        return $this->call('displayGroupCopy', $input);
    }

    public function displayGroupDelete(array $input = []): XiboResponse
    {
        return $this->call('displayGroupDelete', $input);
    }

    public function displayGroupDisplayAssign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupDisplayAssign', $input);
    }

    public function displayGroupDisplayGroupAssign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupDisplayGroupAssign', $input);
    }

    public function displayGroupDisplayGroupUnassign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupDisplayGroupUnassign', $input);
    }

    public function displayGroupDisplayUnassign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupDisplayUnassign', $input);
    }

    public function displayGroupEdit(array $input = []): XiboResponse
    {
        return $this->call('displayGroupEdit', $input);
    }

    public function displayGroupLayoutUnassign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupLayoutUnassign', $input);
    }

    public function displayGroupLayoutsAssign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupLayoutsAssign', $input);
    }

    public function displayGroupMediaAssign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupMediaAssign', $input);
    }

    public function displayGroupMediaUnassign(array $input = []): XiboResponse
    {
        return $this->call('displayGroupMediaUnassign', $input);
    }

    public function displayGroupSearch(array $input = []): XiboResponse
    {
        return $this->call('displayGroupSearch', $input);
    }

    public function displayGroupSearchById(array $input = []): XiboResponse
    {
        return $this->call('displayGroupSearchById', $input);
    }

    public function displayGroupSelectFolder(array $input = []): XiboResponse
    {
        return $this->call('displayGroupSelectFolder', $input);
    }

    public function scheduleCriteriaUpdate(array $input = []): XiboResponse
    {
        return $this->call('ScheduleCriteriaUpdate', $input);
    }

}
