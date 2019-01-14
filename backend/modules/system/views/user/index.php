<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = 'Người dùng';
$this->params['breadcrumbs'][] = $this->title;
/* @var $user backend\models\User */
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['user' => $user]); ?>
    <div class="form-group">
        <a class="btn btn-primary" href="<?= Url::to(['create']) ?>" title="Tạo mới">Tạo mới</a>
    </div>
    <table id="table_user" class="table table-striped table-bordered nowrap" style="width: 100%">
        <thead>
        <tr>
            <th width="1%">
                <div><input class="cb-all" type="checkbox" title=""/></div>
            </th>
            <th><?= $user->getAttributeLabel('username') ?></th>
            <th><?= $user->getAttributeLabel('email') ?></th>
            <th><?= $user->getAttributeLabel('phone') ?></th>
            <th><?= $user->getAttributeLabel('extension') ?></th>
            <th style="max-width: 105px"><?= Yii::t('yii', 'Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>
<script defer="defer">
    $(function () {
        $.blockUI();
        let body = $('body');
        let tableUser = $("#table_user").DataTable({
            processing: true,
            serverSide: true,
            ajax: $.fn.dataTable.pipeline({
                url: "<?= Url::to(['index-table']) ?>",
                data: function (q) {
                    q.filterDatas = $("#form_user_search").serialize();
                }
            }),
            conditionalPaging: true,
        });
        body.on('click', '.btn-toggle-status-user', function () {
            let id = $(this).data('id');
            let self = $(this);
            self.parents('tr').addClass('selected');
            bootbox.confirm({
                size: 'small',
                message: "<?= Yii::t('yii', 'Are you sure you want to change this item?') ?>",
                callback: function (result) {
                    if (result) {
                        $.blockUI();
                        $.post("<?= Url::to(['toggle-status']) ?>", {id: id}, function (result) {
                            if (result === '1') {
                                tableUser.clearPipeline().draw(false);
                                body.noti({
                                    type: 'success',
                                    content: 'Success'
                                });
                            } else {
                                body.noti({
                                    type: 'error',
                                    content: 'Fail'
                                })
                            }
                        });
                    }
                    self.parents('tr').removeClass('selected');
                }
            });
        });
        body.on('click', '.btn-delete-user', function () {
            utils.deleteRow($(this), "<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>", tableUser);
        });
        $("#form_user_search").on('submit', function () {
            tableUser.clearPipeline().draw();
            return false;
        });
        body.on('click', '#btn_reset_filter', function () {
            $("#form_user_search").find('input, select').val('').trigger('change');
            tableUser.clearPipeline().order([]).draw();
        });
    });
</script>