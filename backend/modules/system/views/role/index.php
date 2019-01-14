<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = Yii::t('yii', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
/* @var $role backend\models\Role */
?>
<div class="role-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-group">
        <a class="btn btn-primary" href="<?= Url::to(['create']) ?>" title="Tạo mới">Tạo mới</a>
    </div>
    <table id="table_role" class="table table-striped table-bordered nowrap" style="width: 100%">
        <thead>
        <tr>
            <th width="10px">
                <div><input class="cb-all" type="checkbox" title=""/></div>
            </th>
            <th><?= $role->getAttributeLabel('name') ?></th>
            <th><?= $role->getAttributeLabel('status') ?></th>
            <th style="min-width: 105px">Hành động</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
    $(function () {
        $.blockUI();
        let body = $('body');
        let tableRole = $("#table_role").DataTable({
            processing: true,
            serverSide: true,
            ajax: $.fn.dataTable.pipeline({
                url: "<?= Url::to(['index-table']) ?>",
            }),
            conditionalPaging: true,
        });
        body.on('click', '.btn-delete-role', function () {
            utils.deleteRow($(this), "<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>", tableRole);
        });
    });
</script>