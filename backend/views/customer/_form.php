<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $customer common\models\Customer */
?>
<form id="form_customer">
	<div id="error_summary"></div>
	<div class="row">
		<input type="hidden" name="Customer[id]" value="<?= $customer->id ?>">
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_name"><?= $customer->getAttributeLabel('name') ?> *</label>
                <input type="text" class="form-control alphanum require" name="Customer[name]" value="<?= $customer->name ?>" id="txt_name" autofocus>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_companion"><?= $customer->getAttributeLabel('companion') ?></label>
                <input type="text" class="form-control alphanum" name="Customer[companion]" value="<?= $customer->companion ?>" id="txt_companion">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_cmnd"><?= $customer->getAttributeLabel('cmnd') ?></label>
                <input type="text" class="form-control alphanum" name="Customer[cmnd]" value="<?= $customer->cmnd ?>" id="txt_cmnd">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_phone"><?= $customer->getAttributeLabel('phone') ?></label>
                <input type="text" class="form-control alphanum" name="Customer[phone]" value="<?= $customer->phone ?>" id="txt_phone">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_email"><?= $customer->getAttributeLabel('email') ?></label>
                <input type="text" class="form-control email" name="Customer[email]" value="<?= $customer->email ?>" id="txt_email">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_OTP"><?= $customer->getAttributeLabel('OTP') ?></label>
                <input type="text" class="form-control alphanum" name="Customer[OTP]" value="<?= $customer->OTP ?>" id="txt_OTP">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_otp_date"><?= $customer->getAttributeLabel('otp_date') ?></label>
                <input type="text" class="form-control datepicker" name="Customer[otp_date]" value="<?= Yii::$app->formatter->asDate($customer->otp_date) ?>" id="txt_otp_date">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_is_verified"><?= $customer->getAttributeLabel('is_verified') ?></label>
                <input type="text" class="form-control alphanum" name="Customer[is_verified]" value="<?= $customer->is_verified ?>" id="txt_is_verified">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_verified_date"><?= $customer->getAttributeLabel('verified_date') ?></label>
                <input type="text" class="form-control datepicker" name="Customer[verified_date]" value="<?= Yii::$app->formatter->asDate($customer->verified_date) ?>" id="txt_verified_date">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="select_voucher_id"><?= $customer->getAttributeLabel('voucher_id') ?></label>
				<select name="Customer[voucher_id]" id="select_voucher_id" class="form-control select require">
					<option></option>
                    <?php if ( $customer->voucher_id != null ): ?>
                        <option value="<?= $customer->voucher_id ?>" selected><?= $customer->voucher->name ?></option>
                    <?php endif ?>
				</select>
			</div>
		</div>
	</div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>">Hủy</a>
            <button class="btn <?= $customer->isNewRecord ? 'btn-primary' : 'btn-success' ?>" id="btn_save_customer">Lưu</button>
        </div>
    </div>
</form>
<script>
	$(function () {
		$("#form_customer").on('submit', function () {
			if (utils.validate("form_customer")) {
				let formData = new FormData(document.getElementById("form_customer"));
                utils.submitForm("<?= Url::to( [ 'save' ] ) ?>", formData).then(function(result) {
					if (result.includes('http')) {
						location.href = result;
					} else {
                        utils.showErrorSummary(result, "#form_customer");
					}
				});
			} else {
                $('.error').first().focus();
            }
			return false;
		});
	});
</script>