<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $inventory common\models\Inventory */
$this->title                   = $inventory->id;
$this->params['breadcrumbs'][] = ['label' => 'Kho phòng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-view ">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="txt_stay_date"><?= $inventory->getAttributeLabel('stay_date') ?></label>
                <input type="text" class="form-control" value="<?= Yii::$app->formatter->asDate($inventory->stay_date) ?>" id="txt_stay_date" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="txt_sold_date"><?= $inventory->getAttributeLabel('sold_date') ?></label>
                <input type="text" class="form-control" value="<?= Yii::$app->formatter->asDate($inventory->sold_date) ?>" id="txt_sold_date" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="txt_inventory_status"><?= $inventory->getAttributeLabel('status') ?></label>
                <input type="text" class="form-control" value="<?= $inventory->getStatus() ?>" id="txt_inventory_status" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="txt_note"><?= $inventory->getAttributeLabel('note') ?></label>
                <input type="text" class="form-control" value="<?= $inventory->note ?>" id="txt_note" readonly>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>">Hủy</a>
            <?php if ( Yii::$app->permission->can( Yii::$app->controller->id , 'update' )) : ?>
                <a class="btn btn-success" href="<?= Url::to( [ 'update', 'id' => $inventory->id ] ) ?>">Cập nhật</a>
            <?php endif; ?>
        </div>
    </div>
</div>
