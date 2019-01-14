<?php

/* @var $this yii\web\View */
/* @var $customer common\models\Customer */
$this->title = 'Cập nhật Customer: ' . $customer->name;
$this->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $customer->name, 'url' => ['view', 'id' => $customer->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'customer' => $customer,
]) ?>
