<?php

namespace backend\models\table;

use common\models\Orders;
use common\models\Voucher;
use common\utils\helpers\ArrayHelper;
use common\utils\table\DataTable;
use Yii;
use yii\helpers\Url;

class VoucherTable extends DataTable
{
    /*public function __construct() {
		parent::__construct();
        $arguments = Yii::$app->request->post();
	}*/

    /**
     * Tạo danh sách Voucher
     * .
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public function getData()
    {
        $models    = $this->getModels();
        $dataArray = [];
        foreach ($models as $model) {
            $orderCode = '';
            $orders    = Orders::find()->where(['voucher_id' => $model->id])->all();
            $orderSuccess = ArrayHelper::_filter($orders, function($order) {
                return $order->payment_status == 1;
            });
            /** @var Orders[] $orders */
            foreach ($orders as $order) {
                $orderCode .= "<a class='link-order-detail' href='javascript:void(0)' data-order-id='{$order->id}'>{$order->code}</a>" . ', ';
            }

            $htmlAction = "<a class='btn btn-warning link-view-voucher' title='Xem' data-id='$model->id' href='" . Url::to(['view', 'id' => $model->id]) . "'><i class='glyphicon glyphicon-eye-open'></i> </a>";
//            if (Yii::$app->permission->can(Yii::$app->controller->id, 'update')) {
                $htmlAction .= " <a class='btn btn-info btn-update-voucher' title='Sửa' data-id='$model->id' href='" . Url::to(['update', 'id' => $model->id]) . "'><i class='glyphicon glyphicon-edit'></i> </a>";
//            }
//            if (Yii::$app->permission->can(Yii::$app->controller->id, 'delete')) {
                $htmlAction .= " <button class='btn btn-danger btn-delete-voucher' title='Xóa' data-id='$model->id' data-url='" . Url::to(['delete']) . "'><i class='glyphicon glyphicon-trash'></i> </button>";
//            }
            $dataArray[] = [
                $model->client_name,
                $model->companion,
                $model->phone,
                $model->email,
                $model->code,
                $model->survey_code,
                $orderCode != '' ? substr($orderCode, 0, -2) : $orderCode,
//                count($orderSuccess) > 0 ? 'Đã bán' : '',
                $model->getVoucherTypeText(),
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * Tìm Voucher.
     * @return Voucher[].
     */
    public function getModels()
    {
        $column = $this->getColumn();
        $models = Voucher::find()->where(['voucher.status' => 1])->distinct()->andFilterWhere([
            'and',
            ['like', 'client_name', $this->filterDatas['client_name']],
            ['like', 'phone', $this->filterDatas['phone']],
            ['like', 'email', $this->filterDatas['email']],
            ['like', 'code', $this->filterDatas['code']],
            ['like', 'survey_code', $this->filterDatas['survey_code']],
        ]);

        if (trim($this->filterDatas['orders_code']) != '') {
            $models = $models->joinWith(['orders'])->andFilterWhere(['like', 'orders.code', trim($this->filterDatas['orders_code'])]);
        }

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
                $field = 'client_name';
                break;
            case '2':
                $field = 'companion';
                break;
            case '3':
                $field = 'phone';
                break;
            case '4':
                $field = 'email';
                break;
            case '5':
                $field = 'code';
                break;
            case '6':
                $field = 'survey_code';
                break;
            default:
                $field = 'id';
                break;
        }

        return $field;
    }
}

?>