<?php

namespace common\models;
use \common\models\base\OrdersDetailBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
class OrdersDetail extends OrdersDetailBase{

	/**
	* @inheritdoc
	*/
	public function attributeLabels()
	{
		return [
			'inventory_id' => 'Inventory',
			'orders_id' => 'Orders',
			'price' => 'Price',
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
