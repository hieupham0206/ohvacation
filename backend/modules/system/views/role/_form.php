<?php
use yii\helpers\Inflector;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $role backend\models\Role */
/* @var $modules backend\models\Module[] */
/* @var $moduleChildren backend\models\ModuleChild[] */
/* @var $roles array */
?>
<form id="form_role">
    <div class="row">
        <input type="hidden" name="Role[id]" value="<?= $role->id ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_name"><?= $role->getAttributeLabel( 'name' ) ?></label>
                <input type="text" class="form-control alphanum" name="Role[name]" value="<?= $role->name ?>" id="txt_name" autofocus>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="select_status"><?= $role->getAttributeLabel('status') ?></label>
                <select name="Role[status]" id="select_status" class="select">
                    <option></option>
                    <option value="1" <?= $role->status === 1 || $role->isNewRecord ? 'selected' : '' ?>>Kích hoạt</option>
                    <option value="0" <?= $role->status === 0 ? 'selected' : '' ?>>Không kích hoạt</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12 ">
            <table class="table table-hover table-bordered fix-border-color">
                <tbody class="fix-border-color">
				<?php foreach ( $modules as $moduleKey => $module ): ?>
                    <tr class="tr-groups-title fix-background-color" style="background-color: #f5f5f5">
                        <td colspan="7" class="fix-border-color">
                            <h3><b><?= Yii::t( 'yii', $module->name ); ?></b></h3>
                        </td>
                    </tr>
					<?php foreach ( $moduleChildren as $moduleChildKey => $moduleChild ):
						$permissions = explode( ',', $moduleChild->role );
						$moduleName = $moduleChild->controller;
						?>
                        <?php if ($module->id == $moduleChild->module_id): /** @noinspection UnSafeIsSetOverArrayInspection */
                        $checkAll = isset($roles) && array_key_exists('all_' . $moduleName, $roles) ? $roles['all_' . $moduleName] : ''; ?>
                        <tr class="fix-border-color">
                            <td class="fix-border-color" style="width:20%;vertical-align: middle; font-weight: bold;"><?= Yii::t( 'yii', Inflector::camel2words( Inflector::camelize( $moduleChild->name ) ) ); ?></td>
                            <td class="fix-border-color" style="width:13.333%;">
                                <div class="checkbox" style="padding-top: 7px">
                                    <label>
                                        <input type="checkbox" class="chk_all_permission permission" data-module="<?= $moduleName ?>" data-role="all" <?= $checkAll == 1 ? 'checked' : '' ?>>
										<?= Yii::t( 'yii', 'All' ); ?>
                                    </label>
                                </div>
                            </td>
							<?php /** @var string[] $permissions */
							foreach ( $permissions as $permissionKey => $permission ):
                                /** @noinspection UnSafeIsSetOverArrayInspection */
                                $checked = isset($roles) && array_key_exists(trim($permission) . '_' . $moduleName, $roles) ? $roles[trim($permission) . '_' . $moduleName] : '';
								?>
                                <td class="fix-border-color" style="width:13.333%;">
                                    <div class="checkbox" style="padding-top: 7px">
                                        <label>
                                            <input type="checkbox" class="chk_permission permission" data-module="<?= $moduleName ?>" data-role="<?= $permission ?>" <?= $checked == 1 ? 'checked' : '' ?>>
											<?= Yii::t( 'yii', Inflector::humanize( $permission ) ); ?>
                                        </label>
                                    </div>
                                </td>
							<?php endforeach ?>
                        </tr>
					<?php endif ?>
					<?php endforeach ?>
				<?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a type="button" class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>"><?= Yii::t( 'yii', 'Cancel' ) ?></a>
            <button class="btn <?= $role->isNewRecord ? 'btn-primary' : 'btn-success' ?>" id="btn_save"><?= Yii::t( 'yii', 'Save' ) ?></button>
        </div>
    </div>
</form>
<script>
    $(function () {
        $(".chk_all_permission").on('click', function () {
            if ($(this).is(':checked')) {
                $(this).parents('tr').find('.chk_permission').prop('checked', true);
            } else {
                $(this).parents('tr').find('.chk_permission').prop('checked', false);
            }
        });
        $(".chk_permission").on('click', function () {
            let tr = $(this).parents('tr');
            if (tr.find('.chk_permission:checked').length == 4) {
                $(this).parents('tr').find('.chk_all_permission').prop('checked', true);
            } else {
                $(this).parents('tr').find('.chk_all_permission').prop('checked', false);
            }
        });
        $("#form_role").on('submit', function () {
            if (utils.validate("form_user_role")) {
                let roles = {};
                $(".permission").each(function () {
                    let module = $(this).data('module');
                    let role = $(this).data('role');
                    let check = 0;
                    if ($(this).is(':checked')) {
                        check = 1;
                    }
                    roles[$.trim(role) + '_' + $.trim(module.toLowerCase())] = check;
                });
                roles = JSON.stringify(roles);
                let formData = new FormData(document.getElementById("form_role"));
                formData.append('roles', roles);
                utils.submitForm("<?= Url::to( [ 'save' ] ) ?>", formData);
            } else {
                $('.error').first().focus();
            }
            return false;
        });
    });
</script>