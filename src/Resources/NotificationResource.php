<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class NotificationResource extends BaseResource
{
    public function notificationAdd(array $input = []): XiboResponse
    {
        return $this->call('notificationAdd', $input);
    }

    public function notificationDelete(array $input = []): XiboResponse
    {
        return $this->call('notificationDelete', $input);
    }

    public function notificationEdit(array $input = []): XiboResponse
    {
        return $this->call('notificationEdit', $input);
    }

    public function notificationGetById(array $input = []): XiboResponse
    {
        return $this->call('notificationGetById', $input);
    }

    public function notificationSearch(array $input = []): XiboResponse
    {
        return $this->call('notificationSearch', $input);
    }

}
