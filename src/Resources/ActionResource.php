<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class ActionResource extends BaseResource
{
    public function actionAdd(array $input = []): XiboResponse
    {
        return $this->call('actionAdd', $input);
    }

    public function actionDelete(array $input = []): XiboResponse
    {
        return $this->call('actionDelete', $input);
    }

    public function actionEdit(array $input = []): XiboResponse
    {
        return $this->call('actionEdit', $input);
    }

    public function actionSearch(array $input = []): XiboResponse
    {
        return $this->call('actionSearch', $input);
    }

}
