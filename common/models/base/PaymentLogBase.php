<?php

namespace common\models\base;
use yii\db\ActiveRecord;

use common\models\Payment;
use common\models\User;


/**
* This is the model class for table "payment_log".
*
* @property integer $id
* @property string $payment_id
* @property string $message
* @property integer $created_date
* @property integer $created_by
*
* @property Payment $payment
* @property User $createdBy
*/
class PaymentLogBase extends ActiveRecord {
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'payment_log';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['payment_id', 'message'], 'required'],
            [['payment_id'], 'integer'],
            [['message'], 'string'],
            [['id'], 'filter', 'filter' => 'intval']
        ];
    }


    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['id' => 'payment_id'])->where(['status' => 1]);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->where(['status' => 1]);
    }
}
