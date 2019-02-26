<?php

namespace backend\models\table;

use common\models\Inventory;
use common\utils\helpers\ArrayHelper;
use common\utils\table\DataTable;
use Yii;
use yii\db\ActiveQuery;

class InventoryFilterTable extends DataTable
{
    public $direction = SORT_ASC;
    public $type;

    public function __construct()
    {
        parent::__construct();
        $arguments = Yii::$app->request->post();
        if (array_key_exists('type', $arguments)) {
            $this->type = 1;
        }
    }

    /**
     * Tạo danh sách Inventory
     * .
     * @return array
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function getData()
    {
        $models    = $this->getModels();
        $dataArray = [];
        foreach ($models as $model) {
//            $details = Yii::$app->db->createCommand(" SELECT DATE(from_unixtime(stay_date)),
//  inventory_status,
//  count(*) AS total
//FROM `inventory`
//WHERE `status` = 1 AND stay_date = '{$model['stay_date']}'
//GROUP BY inventory_status")->queryAll();

            $details     = $this->getModels($model['stay_date']);
            $sold        = ArrayHelper::flatten(ArrayHelper::_filter($details, function ($arrs) {
                return $arrs['inventory_status'] == 1;
            }));
            $wait        = ArrayHelper::flatten(ArrayHelper::_filter($details, function ($arrs) {
                return $arrs['inventory_status'] == 2;
            }));
            $stock       = ArrayHelper::flatten(ArrayHelper::_filter($details, function ($arrs) {
                return $arrs['inventory_status'] == 0;
            }));
            $dataArray[] = [
                \Yii::$app->formatter->asDate($model['stay_date']),
                $model['total'],
                ! empty($stock) ? $stock[2] : 0,
                ! empty($wait) ? $wait[2] : 0,
                ! empty($sold) ? $sold[2] : 0,
                $this->type == null ? '<button class="btn btn-warning btn-inventory-detail" data-date="' . Yii::$app->formatter->asDate($model['stay_date']) . '"><i class=\'glyphicon glyphicon-eye-open\'></i> </button>' : ''
//                ' <button title="Khóa ngày" data-date="'.$model['stay_date'].'" class="btn btn-danger btn-lock-date"><i class=\'glyphicon glyphicon-lock\'></i> </button>' .
//                ' <button title="Mở ngày" data-date="'.$model['stay_date'].'" class="btn btn-success btn-open-date"><i class=\'glyphicon glyphicon-check\'></i> </button>'
            ];
        }
        var_dump($models);die;
        Yii::$app->cache->set( 'filterTable', $dataArray);
        return $dataArray;
    }

    /**
     * Tìm Inventory.
     *
     * @param null $stayDate
     *
     * @return Inventory[] .
     * @internal param int $type
     *
     */
    public function getModels($stayDate = null)
    {
        $status = $this->filterDatas['status'];
        $models = Inventory::find()->andFilterWhere([
            'and',
//            ['stay_date' => \Yii::$app->formatter->asTimestamp(str_replace('/', '-', $this->filterDatas['stay_date']))],
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
        if (ArrayHelper::compact($this->filterDatas)) {
            $this->totalRecords = $models->groupBy(['stay_date'])->count();
        } else {
            $this->totalRecords = Inventory::find()->groupBy('stay_date')->count();
        }

        if ($stayDate == null) {
            $models = $models->limit($this->length)
                             ->offset($this->start)
                             ->orderBy(['stay_date' => $this->direction])
                             ->groupBy('DATE(from_unixtime(stay_date))')
                             ->select('stay_date, count(*) as total')->createCommand()->queryAll();
        } else {

            var_dump($models->andFilterWhere(['stay_date' => $stayDate])->limit($this->length)
                            ->offset($this->start)
                            ->orderBy(['stay_date' => $this->direction])
                            ->groupBy('inventory_status')
                            ->select('DATE(from_unixtime(stay_date)), inventory_status, count(*) AS total')->createCommand()->getRawSql());
            $models = $models->andFilterWhere(['stay_date' => $stayDate])->limit($this->length)
                             ->offset($this->start)
                             ->orderBy(['stay_date' => $this->direction])
                             ->groupBy('inventory_status')
                             ->select('DATE(from_unixtime(stay_date)), inventory_status, count(*) AS total')->createCommand()->queryAll();
//                             ->select('DATE(from_unixtime(stay_date)), inventory_status, count(*) AS total')->createCommand()->getRawSql();
//            var_dump($models);die;
        }

        return $models;
    }

    public function getColumn()
    {
        // TODO: Implement getColumn() method.
    }
}

?>