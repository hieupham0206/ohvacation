<?php
/* @var $this yii\web\View */
/* @var $payment common\models\Payment */
?>
<form id="form_payment_search" class="search-form">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_name"><?= $payment->getAttributeLabel('customer_name') ?></label>
                <input type="text" class="form-control" name="customer_name" id="txt_customer_name">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_phone"><?= $payment->getAttributeLabel('customer_phone') ?></label>
                <input type="text" class="form-control" name="customer_phone" id="txt_customer_phone">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_email"><?= $payment->getAttributeLabel('customer_email') ?></label>
                <input type="text" class="form-control" name="customer_email" id="txt_customer_email">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_transaction_info"><?= $payment->getAttributeLabel('transaction_info') ?></label>
                <input type="text" class="form-control" name="transaction_info" id="txt_transaction_info">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_order_code"><?= $payment->getAttributeLabel('order_code') ?></label>
                <input type="text" class="form-control" name="order_code" id="txt_order_code">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_voucher_code"><?= $payment->getAttributeLabel('voucher_code') ?></label>
                <input type="text" class="form-control" name="voucher_code" id="txt_voucher_code">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_date_from"><?= $payment->getAttributeLabel('date_from') ?></label>
                <input type="text" class="form-control datepicker" name="date_from" id="txt_date_from">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_date_to"><?= $payment->getAttributeLabel('date_to') ?></label>
                <input type="text" class="form-control datepicker" name="date_to" id="txt_date_to">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_date_in"><?= 'Ngày check in' ?></label>
                <input type="text" class="form-control datepicker" name="date_in" id="txt_date_in">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="select_type"><?= $payment->getAttributeLabel('type') ?></label>
                <select name="type" id="select_type" class="select form-control">
                    <option></option>
                    <option value="0">Nội địa</option>
                    <option value="1">Visa/Mastercard</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="select_status"><?= $payment->getAttributeLabel('status') ?></label>
                <select name="status" id="select_status" class="select form-control">
                    <option></option>
                    <option value="<?= \common\models\Payment::PAYMENT_WAITING ?>">Chờ thanh toán</option>
                    <option value="<?= \common\models\Payment::PAYMENT_SUCCESS ?>">Thành công</option>
                    <option value="<?= \common\models\Payment::PAYMENT_FAIL ?>">Thất bại</option>
                    <option value="<?= \common\models\Payment::PAYMENT_CANCEL ?>">Hủy giao dịch</option>
                    <option value="5">Đã thanh toán - Hết hạn</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group pull-right" style="margin-top: 22px">
                <a type="button" class="btn btn-default" id="btn_reset_filter">Thiết lập lại</a>
                <button class="btn btn-info" id="btn_filter">Tìm kiếm</button>
            </div>
        </div>
    </div>
</form>
