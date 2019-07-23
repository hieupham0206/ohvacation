<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 5/4/2017
 * Time: 11:22 AM
 */

namespace frontend\models;

use common\models\Customer;
use common\models\Inventory;
use common\models\Orders;
use common\models\OrdersDetail;
use common\models\Payment;
use common\models\Voucher;
use common\utils\helpers\ArrayHelper;
use common\utils\helpers\ClientHelper;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;

class OrderForm {
	const DOMESTIC_PAYPENT = 0;
	const VISA_PAYPENT = 1;

	public function getOrdersAmount( $roomIds ) {
		$inventories = Inventory::find()->where( [ 'status' => 0, 'id' => $roomIds ] )->select( [ 'price', 'stay_date', 'id' ] )->all();

		return array_sum( ArrayHelper::getColumn( $inventories, 'price' ) );
	}

	/**
	 * Hàm tạo Orders, OrdersDetail và Payment
	 *
	 * @param $totalAmount
	 * @param array $inventories
	 * @param $paymentOption
	 * @param int $type : 0 nội địa, 1 visa
	 *
	 * @return string
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\db\Exception
	 */
	public function createOrder( $totalAmount, array $inventories, $paymentOption, $type = 0 ) {
		$customerName  = Yii::$app->session->get( 'customerName' );
		$customerPhone = Yii::$app->session->get( 'customerPhone' );
		$customerId    = Yii::$app->session->get( 'customerId' );
		//$customerId    = 1;//test
		$voucherId   = Yii::$app->session->get( 'voucherId' );
		$note        = Yii::$app->session->get( 'note' );
		$transaction = Yii::$app->db->beginTransaction();
		try {
			/** @var Customer $customer */
			$customer = Customer::find()->where( [ 'id' => $customerId ] )->one();
//            if ($type == 0 && ($customer->email == 'minhtri2582@icloud.com' || $customer->email == 'nguyenhoanghuy279@gmail.com')) {
//                $totalAmount = 10000;
//            }
			$orders               = new Orders();
			$orders->customer_id  = $customerId;
			$orders->voucher_id   = $voucherId;
			$orders->total_price  = $totalAmount;
			$orders->created_date = strtotime( date( 'd.m.Y H:i:s' ) );
			$orders->updated_date = $orders->created_date;

			if ( $flag = $orders->save( false ) ) {
				$orderId = $orders->id;
				$orders->updateAttributes( [
					'code' => 'OVH-' . $customerId . '-' . $orderId
				] );

				/** @var Voucher $voucher */
				$voucher = Voucher::find()->where( [ 'id' => $voucherId ] )->one();

				$detailDatas = [];
				/** @var Inventory[] $inventories */
				foreach ( $inventories as $inventory ) {
					$detailDatas[] = [
						$inventory->id,
						$orderId,
						750000
					];
					$inventory->updateAttributes( [
						'inventory_status' => 2,
					] );
				}

				$row = Yii::$app->db->createCommand()
				                    ->batchInsert( OrdersDetail::tableName(), [
					                    'inventory_id',
					                    'orders_id',
					                    'price'
				                    ], $detailDatas )
				                    ->execute();

				$ip     = ClientHelper::getUserIP( false );
				$params = array(
					'total_price'    => $orders->total_price,
					'ip'             => $ip,
					'order_code'     => $orders->code,
					'voucher_code'   => $voucher->code,
					'customer_name'  => empty( $customerName ) ? $customer->name : $customerName,
					'customer_phone' => empty( $customerPhone ) ? $customer->phone : $customerPhone,
					'customer_email' => $customer->email,
					'orders_id'      => $orders->id,
					'customer_id'    => $customer->id,
					'type'           => $type,
					'payment_option' => $paymentOption,
					'note'           => $note,
				);
				if ( $row > 0 ) {
					if ( Payment::createPayment( $params ) ) {
						Yii::$app->session->set( 'orders', $orders );
						$transaction->commit();

						return Url::to( [ 'order-confirmation' ], true );
					}
				}
			}

			return 'fail';
		} catch ( Exception $e ) {
			$transaction->rollBack();

			return $e->getMessage();
		}
	}
}