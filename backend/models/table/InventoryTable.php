<?php

namespace backend\models\table;

use common\models\Inventory;
use common\models\OrdersDetail;
use common\utils\helpers\ArrayHelper;
use common\utils\table\DataTable;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;

class InventoryTable extends DataTable
{
    public $direction = SORT_ASC;
    private $stayDate;
    private $showDetail;

    public function __construct()
    {
		parent::__construct();
        $this->stayDate   = Yii::$app->request->post('stay_date', null);
        $this->showDetail = Yii::$app->request->post('detail', null);
    }

    /**
     * Tạo danh sách Inventory
     * .
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidParamException
     */
    public function getData()
    {
        $models = [];
        if ($this->showDetail == 1) {
            $models = $this->getModels();
        }
        $dataArray = [];
        foreach ($models as $model) {
            $orderCode = $soldDate = $customerName = $customerPhone = $customerEmail = $voucher = $action = '';
            if ( ! empty($model->ordersDetails) && $model->inventory_status > 0) {
                /** @var OrdersDetail $orderDetail */
                $orderDetail = $model->getOrdersDetails()->joinWith(['orders'])->where(['orders.payment_status' => [0, 1]])->one();
                if ($orderDetail != null) {
                    $orderCode     = "<a class='link-order-detail' href='javascript:void(0)' data-order-id='{$orderDetail->orders_id}'>{$orderDetail->orders->code}</a>";
                    $customerName  = $orderDetail->orders->payments[0]->customer_name;
                    $customerPhone = $orderDetail->orders->payments[0]->customer_phone;
                    $customerEmail = $orderDetail->orders->payments[0]->customer_email;
//                    $voucher       = $orderDetail->orders->voucher->code;
                }
            }
            $htmlAction = '';
            if ($model->status == 1 && $model->inventory_status == 0) {
                $htmlAction = " <button class='btn btn-danger btn-lock-room' title='Khóa phòng' data-id='$model->id' data-url='" . Url::to(['lock-room']) . "'><i class='glyphicon glyphicon-lock'></i> </button>";
            }
            if ($model->status == 0 && $model->inventory_status == 0) {
                $htmlAction = " <button class='btn btn-success btn-open-room' title='Mở phòng' data-id='$model->id' data-url='" . Url::to(['open-room']) . "'><i class='glyphicon glyphicon-check'></i> </button>";
            }
            $htmlAction  .= " <button class='btn btn-info btn-view-note' title='Xem ghi chú' data-id='$model->id' data-url='" . Url::to(['lock-room']) . "'><i class='glyphicon glyphicon-paperclip'></i> </button>";
            $dataArray[] = [
                \Yii::$app->formatter->asDate($model->stay_date),
                $model->getStatus(),
                \Yii::$app->formatter->asDate($model->sold_date),
                $orderCode,
                $customerName,
                $customerPhone,
                $customerEmail,
//                $voucher,
                $htmlAction
            ];
        }

        return $dataArray;
    }

    /**
     * Tìm Inventory.
     * @return Inventory[].
     */
    public function getModels()
    {
        $column = $this->getColumn();
        $status = $this->filterDatas['status'];
        $models = Inventory::find()
//                           ->andWhere(['stay_date' => \Yii::$app->formatter->asTimestamp($this->stayDate)])
                                   ->andFilterWhere([
            'and',
            ['between', 'sold_date', Yii::$app->formatter->asTimestamp(str_replace('/', '-', $this->filterDatas['sold_date_from'])), Yii::$app->formatter->asTimestamp(str_replace('/', '-', $this->filterDatas['sold_date_to']))],
                ['between', 'stay_date', Yii::$app->formatter->asTimestamp(str_replace('/', '-', $this->filterDatas['stay_date_from'])), Yii::$app->formatter->asTimestamp(str_replace('/', '-', $this->filterDatas['stay_date_to']))]
        ])->distinct();
        if ($status == -1) {
            $models = $models->andFilterWhere(['inventory.status' => 0]);
        } else {
            $models = $models->andWhere(['>=', 'inventory.status', 0])->andFilterWhere(['inventory_status' => $status]);
        }
        $filters = [trim($this->filterDatas['order_code']), trim($this->filterDatas['customer_name']), trim($this->filterDatas['customer_email']), trim($this->filterDatas['customer_phone'])];
        if ( ! empty(ArrayHelper::compact($filters))) {
            $models = $models->joinWith([
                'ordersDetails' => function (ActiveQuery $q) {
                    $q->joinWith(['orders'])->where(['payment_status' => [0, 1]]);
                }
            ])->andFilterWhere([
                'and',
                ['like', 'orders.code', trim($this->filterDatas['order_code'])],
                ['like', 'customer.name', trim($this->filterDatas['customer_name'])],
                ['like', 'customer.email', trim($this->filterDatas['customer_email'])],
                ['like', 'customer.phone', trim($this->filterDatas['customer_phone'])],
            ]);
        }
        $this->totalRecords = $models->count();
        $models             = $models->limit($this->length)
                                     ->offset($this->start)
                                     ->orderBy(['stay_date' => $this->direction])
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
                $field = 'stay_date';
                break;
            case '2':
                $field = 'sold_date';
                break;
            case '3':
                $field = 'inventory_status';
                break;
            case '4':
                $field = 'note';
                break;
            default:
                $field = 'stay_date';
                break;
        }

        return $field;
    }
}

?>