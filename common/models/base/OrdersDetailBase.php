<?php

namespace common\models\base;
use yii\db\ActiveRecord;

use common\models\Inventory;
use common\models\Orders;


/**
* This is the model class for table "orders_detail".
*
* @property string $id
* @property string $inventory_id
* @property string $orders_id
* @property integer $price
*
* @property Inventory $inventory
* @property Orders $orders
*/
class OrdersDetailBase extends ActiveRecord {
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'orders_detail';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['inventory_id', 'orders_id'], 'required'],
            [['inventory_id', 'orders_id', 'price'], 'integer'],
            [['id'], 'filter', 'filter' => 'intval']
        ];
    }


    /**
    * @return \yii\db\ActiveQuery
    */
    public function getInventory()
    {
        return $this->hasOne(Inventory::className(), ['id' => 'inventory_id'])->where(['status' => 1]);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrders()
    {
        return $this->hasOne(Orders::className(), ['id' => 'orders_id'])->where(['orders.status' => 1]);
    }
}
