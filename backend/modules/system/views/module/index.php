<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = Yii::t( 'yii', 'Modules' );
$this->params['breadcrumbs'][] = $this->title;
/* @var $module backend\models\Module */
?>
<div class="module-index">
    <h1><?= Html::encode( $this->title ) ?></h1>
    <div class="form-group">
        <a href="<?= Url::to( [ 'create' ] ) ?>" title="Tạo mới">Tạo mới</a>
    </div>
    <table id="table_module" class="table table-striped table-bordered nowrap" style="width: 100%">
        <thead>
        <tr>
            <th>
                <div><input class="cb-all" type="checkbox" title=""/></div>
            </th>
            <th><?= $module->getAttributeLabel( 'name' ) ?></th>
            <th style="min-width: 105px"><?= Yii::t( 'yii', 'Action' ) ?></th>
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
        let tableModule = $("#table_module").DataTable({
            processing: true,
            serverSide: true,
            ajax: $.fn.dataTable.pipeline({
                url: "<?= Url::to( [ 'ajax-table' ] ) ?>",
            }),
            conditionalPaging: true,
        });
        body.on('click', '.btn-update-module', function () {
            let id = $(this).data('id');
            location.href = "<?= Url::to(['update']) ?>" + '/' + id;
        });
        body.on('click', '.btn-view-module', function () {
            let id = $(this).data('id');
            location.href = "<?= Url::to(['view']) ?>" + '/' + id;
        });
        body.on('click', '.btn-delete-module', function () {
            let id = $(this).data('id');
            bootbox.confirm({
                size: 'small',
                message: "<?= Yii::t( 'yii', 'Are you sure?' ) ?>",
                callback: function (result) {
                    if (result) {
                        $.blockUI();
                        $.post("<?= Url::to(['delete']) ?>", {id: id}, function() {
                            tableModule.clearPipeline().draw(false);
                        });
                    }
                }
            });
        });
    });
</script>