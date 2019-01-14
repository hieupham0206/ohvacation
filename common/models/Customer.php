<?php

namespace common\models;

use common\models\base\CustomerBase;
use Yii;

/**
 * Class Customer
 * @property string $code
 * @package common\models
 */
class Customer extends CustomerBase
{
    public $code;

    public static function isVerified($customerId)
    {
        /** @var Customer $customer */
        $customer = Customer::find()->where(['id' => $customerId])->select(['is_verified'])->one();

        return $customer != null && $customer->is_verified == 1;
    }

    public static function isNew($customerId)
    {
        /** @var Orders $orderOfCustomer */
        $orderOfCustomer = Orders::find()->where(['payment_status' => 1, 'customer_id' => $customerId])->one();

        return $customerId != '' && $orderOfCustomer == null;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['code', 'required']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'          => Yii::t('yii', 'Full Name *'),
            'cmnd'          => 'Cmnd',
            'phone'         => Yii::t('yii', 'Phone *'),
            'email'         => 'Email *',
            'OTP'           => 'Otp',
            'otp_date'      => 'Otp Date',
            'is_verified'   => 'Is Verified',
            'verified_date' => 'Verified Date',
            'code'          => Yii::t('yii','Code Voucher *'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_date = strtotime(date('d.m.Y H:i:s'));
            }

            return true;
        } else {
            return false;
        }
    }
}
