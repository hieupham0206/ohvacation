<?php

namespace backend\models\table;

use \common\models\base\Customer;
use common\utils\table\DataTable;
use yii\helpers\Url;
use Yii;

class CustomerTable extends DataTable
{
    /*public function __construct() {
		parent::__construct();
        $arguments = Yii::$app->request->post();
	}*/

	/**
	* Tạo danh sách Customer
.
	* @return array
    * @throws \yii\base\InvalidParamException
	*/
	public function getData()
	{
		$models = $this->getModels();
		$dataArray = [];
		foreach ($models as $model) {
            $htmlAction  = "<a class='btn btn-warning link-view-customer' title='Xem' data-id='$model->id' href='".Url::to(['view', 'id' => $model->id])."'><i class='glyphicon glyphicon-eye-open'></i> </a>";
            if ( Yii::$app->permission->can( Yii::$app->controller->id , 'update' )) {
                $htmlAction .= " <a class='btn btn-info btn-update-customer' title='Sửa' data-id='$model->id' href='".Url::to(['update', 'id' => $model->id])."'><i class='glyphicon glyphicon-edit'></i> </a>";
            }
            if ( Yii::$app->permission->can( Yii::$app->controller->id , 'delete' )) {
			    $htmlAction .= " <button class='btn btn-danger btn-delete-customer' title='Xóa' data-id='$model->id' data-url='".Url::to(['delete'])."'><i class='glyphicon glyphicon-trash'></i> </button>";
            }
			$dataArray[] = [
                "<input class='cb-single' type='checkbox' data-id='$model->id' title=''>",
				$model->name,
				$model->companion,
				$model->cmnd,
				$model->phone,
				$model->email,
				$model->OTP,
				\Yii::$app->formatter->asDate($model->otp_date),
				$model->is_verified,
				\Yii::$app->formatter->asDate($model->verified_date),
				$model->voucher_id != null ? $model->voucher->name : '',
				$htmlAction
			];
		}
		return $dataArray;
	}

	/**
	* Tìm Customer.
	* @return Customer[].
	*/
	public function getModels()
	{
		$column = $this->getColumn();
		$models = Customer::find()->where(['customer.status' => 1])->distinct();
		$this->totalRecords = $models->count();
		$models = $models->limit($this->length)
						 ->offset($this->start)
						 ->orderBy([$column => $this->direction])
						 ->all();

		return $models;
	}

	/**
	 * Lấy cột muốn sắp xếp
	 * @return string
	 */
	public function getColumn()
	{
		switch ($this->column) {
			case '1':
				$field = 'name';
				break;
			case '2':
				$field = 'companion';
				break;
			case '3':
				$field = 'cmnd';
				break;
			case '4':
				$field = 'phone';
				break;
			case '5':
				$field = 'email';
				break;
			case '6':
				$field = 'OTP';
				break;
			case '7':
				$field = 'otp_date';
				break;
			case '8':
				$field = 'is_verified';
				break;
			case '9':
				$field = 'verified_date';
				break;
			case '10':
				$field = 'voucher_id';
				break;
			default:
				$field = 'id';
				break;
		}
		return $field;
	}
}

?>