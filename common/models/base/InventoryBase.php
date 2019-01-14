<?php

namespace common\models\base;
use yii\db\ActiveRecord;
use common\models\query\InventoryQuery;
use common\models\OrdersDetail;


/**
* This is the model class for table "inventory".
*
* @property string $id
* @property integer $stay_date
* @property integer $created_date
* @property integer $modified_date
* @property integer $created_by
* @property integer $modified_by
* @property integer $sold_date
* @property integer $status
* @property integer $inventory_status
* @property string $note
*
* @property OrdersDetail[] $ordersDetails
*/
class InventoryBase extends ActiveRecord {
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * @inheritdoc
     * @return InventoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InventoryQuery(get_called_class());
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['stay_date', 'sold_date', 'status', 'inventory_status'], 'integer'],
            [['status'], 'required'],
            [['note'], 'string'],
            [['id'], 'filter', 'filter' => 'intval']
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrdersDetails()
    {
        return $this->hasMany(OrdersDetail::className(), ['inventory_id' => 'id']);
    }
}
