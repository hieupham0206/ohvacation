<?php

namespace backend\models\table;

use common\models\Inventory;
use common\models\OrdersDetail;
use common\models\Payment;
use common\utils\table\DataTable;
use Yii;

class PaymentTable extends DataTable {
	/*public function __construct() {
		parent::__construct();
		$arguments = Yii::$app->request->post();
	}*/

	/**
	 * Tạo danh sách Payment
	 * .
	 * @return array
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\db\Exception
	 */
	public function getData() {
		$models    = $this->getModels();
		$dataArray = [];
		if ( $this->filterDatas['date_in'] != '' ) {
			$filterDateIn = strtotime( str_replace( '/', '-', $this->filterDatas['date_in'] ) );

			foreach ( $models as $model ) {
				$inventoryIds = OrdersDetail::find()->where( [ 'orders_id' => $model->orders_id ] )->select( [ 'inventory_id' ] )->createCommand()->queryColumn();
				/** @var Inventory[] $inventorys */
				$inventorys = Inventory::find()->where( [ 'id' => $inventoryIds ] )->all();
                if (count($inventorys) < 1) {
                    continue;
                }
				if ( $filterDateIn == $inventorys[0]->stay_date ) {
					$htmlAction = '';

					$dateIn   = date( 'd.m.Y H:i:s', strtotime( '+1 day', $inventorys[ count( $inventorys ) - 1 ]->stay_date ) );
					$checkOut = Yii::$app->formatter->asDate( strtotime( $dateIn ) );

					if ( $model->orders->payment_status == 2 || $model->orders->payment_status == 0 ) {
						$htmlAction .= " <button class='btn btn-info btn-update-success-order' title='Sửa' data-id='$model->orders_id'>Đã thanh toán</button>";
						$htmlAction .= " <button class='btn btn-danger btn-update-fail-order' title='Sửa' data-id='$model->orders_id'>Hủy đơn hàng</button>";
					}
					if ( $model->orders->payment_status == 1 ) {
						$htmlAction .= " <button class='btn btn-primary btn-send-mail' title='Gửi mail' data-id='$model->orders_id'>Gửi mail</button>";
						$htmlAction .= " <button class='btn btn-success btn-edit-payment' title='Gửi mail' data-id='$model->id'>Chỉnh sửa</button>";
						$htmlAction .= " <button class='btn btn-success btn-history' title='Gửi mail' data-id='$model->id'>Xem lịch sử</button>";
					}
					if ( $model->orders->payment_status == 4 || $model->orders->payment_status == 5 ) {
						$htmlAction .= " <button class='btn btn-info btn-success-order' title='Gửi mail' data-id='$model->orders_id'>Đã thanh toán</button>";
					}
					$dataArray[] = [
						$model->customer_name,
						$model->customer_phone,
						$model->customer_email,
						Yii::$app->formatter->asDatetime( $model->created_date ),
						$model->transaction_info,
						"<a class='link-order-detail' href='javascript:void(0)' data-order-id='{$model->orders_id}'>{$model->orders->code}</a>",
						number_format( $model->total_price ),
						$model->voucher_code,
						$model->getType(),
						$model->getStatus( $model->orders->payment_status ),
						$model->getTotalCustomer(),
						Yii::$app->formatter->asDate( $inventorys[0]->stay_date ),
						$checkOut,
						$htmlAction
					];
				}
			}
		} else {
			foreach ( $models as $model ) {
				$htmlAction   = '';
				$inventoryIds = OrdersDetail::find()->where( [ 'orders_id' => $model->orders_id ] )->select( [ 'inventory_id' ] )->createCommand()->queryColumn();
				/** @var Inventory[] $inventorys */
				$inventorys = Inventory::find()->where( [ 'id' => $inventoryIds ] )->all();
				if (count($inventorys) < 1) {
				    continue;
                }
				$dateIn     = date( 'd.m.Y H:i:s', strtotime( '+1 day', $inventorys[ count( $inventorys ) - 1 ]->stay_date ) );
				$checkOut   = Yii::$app->formatter->asDate( strtotime( $dateIn ) );

				if ( $model->orders->payment_status == 2 || $model->orders->payment_status == 0 ) {
					$htmlAction .= " <button class='btn btn-info btn-update-success-order' title='Sửa' data-id='$model->orders_id'>Đã thanh toán</button>";
					$htmlAction .= " <button class='btn btn-danger btn-update-fail-order' title='Sửa' data-id='$model->orders_id'>Hủy đơn hàng</button>";
				}
				if ( $model->orders->payment_status == 1 ) {
					$htmlAction .= " <button class='btn btn-primary btn-send-mail' title='Gửi mail' data-id='$model->orders_id'>Gửi mail</button>";
					$htmlAction .= " <button class='btn btn-success btn-edit-payment' title='Gửi mail' data-id='$model->id'>Chỉnh sửa</button>";
					$htmlAction .= " <button class='btn btn-success btn-history' title='Gửi mail' data-id='$model->id'>Xem lịch sử</button>";
				}
				if ( $model->orders->payment_status == 4 || $model->orders->payment_status == 5 ) {
					$htmlAction .= " <button class='btn btn-info btn-success-order' title='Gửi mail' data-id='$model->orders_id'>Đã thanh toán</button>";
				}
				$dataArray[] = [
					$model->customer_name,
					$model->customer_phone,
					$model->customer_email,
					Yii::$app->formatter->asDatetime( $model->created_date ),
					$model->transaction_info,
					"<a class='link-order-detail' href='javascript:void(0)' data-order-id='{$model->orders_id}'>{$model->orders->code}</a>",
					number_format( $model->total_price ),
					$model->voucher_code,
					$model->getType(),
					$model->getStatus( $model->orders->payment_status ),
					$model->getTotalCustomer(),
					Yii::$app->formatter->asDate( $inventorys[0]->stay_date ),
					$checkOut,
					$htmlAction
				];
			}
		}

		return $dataArray;
	}

