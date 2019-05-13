<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

$language = 'vi';
if (isset(Yii::$app->request->cookies['language']->value)) {
    $language = Yii::$app->request->cookies['language']->value;
}
$this->title = Yii::t('yii', 'Choose payment method');
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl . '/templates/css/style.css' ?>">
<input type="hidden" class="check_lang" value="<?= $language ?>">
<div class="overlay"></div>
<div class="container_choose_payment">
    <div id="contact_choose_payment">
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
                <li class="l_1_c">
                    <span class="step ">&nbsp;</span>
                </li>
                <li class="l_2_c">
                    <span class="step ">&nbsp;</span>
                </li>
                <li class="l_3">
                    <span class="step "><?= Yii::t('yii', 'Choose payment') ?></span>
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
                        <span class="step">2</span>
                    </a>
                </li>
                <li class="active" data-target="#step3" class="">
                    <a href="javascript:void(0)" class="active" title="<?= Yii::t('yii', 'Choose payment') ?>">
                        <span class="step step_2">3</span>
                    </a>
                </li>
                <li data-target="#step4">
                    <a href="javascript:void(0)" title="<?= Yii::t('yii', 'Order confirmation') ?>">
                        <span class="step">4</span><span class="title">&nbsp;</span>
                    </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="login-form form_margin">
            <input type="hidden" id="txt_room_price" value="<?= $roomPrice ?>">
            <div class="class_radio class_radio_top">
                <input type="radio" id="radio01" name="paymentType" value="0" disabled/>
                <label for="radio01"><span></span><?= Yii::t('yii', 'Domestic payment') ?> (ATM có internet banking)</label>
            </div>
            <div class="class_radio">
                <input type="radio" id="radio02" name="paymentType" value="1" checked/>
                <label for="radio02"><span></span><?= Yii::t('yii', 'International payments') ?> (VISA, MasterCard)</label>
            </div>
            <div class="left_table">
                <label for=""><?= Yii::t('yii', 'Order information'); ?></label>
                <table id="table_check_out" class="table table-bordered datatable" width="100%">
                    <!--                    <thead>-->
                    <!--                    <tr>-->
                    <!--                        <th>--><?php //Yii::t('yii', 'Date') ?><!--</th>-->
                    <!--                        <th>--><?php //Yii::t('yii', 'Note') ?><!--</th>-->
                    <!--                    </tr>-->
                    <!--                    </thead>-->
                    <tbody>
                    <?php /** @var \common\models\Inventory[] $rooms */ ?>
                    <tr>
                        <td><?= Yii::t('yii', 'Check In Date') ?></td>
                        <td><?= Yii::$app->formatter->asDate($rooms[0]->stay_date) ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('yii', 'Check Out Date') ?></td>
                        <td><?= date('d-m-Y', strtotime('+1 days', $rooms[count($rooms) - 1]->stay_date)) ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('yii', 'Total customer'); ?></td>
                        <td><?= Yii::t('yii', 'Adult'); ?>: <?= $totalCustomer[0] ?>, <?= Yii::t('yii', 'Child'); ?>: <?= $totalCustomer[1] ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('yii', 'Reservation fee') ?></td>
                        <td><?= number_format($roomPrice) ?> VND</td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('yii', 'Transaction processing fee') ?></td>
                        <td><label id="lbl_charge"></label></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('yii', 'Total money to pay') ?></td>
                        <td>
                            <label id="lbl_total_price_visible"></label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
         
            <!-- <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> -->
            <div class="left_table">
                <label class="checkbox-inline">
                    <input type="checkbox" id="rad_condition">
                    <?= Yii::t('yii', 'I have read and accept the ') ?> <a href="javascript:void(0)" class="rules" style="color: #ffc90e;"><?= Yii::t('yii','terms and conditions') ?></a> <?= Yii::t('yii',' of the promotion') ?>
                   
                </label>
            </div>
            <div class="left-w3-agile">
                <button type="button" class="btn_ov btn-prev" id=""><?= Yii::t('yii', 'Previous') ?></button>
            </div>
            <div class="right-agileits">
                <button type="button" class="btn_ov" id="btn_confirm"><?= Yii::t('yii', 'Confirm') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModalIndex" class="modal">
    <!-- Modal content -->
    <div class="modal-content-index">
        <div class="modal-header">
            <span style="display: none;" class="closeIndex">&times;</span>
            <h2><?= Yii::t('yii', 'Do you really want to leave the page?') ?></h2>
        </div>
        <div class="modal-footer">
            <div class="right-agileits">
                <button type="button" class="btn_ov_modal_index" id="id_no"><?= Yii::t('yii', 'No') ?></button>
                <button type="button" class="btn_ov_modal_index" id="id_yes"><?= Yii::t('yii', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="myModalrules" class="modal">
    <!-- Modal content -->
    <div class="modal-content-index">
        <div class="modal-header">
            <span class="close closerules" style="z-index: 999999">×</span>
            <h2>ĐIỀU KHOẢN VÀ ĐIỀU KIỆN SỬ DỤNG GIFT VOUCHER</h2>
        </div>
        <div class="modal-footer">
            <?php if ($isOldVoucher): ?>
                <h2 style="color: black;text-align: left;font-weight: bold;margin: 5px 0;">A.	ĐIỀU KHOẢN VÀ ĐIỀU KIỆN SỬ DỤNG PHIẾU QUÀ TẶNG</h2>
                <p class="p_rules">- Phiếu Qùa Tặng không có giá trị chuyển nhượng, tặng cho và quy đổi thành tiền dưới bất kỳ hình thức nào;</p>
                <p class="p_rules">- Phiếu Qùa Tặng không áp dụng cho chương trình khuyến mãi khác và không được cấp lại nếu mất mát hoặc không còn nguyên vẹn, lành lặn;</p>
                <p class="p_rules">- Phiếu Qùa Tặng có giá trị lưu trú 03 ngày 02 đêm dành cho 02 người lớn và 01 trẻ dm dưới 12 tuổi tại Boutique Hotel thuộc Cocobay Đà Nẵng. Không áp dụng chia nhỏ ngày nghỉ dưỡng;</p>
                <p class="p_rules">- Không bao gồm vé máy bay, chi phí đi lại, ăn uống và các chi phí cá nhân phát sinh khác;</p>
                <p class="p_rules">- Điều kiện áp dụng: Tham gia tối thiểu 60 phút tour giới thiệu về kỳ nghỉ của chúng tôi. Qúy khách sẽ chịu chi phí phòng theo giá niêm yết tại Boutqiue Hotel thuộc Cocobay Đà Nẵng nếu không tham gia tour
                                       giới thiệu về kỳ nghỉ;</p>
                <p class="p_rules">- Áp dụng phí đặt phòng 650,000VNĐ (Đã bao gồm VAT); miễn phí cho Chủ sở hữu;</p>
                <p class="p_rules">- Phiếu Quà Tặng không áp dụng cho các ngày Lễ đặc biệt và mùa cao điểm, bao gồm cả ngày Quốc Khánh và mùa Giáng Sinh;</p>
                <p class="p_rules">- Qúy khách vui lòng mang theo Phiếu Quà Tặng này để làm thủ tục nhận phòng và xác nhận trước khi thanh toán;</p>
                <p class="p_rules">- Phiếu Qùa Tặng này có giá trị sử dụng như thời hạn in trên Phiếu Qùa Tặng;</p>
                <p class="p_rules">- Khu nghỉ dưỡng bắt đầu đón khách từ 01/08/2017;</p>
            <?php else: ?>
                <h2 style="color: black;text-align: left;font-weight: bold;margin: 5px 0;">A.	ĐIỀU KHOẢN VÀ ĐIỀU KIỆN SỬ DỤNG PHIẾU QUÀ TẶNG</h2>
                <p class="p_rules">- Phiếu Quà tặng không có giá trị chuyển nhượng, tặng cho và quy đổi thành tiền dưới bất kỳ hình thực nào;</p>
                <p class="p_rules">- Phiếu Quà tặng không áp dụng cho chương trình khuyến mãi khác và không được cấp
                                   lại nếu mất mát hoặc không còn nguyên vẹn, lành lặn;</p>
                <p class="p_rules">- Phiếu Quà Tặng có giá trị lưu trú 03 ngày 02 đêm hoặc 04 ngày 03 đêm tùy theo loại Phiếu Quà Tặng -  dành cho 02 người lớn và 01 trẻ em dưới 12 tuổi tại Boutique Hotel thuộc Cocobay Đà Nẵng. Không áp dụng chia
                                   nhỏ ngày nghỉ dưỡng;</p>
                <p class="p_rules">- Không bao gồm vé máy bay, chi phí đi lại, ăn uống và các chi phí cá nhân phát sinh khác;</p>
                <p class="p_rules">- Điều kiện áp dụng: Tham gia tối thiểu 90 phút tour giới thiệu về kỳ nghỉ của chúng tôi. Quý
                                   khách sẽ chịu chi phí phòng theo giá niêm yết tại Boutique Hotel thuộc Cocobay Đà Nẵng
                                   nếu không tham gia tour giới thiệu về kỳ nghỉ;</p>
                <p class="p_rules">- Áp dụng phí đặt phòng 650,000VNĐ với Phiếu Qùa Tặng 3 ngày 2 đêm và 990,000 VNĐ với Phiếu Qùa Tặng 4 ngày 3 đêm (Đã bao gồm VAT); miễn phí cho Chủ sở hữu;</p>
                <p class="p_rules">- Phiếu quà tặng không áp dụng cho các ngày Lễ đặc biệt và mùa cao điểm, bao gồm cả
                                   ngày Quốc Khánh và mùa Giáng sinh;</p>
                <p class="p_rules">- Quý khách vui lòng mang theo Phiếu quà tặng này để làm thủ tục nhận phòng và xác
                                   nhận trước khi thanh toán;</p>
                <p class="p_rules">- Phiếu Quà tặng này có giá trị sử dụng như thời hạn in trên voucher;</p>
                <p class="p_rules">- Khu nghỉ dưỡng bắt đầu đón khách từ 01/08/2017;</p>
            <?php endif ?>


<!--            <p class="p_rules">- Tham khảo điều khoản & điều kiện sử dụng dịch vụ ipay tại: <a href="https://card.vietinbank.vn/sites/home/vi/chu-the/dich-vu-tien-ich/dich-vu-iPay.html">https://card.vietinbank.vn/sites/home/vi/chu-the/dich-vu-tien-ich/dich-vu-iPay.html</a></p>-->
            <h2 style="color: black;text-align: left;font-weight: bold;margin: 5px 0;">B.	ĐIỀU KHOẢN QUY ĐỊNH VỀ THANH TOÁN</h2>
            <p class="p_rules">- Phiếu Quà Tặng đã có hiệu lực sau khi khách hàng hoàn tất các thủ tục thanh toán;</p>
            <p class="p_rules">- Giao dịch thanh toán cho kỳ nghỉ của Quý khách tại website không được hoàn trả vì bất kỳ lý do nào và dưới bất kỳ hình thức nào trừ trường hợp giao dịch thanh toán tại website không thành công nhưng Quý khách bị
                               trừ tiền qua hệ thống thanh toán trực tuyến, Công Ty sẽ phối hợp với các đối tác để kiểm tra thông tin và hỗ trợ các thủ tục tiến hành hoàn trả.</p>

            <h2 style="color: black;text-align: left;font-weight: bold;margin: 5px 0;">C.	ĐIỀU KHOẢN BẢO MẬT</h2>
            <p class="p_rules">- Thông tin khách hàng bao gồm Họ và tên, Email, Số Điện Thoại được phía Công Ty đề nghị Quý khách cung cấp được sử dụng cho mục đích cung cấp các dịch vụ đến Quý khách. Công Ty cam kết bảo mật các thông tin liên
                               quan đến khách hàng và không tiết lộ cho bất cứ bên thứ 3 nào khác trừ trường hợp có yêu cầu từ cơ quan nhà nước có thẩm quyền.</p>

            <h2 style="color: black;text-align: left;font-weight: bold;margin: 5px 0;">D.	LIÊN HỆ HỖ TRỢ DỊCH VỤ ĐẶT PHÒNG</h2>
            <p class="p_rules">- Văn phòng HCM: Tầng 19, Pearl Plaza, 561A Điện Biên Phủ, P.25, Q. Bình  Thạnh, TP.HCM</p>
            <p class="p_rules">- Văn phòng Hà Nội: Tầng 1-2, Horison Tower, 40 Cát Linh, P. Cát Linh, Q, Đống Đa, Hà Nội</p>
            <p class="p_rules">- Văn phòng Đà Nẵng: đường Trường Sa, P. Hòa Hải, Q. Ngũ Hành Sơn, Đà Nẵng.</p>
            <p class="p_rules">- Hotline : 19006967</p>
            <p class="p_rules">- Email: info@ohacation.com</p>
        </div>
    </div>
</div>
<script type="text/javascript">
    var paymentOption = '';
    $(document).ready(function() {
        /*modal dieu khoan*/
        // Get the modal
        var modalRules = document.getElementById('myModalrules');
        var closerule = document.getElementsByClassName('closerules')[0];
         closerule.onclick = function() {
            modalRules.style.display = 'none';
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modalRules) {
                modalRules.style.display = 'none';
            }
        };

        $('body').on('click', '.rules', function() {
            modalRules.style.display = 'block';
        });
        /*
         /* modal tro ve index */
        // Get the modal
        var modalIndex = document.getElementById('myModalIndex');

        // Get the <span> element that closes the modal
        var spanIndex = document.getElementsByClassName('closeIndex')[1];

        // When the user clicks the button, open the modal 

        // When the user clicks on <span> (x), close the modal
        // spanIndex.onclick = function() {
        //     modalIndex.style.display = 'none';
        // };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modalIndex) {
                modalIndex.style.display = 'none';
            }
        };
        $('body').on('click', '#check_index', function() {
            modalIndex.style.display = 'block';
        });
        $('body').on('click', '#id_no', function() {
            modalIndex.style.display = 'none';
        });
        $('body').on('click', '#id_yes', function() {
            location.href = '<?= Url::to(['index']) ?>';
        });
        /*
         MOdal chon ngan hang
         */
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById('myBtn');

        // Get the <span> element that closes the modal
        var span = $('.close');

        // When the user clicks the button, open the modal
        // btn.onclick = function() {
        //     modal.style.display = "block";
        // }
        // if ($('input[name="paymentType"]:checked').val() == 0) {
        //     modal.style.display = 'block';
        // }
        $('input[name="paymentType"]').click(function() {
            let amount = 0, charge = 0;
            let roomPrice = parseInt($('#txt_room_price').val())

            if ($(this).val() == 0 && $(this).is(':checked')) {
                //$.ajax({
                //    url: '<?//= Url::to(['choose-payment-option']) ?>//',
                //    success: function(result) {
                //        $('#myModal .modal-content .modal-body').html(result);
                //        modal.style.display = 'block';
                //    }
                //});
                charge = 2200 + (roomPrice * 0.012);
                amount = roomPrice + charge;
            } else {
                charge = 2200 + (roomPrice * 0.025);
                amount = roomPrice + charge;
            }
            $('#lbl_charge').text(numeral(charge).format('0,0') + ' VND');
            $('#lbl_total_price_visible').text(numeral(amount).format('0,0') + ' VND');
        });
        $('input[name="paymentType"]').trigger('click');
        $('body').on('click', '#btn_confirm_option', function() {
            paymentOption = $('input[name="bankcode"]:checked').val();
            modal.style.display = 'none';
        });
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = 'none';
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target !== modal) {
                modal.style.display = 'none';
            }
        };

        /* end ----*/
        $('body').on('click', '.btn-prev', function() {
            location.href = '<?= Url::to(['choose-date']) ?>';
        });
//        $('#table_check_out').DataTable({
//            'lengthChange': false,
//            'searching': false,
//            paging: false,
//            'sort': false,
//            'info': false
//        });
        $('#btn_confirm').on('click', function() {
            if ($('#rad_condition').is(':checked')) {
                let paymentType = $('input[name="paymentType"]:checked').val();
                $.blockUI();
                $.post('<?= Url::to(['confirm-order']) ?>', {paymentType: paymentType}, function(result) {
                    if (result.indexOf('http') > -1) {
                        if (paymentType == 0) {
                            location.href = result;
                        } else {
                            location.href = result;
                        }
                    } else {
                        alert('Xác nhận đơn hàng lỗi');

                    }
                });
            } else {
                alert('Bạn chưa đồng ý điều khoản');
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
