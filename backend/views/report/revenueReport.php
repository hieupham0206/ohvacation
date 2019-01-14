<?php

use yii\helpers\Url;

$this->title                   = Yii::t('yii', 'Report');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Báo cáo doang thu';
\backend\assets\HighChartsAsset::register($this)
/* @var $role backend\models\Role */
?>
<div class="">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#revenue" aria-controls="revenue" role="tab" data-toggle="tab">Báo cáo doanh thu theo ngày</a></li>
        <li role="presentation"><a href="#transaction" aria-controls="transaction" role="tab" data-toggle="tab">Báo cáo giao dịch</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="revenue">
            <div class="row" style="margin-top: 10px">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="txt_date_from">Nhóm ngày</label>
                        <select name="preset_date" id="select_preset_date" title="" class="select">
                            <option></option>
                            <option value="0">Theo ngày</option>
                            <option value="1">Theo tuần</option>
                            <option value="2">Theo tháng</option>
                        </select>
                    </div>
                </div>
                <div id="date_section" style="display: none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txt_date_from">Từ ngày</label>
                            <input type="text" class="form-control custom-datepicker" id="txt_date_from" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txt_date_to">Đến ngày</label>
                            <input type="text" class="form-control custom-datepicker" id="txt_date_to" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="button" class="btn btn-default" id="btn_reset_filter" title="Thiết lập lại" style="margin-top: 22px">Thiết lập lại</button>
                        <button class="btn btn-primary" id="btn_generate_revenue" title="Báo cáo tổng hợp" style="margin-top: 22px">Báo cáo</button>
                        <a class="btn btn-primary" href="<?= Url::to( [ 'export-report-revenue' ] ) ?>" title="Báo cáo tổng hợp" style="margin-top: 22px">Export excel</a>
                    </div>
                </div>
            </div>
            <div id="report_revenue_section" style="width: 100%; display: none">
                <div id="report_revenue_chart_section"></div>
                <table id="table_report_revenue" class="table table-striped table-bordered nowrap" style="width: 100%; display: none">
                    <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Số tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="transaction">
            <div class="row" style="margin-top: 10px">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="txt_date_from">Từ ngày</label>
                        <input type="text" class="form-control custom-datepicker" id="txt_transaction_date_from">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="txt_date_to">Đến ngày</label>
                        <input type="text" class="form-control custom-datepicker" id="txt_transaction_date_to">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-primary" id="btn_generate_transaction" title="Báo cáo tổng hợp" style="margin-top: 22px">Báo cáo</button>
                    </div>
                </div>
            </div>
            <div id="report_transaction_section" style="width: 100%; display: none">
                <div id="report_transaction_chart_section"></div>
                <table id="table_order_summary" class="table table-striped table-bordered nowrap" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Tổng số giao dịch</th>
                        <th>Tổng số giao dịch thành công</th>
                        <th>Tổng số giao dịch thất bại</th>
                        <th>Tổng số giao dịch chờ thanh toán</th>
                        <th>Tổng số giao dịch hủy</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".custom-datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom left',
            todayHighlight: true,
        });
        $("#btn_generate_revenue").on('click', function () {
            $.blockUI();
            $.post("<?= Url::to(['generate-revenue-report']) ?>", {dateFrom: $("#txt_date_from").val(), dateTo: $("#txt_date_to").val(), presetDate: $("#select_preset_date").val()}, function (result) {
                if (result != 'empty') {
                    $("#report_revenue_section").show();
                    Highcharts.chart('report_revenue_chart_section', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Báo cáo doanh thu theo thời gian'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: [{ // Primary yAxis
                            labels: {
//                                format: '{value} VND',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'Số tiền',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        },
//                            { // Secondary yAxis
//                                title: {
//                                    text: 'Số giao dịch',
//                                    style: {
//                                        color: Highcharts.getOptions().colors[0]
//                                    }
//                                },
//                                labels: {
//                                    style: {
//                                        color: Highcharts.getOptions().colors[0]
//                                    }
//                                },
//                                opposite: true
//                            }
                        ],
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
                            name: 'Tổng tiền',
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
                    $("#table_report_revenue").show().find('tbody').html(rows);
                } else {
                    $("body").noti({
                        type: 'warning',
                        content: 'Không có dữ liệu'
                    });
                    $("#report_revenue_section").hide();
                }
            });
        });
        $("#btn_generate_transaction").on('click', function () {
            let dateFrom = $("#txt_transaction_date_from").val();
            let dateTo = $("#txt_transaction_date_to").val();
            if (dateFrom != '' || dateTo != '') {
                $.blockUI();
                $.post("<?= Url::to(['generate-transaction-report']) ?>", {dateFrom: dateFrom, dateTo: dateTo}, function (result) {
                    if (result != 'empty') {
                        $("#report_transaction_section").show();
                        Highcharts.chart('report_transaction_chart_section', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: 'Biểu đồ tỉ lệ giao dịch'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: false
                                    },
                                    showInLegend: true
                                }
                            },
                            series: [{
                                name: 'Tỉ lệ',
                                colorByPoint: true,
                                data: result[0]
                            }]
                        });
                        let hold = result[1][3] != 'undefined' ? result[1][3] : 0;
                        let cancel = result[1][3] != 'undefined' ? result[1][4] : 0;
                        let success = result[1][1] != 'undefined' ? result[1][1] : 0;
                        let fail = result[1][2] != 'undefined' ? result[1][2] : 0;
                        $("#table_order_summary").find('tbody').html(`
                            <tr>
                                <td>${result[1][0]}</td>
                                <td>${success}</td>
                                <td>${fail}</td>
                                <td>${hold}</td>
                                <td>${cancel}</td>
                            </tr>
                        `)
                    } else {
                        $("body").noti({
                            type: 'warning',
                            content: 'Không có dữ liệu'
                        });
                        $("#report_transaction_section").hide();
                    }
                });
            } else {
                $("body").noti({
                    type: 'error',
                    content: 'Bạn chưa chọn ngày'
                })
            }
        });
        $('#btn_reset_filter').on('click', function () {
            $("#report_revenue_section").hide();
            $("#revenue").find('input, select').val('').trigger('change');
            $('#date_section').hide();
        });
        $("#select_preset_date").on('change', function () {
            $("#report_revenue_section").hide();
            if ($(this).val() == 0) {
                $("#date_section").show();
            } else {
                $("#date_section").find('input').val('').end().hide();
            }
        })
    });
</script>