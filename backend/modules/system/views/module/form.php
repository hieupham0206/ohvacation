<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $module backend\models\Module */
/* @var $moduleChild backend\models\ModuleChild */
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->title                   = 'Tạo module';
?>
<form id="form_role">
    <div class="row">
        <input type="hidden" name="Module[id]" value="<?= $module->id ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_name"><?= $module->getAttributeLabel('name') ?></label>
                <input type="text" class="form-control alphanum" name="Module[name]" value="<?= $module->name ?>" id="txt_name" autofocus>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="">Danh sách chi tiết</label>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_module_child_name"><?= $moduleChild->getAttributeLabel('name') ?></label>
                <input type="text" class="form-control" id="txt_module_child_name">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_module_child_controller"><?= $moduleChild->getAttributeLabel('controller') ?></label>
                <input type="text" class="form-control" id="txt_module_child_controller">
            </div>
        </div>
        <div class="col-md-2 form-group">
            <a type="button" class="btn btn-info" id="btn_add_module_child" style="margin-top: 24px"><?= Yii::t('yii', 'Add') ?></a>
        </div>
        <div class="col-md-2 form-group">
            <a type="button" class="btn btn-info" id="btn_load_controller" style="margin-top: 24px">Load controller</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <table id="table_module_child" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead>
                <tr>
                    <th width="100px"><?= $moduleChild->getAttributeLabel('name') ?></th>
                    <th width="100px"><?= $moduleChild->getAttributeLabel('controller') ?></th>
                    <th width="250px"><?= $moduleChild->getAttributeLabel('role') ?></th>
                    <th width="5%"><?= Yii::t('yii', 'Action') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php /** @noinspection UnSafeIsSetOverArrayInspection */
                if (isset($moduleChildren) && is_array($moduleChildren)): ?>
                    <?php /** @var backend\models\ModuleChild[] $moduleChildren */ ?>
                    <?php foreach ($moduleChildren as $key => $moduleChild): ?>
                        <tr>
                            <td>
                                <input type="hidden" name="ModuleChild[<?= $key ?>][id]" value="<?= $moduleChild->id ?>"">
                                <input type="text" style="width: 100% !important;" class="form-control" name="ModuleChild[<?= $key ?>][name]" value="<?= $moduleChild->name ?>" title="">
                            </td>
                            <td>
                                <input type="text" style="width: 100% !important;" class="form-control" name="ModuleChild[<?= $key ?>][controller]" value="<?= $moduleChild->controller ?>" title="">
                            </td>
                            <td>
                                <input type="text" style="width: 100% !important;" class="form-control" name="ModuleChild[<?= $key ?>][role]" value="<?= $moduleChild->role ?>" title="">
                            </td>
                            <td><a class="btn btn-danger btn-remove-module-child"> <i class="glyphicon glyphicon-trash"></i> </a></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a type="button" class="btn btn-default" href="<?= Url::to(['index']) ?>"><?= Yii::t('yii', 'Cancel') ?></a>
            <button type="submit" class="btn <?= $module->isNewRecord ? 'btn-info' : 'btn-success' ?>" id="btn_save"><?= Yii::t('yii', 'Save') ?></button>
        </div>
    </div>
</form>
<script>
    $(function () {
        $("#form_role").on('submit', function () {
            if (utils.validate("form_role")) {
                let formData = new FormData(document.getElementById("form_role"));
                utils.submitForm("<?= Url::to(['save-module']) ?>", formData);
            } else {
                $('.error').first().focus();
            }
            return false;
        });
//		MODEL DETAIL
        let tableModuleChild = $("#table_module_child").DataTable({conditionalPaging: true});
        let body = $("body");
        $("#btn_add_module_child").on('click', function () {
            let index = tableModuleChild.rows().count();
            let name = $("#txt_module_child_name").val();
            let controller = $("#txt_module_child_controller").val();
            let role = 'create, update, delete, view';
            tableModuleChild.row
                .add([
                    `<input type="text" name="ModuleChild[${index}][name]" value="${name}" class="form-control txt-name">`
                    , `<input type="text" name="ModuleChild[${index}][controller]" value="${controller}" class="form-control txt-controller">`
                    , `<input type="text" name="ModuleChild[${index}][role]" value="${role}" class="form-control txt-role">`
                    , '<a class="btn btn-danger btn-remove-module-child"> <i class="glyphicon glyphicon-trash"></i> </a>'])
                .draw(false);
        });
        body.on('click', '.btn-remove-module-child', function () {
            tableModuleChild.row($(this).parents('tr')).remove().draw();
        });
        body.on('click', '#btn_load_controller', function () {
            $.blockUI();
            $.get("<?= Url::to(['load-controller']) ?>", function (data) {
                let json = JSON.parse(data);
                let index = tableModuleChild.rows().count();
                let role = 'create, update, delete, view';
                for (let i = 0; i < json.length; i++) {
                    let name = json[i];
                    tableModuleChild.row
                        .add([
                            `<input type="text" name="ModuleChild[${index}][name]" value="${name}" class="form-control txt-name">`
                            , `<input type="text" name="ModuleChild[${index}][controller]" value="${name}" class="form-control txt-controller">`
                            , `<input type="text" name="ModuleChild[${index}][role]" value="${role}" class="form-control txt-role">`
                            , '<a class="btn btn-danger btn-remove-module-child"> <i class="glyphicon glyphicon-trash"></i> </a>'])
                        .draw(false);
                }
                tableModuleChild.row().draw(false);
            });
        });
    });
</script>