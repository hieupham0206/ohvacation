<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = 'Kho phòng';
$this->params['breadcrumbs'][] = $this->title;
/* @var $inventory common\models\Inventory */
?>
<div class="inventory-index">
    <h1><?= Html::encode( $this->title ) ?></h1>
	<?php if ( Yii::$app->permission->isAdmin() || Yii::$app->user->identity->username == 'chau.bui' ): ?>
        <div class="form-group">
            <a class="btn btn-primary" href="<?= Url::to( [ 'create' ] ) ?>" title="Tạo mới">Tạo mới</a>
            <a class="btn btn-primary" href="<?= Url::to( [ 'create-custom' ] ) ?>" title="Tạo nhiều">Tạo nhiều</a>
            <button class="btn btn-primary" id="btn_modal_delete_rooms" title="Xóa phòng">Xóa phòng</button>
            <button class="btn btn-primary" id="btn_modal_lock_rooms" title="Xóa phòng">Khóa phòng</button>
            <a class="btn btn-primary" href="<?= Url::to( [ 'export-inventory' ] ) ?>" title="Export">Export</a>
        </div>
	<?php endif ?>

	<?= $this->render( '_search', [ 'inventory' => $inventory ] ); ?>
    <table id="table_filter_inventory" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
        <tr>
            <th><?= $inventory->getAttributeLabel( 'stay_date' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'quantity' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'in_stock' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'waiting' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'sold' ) ?></th>
            <th width="5%">Hành động</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th style="text-align:right">Tổng số:&nbsp;&nbsp;</th>
            <th><span id="span-total-all"></span></th>
            <th><span id="span-total-stock"></span></th>
            <th><span id="span-total-wait"></span></th>
            <th><span id="span-total-sold"></span></th>
            <th></th>
        </tr>
        </tfoot>
    </table>
    <hr>
    <h3 style="display: none">Chi tiết phòng ngày <span id="span-view-date"></span></h3>
    <table id="table_inventory" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
        <tr>
            <th><?= $inventory->getAttributeLabel( 'stay_date' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'status' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'sold_date' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'order_code' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'customer_name' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'customer_phone' ) ?></th>
            <th><?= $inventory->getAttributeLabel( 'customer_email' ) ?></th>
