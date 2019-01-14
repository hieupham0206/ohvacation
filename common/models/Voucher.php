<?php

namespace common\models;

use common\models\base\VoucherBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Voucher extends VoucherBase
{
    public function behaviors()
    {
        return [
            [
                'class'              => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'modified_by',
            ],
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'modified_date',
                'value'              => strtotime(date('d.m.Y H:i:s')),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_name'   => 'Tên khách hàng',
            'companion'     => 'Husband/Wife',
            'phone'         => 'Số điện thoại',
            'email'         => 'Email',
            'code'          => 'Mã Voucher',
            'orders_code'   => 'Mã đơn hàng',
            'survey_code'   => 'Mã Survey',
            'created_date'  => 'Created Date',
            'modified_date' => 'Modified Date',
            'created_by'    => 'Created By',
            'modified_by'   => 'Modified By',
            'status'        => 'Trạng thái',
            'voucher_type'  => 'Loại voucher',
        ];
    }

    public function isOldType()
    {
        return $this->voucher_type == 1;
    }

    public function getVoucherTypeText()
    {
        return $this->isOldType() ? 'Cũ' : 'Mới';
    }

    //	public function beforeSave( $insert ) {
    //		if ( parent::beforeSave( $insert ) ) {
    //			if ( $insert ) {
    //				//nếu là thêm mới
    //			}
    //
    //			return true;
    //		} else {
    //			return false;
    //		}
    //	}
}
