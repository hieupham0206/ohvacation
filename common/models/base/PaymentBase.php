<?php

namespace common\models\base;

use common\models\Customer;
use common\models\Orders;
use common\models\query\PaymentQuery;
use common\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment".
 *
 * @property string $id
 * @property integer $modified_by
 * @property integer $created_date
 * @property integer $modified_date
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $customer_email
 * @property string $transaction_info
 * @property double $total_price
 * @property string $order_code
 * @property string $voucher_code
 * @property string $payment_option
 * @property string $response_code
 * @property string $message
 * @property integer $type
 * @property string $note
 * @property string $ip
 * @property string $orders_id
 * @property integer $customer_id
 *
 * @property User $modifiedBy
 * @property Orders $orders
 * @property Customer $customer
 */
class PaymentBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     * @return PaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total_price'], 'number'],
            [['message', 'note'], 'string'],
            [['type', 'orders_id', 'customer_id'], 'integer'],
            [['orders_id', 'customer_id'], 'required'],
            [['customer_name', 'customer_phone', 'transaction_info'], 'string', 'max' => 50],
            [['customer_email'], 'string', 'max' => 100],
            [['order_code'], 'string', 'max' => 10],
            [['response_code'], 'string', 'max' => 5],
            [['ip'], 'string', 'max' => 20],
            [['id'], 'filter', 'filter' => 'intval']
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Orders::className(), ['id' => 'orders_id'])->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id'])->where(['status' => 1]);
    }
}
