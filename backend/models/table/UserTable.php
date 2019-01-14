<?php

namespace backend\models\table;

use backend\models\User;
use common\utils\table\DataTable;
use yii\helpers\Url;

class UserTable extends DataTable
{
    /*public function __construct()
    {
        parent::__construct();
        $arguments = Yii::$app->request->post();
    }*/

    /**
     * Tạo danh sách User
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public function getData()
    {
        $models    = $this->getModels();
        $dataArray = [];
        foreach ($models as $model) {
            $htmlAction = "<a class='btn btn-warning link-view-user' data-id='$model->id' href=" . Url::to(['view', 'id' => $model->id]) . "><i class='glyphicon glyphicon-eye-open'></i> </a>";
            $htmlAction .= " <a class='btn btn-info link-update-user' data-id='$model->id' href=" . Url::to(['update', 'id' => $model->id]) . "><i class='glyphicon glyphicon-edit'></i> </a>";
//            $htmlAction .= " <a class='btn btn-info btn-toggle-status-user' data-id='$model->id'><i class='glyphicon glyphicon-edit'></i> </a>";
            $htmlAction  .= " <button class='btn btn-danger btn-delete-user' data-id='$model->id' data-url='" . Url::to(['delete']) . "'><i class='glyphicon glyphicon-trash'></i> </button>";
            $dataArray[] = [
                "<input class='cb-single' type='checkbox' data-id='$model->id'>",
                $model->username,
                $model->email,
                $model->phone,
                $model->extension,
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * Tìm User theo dữ liệu đầu vào
     * @return User[]
     */
    public function getModels()
    {
        $column             = $this->getColumn();
        $models             = User::find()->visible()->andWhere( ['!=' , 'username' , 'admin' ])->andFilterWhere([
            'and',
            ['username' => $this->filterDatas['username']],
            ['email' => $this->filterDatas['email']],
            ['phone' => $this->filterDatas['phone']],
//            ['status' => $this->filterDatas['status']]
        ]);
        $this->totalRecords = $models->count();
        $models             = $models->limit($this->length)->offset($this->start)->orderBy([$column => $this->direction])
                                                                                 ->select(['id', 'username', 'email', 'phone', 'status', 'extension'])->all();

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
                $field = 'username';
                break;
            case '2':
                $field = 'email';
                break;
            case '3':
                $field = 'phone';
                break;
            case '4':
                $field = 'status';
                break;
            default:
                $field = 'id';
                break;
        }

        return $field;
    }
}