<?php

namespace backend\models\table;

use backend\models\Role;
use common\utils\table\DataTable;
use yii\helpers\Url;

class RoleTable extends DataTable
{
    /**
     * Lấy giá trị từ form filter
     */
    /*
    public function __construct( ) {
        parent::__construct();
        $arguments = Yii::$app->request->post();
        if ( array_key_exists( 'filter', $arguments ) ) {
            parse_str( $arguments['filter'], $datas );
            $this->filterDatas = $datas;
        }
    }
    */

    /**
     * Tạo danh sách Role
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public function getData()
    {
        $models    = $this->getModels();
        $dataArray = [];
        foreach ($models as $model) {
            $htmlAction = "<a class='btn btn-warning link-view-role' data-id='$model->id' href=" . Url::to(['view', 'id' => $model->id]) . "><i class='glyphicon glyphicon-eye-open'></i> </a>";
            $htmlAction .= " <a class='btn btn-info link-update-role' data-id='$model->id' href=" . Url::to(['update', 'id' => $model->id]) . "><i class='glyphicon glyphicon-edit'></i> </a>";
            $htmlAction .= " <button class='btn btn-danger btn-delete-role' data-id='$model->id' data-url='" . Url::to(['delete']) . "'><i class='glyphicon glyphicon-trash'></i> </button>";
            $dataArray[] = [
                "<input class='cb-single' type='checkbox' data-id='$model->id'>",
                $model->name,
                $model->status,
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * Tìm Role theo dữ liệu đầu vào
     * @return Role[]
     */
    public function getModels()
    {
        $column             = $this->getColumn();
        $models             = Role::find()->visible();
        $this->totalRecords = $models->count();
        $models             = $models->limit($this->length)
                                     ->offset($this->start)
                                     ->orderBy([$column => $this->direction])
                                     ->all();

        return $models;
    }

    /**
     * Lấy cột muốn sắp xếp
     * @return string
     */
    public function getColumn()
    {
        switch ($this->column) {
            case '1':
                $field = 'name';
                break;
            case '2':
                $field = 'role';
                break;
            default:
                $field = 'id';
                break;
        }

        return $field;
    }
}

?>