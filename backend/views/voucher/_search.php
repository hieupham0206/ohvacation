<?php
/* @var $this yii\web\View */
/* @var $voucher common\models\Voucher */
?>
<form id="form_voucher_search" class="search-form">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_client_name"><?= $voucher->getAttributeLabel('client_name') ?></label>
				<input type="text" class="form-control" name="client_name" id="txt_client_name">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_phone"><?= $voucher->getAttributeLabel('phone') ?></label>
				<input type="text" class="form-control" name="phone" id="txt_phone">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_email"><?= $voucher->getAttributeLabel('email') ?></label>
				<input type="text" class="form-control" name="email" id="txt_email">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_code"><?= $voucher->getAttributeLabel('code') ?></label>
				<input type="text" class="form-control" name="code" id="txt_code">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_survey_code"><?= $voucher->getAttributeLabel('survey_code') ?></label>
				<input type="text" class="form-control" name="survey_code" id="txt_survey_code">
			</div>
		</div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_orders_code"><?= $voucher->getAttributeLabel('orders_code') ?></label>
                <input type="text" class="form-control" name="orders_code" id="txt_orders_code">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group pull-right" style="margin-top: 22px">
                <a type="button" class="btn btn-default" id="btn_reset_filter">Thiết lập lại</a>
                <button class="btn btn-info" id="btn_filter">Tìm kiếm</button>
            </div>
        </div>
	</div>
</form>
