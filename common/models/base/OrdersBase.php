<?php

namespace common\models\base;

use common\models\Customer;
use common\models\OrdersDetail;
use common\models\Payment;
use common\models\query\OrdersQuery;
use common\models\Voucher;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property string $id
 * @property integer $customer_id
 * @property integer $voucher_id
 * @property string $code
 * @property integer $created_date
 * @property integer $updated_date
 * @property integer $updated_by
 * @property double $total_price
 * @property integer $status
 * @property integer $payment_status
 *
 * @property Customer $customer
 * @property Voucher $voucher
 * @property OrdersDetail[] $ordersDetails
 * @property Payment[] $payments
 */
class OrdersBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id'], 'required'],
            [['customer_id', 'voucher_id', 'updated_date', 'updated_by', 'status', 'payment_status'], 'integer'],
            [['total_price'], 'number'],
            [['code'], 'string', 'max' => 50],
            [['id'], 'filter', 'filter' => 'intval']
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoucher()
    {
        return $this->hasOne(Voucher::className(), ['id' => 'voucher_id'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersDetails()
    {
        return $this->hasMany(OrdersDetail::className(), ['orders_id' => 'id'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['orders_id' => 'id']);
    }
}
