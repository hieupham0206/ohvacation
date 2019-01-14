<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = 'Giao dịch';
$this->params['breadcrumbs'][] = $this->title;
/* @var $payment common\models\Payment */
?>
<div class="payment-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['payment' => $payment]); ?>
    <a class="btn btn-primary" href="<?= Url::to( [ 'export-orders' ] ) ?>" title="Export">Export</a>
    <table id="table_payment" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
        <tr>
            <th><?= $payment->getAttributeLabel('customer_name') ?></th>
            <th><?= $payment->getAttributeLabel('customer_phone') ?></th>
            <th><?= $payment->getAttributeLabel('customer_email') ?></th>
            <th><?= $payment->getAttributeLabel('created_date') ?></th>
            <th><?= $payment->getAttributeLabel('transaction_info') ?></th>
            <th><?= $payment->getAttributeLabel('order_code') ?></th>
            <th><?= $payment->getAttributeLabel('total_price') ?></th>
            <th><?= $payment->getAttributeLabel('voucher_code') ?></th>
            <th><?= $payment->getAttributeLabel('type') ?></th>
            <th><?= $payment->getAttributeLabel('status') ?></th>
            <th><?= $payment->getAttributeLabel('total_customer') ?></th>
            <th>Ngày nhận phòng</th>
            <th>Ngày trả phòng</th>
            <th width="5%">Hành động</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
    $(function() {
        $.blockUI();
        let body = $('body');
        let tablePayment = $('#table_payment').DataTable({
            processing: true,
            serverSide: true,
            ajax: $.fn.dataTable.pipeline({
                url: '<?= Url::to(['index-table']) ?>',
                data: function(q) {
                    q.filterDatas = $('#form_payment_search').serialize();
                },
            }),
            conditionalPaging: true,
        });
        body.on('click', '.btn-update-success-order', function() {
            let id = $(this).data('id');
            let self = $(this);
            self.parents('tr').addClass('selected');
            bootbox.confirm({
                size: 'small',
                message: 'Bạn có muốn chuyển trạng thái là thành công?',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post('<?= Url::to(['update-order']) ?>', {id: id, newStatus: 1}, function(result) {
                            if (result == 'success') {
                                body.noti({
                                    type: 'success',
                                    content: 'Success',
                                });
                                tablePayment.clearPipeline().draw();
                            }
                        });
                    }
                    self.parents('tr').removeClass('selected');
                },
            });
        });
        body.on('click', '.btn-success-order', function() {
            let id = $(this).data('id');
            let self = $(this);
            self.parents('tr').addClass('selected');
            bootbox.confirm({
                size: 'small',
                message: 'Bạn có muốn chuyển trạng thái là thành công?',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post('<?= Url::to(['success-order']) ?>', {id: id}, function(result) {
                            if (result == 'success') {
                                body.noti({
                                    type: 'success',
                                    content: 'Success',
                                });
                                tablePayment.clearPipeline().draw();
                            } else {
                                body.noti({
                                    type: 'error',
                                    content: 'Hết phòng, không thể cập nhật đơn hàng',
                                });
                            }
                        });
                    }
                    self.parents('tr').removeClass('selected');
                },
            });
        });
        body.on('click', '.btn-update-fail-order', function() {
            let id = $(this).data('id');
            let self = $(this);
            self.parents('tr').addClass('selected');
            bootbox.confirm({
                size: 'small',
                message: 'Bạn có muốn hủy giao dịch?',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post('<?= Url::to(['update-order']) ?>', {id: id, newStatus: 4}, function(result) {
                            if (result == 'success') {
                                body.noti({
                                    type: 'success',
                                    content: 'Success',
                                });
                                tablePayment.clearPipeline().draw();
                            }
                        });
                    }
                    self.parents('tr').removeClass('selected');
                },
            });
        });
        body.on('click', '.btn-send-mail', function() {
            let id = $(this).data('id');
            let self = $(this);
            self.parents('tr').addClass('selected');
            bootbox.confirm({
                size: 'small',
                message: 'Bạn có muốn gửi mail xác nhận?',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post('<?= Url::to(['send-mail-confirm']) ?>', {id: id}, function(result) {
                            if (result == 'success') {
                                body.noti({
                                    type: 'success',
                                    content: 'Success',
                                });
                            }
                        });
                    }
                    self.parents('tr').removeClass('selected');
                },
            });
        });
        body.on('click', '.btn-edit-payment', function() {
            let id = $(this).data('id');
            utils.showModal({paymentId: id}, '<?= Url::to(['modal-edit-payment']) ?>', $('#modal-lg'));
        });
        body.on('click', '.btn-history', function() {
            let id = $(this).data('id');
            utils.showModal({paymentId: id}, '<?= Url::to(['modal-history']) ?>', $('#modal-lg'));
        });
        body.on('click', '.link-order-detail', function() {
            let orderId = $(this).data('order-id');
            utils.showModal({orderId: orderId}, '<?= Url::to(['inventory/view-orders-detail']) ?>', $('#modal-lg'));
        });
        body.on('click', '.btn-delete-payment', function() {
            utils.deleteRow($(this), '<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>', tablePayment);
        });
        $('#form_payment_search').on('submit', function() {
            tablePayment.clearPipeline().draw();
            return false;
        });
        body.on('click', '#btn_reset_filter', function() {
            $('#form_payment_search').find('input, select').val('').trigger('change');
            tablePayment.clearPipeline().order([]).draw();
        });
    });
</script>