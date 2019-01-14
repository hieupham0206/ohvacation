<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $inventory common\models\Inventory */
?>
<form id="form_inventory">
	<div id="error_summary"></div>
	<div class="row">
		<input type="hidden" name="Inventory[id]" value="<?= $inventory->id ?>">
		<div class="col-md-3">
			<div class="form-group">
                <label for="txt_stay_date"><?= $inventory->getAttributeLabel('stay_date') ?></label>
                <input type="text" class="form-control datepicker" name="Inventory[stay_date]" value="<?= Yii::$app->formatter->asDate($inventory->stay_date) ?>" id="txt_stay_date" autofocus>
			</div>
		</div>
        <div class="col-md-3">
			<div class="form-group">
                <label for="txt_quantity">Số lượng</label>
                <input type="text" class="form-control number" name="quantity" value="" id="txt_quantity" autofocus>
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
                utils.submitForm("<?= Url::to( [ 'save' ] ) ?>", formData).then(function(result) {
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