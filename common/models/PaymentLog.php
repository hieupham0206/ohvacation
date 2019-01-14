<?php

namespace common\models;

use common\models\base\PaymentLogBase;

class PaymentLog extends PaymentLogBase {

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'payment_id'   => 'Payment',
			'message'      => 'Message',
			'created_date' => 'Created Date',
			'created_by'   => 'Created By',
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
