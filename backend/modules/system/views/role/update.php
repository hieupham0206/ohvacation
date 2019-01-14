<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $role backend\models\Role */
/* @var $modules backend\models\Module[] */
/* @var $moduleChildren backend\models\ModuleChild[] */
/* @var $roles array */
$this->title                   = Yii::t('yii', 'Update {model}', ['model' => mb_convert_case(Yii::t('yii', 'Role'), MB_CASE_LOWER, 'UTF-8')]) . ': ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Role'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $role->name, 'url' => ['view', 'id' => $role->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
    'role'           => $role,
    'modules'        => $modules,
    'moduleChildren' => $moduleChildren,
    'roles'          => $roles
]) ?>
