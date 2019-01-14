<?php

use yii\helpers\Url;

$this->title                   = Yii::t('yii', 'Report');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Báo cáo tồn kho';
\backend\assets\HighChartsAsset::register($this)
/** @var \common\models\Inventory $inventory */
/* @var $role backend\models\Role */
?>
<div class="">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#room_by_date" aria-controls="synthetic" role="tab" data-toggle="tab">Báo cáo tồn kho theo ngày</a></li>
<!--        <li role="presentation"><a href="#room_by_status" aria-controls="synthetic" role="tab" data-toggle="tab">Báo cáo tồn kho theo trạng thái</a></li>-->
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="room_by_date">
            <div class="row" style="margin-top: 10px">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="txt_date_from">Từ ngày</label>
                        <input type="text" class="form-control custom-datepicker" name="date_from" id="txt_date_from" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="txt_date_to">Đến ngày</label>
                        <input type="text" class="form-control custom-datepicker" name="date_to" id="txt_date_to" readonly>
                    </div>
                </div>
<!--                <div class="col-md-2">-->
<!--                    <div class="radio">-->
<!--                        <label>-->
<!--                            <input type="checkbox" id="chk_check_all" value="1"> Tất cả-->
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-primary" id="btn_generate_room_by_price" title="Báo cáo tổng hợp" style="margin-top: 22px">Báo cáo</button>
                        <a class="btn btn-primary" href="<?= Url::to( [ 'export-report-inventory-by-price' ] ) ?>" title="Báo cáo tổng hợp" style="margin-top: 22px">Export excel</a>
                    </div>
                </div>
            </div>
            <div id="report_by_price_section" style="width: 100%">
                <div id="report_by_price_chart_section"></div>
                <table id="table_report_by_price" class="table table-striped table-bordered nowrap" style="width: 100%; display: none">
                    <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Số phòng</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="room_by_status" style="display: none">
            <div class="" style="margin-top: 10px">
                <?= $this->render('/inventory/_search', ['inventory' => $inventory]); ?>
                <table id="table_filter_inventory" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                    <tr>
                        <th><?= $inventory->getAttributeLabel('stay_date') ?></th>
                        <th><?= $inventory->getAttributeLabel('quantity') ?></th>
                        <th><?= $inventory->getAttributeLabel('in_stock') ?></th>
                        <th><?= $inventory->getAttributeLabel('waiting') ?></th>
                        <th><?= $inventory->getAttributeLabel('sold') ?></th>
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
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        let onInit = 0;
        $(".custom-datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom left',
            todayHighlight: true,
//            startDate: '01-08-2017'
        });
        $("#btn_generate_synthetic").on('click', function () {
            $.blockUI();
            $.post("<?= Url::to(['generate-synthetic-report']) ?>", function (result) {
                $("#report_synthetic_section").html(result);
            });
        });
        $("#btn_generate_room_by_price").on('click', function () {
            $.blockUI();
            let checkAll = $("#chk_check_all").is(':checked') ? 1 : 0;
            $.post("<?= Url::to(['generate-by-date-report']) ?>", {dateFrom: $("#txt_date_from").val(), dateTo: $("#txt_date_to").val(), checkAll: checkAll}, function (result) {
                if (result !== 'empty') {
                    $("#report_by_price_section").show();
                    Highcharts.chart('report_by_price_chart_section', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Báo cáo phòng tồn kho'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'Số phòng'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                }
                            }
                        },
                        series: [{
                            name: 'Phòng',
                            colorByPoint: true,
                            data: result
                        }],
                    });
                    let datas = result;
                    let rows = '';
                    _.each(datas, function(obj) {
                        rows += `<tr>
                                <td>${obj['name']}</td>
                                <td>${obj['y']}</td>
                            </tr>`
                    });
                    $("#table_report_by_price").show().find('tbody').html(rows);
                } else {
                    $("body").noti({
                        type: 'warning',
                        content: 'Không có dữ liệu'
                    });
                    $("#report_by_price_section").hide();
                }
            });
        });
//        let tableFilter = $('#table_filter_inventory').on('draw.dt', function() {
//            if (onInit == 0) {
//                getSummary();
//            }
//            onInit++;
//        }).DataTable({
//            processing: true,
//            serverSide: true,
//            ajax: $.fn.dataTable.pipeline({
//                url: '<?//= Url::to(['/inventory/index-filter-table']) ?>//',
//                data: function(q) {
//                    q.filterDatas = $('#form_inventory_search').serialize();
//                    q.type = 0;
//                },
//            }),
//            conditionalPaging: true,
//            iDisplayLength: 5,
//            sorting: false
//        });
//
//        function getSummary() {
//            $.get('<?//= Url::to(['/inventory/get-summary']) ?>//', {filterDatas: $('#form_inventory_search').serialize()}, function(data) {
//                if (data == 'empty') {
//                    $('#table_filter_inventory').find('tfoot span').text('');
//                } else {
//                    $('#span-total-stock').text(data['totalStock']);
//                    $('#span-total-wait').text(data['totalWait']);
//                    $('#span-total-sold').text(data['totalSold']);
//                    $('#span-total-all').text(data['totalAll']);
//                }
//            });
//        }
//
//        $("#form_inventory_search").on('submit', function () {
//            tableFilter.clearPipeline().draw();
//            getSummary();
//            return false;
//        });
//        $("body").on('click', '#btn_reset_filter', function () {
//            $("#form_inventory_search").find('input, select').val('').trigger('change');
//            tableFilter.clearPipeline().order([]).draw();
//            getSummary();
//        });
    });
</script>