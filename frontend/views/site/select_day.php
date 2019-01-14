<?php
use yii\helpers\Url;

$language = 'vi';
if (isset(Yii::$app->request->cookies['language']->value)) {
    $language = Yii::$app->request->cookies['language']->value;
}
$this->title = Yii::t('yii', 'Choose Date');
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl . '/templates/css/style.css' ?>">
<input type="hidden" class="check_lang" value="<?= $language ?>">
<div class="overlay"></div>
<div class="container">
    <div id="contact_select_day">
        <div class="w3ls-agileinfo">
            <a href="javascript:void(0)" id="check_index"><img src="<?= Yii::$app->request->baseUrl . '/templates/images/logo.png' ?>"> </a>
            <p class="lang-select">
                <a class="btn_vietnam" href="javascript:void(0)" hreflang="vn">vn</a>
                <a class="btn_america" href="javascript:void(0)" hreflang="en">en</a>
            </p>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="top-icons-agileits-w3layouts">
            <ul class="bootstrapWizardText">
                <li class="li_1_s">
                    <span class="step ">&nbsp;</span>
                </li>
                <li class="li_2">
                    <span class="step "><?= Yii::t('yii', 'Choose check-in date') ?></span>
                </li>
                <li>
                    <span class="step "></span>
                </li>
                <li>
                    <span class="step "></span>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="bootstrapWizard form-wizard">
                <li class="active" data-target="#step1">
                    <a href="javascript:void(0)" class="active" title="<?= Yii::t('yii', 'Confirm information') ?>">
                        <span class="step ">1</span>
                    </a>
                </li>
                <li class="active" data-target="#step2">
                    <a href="javascript:void(0)" class="active" title="<?= Yii::t('yii', 'Choose check-in date') ?>">
                        <span class="step step_2">2</span>
                    </a>
                </li>
                <li data-target="#step3" class="">
                    <a href="javascript:void(0)" title="<?= Yii::t('yii', 'Choose payment') ?>">
                        <span class="step">3</span>
                    </a>
                </li>
                <li data-target="#step4">
                    <a href="javascript:void(0)" title="<?= Yii::t('yii', 'Order confirmation') ?>">
                        <span class="step">4</span><span class="title">&nbsp;</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="login-form form_select_day">
            <div class="left-w3-agile left_mobile_s">
                <label><?= Yii::t('yii', 'Check in date') ?></label>
                <input type="text" class="datepicker" id="txt_date_in" title="">
            </div>
            <div class="right-agileits right_mobile_s">
                <label><?= Yii::t('yii', 'Check out date') ?></label>
                <input type="text" class="form-control" id="txt_date_out" title="" disabled>
            </div>
            <br>
            <!-- <div class="col_100">
                <label>Phòng: 1</label>
            </div>
            <div class="col_100">
                <label>Người lớn:</label>
                <label class="checkbox_select">
                    <input type="radio" title="" value="1" name="rad_adult" checked> 1
                </label>
                <label class="checkbox_select">
                    <input type="radio" title="" value="0" name="rad_adult"> 0
                </label>
            </div>
            <div class="col_100">
                <label>Trẻ em dưới 12 tuổi:</label>
                <label class="checkbox_select">
                    <input type="radio" title="" value="0" name="rad_children" checked> 0
                </label>
                <label class="checkbox_select">
                    <input type="radio" title="" value="1" name="rad_children"> 1
                </label>
            </div> -->
            <div class="col_100_table">
                <br>
                <table id="table_room_choose" class="table table-bordered datatable" width="100%">
                    <tbody>
                    <tr>
                        <td><label><?= Yii::t('yii', 'Room'); ?>: 1</label></td>
                        <td>
                            <label for="select_adult"><?= Yii::t('yii', 'Adult'); ?>:</label>
                            <select id="select_adult">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </td>
                        <td>
                            <label for="select_child"><?= Yii::t('yii', 'Child'); ?> *</label>
                            <select id="select_child">
                                <option>0</option>
                                <option>1</option>
<!--                                <option>2</option>-->
                            </select>
                            <br>
                            <label>*<?= Yii::t('yii', 'under 12 years old'); ?></label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--            <div class="left_table">-->
            <!--                <table id="table_room" class="table table-bordered datatable" width="100%">-->
            <!--                    <thead>-->
            <!--                    <tr>-->
            <!--                        <th>--><?php //Yii::t('yii', 'Date') ?><!--</th>-->
            <!--                        <th>--><?php //Yii::t('yii', 'Note') ?><!--</th>-->
            <!--                    </tr>-->
            <!--                    </thead>-->
            <!--                    <tbody>-->
            <!--                    </tbody>-->
            <!--                </table>-->
            <!--            </div>-->
            <div class="left-w3-agile">
                <button type="button" class="btn_ov btn-prev" id=""><?= Yii::t('yii', 'Previous') ?></button>
            </div>
            <div class="right-agileits">
                <button type="button" class="btn_ov" id="btn_confirm"><?= Yii::t('yii', 'Confirm') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('body').on('click', '.btn-prev', function() {
            location.href = '<?= Url::to(['index']) ?>';
        });
        let roomIds = [];
        $('table_room_choose').DataTable({
            'lengthChange': false,
            'searching': false,
            paging: false,
            'sort': false,
            'info': false
        });
