<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $voucher common\models\Voucher */
?>
<form id="form_voucher">
    <div id="error_summary"></div>
    <div class="row">
        <input type="hidden" name="Voucher[id]" value="<?= $voucher->id ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_code"><?= $voucher->getAttributeLabel('code') ?> *</label>
                <input type="text" class="form-control alphanum require" name="Voucher[code]" value="<?= $voucher->code ?>" id="txt_code">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_survey_code"><?= $voucher->getAttributeLabel('survey_code') ?></label>
                <input type="text" class="form-control alphanum" name="Voucher[survey_code]" value="<?= $voucher->survey_code ?>" id="txt_survey_code">
            </div>
        </div>
        <?php //if ( ! $voucher->isNewRecord): ?>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_phone"><?= $voucher->getAttributeLabel('phone') ?></label>
                <input type="text" class="form-control alphanum" name="Voucher[phone]" value="<?= $voucher->phone ?>" id="txt_phone">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_email"><?= $voucher->getAttributeLabel('email') ?></label>
                <input type="text" class="form-control" name="Voucher[email]" value="<?= $voucher->email ?>" id="txt_email">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_client_name"><?= $voucher->getAttributeLabel('client_name') ?></label>
                <input type="text" class="form-control" name="Voucher[client_name]" value="<?= $voucher->client_name ?>" id="txt_client_name">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_companion"><?= $voucher->getAttributeLabel('companion') ?></label>
                <input type="text" class="form-control" name="Voucher[companion]" value="<?= $voucher->companion ?>" id="txt_companion">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="select_voucher_type"><?= $voucher->getAttributeLabel('voucher_type') ?></label>
                <select name="Voucher[voucher_type]" id="select_voucher_type">
                    <option value="1" <?= $voucher->voucher_type == 1 ? 'selected' : '' ?>>Cũ</option>
                    <option value="2" <?= $voucher->voucher_type == 2 ? 'selected' : '' ?>>Mới</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="textarea_note">Ghi chú</label>
                <textarea name="Voucher[note]" id="textarea_note" cols="30" rows="5" class="form-control"><?= $voucher->note ?></textarea>
            </div>
        </div>
        <?php //endif ?>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to(['index']) ?>">Hủy</a>
            <button class="btn <?= $voucher->isNewRecord ? 'btn-primary' : 'btn-success' ?>" id="btn_save_voucher">Lưu</button>
        </div>
    </div>
</form>
<script>
    $(function() {
    	$('#select_voucher_type').select2()
        $('#form_voucher').on('submit', function() {
            if (utils.validate('form_voucher')) {
                let formData = new FormData(document.getElementById('form_voucher'));
                utils.submitForm('<?= Url::to(['save']) ?>', formData).then(function(result) {
                    if (typeof result !== 'object' && result.includes('http')) {
                        location.href = result;
                    } else {
                        utils.showErrorSummary(result, '#form_voucher');
                    }
                });
            } else {
                $('.error').first().focus();
            }
            return false;
        });
    });
</script>