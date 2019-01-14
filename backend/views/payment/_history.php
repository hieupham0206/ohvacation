<?php
?>

<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<table id="table_payment_log" class="table table-striped table-bordered" width="100%">
				<thead>
				<tr>
					<th>Ngày chỉnh sửa</th>
					<th>Người chỉnh sửa</th>
					<th>Nội dung</th>
				</tr>
				</thead>

				<tbody>
				<?php /** @var \common\models\PaymentLog[] $paymentLogs */
				foreach ($paymentLogs as $key => $payment_log): ?>
					<tr>
						<td><?= Yii::$app->formatter->asDatetime( $payment_log->created_date) ?></td>
						<td><?= $payment_log->createdBy->username ?></td>
						<td><?= $payment_log->message ?></td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-default" type="button" data-dismiss="modal" data-bb-handler="cancel">Đóng</button>
</div>
<script>
    $(function() {
	    $("#table_payment_log").DataTable({
            "columnDefs": [
                {"targets": [0, 1, 2], "searchable": false, "orderable": false, "visible": true},
                // {className: "text-center", "targets": '_all'}
            ],
		    conditionalPaging: true,
	    });
    });
</script>
