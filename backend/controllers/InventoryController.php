<?php

namespace backend\controllers;

use backend\models\table\InventoryFilterTable;
use backend\models\table\InventoryTable;
use common\models\Inventory;
use common\models\Orders;
use common\models\OrdersDetail;
use common\models\Payment;
use common\utils\controller\Controller;
use common\utils\helpers\ArrayHelper;
use common\utils\helpers\TimeHelper;
use common\utils\table\TableFacade;
use PHPExcel_IOFactory;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class InventoryController extends Controller {
	public function actionIndex() {
		$inventory = new Inventory();

		return $this->render( 'index', [ 'inventory' => $inventory ] );
	}

	public function actionIndexFilterTable() {
		$tableFacade = new TableFacade( new InventoryFilterTable() );

		return $tableFacade->getDataTable();
	}

	public function actionIndexTable() {
		$tableFacade = new TableFacade( new InventoryTable );

		return $tableFacade->getDataTable();
	}

	public function actionView() {
		$inventoryId = Yii::$app->request->get( 'id', '' );
		$inventory   = $this->findModel( $inventoryId );

		return $this->render( 'view', [
			'inventory' => $inventory
		] );
	}

	/**
	 * Finds the Inventory model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * If $inventoryId == '', return new Inventory.
	 *
	 * @param $inventoryId
	 *
	 * @return Inventory the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel( $inventoryId ) {
		if ( ( $model = Inventory::findOne( [ 'id' => $inventoryId, 'status' => 1 ] ) ) !== null ) {
			return $model;
		}

		throw new NotFoundHttpException( Yii::t( 'yii', 'Page not found.' ) );
	}

	public function actionCreate() {
		$inventory = new Inventory();

		return $this->render( 'create', [
			'inventory' => $inventory,
		] );
	}

	public function actionCreateCustom() {
		$inventory = new Inventory();

		return $this->render( 'form_custom', [ 'inventory' => $inventory ] );
	}

	public function actionUpdate() {
		$inventoryId = Yii::$app->request->get( 'id', '' );
		$inventory   = $this->findModel( $inventoryId );

		return $this->render( 'update', [
			'inventory' => $inventory
		] );
	}

	/**
	 * @return string:
	 * - url: lưu thành công
	 * - chuỗi: lưu thất bại, trả về lỗi
	 * - An internal server error occurred: không load được model
	 * @throws \yii\base\InvalidParamException
	 * @throws NotFoundHttpException
	 * @throws ServerErrorHttpException
	 * @throws \yii\base\Exception
	 * @throws \yii\db\Exception
	 * @throws \yii\base\InvalidCallException
	 */
	public function actionSave() {
		$inventoryId = Yii::$app->request->post( 'Inventory' )['id'];
		$quantity    = Yii::$app->request->post( 'quantity', 1 );
		for ( $i = 0; $i < $quantity; $i ++ ) {
			$inventory = $inventoryId != '' ? $this->findModel( $inventoryId ) : new Inventory();

			if ( $inventory->load( Yii::$app->request->post() ) ) {
				$inventory->stay_date = strtotime( str_replace( '/', '-', $inventory->stay_date ) );
				$inventory->status    = 1;
				if ( ! $inventory->save() ) {
					return $this->asJson( $inventory->errors );
				}

			}
		}

		return Url::to( [ 'index' ], true );
	}

	public function actionSaveCustom() {
		$fromDate = Yii::$app->request->post( 'from_date', 1 );
		$toDate   = Yii::$app->request->post( 'to_date', 1 );
		$quantity = Yii::$app->request->post( 'quantity', 1 );
		$periods  = TimeHelper::getDatesFromRange( str_replace( '/', '-', $fromDate ), str_replace( '/', '-', $toDate ) );
		$datas    = [];

		foreach ( $periods as $period ) {
			for ( $i = 0; $i < $quantity; $i ++ ) {
				$datas[] = [
					strtotime( $period ),
					strtotime( date( 'd.m.Y H:i:s' ) ),
					0,
					1
				];
			}
		}

		Yii::$app->db->createCommand()
		             ->batchInsert( Inventory::tableName(), [
			             'stay_date',
			             'created_date',
			             'inventory_status',
			             'status'
		             ], $datas )
		             ->execute();

		return Url::to( [ 'index' ], true );
	}

	public function actionDelete() {
		$inventoryId = Yii::$app->request->post( 'id', '' );
		$inventory   = Inventory::findOne( [ 'id' => $inventoryId, 'status' => 1 ] );

		return $inventory != null && $inventory->updateAttributes( [ 'status' => - 1 ] ) > 0;
	}

	/**
	 * Select2 ajax Inventory.
	 * @return string
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\web\MethodNotAllowedHttpException
	 */
	public function actionSelectInventory() {
		if ( Yii::$app->request->isAjax ) {
			$query      = Yii::$app->request->get( 'query', '' );
			$page       = Yii::$app->request->get( 'page', 1 );
			$offset     = ( $page - 1 ) * 10;
			$inventorys = Inventory::find()->where( [ 'status' => 1 ] )->andFilterWhere( [ 'like', 'id', $query ] )->select( [ 'id', 'id' ] );

			return $this->asJson( [
				'total_count' => $inventorys->count(),
				'items'       => $inventorys->offset( $offset )->limit( 10 )->all()
			] );
		}

		throw new MethodNotAllowedHttpException( Yii::t( 'yii', 'Method Not Allowed' ) );
	}

	public function actionImportData() {
		$datas = [];

		$document = PHPExcel_IOFactory::load( 'C:\xampp\htdocs\oh_voucher\database\SỐ LƯỢNG PHÒNG BOUTIQUE HOTEL (06.06.2017)_Mr.Tri.xlsx' );
		// Get the active sheet as an array
		$activeSheetData = $document->getSheet( 0 )->toArray( null, true, true, true );

		//t7
		for ( $i = 6; $i <= 22; $i ++ ) {
			$date     = str_replace( '-Thg7', '-07-2017', $activeSheetData[ $i ]['A'] );
			$quantity = $activeSheetData[ $i ]['C'];

			$createdDate = time();
			for ( $j = 0; $j < $quantity; $j ++ ) {
				$datas[] = [
					strtotime( $date ),
					$createdDate,
					0
				];
			}
		}

		//t8
		for ( $i = 6; $i <= 34; $i ++ ) {
			$date     = str_replace( '-Thg8', '-08-2017', $activeSheetData[ $i ]['E'] );
			$quantity = $activeSheetData[ $i ]['G'];

			$createdDate = time();
			for ( $j = 0; $j < $quantity; $j ++ ) {
				$datas[] = [
					strtotime( $date ),
					$createdDate,
					0
				];
			}
		}
		//t9
		for ( $i = 9; $i <= 35; $i ++ ) {
			$date     = str_replace( '-Thg9', '-09-2017', $activeSheetData[ $i ]['I'] );
			$quantity = $activeSheetData[ $i ]['K'];

			$createdDate = time();
			for ( $j = 0; $j < $quantity; $j ++ ) {
				$datas[] = [
					strtotime( $date ),
					$createdDate,
					0
				];
			}
		}
		//t10
		for ( $i = 6; $i <= 36; $i ++ ) {
			$date     = str_replace( '-Thg10', '-10-2017', $activeSheetData[ $i ]['M'] );
			$quantity = $activeSheetData[ $i ]['O'];

			$createdDate = time();
			for ( $j = 0; $j < $quantity; $j ++ ) {
				$datas[] = [
					strtotime( $date ),
					$createdDate,
					0
				];
			}
		}
		//t11
		for ( $i = 6; $i <= 35; $i ++ ) {
			$date     = str_replace( '-Thg11', '-11-2017', $activeSheetData[ $i ]['Q'] );
			$quantity = $activeSheetData[ $i ]['S'];

			$createdDate = time();
			for ( $j = 0; $j < $quantity; $j ++ ) {
				$datas[] = [
					strtotime( $date ),
					$createdDate,
					0
				];
			}
		}
		//t12
		for ( $i = 6; $i <= 36; $i ++ ) {
			$date     = str_replace( '-Thg12', '-12-2017', $activeSheetData[ $i ]['U'] );
			$quantity = $activeSheetData[ $i ]['W'];
			if ( $quantity == 0 ) {
				continue;
			}
			$createdDate = time();
			for ( $j = 0; $j < $quantity; $j ++ ) {
				$datas[] = [
					strtotime( $date ),
					$createdDate,
					0
				];
			}
		}

		return Yii::$app->db->createCommand()
		                    ->batchInsert( Inventory::tableName(), [
			                    'stay_date',
			                    'created_date',
			                    'inventory_status'
		                    ], $datas )
		                    ->execute();
	}

	public function actionImport() {
		$months = [ 8, 9, 10, 11, 12, 1, 2 ];

		$datas = [];
		foreach ( $months as $month ) {
			$iterations = 65;
			switch ( $month ) {
				case 9:
					$iterations = 103;
					break;
				case 10:
					$iterations = 129;
					break;
				case 11:
					$iterations = 133;
					break;
				case 12:
					$iterations = 100;
					break;
				case 1:
					$iterations = 133;
					break;
				case 2:
					$iterations = 286;
					break;
			}

			$dayOfMonth = TimeHelper::getDayOfMonth( $month );
			$startDate  = '01-' . $month . '-2017';
			$endDate    = $dayOfMonth . '-' . $month . '-' . '2017';
			if ( $month == 1 || $month == 2 ) {
				$dayOfMonth = TimeHelper::getDayOfMonth( $month, 2018 );
				$startDate  = '01-' . $month . '-2018';
				$endDate    = $dayOfMonth . '-' . $month . '-' . '2018';
				if ( $month == 2 ) {
					$endDate = '14-' . $month . '-' . '2018';
				}
			}
			$dates = TimeHelper::getDatesFromRange( $startDate, $endDate );
			foreach ( $dates as $date ) {
				for ( $i = 0; $i < $iterations; $i ++ ) {
					$datas[] = [
						strtotime( $date ),
						strtotime( date( 'd.m.Y H:i:s' ) ),
						0
					];
				}
			}
		}

		return Yii::$app->db->createCommand()
		                    ->batchInsert( Inventory::tableName(), [
			                    'stay_date',
			                    'created_date',
			                    'inventory_status'
		                    ], $datas )
		                    ->execute();
	}

	/**
	 * Khóa phòng
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionLockRoom() {
		$inventoryId = Yii::$app->request->post( 'id' );
		$inventory   = $this->findModel( $inventoryId );

		return $inventory->updateAttributes( [ 'status' => 0 ] ) > 0 ? 'success' : 'fail';
	}

	/**
	 * Mở phòng
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionOpenRoom() {
		$inventoryId = Yii::$app->request->post( 'id' );
		$inventory   = Inventory::findOne( [ 'id' => $inventoryId ] );

		return $inventory->updateAttributes( [ 'status' => 1 ] ) > 0 ? 'success' : 'fail';
	}

	/**
	 * Khóa ngày
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionLockDate() {
		$date = Yii::$app->request->post( 'date' );

		return Inventory::updateAll( [ 'status' => 0 ], [ 'stay_date' => $date, 'inventory_status' => 0 ] ) > 0 ? 'success' : 'fail';
	}

	/**
	 * Khóa ngày
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionOpenDate() {
		$date = Yii::$app->request->post( 'date' );

		return Inventory::updateAll( [ 'status' => 1 ], [ 'stay_date' => $date, 'inventory_status' => 0 ] ) > 0 ? 'success' : 'fail';
	}

	public function actionViewNote() {
		$inventoryId = Yii::$app->request->post( 'id' );

		return $this->renderAjax( '_viewNote', [ 'inventory' => $this->findModel( $inventoryId ) ] );
	}

	public function actionViewOrdersDetail() {
		$orderId = Yii::$app->request->post( 'orderId' );
		$form    = Yii::$app->request->post( 'form', 'inventory' );
		/** @var Orders $order */
		$order        = Orders::find()->where( [ 'id' => $orderId ] )->one();
		$payment      = Payment::find()->where( [ 'orders_id' => $orderId ] )->one();
		//$orderDetails = OrdersDetail::find()->where( [ 'orders_id' => $order->id ] )->all();
$orderDetails = OrdersDetail::find()->joinWith(['inventory'])->orderBy(["inventory.stay_date" => SORT_ASC])->where([ 'orders_id' => $order->id ])->all();
		if ( $order->payment_status == 1 ) {
			$payment      = Payment::find()->where( [ 'orders_id' => $orderId ] )->one();
			//$orderDetails = OrdersDetail::find()->where( [ 'orders_id' => $order->id ] )->all();
		}

		return $this->renderAjax( '_ordersDetail', [ 'payment' => $payment, 'orderDetails' => $orderDetails, 'form' => $form ] );
	}

	public function actionGetSummary() {
		$filterDatas = [];
		if ( array_key_exists( 'filterDatas', Yii::$app->request->get() ) ) {
			parse_str( Yii::$app->request->get( 'filterDatas' ), $datas );
			$filterDatas = $datas;
		}
		$status      = $filterDatas['status'];
		$inventories = Inventory::find()->andFilterWhere( [
			'and',
//            ['stay_date' => \Yii::$app->formatter->asTimestamp(str_replace('/', '-', $filterDatas['stay_date']))],
			[ 'between', 'sold_date', Yii::$app->formatter->asTimestamp( str_replace( '/', '-', $filterDatas['sold_date_from'] ) ), Yii::$app->formatter->asTimestamp( str_replace( '/', '-', $filterDatas['sold_date_to'] ) ) ],
			[ 'between', 'stay_date', Yii::$app->formatter->asTimestamp( str_replace( '/', '-', $filterDatas['stay_date_from'] ) ), Yii::$app->formatter->asTimestamp( str_replace( '/', '-', $filterDatas['stay_date_to'] ) ) ]
		] )->distinct()->groupBy( 'DATE(from_unixtime(stay_date)), inventory_status' );
		if ( $status == - 1 ) {
			$inventories = $inventories->andFilterWhere( [ 'inventory.status' => $status ] );
		} else {
			$inventories = $inventories->andWhere( [ 'inventory.status' => 1 ] )->andFilterWhere( [ 'inventory_status' => $status ] );
		}
		$filters = [ trim( $filterDatas['order_code'] ), trim( $filterDatas['customer_name'] ), trim( $filterDatas['customer_email'] ), trim( $filterDatas['customer_phone'] ) ];
		if ( ! empty( ArrayHelper::compact( $filters ) ) ) {
			$inventories = $inventories->joinWith( [
				'ordersDetails' => function ( ActiveQuery $q ) {
					$q->joinWith( [ 'orders' ] )->where( [ 'payment_status' => [ 0, 1 ] ] );
				}
			] )->andFilterWhere( [
				'and',
				[ 'like', 'orders.code', trim( $filterDatas['order_code'] ) ],
				[ 'like', 'customer.name', trim( $filterDatas['customer_name'] ) ],
				[ 'like', 'customer.email', trim( $filterDatas['customer_email'] ) ],
				[ 'like', 'customer.phone', trim( $filterDatas['customer_phone'] ) ],
			] );
		}
		$inventories = $inventories->select( 'stay_date, inventory.id, inventory_status, count(*) as total' )->createCommand()->queryAll();
		if ( $inventories ) {
			$totalStocks = ArrayHelper::getColumn( ArrayHelper::_filter( $inventories, function ( $inventory ) {
				return $inventory['inventory_status'] == 0;
			} ), 'total' );
			$totalSolds  = ArrayHelper::getColumn( ArrayHelper::_filter( $inventories, function ( $inventory ) {
				return $inventory['inventory_status'] == 1;
			} ), 'total' );
			$totalWaits  = ArrayHelper::getColumn( ArrayHelper::_filter( $inventories, function ( $inventory ) {
				return $inventory['inventory_status'] == 2;
			} ), 'total' );

			$totalWait = array_sum( $totalWaits );

			$totalSold = array_sum( $totalSolds );

			$totalStock = array_sum( $totalStocks );

			return $this->asJson( [
				'totalStock' => $totalStock,
				'totalSold'  => $totalSold,
				'totalWait'  => $totalWait,
			] );
		}

		return 'empty';
	}

	public function actionExportInventory() {
		$inventories = Yii::$app->cache->get( 'filterTable' );

		$objPHPExcel = new \PHPExcel();
		$titles      = [
			'Ngày',
			'Tổng số lượng',
			'Tổng số còn',
			'Tổng số đã bán',
		];
		$colums      = range( 'A', 'D' );
		foreach ( $colums as $key => $column ) {
			$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setAutoSize( true );
			$objPHPExcel->getActiveSheet()->setCellValue( $column . '2', $titles[ $key ] );
		}
		$row = 3;

		foreach ( $inventories as $inventory ) {
			$objPHPExcel->getActiveSheet()->setCellValue( 'A' . $row, $inventory[0] );
			$objPHPExcel->getActiveSheet()->setCellValue( 'B' . $row, $inventory[1] );
			$objPHPExcel->getActiveSheet()->setCellValue( 'C' . $row, $inventory[2] );
			$objPHPExcel->getActiveSheet()->setCellValue( 'D' . $row, $inventory[4] );

			$row ++;
		}

		//ACTIVE SHEET STYLE FORMAT
		$objPHPExcel->getActiveSheet()->getStyle( 'A2:D2' )->getFont()->setBold( true )->setSize( 11 );
		$objPHPExcel->getActiveSheet()->getStyle( 'A2:D2' )->getAlignment()->applyFromArray( array( 'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER ) )->setVertical( \PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$objPHPExcel->getActiveSheet()->getStyle( "A2:D$row" )->getBorders()->getAllBorders()->setBorderStyle( \PHPExcel_Style_Border::BORDER_THIN );

		header( 'Pragma: public' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename=Rooms_' . Yii::$app->formatter->asDatetime( time() ) . '.xlsx ' );
		header( 'Content-Transfer-Encoding: binary ' );
		header( 'Cache-Control: max-age=0' );

		$objWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
		$objWriter->save( 'php://output' );
	}

	public function actionModalDeleteRooms() {
		return $this->renderAjax( '_form_delete_rooms', [ 'action' => 'delete' ] );
	}

	public function actionModalLockRooms() {
		return $this->renderAjax( '_form_delete_rooms', [ 'action' => 'lock' ] );
	}

	public function actionModifyRooms() {
		$date     = Yii::$app->request->post( 'date' );
		$quantity = Yii::$app->request->post( 'quantity' );
		$action   = Yii::$app->request->post( 'action' );

		$status = - 1;
		if ( $action == 'lock' ) {
			$status = 0;
		}
		$rooms         = Inventory::find()->where( [
			'inventory_status' => 0,
			'status'           => 1,
			'stay_date'        => strtotime( str_replace( '/', '-', $date ) )
		] )->all();
		$availableRoom = count( $rooms );
		if ( $quantity > $availableRoom ) {
			return 'out_of_room';
		}

		$transaction = Yii::$app->db->beginTransaction();
		try {
			foreach ( $rooms as $key => $room ) {
				if ( $key + 1 > $quantity ) {
					break;
				}

				$room->updateAttributes( [ 'status' => $status ] );
			}
			$transaction->commit();

			return 'success';
		} catch ( Exception $e ) {
			$transaction->rollback();

			return $e->getMessage();
		}
	}

	public function actionLockRooms() {
		return Yii::$app->db->createCommand( 'UPDATE inventory SET status = 0 WHERE inventory_status = 0 AND `stay_date` BETWEEN 1500310800 AND 1504458000' )->execute();
	}

	public function actionOpenRooms() {
		$startDate = '02-08-2017';
		$endDate   = '29-08-2017';
		$periods   = TimeHelper::getDatesFromRange( $startDate, $endDate, 'Y-m-d' );
		$result    = 0;
		foreach ( $periods as $period ) {
			$roomIds = Inventory::find()->where( [ 'stay_date' => strtotime( $period ), 'inventory_status' => 0, 'status' => 1 ] )
			                    ->limit( 10 )
			                    ->select( [ 'id' ] )
			                    ->createCommand()
			                    ->queryColumn();
//			                    ->queryAll();
			var_dump( count( $roomIds ) );
			if ( count( $roomIds ) == 5 ) {
				var_dump( strtotime( $period ) );
				die;
			}
//			$result += Inventory::updateAll( [ 'status' => 1 ], ['id' => $roomIds]);
		}
//    	$rooms = Yii::$app->db->createCommand( 'select * from inventory WHERE inventory_status = 0 AND `stay_date` BETWEEN 1501520400 AND 1503939600' )->queryAll();
//		var_dump( $result );
		die;
	}

	public function actionAddRooms() {
		for ( $i = 0; $i < 5; $i ++ ) {
			$room                   = new Inventory();
			$room->stay_date        = 1501866000;
			$room->created_date     = strtotime( date( 'd.m.Y H:i:s' ) );
			$room->inventory_status = 0;
			$room->save( false );
		}
	}

	public function actionDelRooms() {
		var_dump(Yii::$app->db->createCommand( 'select * from orders_detail WHERE inventory_id = 21739' )->queryAll());die;

var_dump(Yii::$app->db->createCommand( 'SELECT
  FROM_UNIXTIME(stay_date),
  id
FROM inventory
WHERE stay_date < (UNIX_TIMESTAMP() - 86400) AND (inventory_status = 0 OR status = -1)' )->queryAll());die;

		var_dump(Yii::$app->db->createCommand( 'SELECT
  FROM_UNIXTIME(stay_date),
  id
FROM inventory
WHERE stay_date < (UNIX_TIMESTAMP() - 86400)
      AND inventory_status = 0
ORDER BY id DESC;' )->queryAll());die;
	}
}