	/**
	 * Tìm Payment.
	 * @return Payment[].
	 * @throws \yii\db\Exception
	 */
	public function getModels() {
		$column   = $this->getColumn();
		$orderIds = [];
		if ( $this->filterDatas['date_in'] != '' ) {
			$filterDateIn = strtotime( str_replace( '/', '-', $this->filterDatas['date_in'] ) );
			$inIds        = Inventory::find()->where( [ 'stay_date' => $filterDateIn ] )
			                         ->select( [ 'id' ] )->createCommand()->queryColumn();
			$orderIds     = OrdersDetail::find()->where( [ 'inventory_id' => $inIds ] )
			                            ->select( [ 'orders_id' ] )->createCommand()->queryColumn();

		}
		$models = Payment::find()->joinWith( [ 'orders' ] )->andFilterWhere( [
			'and',
			[ 'like', 'customer_name', $this->filterDatas['customer_name'] ],
			[ 'like', 'customer_phone', $this->filterDatas['customer_phone'] ],
			[ 'like', 'customer_email', $this->filterDatas['customer_email'] ],
			[ 'like', 'transaction_info', $this->filterDatas['transaction_info'] ],
			[ 'like', 'voucher_code', $this->filterDatas['voucher_code'] ],
			[ 'like', 'orders.code', $this->filterDatas['order_code'] ],
			[ 'type' => $this->filterDatas['type'] ],
			[ 'orders.payment_status' => $this->filterDatas['status'] ],
			[ 'orders_id' => $orderIds ]
		] )->distinct();
//        if ($this->filterDatas['status'] == 1) {
//            $models = $models->andFilterWhere(['orders.payment_status' => 100]);
//        }
//
//        if ($this->filterDatas['status'] == -1) {
//            $models = $models->andFilterWhere(['not in', 'response_code', [100]]);
//        }

		if ( $this->filterDatas['date_from'] != '' && $this->filterDatas['date_to'] == '' ) {
			$startDate = strtotime( str_replace( '/', '-', $this->filterDatas['date_from'] ) . ' 00:00:00' );
			$endDate   = strtotime( str_replace( '/', '-', $this->filterDatas['date_from'] ) . ' 23:59:59' );

			$models = $models->andFilterWhere( [ 'between', 'payment.created_date', $startDate, $endDate ] );
		} else if ( $this->filterDatas['date_from'] == '' && $this->filterDatas['date_to'] != '' ) {
			$startDate = strtotime( str_replace( '/', '-', $this->filterDatas['date_to'] ) . ' 00:00:00' );
			$endDate   = strtotime( str_replace( '/', '-', $this->filterDatas['date_to'] ) . ' 23:59:59' );

			$models = $models->andFilterWhere( [ 'between', 'payment.created_date', $startDate, $endDate ] );
		} else if ( $this->filterDatas['date_from'] != '' && $this->filterDatas['date_to'] != '' ) {
			$startDate = strtotime( str_replace( '/', '-', $this->filterDatas['date_from'] ) . ' 00:00:00' );
			$endDate   = strtotime( str_replace( '/', '-', $this->filterDatas['date_to'] ) . ' 23:59:59' );

			$models = $models->andFilterWhere( [ 'between', 'payment.created_date', $startDate, $endDate ] );
		}

		$this->totalRecords = $models->count();
		$models             = $models->limit( $this->length )
		                             ->offset( $this->start )
		                             ->orderBy( [ $column => $this->direction ] )
		                             ->all();
		Yii::$app->cache->set( 'paymentFilter', $this->filterDatas );

		return $models;
	}

	/**
	 * Lấy cột muốn sắp xếp
	 * @return string
	 */
	public function getColumn() {
		switch ( $this->column ) {
			case '0':
				$field = 'customer_name';
				break;
			case '1':
				$field = 'customer_phone';
				break;
			case '2':
				$field = 'customer_email';
				break;
			case '3':
				$field = 'transaction_info';
				break;
			case '4':
				$field = 'total_price';
				break;
			case '5':
				$field = 'order_code';
				break;
			case '6':
				$field = 'type';
				break;
			default:
				$field = 'id';
				break;
		}

		return $field;
	}
}

?>