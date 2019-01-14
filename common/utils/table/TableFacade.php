<?php
namespace common\utils\table;

/**
 * Class TableFacade
 * @property DataTable $dataTable
 * @package common\utils\table
 */
class TableFacade
{
    private $dataTable;

    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    private function getData()
    {
        return $this->dataTable->getData();
    }

    private function getDraw()
    {
        return $this->dataTable->draw;
    }

    private function getTotalRecord()
    {
        return $this->dataTable->totalRecords;
    }

    private function getTotalFiltered()
    {
        return $this->dataTable->totalRecords;
    }

    public function getDataTable()
    {
        $data = [
            'data'            => $this->getData(),
            'draw'            => $this->getDraw(),
            'recordsTotal'    => $this->getTotalRecord(),
            'recordsFiltered' => $this->getTotalFiltered(),
        ];

        return json_encode($data);
    }
}

?>