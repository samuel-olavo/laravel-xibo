<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class UserResource extends BaseResource
{
    public function userAdd(array $input = []): XiboResponse
    {
        return $this->call('userAdd', $input);
    }

    public function userApplicationsGrid(array $input = []): XiboResponse
    {
        return $this->call('userApplicationsGrid', $input);
    }

    public function userDelete(array $input = []): XiboResponse
    {
        return $this->call('userDelete', $input);
    }

    public function userEdit(array $input = []): XiboResponse
    {
        return $this->call('userEdit', $input);
    }

    public function userMe(array $input = []): XiboResponse
    {
        return $this->call('userMe', $input);
    }

    public function userPermissionsMultiSearch(array $input = []): XiboResponse
    {
        return $this->call('userPermissionsMultiSearch', $input);
    }

    public function userPermissionsMultiSet(array $input = []): XiboResponse
    {
        return $this->call('userPermissionsMultiSet', $input);
    }

    public function userPermissionsSearch(array $input = []): XiboResponse
    {
        return $this->call('userPermissionsSearch', $input);
    }

    public function userPermissionsSet(array $input = []): XiboResponse
    {
        return $this->call('userPermissionsSet', $input);
    }

    public function userPrefEdit(array $input = []): XiboResponse
    {
        return $this->call('userPrefEdit', $input);
    }

    public function userPrefEditFromForm(array $input = []): XiboResponse
    {
        return $this->call('userPrefEditFromForm', $input);
    }

    public function userPrefGet(array $input = []): XiboResponse
    {
        return $this->call('userPrefGet', $input);
    }

    public function userSearch(array $input = []): XiboResponse
    {
        return $this->call('userSearch', $input);
    }

    public function userSearchById(array $input = []): XiboResponse
    {
        return $this->call('userSearchById', $input);
    }

}
