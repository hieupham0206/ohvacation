<?php

/* @var $this yii\web\View */
/* @var $voucher common\models\Voucher */
$this->title = 'Cập nhật Voucher: ' . $voucher->code;
$this->params['breadcrumbs'][] = ['label' => 'Voucher', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $voucher->code, 'url' => ['view', 'id' => $voucher->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'voucher' => $voucher,
]) ?>
