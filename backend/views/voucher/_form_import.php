<?php
?>
<div class="modal-header">Import voucher</div>
<div class="modal-body">
	<div class="row form-group">
		<div class="col-md-12 form-group">
			<div class="col-md-4"><label for="">Chọn file excel</label></div>
			<div class="col-md-6">
				<input type="file" class="" id="file" name="file_import" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
			</div>
		</div>
		<div class="col-md-12 form-group">
			<div class="col-md-4"><label for="select_voucher_type">Loại voucher</label></div>
			<div class="col-md-6">
                <select name="voucher_type" id="select_voucher_type">
                    <option value="1">Cũ</option>
                    <option value="2">Mới</option>
                </select>
			</div>
		</div>
	</div>
<!--	<div class="row form-group">-->
<!--		<div class="col-md-12">-->
<!--			<div class="col-md-4"><label for="">Excel template</label></div>-->
<!--            <div class="col-md-6"><a download href="--><?php //Yii::getAlias( '@web' ) . '/template/customer.xlsx' ?><!--" class="btn btn-primary">Download Excel Template</a></div>-->
<!--		</div>-->
<!--	</div>-->
</div>
<div class="modal-footer">
	<button data-bb-handler="cancel" data-dismiss="modal" type="button" class="btn btn-default">Đóng</button>
    <a type="button" class="btn btn-primary" id="btn_import_customer">Import</a>
</div>
<script>
</script>