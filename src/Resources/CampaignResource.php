<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class CampaignResource extends BaseResource
{
    public function campaignAdd(array $input = []): XiboResponse
    {
        return $this->call('campaignAdd', $input);
    }

    public function campaignAssignLayout(array $input = []): XiboResponse
    {
        return $this->call('campaignAssignLayout', $input);
    }

    public function campaignDelete(array $input = []): XiboResponse
    {
        return $this->call('campaignDelete', $input);
    }

    public function campaignEdit(array $input = []): XiboResponse
    {
        return $this->call('campaignEdit', $input);
    }

    public function campaignRemoveLayout(array $input = []): XiboResponse
    {
        return $this->call('campaignRemoveLayout', $input);
    }

    public function campaignSearch(array $input = []): XiboResponse
    {
        return $this->call('campaignSearch', $input);
    }

    public function campaignSearchById(array $input = []): XiboResponse
    {
        return $this->call('campaignSearchById', $input);
    }

    public function campaignSelectFolder(array $input = []): XiboResponse
    {
        return $this->call('campaignSelectFolder', $input);
    }

    public function deleteCampaignLayoutRemoveCampaignId(array $input = []): XiboResponse
    {
        return $this->call('delete:/campaign/layout/remove/{campaignId}', $input);
    }

}
