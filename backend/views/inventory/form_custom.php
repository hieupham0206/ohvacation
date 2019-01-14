<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

/* @var $inventory common\models\Inventory */
$this->title                   = 'Tạo Phòng';
$this->params['breadcrumbs'][] = ['label' => 'Kho phòng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<form id="form_inventory">
    <div id="error_summary"></div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_from_date">Từ ngày</label>
                <input type="text" class="form-control datepicker require" name="from_date" autofocus id="txt_from_date">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_to_date">Đến ngày</label>
                <input type="text" class="form-control datepicker require" name="to_date" id="txt_to_date">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_quantity">Số lượng</label>
                <input type="text" class="form-control number require" name="quantity" value="" id="txt_quantity" autofocus>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="textarea_note"><?= $inventory->getAttributeLabel('note') ?></label>
                <textarea class="form-control" name="Inventory[note]" id="textarea_note" cols="30" rows="5"><?= $inventory->note ?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>">Hủy</a>
            <button class="btn <?= $inventory->isNewRecord ? 'btn-primary' : 'btn-success' ?>" id="btn_save_inventory">Lưu</button>
        </div>
    </div>
</form>
<script>
    $(function () {
        $("#form_inventory").on('submit', function () {
            if (utils.validate("form_inventory")) {
                let formData = new FormData(document.getElementById("form_inventory"));
                utils.submitForm("<?= Url::to( [ 'save-custom' ] ) ?>", formData).then(function(result) {
                    if (typeof result !== 'object' && result.includes('http')) {
                        location.href = result;
                    } else {
                        utils.showErrorSummary(result, "#form_inventory");
                    }
                });
            } else {
                $('.error').first().focus();
            }
            return false;
        });
    });
</script>