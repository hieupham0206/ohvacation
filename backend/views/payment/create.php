<?php

/* @var $this yii\web\View */
/* @var $payment common\models\Payment */
$this->title = 'Tạo Payment';
$this->params['breadcrumbs'][] = ['label' => 'Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'payment' => $payment,
]) ?>
