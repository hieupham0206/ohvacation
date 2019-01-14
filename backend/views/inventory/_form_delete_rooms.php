<?php

?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-3">
            <label for="txt_date">Ngày</label>
            <input name="" class="form-control" id="txt_date">
            <input type="hidden" class="form-control" id="txt_action" value="<?= $action ?>">
        </div>
        <div class="col-md-3">
            <label for="txt_quantity">Số lượng</label>
            <input name="" class="form-control" id="txt_quantity">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button data-dismiss="modal" type="button" class="btn btn-default">Đóng</button>
    <button type="button" class="btn btn-primary" id="btn_delete_rooms">Lưu</button>
</div>
<script>
    $(function() {
        $("#txt_date").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom left',
            todayHighlight: true,
            language: 'vi'
        });
    });
</script>