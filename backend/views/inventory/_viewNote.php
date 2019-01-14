<?php
/** @var \common\models\Inventory $inventory */
?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <label for="textarea_note">Ghi chú</label>
            <textarea name="" class="form-control" id="textarea_note" cols="30" rows="5" readonly><?= $inventory->note ?></textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button data-dismiss="modal" type="button" class="btn btn-default">Đóng</button>
</div>
