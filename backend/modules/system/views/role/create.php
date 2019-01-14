<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $role backend\models\Role */
/* @var $modules backend\models\Module[] */
/* @var $moduleChildren backend\models\ModuleChild[] */
$this->title                   = Yii::t('yii', 'Create {model}', ['model' => mb_convert_case(Yii::t('yii', 'Role'), MB_CASE_LOWER, 'UTF-8')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
    'role'           => $role,
    'roles'          => null,
    'modules'        => $modules,
    'moduleChildren' => $moduleChildren
]) ?>
