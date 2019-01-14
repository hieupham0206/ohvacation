<?php

namespace common\models;

use common\models\base\OrdersBase;

class Orders extends OrdersBase
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id'    => 'Customer',
            'code'           => 'Code',
            'updated_date'   => 'Updated Date',
            'updated_by'     => 'Updated By',
            'total_price'    => 'Total Price',
            'payment_status' => 'Payment Status',
        ];
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
