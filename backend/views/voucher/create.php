<?php

/* @var $this yii\web\View */
/* @var $voucher common\models\Voucher */
$this->title = 'Tạo Voucher';
$this->params['breadcrumbs'][] = ['label' => 'Voucher', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'voucher' => $voucher,
]) ?>
