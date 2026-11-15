<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class LayoutResource extends BaseResource
{
    public function layoutAdd(array $input = []): XiboResponse
    {
        return $this->call('layoutAdd', $input);
    }

    public function layoutAddFullScreen(array $input = []): XiboResponse
    {
        return $this->call('layoutAddFullScreen', $input);
    }

    public function layoutApplyTemplate(array $input = []): XiboResponse
    {
        return $this->call('layoutApplyTemplate', $input);
    }

    public function layoutCheckout(array $input = []): XiboResponse
    {
        return $this->call('layoutCheckout', $input);
    }

    public function layoutClear(array $input = []): XiboResponse
    {
        return $this->call('layoutClear', $input);
    }

    public function layoutCopy(array $input = []): XiboResponse
    {
        return $this->call('layoutCopy', $input);
    }

    public function layoutDelete(array $input = []): XiboResponse
    {
        return $this->call('layoutDelete', $input);
    }

    public function layoutDiscard(array $input = []): XiboResponse
    {
        return $this->call('layoutDiscard', $input);
    }

    public function layoutEdit(array $input = []): XiboResponse
    {
        return $this->call('layoutEdit', $input);
    }

    public function layoutEditBackground(array $input = []): XiboResponse
    {
        return $this->call('layoutEditBackground', $input);
    }

    public function layoutPublish(array $input = []): XiboResponse
    {
        return $this->call('layoutPublish', $input);
    }

    public function layoutRetire(array $input = []): XiboResponse
    {
        return $this->call('layoutRetire', $input);
    }

    public function layoutSearch(array $input = []): XiboResponse
    {
        return $this->call('layoutSearch', $input);
    }

    public function layoutSetEnableStat(array $input = []): XiboResponse
    {
        return $this->call('layoutSetEnableStat', $input);
    }

    public function layoutStatus(array $input = []): XiboResponse
    {
        return $this->call('layoutStatus', $input);
    }

    public function layoutTag(array $input = []): XiboResponse
    {
        return $this->call('layoutTag', $input);
    }

    public function layoutUnretire(array $input = []): XiboResponse
    {
        return $this->call('layoutUnretire', $input);
    }

    public function layoutUntag(array $input = []): XiboResponse
    {
        return $this->call('layoutUntag', $input);
    }

    public function regionAdd(array $input = []): XiboResponse
    {
        return $this->call('regionAdd', $input);
    }

    public function regionDelete(array $input = []): XiboResponse
    {
        return $this->call('regionDelete', $input);
    }

    public function regionDrawerAdd(array $input = []): XiboResponse
    {
        return $this->call('regionDrawerAdd', $input);
    }

    public function regionDrawerSave(array $input = []): XiboResponse
    {
        return $this->call('regionDrawerSave', $input);
    }

    public function regionEdit(array $input = []): XiboResponse
    {
        return $this->call('regionEdit', $input);
    }

    public function regionPositionAll(array $input = []): XiboResponse
    {
        return $this->call('regionPositionAll', $input);
    }

}
