<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Voucher';
$this->params['breadcrumbs'][] = $this->title;
/* @var $voucher common\models\Voucher */
?>
<div class="voucher-index">
	<h1><?= Html::encode($this->title) ?></h1>
	<?= $this->render( '_search', ['voucher' => $voucher] ); ?>
    <div class="form-group">
        <a class="btn btn-primary" href="<?= Url::to(['create']) ?>" title="Tạo mới">Tạo mới</a>
        <a class="btn btn-primary" href="javascript:void(0)" title="Import" id="link_import">Import</a>
    </div>
	<table id="table_voucher" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
		<tr>
			<th><?= $voucher->getAttributeLabel('client_name') ?></th>
			<th><?= $voucher->getAttributeLabel('companion') ?></th>
			<th><?= $voucher->getAttributeLabel('phone') ?></th>
			<th><?= $voucher->getAttributeLabel('email') ?></th>
			<th><?= $voucher->getAttributeLabel('code') ?></th>
			<th><?= $voucher->getAttributeLabel('survey_code') ?></th>
            <th><?= $voucher->getAttributeLabel('orders_code') ?></th>
            <th><?= $voucher->getAttributeLabel('voucher_type') ?></th>
<!--            <th>--><?php //$voucher->getAttributeLabel('status') ?><!--</th>-->
			<th width="5%">Hành động</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<script>
	$(function () {
		$.blockUI();
		let body = $('body');
		let tableVoucher = $("#table_voucher").DataTable({
			processing: true,
			serverSide: true,
			ajax: $.fn.dataTable.pipeline({
				url: "<?= Url::to(['index-table']) ?>",
				data: function(q) {
					q.filterDatas = $("#form_voucher_search").serialize();
				}
			}),
			conditionalPaging: true,
		});
		body.on('click', '.btn-delete-voucher', function () {
            utils.deleteRow($(this), "<?= Yii::t('yii', 'Are you sure you want to delete this item?') ?>", tableVoucher);
		});
        body.on('click', '.link-order-detail', function() {
            let orderId = $(this).data('order-id');
            utils.showModal({orderId: orderId}, '<?= Url::to(['inventory/view-orders-detail']) ?>', $('#modal-lg'));
        });
        $("#form_voucher_search").on('submit', function () {
			tableVoucher.clearPipeline().draw();
            return false;
		});
        $("#link_import").on('click', function() {
            utils.showModal({}, '<?= Url::to( [ 'modal-import' ] ) ?>', $("#modal-md"));
        });
		$("#modal-md").on('show.bs.modal', function() {
			$('#select_voucher_type').select2()
        })
		body.on('click', '#btn_reset_filter', function () {
			$("#form_voucher_search").find('input, select').val('').trigger('change');
			tableVoucher.clearPipeline().order([]).draw();
		});
        body.on('click', '#btn_import_customer', function () {
            $.blockUI();
            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);
            formData.append('voucher_type', $('#select_voucher_type').val());
            utils.submitForm("<?= Url::to( [ 'import-voucher' ] ) ?>", formData).then(function (result) {
                $.unblockUI();
                $("#modal-md").modal('hide');
                if (result == 'no_file') {
                    body.noti({
                        'type': 'error',
                        'title': '<strong>No file!!!</strong>'
                    });
                } else if (result == 'duplicate') {
					body.noti({
						'type': 'error',
						'title': '<strong>File import có voucher trùng, vui lòng kiểm tra lại!!!</strong>'
					});
					tableVoucher.clearPipeline().draw();
				} else if (result == 'success') {
					body.noti({
						'type': 'success',
						'title': '<strong>Success!!!</strong>'
					});
					tableVoucher.clearPipeline().draw();
				} else {
					body.noti({
						'type': 'error',
						'title': '<strong>Failed!!!</strong>'
					});
				}
            });
        });
	});
</script>