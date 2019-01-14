<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $voucher common\models\Voucher */
$this->title = $voucher->code;
$this->params['breadcrumbs'][] = ['label' => 'Voucher', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voucher-view ">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_client_nane"><?= $voucher->getAttributeLabel('client_nane') ?></label>
                <input type="text" class="form-control client_nane" name="Voucher[client_nane]" value="<?= $voucher->client_name ?>" id="txt_client_nane" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_companion"><?= $voucher->getAttributeLabel('companion') ?></label>
                <input type="text" class="form-control companion" name="Voucher[companion]" value="<?= $voucher->companion ?>" id="txt_companion" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_code"><?= $voucher->getAttributeLabel('code') ?></label>
                <input type="text" class="form-control" value="<?= $voucher->code ?>" id="txt_code" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_survey_code"><?= $voucher->getAttributeLabel('survey_code') ?></label>
                <input type="text" class="form-control" value="<?= $voucher->survey_code ?>" id="txt_survey_code" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_phone"><?= $voucher->getAttributeLabel('phone') ?></label>
                <input type="text" class="form-control" value="<?= $voucher->phone ?>" id="txt_phone" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_email"><?= $voucher->getAttributeLabel('email') ?></label>
                <input type="text" class="form-control" value="<?= $voucher->email ?>" id="txt_email" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_voucher_type"><?= $voucher->getAttributeLabel('voucher_type') ?></label>
                <input type="text" class="form-control" value="<?= $voucher->getVoucherTypeText() ?>" id="txt_voucher_type" readonly>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>">Hủy</a>
            <?php if ( Yii::$app->permission->can( Yii::$app->controller->id , 'update' )) : ?>
                <a class="btn btn-success" href="<?= Url::to( [ 'update', 'id' => $voucher->id ] ) ?>">Cập nhật</a>
            <?php endif; ?>
        </div>
    </div>
</div>
