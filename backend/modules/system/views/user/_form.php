<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user backend\models\User */
?>
<form id="form_user">
    <div id="error_summary"></div>
    <div class="row">
        <input type="hidden" name="User[id]" value="<?= $user->id ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_username"><?= $user->getAttributeLabel('username') ?></label>
                <input type="text" class="form-control username require" name="User[username]" value="<?= $user->username ?>" id="txt_username" autofocus <?= $user->isNewRecord ? '' : 'disabled' ?>>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_password_hash"><?= $user->getAttributeLabel('password_hash') ?></label>
                <input type="text" class="form-control <?= $user->isNewRecord ? 'require' : '' ?>" name="User[password_hash]" value="" id="txt_password_hash">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_email"><?= $user->getAttributeLabel('email') ?></label>
                <input type="text" class="form-control" name="User[email]" value="<?= $user->email ?>" id="txt_email">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_phone"><?= $user->getAttributeLabel('phone') ?></label>
                <input type="text" class="form-control number" name="User[phone]" value="<?= $user->phone ?>" id="txt_phone">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_extension"><?= $user->getAttributeLabel('extension') ?></label>
                <input type="text" class="form-control number" name="User[extension]" value="<?= $user->extension ?>" id="txt_extension">
            </div>
        </div>
<!--        <div class="col-md-3">-->
<!--            <div class="form-group">-->
<!--                <label for="select_role_id">--><?php // $user->getAttributeLabel('role_id') ?><!--</label>-->
<!--                <select name="User[role_id]" id="select_role_id" class="form-control">-->
<!--                    <option></option>-->
<!--                </select>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to(['index']) ?>"><?= 'Hủy' ?></a>
            <button type="submit" class="btn <?= $user->isNewRecord ? 'btn-primary' : 'btn-success' ?>" id="btn_save_user"><?= Yii::t('yii', 'Save') ?></button>
        </div>
    </div>
</form>
<script>
    $(function () {
        $("#form_user").on('submit', function () {
            if (utils.validate("form_user")) {
                let formData = new FormData(document.getElementById("form_user"));
                utils.submitForm("<?= Url::to(['save']) ?>", formData).then(function (result) {
                    if (result.includes('http')) {
                        location.href = result;
                    } else {
                        utils.showErrorSummary(result, '#form_user');
                    }
                });
            } else {
                $('.error').first().focus();
            }
            return false;
        });
        $("#select_role_id").select2Ajax({
            url: "<?= Url::to(['role/select-role']) ?>"
        })
    });
</script>