<!--            <th>--><?php //$inventory->getAttributeLabel( 'voucher' ) ?><!--</th>-->
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
        let onInit = 0;
        let body = $('body');
        let tableFilter = $('#table_filter_inventory').on('draw.dt', function() {
            if (onInit == 0) {
                getSummary();
            }
            onInit++;
        }).DataTable({
            processing: true,
            serverSide: true,
            ajax: $.fn.dataTable.pipeline({
                url: '<?= Url::to( [ 'index-filter-table' ] ) ?>',
                data: function(q) {
                    q.filterDatas = $('#form_inventory_search').serialize();
                }
            }),
            conditionalPaging: true,
            iDisplayLength: 5,
            sorting: false
        });
        let stayDate = '';
        let detail = '';
        let tableInventory = $('#table_inventory').DataTable({
            processing: true,
            serverSide: true,
            ajax: $.fn.dataTable.pipeline({
                url: '<?= Url::to( [ 'index-table' ] ) ?>',
                data: function(q) {
                    q.filterDatas = $('#form_inventory_search').serialize();
                    q.stay_date = stayDate;
                    q.detail = detail;
                }
            }),
            conditionalPaging: true
        });
        body.on('click', '.btn-lock-room', function() {
            let self = $(this);
            let id = self.data('id');
            let url = self.data('url');
            self.parents('tr').addClass('danger');
            bootbox.confirm({
                size: 'small',
                message: '<?= Yii::t( 'yii', 'Are you sure you want to change this item?' ) ?>',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post(url, {id: id}, function(result) {
                            if (result === 'success') {
                                $('body').noti({
                                    type: 'success',
                                    content: 'Success'
                                });
                                tableInventory.clearPipeline().draw(false);
                            } else {
                                $('body').noti({
                                    type: 'error',
                                    content: 'Fail'
                                });
                            }
                        });
                    }
                    self.parents('tr').removeClass('danger');
                }
            });
        });
        body.on('click', '.btn-open-room', function() {
            let self = $(this);
            let id = self.data('id');
            let url = self.data('url');
            self.parents('tr').addClass('danger');
            bootbox.confirm({
                size: 'small',
                message: '<?= Yii::t( 'yii', 'Are you sure you want to change this item?' ) ?>',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post(url, {id: id}, function(result) {
                            if (result === 'success') {
                                $('body').noti({
                                    type: 'success',
                                    content: 'Success'
                                });
                                tableInventory.clearPipeline().draw(false);
                            } else {
                                $('body').noti({
                                    type: 'error',
                                    content: 'Fail'
                                });
                            }
                        });
                    }
                    self.parents('tr').removeClass('danger');
                }
            });
        });
        body.on('click', '.btn-lock-date', function() {
            let self = $(this);
            let date = self.data('date');
            let url = '<?= Url::to( [ 'lock-date' ] ) ?>';
            self.parents('tr').addClass('danger');
            bootbox.confirm({
                size: 'small',
                message: '<?= Yii::t( 'yii', 'Are you sure you want to change this item?' ) ?>',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post(url, {date: date}, function(result) {
                            if (result === 'success') {
                                $('body').noti({
                                    type: 'success',
                                    content: 'Success'
                                });
                                tableInventory.clearPipeline().draw(false);
                            } else {
                                $('body').noti({
                                    type: 'error',
                                    content: 'Fail'
                                });
                            }
                        });
                    }
                    self.parents('tr').removeClass('danger');
                }
            });
        });
        body.on('click', '.btn-open-date', function() {
            let self = $(this);
            let date = self.data('date');
            let url = '<?= Url::to( [ 'open-date' ] ) ?>';
            self.parents('tr').addClass('danger');
            bootbox.confirm({
                size: 'small',
                message: '<?= Yii::t( 'yii', 'Are you sure you want to change this item?' ) ?>',
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post(url, {date: date}, function(result) {
                            if (result === 'success') {
                                body.noti({
                                    type: 'success',
                                    content: 'Success'
                                });
                                tableInventory.clearPipeline().draw(false);
                            } else {
                                body.noti({
                                    type: 'error',
                                    content: 'Fail'
                                });
                            }
                        });
                    }
                    self.parents('tr').removeClass('danger');
                }
            });
        });

        body.on('click', '.btn-view-note', function() {
            let self = $(this);
            let id = self.data('id');
            utils.showModal({id: id}, '<?= Url::to( [ 'view-note' ] ) ?>', $('#modal-md'));
        });
        body.on('click', '.link-order-detail', function() {
            let orderId = $(this).data('order-id');
            utils.showModal({orderId: orderId}, '<?= Url::to( [ 'view-orders-detail' ] ) ?>', $('#modal-lg'));
        });
        body.on('click', '#btn_modal_delete_rooms', function() {
            utils.showModal({}, '<?= Url::to( [ 'modal-delete-rooms' ] ) ?>', $('#modal-md'));
        });
        body.on('click', '#btn_modal_lock_rooms', function() {
            utils.showModal({}, '<?= Url::to( [ 'modal-lock-rooms' ] ) ?>', $('#modal-md'));
        });
        body.on('click', '#btn_delete_rooms', function() {
            let date = $('#txt_date').val();
            let quantity = $('#txt_quantity').val();
            let action = $('#txt_action').val();

            $.post('<?= Url::to( [ 'modify-rooms' ] ) ?>', {date: date, quantity: quantity, action: action}, function(result) {
                if (result == 'success') {
                    body.noti({
                        type: 'success',
                        content: 'Success'
                    });
                    $('#modal-md').modal('hide');
                    tableFilter.clearPipeline().draw();
                    detail = 0;
                    getSummary();
                } else if (result == 'out_of_room') {
                    body.noti({
                        type: 'error',
                        content: 'Số lượng không đủ'
                    });
                } else {
                    body.noti({
                        type: 'error',
                        content: 'Fail'
                    });
                }
            });
        });
        $('#form_inventory_search').on('submit', function() {
            tableFilter.clearPipeline().draw();
            detail = 0;
            tableInventory.clearPipeline().draw();
            getSummary();
            return false;
        });
        body.on('click', '#btn_reset_filter', function() {
            $('#form_inventory_search').find('input, select').val('').trigger('change');
            tableFilter.clearPipeline().order([]).draw();
            detail = 0;
            getSummary();
        });
        body.on('click', '.btn-inventory-detail', function() {
            $(this).parents('tbody').find('tr.selected').removeClass('selected');
            $(this).parents('tr').addClass('selected');
            $('#span-view-date').parent().show().end().text($(this).parents('tr').find('td:eq(0)').text());
            stayDate = $(this).data('date');
            detail = 1;
            tableInventory.clearPipeline().draw();
            getSummary();
        });

        function getSummary() {
            $.get('<?= Url::to( [ 'get-summary' ] ) ?>', {filterDatas: $('#form_inventory_search').serialize()}, function(data) {
                if (data == 'empty') {
                    $('#table_filter_inventory').find('tfoot span').text('');
                } else {
                    $('#span-total-stock').text(data['totalStock']);
                    $('#span-total-wait').text(data['totalWait']);
                    $('#span-total-sold').text(data['totalSold']);
                    $('#span-total-all').text(data['totalAll']);
                }
            });
        }
    });
</script>