<?php

/* @var $this yii\web\View */
/* @var $customer common\models\Customer */
$this->title = 'Tạo Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'customer' => $customer,
]) ?>
