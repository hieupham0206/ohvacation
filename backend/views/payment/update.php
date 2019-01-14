<?php

/* @var $this yii\web\View */
/* @var $payment common\models\Payment */
$this->title = 'Cập nhật Payment: ' . $payment->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $payment->customer_name, 'url' => ['view', 'id' => $payment->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'payment' => $payment,
]) ?>
