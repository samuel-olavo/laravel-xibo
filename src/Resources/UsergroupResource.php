<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class UsergroupResource extends BaseResource
{
    public function userGroupAdd(array $input = []): XiboResponse
    {
        return $this->call('userGroupAdd', $input);
    }

    public function userGroupAssign(array $input = []): XiboResponse
    {
        return $this->call('userGroupAssign', $input);
    }

    public function userGroupCopy(array $input = []): XiboResponse
    {
        return $this->call('userGroupCopy', $input);
    }

    public function userGroupDelete(array $input = []): XiboResponse
    {
        return $this->call('userGroupDelete', $input);
    }

    public function userGroupEdit(array $input = []): XiboResponse
    {
        return $this->call('userGroupEdit', $input);
    }

    public function userGroupSearch(array $input = []): XiboResponse
    {
        return $this->call('userGroupSearch', $input);
    }

    public function userGroupSearchById(array $input = []): XiboResponse
    {
        return $this->call('userGroupSearchById', $input);
    }

    public function userGroupUnassign(array $input = []): XiboResponse
    {
        return $this->call('userGroupUnassign', $input);
    }

}
