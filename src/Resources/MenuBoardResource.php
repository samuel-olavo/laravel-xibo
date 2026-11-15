<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class MenuBoardResource extends BaseResource
{
    public function menuBoardAdd(array $input = []): XiboResponse
    {
        return $this->call('menuBoardAdd', $input);
    }

    public function menuBoardCategoryAdd(array $input = []): XiboResponse
    {
        return $this->call('menuBoardCategoryAdd', $input);
    }

    public function menuBoardCategoryCopy(array $input = []): XiboResponse
    {
        return $this->call('menuBoardCategoryCopy', $input);
    }

    public function menuBoardCategoryDelete(array $input = []): XiboResponse
    {
        return $this->call('menuBoardCategoryDelete', $input);
    }

    public function menuBoardCategoryEdit(array $input = []): XiboResponse
    {
        return $this->call('menuBoardCategoryEdit', $input);
    }

    public function menuBoardCategorySearch(array $input = []): XiboResponse
    {
        return $this->call('menuBoardCategorySearch', $input);
    }

    public function menuBoardCategorySearchById(array $input = []): XiboResponse
    {
        return $this->call('menuBoardCategorySearchById', $input);
    }

    public function menuBoardCopy(array $input = []): XiboResponse
    {
        return $this->call('menuBoardCopy', $input);
    }

    public function menuBoardDelete(array $input = []): XiboResponse
    {
        return $this->call('menuBoardDelete', $input);
    }

    public function menuBoardEdit(array $input = []): XiboResponse
    {
        return $this->call('menuBoardEdit', $input);
    }

    public function menuBoardProductAdd(array $input = []): XiboResponse
    {
        return $this->call('menuBoardProductAdd', $input);
    }

    public function menuBoardProductDelete(array $input = []): XiboResponse
    {
        return $this->call('menuBoardProductDelete', $input);
    }

    public function menuBoardProductEdit(array $input = []): XiboResponse
    {
        return $this->call('menuBoardProductEdit', $input);
    }

    public function menuBoardProductSearchById(array $input = []): XiboResponse
    {
        return $this->call('menuBoardProductSearchById', $input);
    }

    public function menuBoardProductsSearch(array $input = []): XiboResponse
    {
        return $this->call('menuBoardProductsSearch', $input);
    }

    public function menuBoardSearch(array $input = []): XiboResponse
    {
        return $this->call('menuBoardSearch', $input);
    }

    public function menuBoardSearchById(array $input = []): XiboResponse
    {
        return $this->call('menuBoardSearchById', $input);
    }

    public function menuBoardSelectFolder(array $input = []): XiboResponse
    {
        return $this->call('menuBoardSelectFolder', $input);
    }

}
