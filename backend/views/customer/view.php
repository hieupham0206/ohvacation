<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $customer common\models\Customer */
$this->title = $customer->name;
$this->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view ">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_name"><?= $customer->getAttributeLabel('name') ?></label>
                <input type="text" class="form-control" value="<?= $customer->name ?>" id="txt_name" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_companion"><?= $customer->getAttributeLabel('companion') ?></label>
                <input type="text" class="form-control" value="<?= $customer->companion ?>" id="txt_companion" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_cmnd"><?= $customer->getAttributeLabel('cmnd') ?></label>
                <input type="text" class="form-control" value="<?= $customer->cmnd ?>" id="txt_cmnd" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_phone"><?= $customer->getAttributeLabel('phone') ?></label>
                <input type="text" class="form-control" value="<?= $customer->phone ?>" id="txt_phone" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_email"><?= $customer->getAttributeLabel('email') ?></label>
                <input type="text" class="form-control" value="<?= $customer->email ?>" id="txt_email" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_OTP"><?= $customer->getAttributeLabel('OTP') ?></label>
                <input type="text" class="form-control" value="<?= $customer->OTP ?>" id="txt_OTP" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_otp_date"><?= $customer->getAttributeLabel('otp_date') ?></label>
                <input type="text" class="form-control" value="<?= Yii::$app->formatter->asDate($customer->otp_date) ?>" id="txt_otp_date" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_is_verified"><?= $customer->getAttributeLabel('is_verified') ?></label>
                <input type="text" class="form-control" value="<?= $customer->is_verified ?>" id="txt_is_verified" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_verified_date"><?= $customer->getAttributeLabel('verified_date') ?></label>
                <input type="text" class="form-control" value="<?= Yii::$app->formatter->asDate($customer->verified_date) ?>" id="txt_verified_date" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_voucher_id"><?= $customer->getAttributeLabel('voucher_id') ?></label>
                <input type="text" class="form-control" value="<?= $customer->voucher_id != null ? $customer->voucher->name : '' ?>" id="txt_voucher_id" readonly>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>">Hủy</a>
            <?php if ( Yii::$app->permission->can( Yii::$app->controller->id , 'update' )) : ?>
                <a class="btn btn-success" href="<?= Url::to( [ 'update', 'id' => $customer->id ] ) ?>">Cập nhật</a>
            <?php endif; ?>
        </div>
    </div>
</div>
