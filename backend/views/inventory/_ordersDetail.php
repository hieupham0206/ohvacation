<?php
/** @var \common\models\Payment $payment */
/** @var \common\models\OrdersDetail[] $orderDetails */
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title create_user" id="myModalLabel">Chi tiết đơn hàng</h4>
</div>
<div class="modal-body">
    <div class="row">
        <?php if ($form == 'inventory'): ?>
            <div class="col-md-12">
                <table id="table_inventory" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                    <tr>
                        <th>Message</th>
                        <th>Số tiền</th>
                        <th>Ngày thanh toán</th>
<!--                        <th>Hành động</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($payment != null): ?>
                        <tr>
                            <td><?= $payment->message ?></td>
                            <td><?= number_format($payment->total_price) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($payment->modified_date) ?></td>
<!--                            <td>-->
<!--                                --><?php //if ($payment->orders->payment_status == 0): ?>
<!--                                    <button class='btn btn-info btn-update-success-order' data-id='--><?php //$payment->orders_id ?><!--'><i class='glyphicon glyphicon-edit'></i></button>-->
<!--                                    <button class='btn btn-danger btn-update-fail-order' title='Sửa' data-id='--><?php //$payment->orders_id ?><!--'><i class='glyphicon glyphicon-edit'></i></button>-->
<!--                                --><?php //endif ?>
<!--                            </td>-->
                        </tr>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
        <div class="col-md-12">
            <table id="table_inventory" class="table table-striped table-bordered nowrap" width="100%">
                <tbody>
                <tr>
                    <td>Ngày nhận phòng</td>
                    <td><?= date('d-m-Y', $orderDetails[0]->inventory->stay_date) ?></td>
                </tr>
                <tr>
                    <td>Ngày trả phòng</td>
                    <td><?= date('d-m-Y', strtotime('+1 day', $orderDetails[count($orderDetails) - 1]->inventory->stay_date)) ?></td>
                </tr>
                <tr>
                    <td>Tổng số khách</td>
                    <td><?= $payment->getTotalCustomer() ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default" type="button" data-dismiss="modal" data-bb-handler="cancel">Đóng</button>
        </div>
    </div>
</div>