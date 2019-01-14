<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $payment common\models\Payment */
?>
<form id="form_payment">
    <div class="modal-body">
        <div id="error_summary"></div>
        <div class="row">
            <input type="hidden" name="Payment[id]" value="<?= $payment->id ?>">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_customer_name"><?= $payment->getAttributeLabel( 'customer_name' ) ?></label>
                    <input type="text" class="form-control alphanum" name="Payment[customer_name]" value="<?= $payment->customer_name ?>" id="txt_customer_name">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_customer_phone"><?= $payment->getAttributeLabel( 'customer_phone' ) ?></label>
                    <input type="text" class="form-control alphanum" name="Payment[customer_phone]" value="<?= $payment->customer_phone ?>" id="txt_customer_phone">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_customer_email"><?= $payment->getAttributeLabel( 'customer_email' ) ?></label>
                    <input type="text" class="form-control email" name="Payment[customer_email]" value="<?= $payment->customer_email ?>" id="txt_customer_email">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="textarea_note">Người lớn</label>
                    <input type="text" class="form-control" name="adult" value="<?= $adults ?>" id="txt_customer_email">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="textarea_note">Trẻ em</label>
                    <input type="text" class="form-control" name="child" value="<?= $childs ?>" id="txt_customer_email">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="textarea_note">Voucher</label>
                    <input type="text" class="form-control" name="Payment[voucher_code]" value="<?= $payment->voucher_code ?>" id="txt_customer_email">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" type="button" data-dismiss="modal" data-bb-handler="cancel">Đóng</button>
        <button class="btn <?= $payment->isNewRecord ? 'btn-primary' : 'btn-success' ?>" id="btn_save_payment">Lưu</button>
    </div>
</form>
<script>
    $(function() {
        $('#form_payment').on('submit', function() {
            if (utils.validate('form_payment')) {
                let formData = new FormData(document.getElementById('form_payment'));
                utils.submitForm('<?= Url::to( [ 'save' ] ) ?>', formData).then(function(result) {
                    if (result == 'success') {
                        $("body").noti({
                            type: 'success',
                            content: 'Success',
                        });
                        $('#table_payment').DataTable().clearPipeline().draw();
                        $("#modal-lg").modal('hide');
                    } else {
                        utils.showErrorSummary(result, '#form_payment');
                    }
                });
            } else {
                $('.error').first().focus();
            }
            return false;
        });
    });
</script>