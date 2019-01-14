<?php

namespace common\models\base;
use yii\db\ActiveRecord;
use common\models\query\CustomerQuery;
use common\models\Orders;
use common\models\Payment;


/**
* This is the model class for table "customer".
*
* @property integer $id
* @property string $name
* @property string $companion
* @property string $cmnd
* @property string $phone
* @property string $email
* @property string $OTP
* @property integer $otp_date
* @property integer $created_date
* @property integer $is_verified
* @property integer $verified_date
* @property integer $voucher_id
*
* @property Orders[] $orders
* @property Payment[] $payments
*/
class CustomerBase extends ActiveRecord {
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],
            [['otp_date', 'is_verified', 'verified_date'], 'integer'],
            [['name'], 'string', 'max' => 300],
            [['companion', 'email'], 'string', 'max' => 100],
            [['cmnd'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['id'], 'filter', 'filter' => 'intval'],
            ['email', 'email'],
            ['phone', 'string', 'length' => [9, 11]],
            ['name', 'string'],
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['customer_id' => 'id'])->where(['status' => 1]);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['customer_id' => 'id'])->where(['status' => 1]);
    }
}
