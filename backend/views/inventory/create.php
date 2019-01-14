<?php

/* @var $this yii\web\View */
/* @var $inventory common\models\Inventory */
$this->title                   = 'Tạo Phòng';
$this->params['breadcrumbs'][] = ['label' => 'Kho phòng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'inventory' => $inventory,
]) ?>
