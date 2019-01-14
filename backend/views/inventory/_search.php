<?php
/* @var $this yii\web\View */
/* @var $inventory common\models\Inventory */
?>
<form id="form_inventory_search" class="search-form">
	<div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_stay_date_to"><?= $inventory->getAttributeLabel('stay_date_from') ?></label>
                <div class="input-group stay-date">
                    <input type="text" class="form-control datepicker" name="stay_date_from" id="txt_stay_date_to"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
        </div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="txt_stay_date_from"><?= $inventory->getAttributeLabel('stay_date_to') ?></label>
                <div class="input-group stay-date">
                    <input type="text" class="form-control datepicker" name="stay_date_to" id="txt_stay_date_from"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
			</div>
		</div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_sold_date_from"><?= $inventory->getAttributeLabel('sold_date_from') ?></label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" name="sold_date_from" id="txt_sold_date_from"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_sold_date_to"><?= $inventory->getAttributeLabel('sold_date_to') ?></label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" name="sold_date_to" id="txt_sold_date_to"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_name"><?= $inventory->getAttributeLabel('customer_name') ?></label>
                <input type="text" class="form-control" name="customer_name" id="txt_customer_name">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_email"><?= $inventory->getAttributeLabel('customer_email') ?></label>
                <input type="text" class="form-control" name="customer_email" id="txt_customer_email">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_customer_phone"><?= $inventory->getAttributeLabel('customer_phone') ?></label>
                <input type="text" class="form-control" name="customer_phone" id="txt_customer_phone">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_order_code"><?= $inventory->getAttributeLabel('order_code') ?></label>
                <input type="text" class="form-control" name="order_code" id="txt_order_code">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_inventory_status"><?= $inventory->getAttributeLabel('status') ?></label>
                <select name="status" id="select_status" class="form-control select" title="">
                    <option></option>
                    <option value="0">Còn</option>
                    <option value="1">Đã bán</option>
                    <option value="2">Chờ thanh toán</option>
                    <option value="3">Chờ xác nhận</option>
                    <option value="-1">Đã khóa</option>
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
<script>
    $(function () {
        $("#txt_stay_date").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom left',
//            startDate: '01-08-2017',
            todayHighlight: true,
        });
    });
</script>