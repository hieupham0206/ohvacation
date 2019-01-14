<?php

/* @var $this yii\web\View */
/* @var $inventory common\models\Inventory */
$this->title                   = 'Cập nhật Phòng: ' . $inventory->id;
$this->params['breadcrumbs'][] = ['label' => 'Kho phòng', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $inventory->id, 'url' => ['view', 'id' => $inventory->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<h1><?= yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'inventory' => $inventory,
]) ?>
