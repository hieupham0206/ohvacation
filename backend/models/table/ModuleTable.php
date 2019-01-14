<?php

namespace backend\models\table;

use backend\models\Module;
use common\utils\table\DataTable;

class ModuleTable extends DataTable
{
    /**
     * Tạo danh sách Module
     * @return array
     */
    public function getData()
    {
        $models    = $this->getModels();
        $dataArray = [];
        foreach ($models as $model) {
            $htmlAction = " <a class='btn btn-info btn-update-module' data-id='$model->id'><i class='glyphicon glyphicon-edit'></i> </a>";
            $htmlAction .= " <a class='btn btn-danger btn-delete-module' data-id='$model->id'><i class='glyphicon glyphicon-trash'></i> </a>";
            $dataArray[] = [
                "<input class='cb-single' type='checkbox' data-id='$model->id'>",
                $model->name,
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * Tìm Module theo dữ liệu đầu vào
     * @return Module[]
     */
    public function getModels()
    {
        $models             = Module::find();
        $this->totalRecords = $models->count();
        $models             = $models->limit($this->length)
                                     ->offset($this->start)
                                     ->orderBy(['id' => $this->direction])
                                     ->all();

        return $models;
    }

    public function getColumn()
    {
        return [];
    }
}

?>