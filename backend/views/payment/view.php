<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $payment common\models\Payment */
$this->title = $payment->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view ">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_name"><?= $payment->getAttributeLabel('customer_name') ?></label>
                <input type="text" class="form-control" value="<?= $payment->customer_name ?>" id="txt_customer_name" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_phone"><?= $payment->getAttributeLabel('customer_phone') ?></label>
                <input type="text" class="form-control" value="<?= $payment->customer_phone ?>" id="txt_customer_phone" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_email"><?= $payment->getAttributeLabel('customer_email') ?></label>
                <input type="text" class="form-control" value="<?= $payment->customer_email ?>" id="txt_customer_email" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_transaction_info"><?= $payment->getAttributeLabel('transaction_info') ?></label>
                <input type="text" class="form-control" value="<?= $payment->transaction_info ?>" id="txt_transaction_info" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_total_price"><?= $payment->getAttributeLabel('total_price') ?></label>
                <input type="text" class="form-control" value="<?= $payment->total_price ?>" id="txt_total_price" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_order_code"><?= $payment->getAttributeLabel('order_code') ?></label>
                <input type="text" class="form-control" value="<?= $payment->order_code ?>" id="txt_order_code" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_response_code"><?= $payment->getAttributeLabel('response_code') ?></label>
                <input type="text" class="form-control" value="<?= $payment->response_code ?>" id="txt_response_code" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_message"><?= $payment->getAttributeLabel('message') ?></label>
                <input type="text" class="form-control" value="<?= $payment->message ?>" id="txt_message" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_type"><?= $payment->getAttributeLabel('type') ?></label>
                <input type="text" class="form-control" value="<?= $payment->type ?>" id="txt_type" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_note"><?= $payment->getAttributeLabel('note') ?></label>
                <input type="text" class="form-control" value="<?= $payment->note ?>" id="txt_note" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_orders_id"><?= $payment->getAttributeLabel('orders_id') ?></label>
                <input type="text" class="form-control" value="<?= $payment->orders_id != null ? $payment->orders->name : '' ?>" id="txt_orders_id" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_id"><?= $payment->getAttributeLabel('customer_id') ?></label>
                <input type="text" class="form-control" value="<?= $payment->customer_id != null ? $payment->customer->name : '' ?>" id="txt_customer_id" readonly>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>">Hủy</a>
            <?php if ( Yii::$app->permission->can( Yii::$app->controller->id , 'update' )) : ?>
                <a class="btn btn-success" href="<?= Url::to( [ 'update', 'id' => $payment->id ] ) ?>">Cập nhật</a>
            <?php endif; ?>
        </div>
    </div>
</div>
