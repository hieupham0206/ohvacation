<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Customer';
$this->params['breadcrumbs'][] = $this->title;
/* @var $customer common\models\Customer */
?>
<div class="customer-index">
	<h1><?= Html::encode($this->title) ?></h1>
	<?= $this->render( '_search', ['customer' => $customer] ); ?>
    <?php if ( Yii::$app->permission->can( Yii::$app->controller->id , 'create' )) : ?>
        <div class="form-group">
            <a class="btn btn-primary" href="<?= Url::to(['create']) ?>" title="Tạo mới">Tạo mới</a>
        </div>
    <?php endif; ?>
	<table id="table_customer" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
		<tr>
			<th width="1%"><input class="cb-all" type="checkbox" title=""/></th>
			<th><?= $customer->getAttributeLabel('name') ?></th>
			<th><?= $customer->getAttributeLabel('companion') ?></th>
			<th><?= $customer->getAttributeLabel('cmnd') ?></th>
			<th><?= $customer->getAttributeLabel('phone') ?></th>
			<th><?= $customer->getAttributeLabel('email') ?></th>
			<th><?= $customer->getAttributeLabel('OTP') ?></th>
			<th><?= $customer->getAttributeLabel('otp_date') ?></th>
			<th><?= $customer->getAttributeLabel('is_verified') ?></th>
			<th><?= $customer->getAttributeLabel('verified_date') ?></th>
			<th><?= $customer->getAttributeLabel('voucher_id') ?></th>
			<th width="5%">Hành động</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<script>
	$(function () {
		$.blockUI();
		let body = $('body');
		let tableCustomer = $("#table_customer").DataTable({
			processing: true,
			serverSide: true,
			ajax: $.fn.dataTable.pipeline({
				url: "<?= Url::to(['index-table']) ?>",
				data: function(q) {
					q.filterDatas = $("#form_customer_search").serialize();
				}
			}),
			conditionalPaging: true,
		});
		body.on('click', '.btn-delete-customer', function () {
            utils.deleteRow($(this), "<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>", tableCustomer);
		});
        $("#form_customer_search").on('submit', function () {
			tableCustomer.clearPipeline().draw();
            return false;
		});
		body.on('click', '#btn_reset_filter', function () {
			$("#form_customer_search").find('input, select').val('').trigger('change');
			tableCustomer.clearPipeline().order([]).draw();
		});
	});
</script>