//        let tableRoom = $('#table_room').DataTable({
//            'lengthChange': false,
//            'searching': false,
//            paging: false,
//            'sort': false,
//            'info': false
//        });
        let red = JSON.parse('<?= $reds ?>');
        let reds = $.map(red, function(el) { return parseInt(el); });
        let yellow = JSON.parse('<?= $yellows ?>');
        let yellows = $.map(yellow, function(el) { return parseInt(el); });
        let blue = JSON.parse('<?= $blues ?>');
        let blues = $.map(blue, function(el) { return parseInt(el); });
        $('#txt_date_in').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom left',
            todayHighlight: true,
            language: 'vi',
            datesDisabled: ['<?= $datesDisabled[0] ?>', '<?= $datesDisabled[1] ?>', '<?= $datesDisabled[2] ?>','<?= $datesDisabled[3] ?>', '<?= $datesDisabled[4] ?>', '<?= $datesDisabled[5] ?>', '<?= $datesDisabled[6] ?>', '<?= $datesDisabled[7]
                ?>'],
//            startDate: '01-08-2017',
            beforeShowDay: function(date) {
                let curDate = moment(date).unix();
                if ($.inArray(curDate, yellows) !== -1) {
                    return 'yellow';
                }
                if ($.inArray(curDate, blues) !== -1) {
                    return 'blue';
                }
                if ($.inArray(curDate, reds) !== -1) {
                    return 'red';
                }
            }
        }).on('changeDate', function() {
            let date = $('#txt_date_in').val();
            if (date === '') {
                alert('Bạn chưa chọn phòng');
            } else {
                $.post('<?= Url::to(['get-room']) ?>', {date: date}, function(datas) {
//                    tableRoom.rows().remove();
                    if (datas == 'room_empty') {
                        alert('Đã hết phòng, vui lòng chọn lại');
                        $('#txt_date_out').val('');
                        $('#txt_date_in').val('');
                        roomIds = [];
                        return false;
                    }
                    if (datas == 'rechoose_date') {
                        alert('Vui lòng chọn lại sau 7 ngày');
                        $('#txt_date_out').val('');
                        $('#txt_date_in').val('');
                        roomIds = [];
                        return false;
                    }
                    let totalRow = datas.length;
                    roomIds = datas[totalRow - 1];
                    $('#txt_date_out').val(moment.unix(datas[totalRow - 2]['stay_date']).format('DD-MM-YYYY'));
//                    for (let i = 0; i < totalRow; i++) {
//                        let obj = datas[i];
//                        let note = '';
//                        if (i == 0) {
//                            note = '<?//= Yii::t('yii', 'Check In Date'); ?>//';
//                        }
//                        if (i == totalRow - 1) {
//                            note = '<?//= Yii::t('yii', 'Check Out Date'); ?>//';
//                        } else {
//                            roomIds.push(obj['id']);
//                        }
//                        tableRoom.row.add([
//                            moment.unix(obj['stay_date']).format('DD-MM-YYYY'),
//                            note
//                        ]);
//                    }
//                    tableRoom.row().draw();
                });
            }
        });
        $('#btn_confirm').on('click', function() {
            if ($('#txt_date_in').val().length == 0) {
                alert('<?= Yii::t('yii', 'Please Choose Date') ?>');
                return false;
            } else {
                let roomTempIds = roomIds.join(',');
                if (roomTempIds !== '') {
                    $.blockUI();
                    let adult = $('#select_adult').val();
                    let child = $('#select_child').val();
                    location.href = '<?= Url::to(['choose-payment']) ?>' + '?roomIds='+roomTempIds+'&note='+adult+','+child;
                } else {
                    alert('Bạn chưa chọn phòng, vui lòng chọn phòng');
                }
            }
        });

        /* js ngôn ngữ */
        if ($('.check_lang').val() == 'vi') {
            $('.btn_vietnam').css('font-weight', 'bold');
            $('.btn_vietnam').css('font-size', '18px');
        } else {
            $('.btn_america').css('font-weight', 'bold');
            $('.btn_america').css('font-size', '18px');
        }

        $('body').on('click', '.btn_vietnam', function() {
            $.ajax({
                method: 'POST',
                url: '<?= Url::to(['site/change-lang'])?>',
                data: {
                    lang: 'vi'
                }
            }).success(function() {
                location.reload();
            });
        });

        $('body').on('click', '.btn_america', function() {
            $.ajax({
                method: 'POST',
                url: '<?= Url::to(['site/change-lang'])?>',
                data: {
                    lang: 'en'
                }
            }).success(function() {
                location.reload();
            });
        });

    });
</script>
<style>
    .datepicker-days .yellow:not(.disabled):not(.new):not(.old) {
        color: gold;
        border: solid 1px gold;
    }

    .datepicker-days .blue:not(.disabled):not(.new):not(.old) {
        color: blue;
        border: solid 1px blue;
    }

    .datepicker-days .red:not(.disabled):not(.new):not(.old) {
        color: red;
        border: solid 1px red;
    }
</style>