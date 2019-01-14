<?php
/* @var $this yii\web\View */

/* @var $user backend\models\User */
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?= Yii::t('yii', 'Update') . ': ' . $user->username; ?></h4>
</div>
<form action="" id="form_change_password">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_password_old">Mật khẩu cũ</label>
                    <input type="text" class="form-control require" name="old_password" value="" id="txt_password_old" autocomplete="off">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_password_new">Mật khẩu mới</label>
                    <input type="text" class="form-control require" name="new_password" value="" id="txt_password_new" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button type="submit" class="btn <?= $user->isNewRecord ? 'btn-primary' : 'btn-success' ?>" id="btn_save_change_password"><?= Yii::t('yii', 'Save') ?></button>
    </div>
</form>
