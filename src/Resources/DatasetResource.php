<?php

namespace SamuelOlavo\LaravelXibo\Resources;

use SamuelOlavo\LaravelXibo\Http\XiboResponse;

/** Generated from Xibo API specifications. */
final class DatasetResource extends BaseResource
{
    public function dataSetAdd(array $input = []): XiboResponse
    {
        return $this->call('dataSetAdd', $input);
    }

    public function dataSetColumnAdd(array $input = []): XiboResponse
    {
        return $this->call('dataSetColumnAdd', $input);
    }

    public function dataSetColumnDelete(array $input = []): XiboResponse
    {
        return $this->call('dataSetColumnDelete', $input);
    }

    public function dataSetColumnEdit(array $input = []): XiboResponse
    {
        return $this->call('dataSetColumnEdit', $input);
    }

    public function dataSetColumnSearch(array $input = []): XiboResponse
    {
        return $this->call('dataSetColumnSearch', $input);
    }

    public function dataSetCopy(array $input = []): XiboResponse
    {
        return $this->call('dataSetCopy', $input);
    }

    public function dataSetData(array $input = []): XiboResponse
    {
        return $this->call('dataSetData', $input);
    }

    public function dataSetDataAdd(array $input = []): XiboResponse
    {
        return $this->call('dataSetDataAdd', $input);
    }

    public function dataSetDataConnectorEdit(array $input = []): XiboResponse
    {
        return $this->call('dataSetDataConnectorEdit', $input);
    }

    public function dataSetDataDelete(array $input = []): XiboResponse
    {
        return $this->call('dataSetDataDelete', $input);
    }

    public function dataSetDataEdit(array $input = []): XiboResponse
    {
        return $this->call('dataSetDataEdit', $input);
    }

    public function dataSetDelete(array $input = []): XiboResponse
    {
        return $this->call('dataSetDelete', $input);
    }

    public function dataSetEdit(array $input = []): XiboResponse
    {
        return $this->call('dataSetEdit', $input);
    }

    public function dataSetExportCsv(array $input = []): XiboResponse
    {
        return $this->call('dataSetExportCsv', $input);
    }

    public function dataSetImport(array $input = []): XiboResponse
    {
        return $this->call('dataSetImport', $input);
    }

    public function dataSetImportJson(array $input = []): XiboResponse
    {
        return $this->call('dataSetImportJson', $input);
    }

    public function dataSetRSSDelete(array $input = []): XiboResponse
    {
        return $this->call('dataSetRSSDelete', $input);
    }

    public function dataSetRSSSearch(array $input = []): XiboResponse
    {
        return $this->call('dataSetRSSSearch', $input);
    }

    public function dataSetRssAdd(array $input = []): XiboResponse
    {
        return $this->call('dataSetRssAdd', $input);
    }

    public function dataSetRssEdit(array $input = []): XiboResponse
    {
        return $this->call('dataSetRssEdit', $input);
    }

    public function dataSetSearch(array $input = []): XiboResponse
    {
        return $this->call('dataSetSearch', $input);
    }

    public function dataSetSelectFolder(array $input = []): XiboResponse
    {
        return $this->call('dataSetSelectFolder', $input);
    }

    public function datasetColumnSearchById(array $input = []): XiboResponse
    {
        return $this->call('datasetColumnSearchById', $input);
    }

    public function datasetRssSearchById(array $input = []): XiboResponse
    {
        return $this->call('datasetRssSearchById', $input);
    }

    public function datasetSearchById(array $input = []): XiboResponse
    {
        return $this->call('datasetSearchById', $input);
    }

}
