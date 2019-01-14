<?php
/* @var $this yii\web\View */
/* @var $customer common\models\Customer */
?>
<form id="form_customer_search" class="search-form">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_name"><?= $customer->getAttributeLabel('name') ?></label>
				<input type="text" class="form-control" name="name" id="txt_name">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_companion"><?= $customer->getAttributeLabel('companion') ?></label>
				<input type="text" class="form-control" name="companion" id="txt_companion">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_cmnd"><?= $customer->getAttributeLabel('cmnd') ?></label>
				<input type="text" class="form-control" name="cmnd" id="txt_cmnd">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_phone"><?= $customer->getAttributeLabel('phone') ?></label>
				<input type="text" class="form-control" name="phone" id="txt_phone">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_email"><?= $customer->getAttributeLabel('email') ?></label>
				<input type="text" class="form-control" name="email" id="txt_email">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_OTP"><?= $customer->getAttributeLabel('OTP') ?></label>
				<input type="text" class="form-control" name="OTP" id="txt_OTP">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_otp_date"><?= $customer->getAttributeLabel('otp_date') ?></label>
				<input type="text" class="form-control datepicker" name="otp_date" id="txt_otp_date">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_is_verified"><?= $customer->getAttributeLabel('is_verified') ?></label>
				<input type="text" class="form-control" name="is_verified" id="txt_is_verified">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_verified_date"><?= $customer->getAttributeLabel('verified_date') ?></label>
				<input type="text" class="form-control datepicker" name="verified_date" id="txt_verified_date">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_voucher_id"><?= $customer->getAttributeLabel('voucher_id') ?></label>
				<select name="voucher_id" id="select_voucher_id" class="form-control select" title="">
					<option></option>
				</select>
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
