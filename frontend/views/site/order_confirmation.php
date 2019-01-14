<?php
use yii\helpers\Url;

$language = 'vi';

// get a session variable. The following usages are equivalent:
if (isset(Yii::$app->request->cookies['language']->value)) {
    $language = Yii::$app->request->cookies['language']->value;
}
$this->title = Yii::t('yii', 'Order Confirmation');
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl . '/templates/css/style.css' ?>">
<input type="hidden" class="check_lang" value="<?= $language ?>">
<div class="overlay"></div>
<div class="container_oder_confirmation">
    <div id="contact">
        <div class="w3ls-agileinfo">
            <a href="javascript:void(0)" id="check_index"><img src="<?= Yii::$app->request->baseUrl . '/templates/images/logo.png' ?>"> </a>
            <p class="lang-select">
                <a class="btn_vietnam" href="javascript:void(0)" hreflang="vn">vn</a>
                <a class="btn_america" href="javascript:void(0)" hreflang="en">en</a>
            </p>
        </div>
        <br>
        <div class="top-icons-agileits-w3layouts">
            <ul class="bootstrapWizardText">
                <li class="l_1_c">
                    <span class="step">&nbsp;</span>
                </li>
                <li class="l_2_c">
                    <span class="step">&nbsp;</span>
                </li>
                <li class="l_3_o ">
                    <span class="step">&nbsp;</span>
                </li>
                <li class="l_4_o ">
                    <span class="step"><?= Yii::t('yii', 'Order confirmation') ?></span>
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
                        <span class="step">3</span>
                    </a>
                </li>
                <li class="active" data-target="#step4">
                    <a href="javascript:void(0)" class="active" title="<?= Yii::t('yii', 'Order confirmation') ?>">
                        <span class="step step_2">4</span><span class="title">&nbsp;</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="login-form form_margin">
            <!-- <label><?php // Yii::t('yii', 'Hi') ?>: <?= $customerName ?></label><br> -->
            <div class="table_left">
                <?php if ($paymentType == 1): ?>
<!--                    <form id="payment_confirmation" action="--><?//= \frontend\models\Cybersource::PAYMENT_URL ?><!--" method="post">-->
                    <form id="payment_confirmation" action="<?= Url::to(['site/fake-result']) ?>" method="post">
                        <input type="hidden" name="access_key" value="<?= \frontend\models\Cybersource::ACCESS_KEY ?>">
                        <input type="hidden" name="profile_id" value="<?= \frontend\models\Cybersource::PROFILE_ID ?>">
                        <input type="hidden" name="transaction_uuid" value="<?= $cybersourceParams['transaction_uuid'] ?>">
                        <input type="hidden" name="signed_field_names" value="<?= \frontend\models\Cybersource::SIGNED_FIELD_NAME ?>">
                        <input type="hidden" name="unsigned_field_names">
                        <input type="hidden" name="signed_date_time" value="<?= $cybersourceParams['signed_date_time'] ?>">
                        <input type="hidden" name="locale" value="<?= Yii::$app->language == 'en' ? 'en-us' : 'vi-vn' ?>">
                        <input type="hidden" name="transaction_type" value="<?= $cybersourceParams['transaction_type'] ?>">
                        <input type="hidden" name="reference_number" value="<?= $cybersourceParams['reference_number'] ?>">
                        <input type="hidden" name="currency" value="VND">
                        <input type="hidden" name="bill_to_email" value="<?= $cybersourceParams['bill_to_email'] ?>">
                        <input type="hidden" name="bill_to_surname" value="<?= $cybersourceParams['bill_to_surname'] ?>">
                        <input type="hidden" name="bill_to_forename" value="<?= $cybersourceParams['bill_to_forename'] ?>">
                        <input type="hidden" name="bill_to_phone" value="<?= $cybersourceParams['bill_to_phone'] ?>">
                        <input type="hidden" name="bill_to_address_country" value="VN">
                        <input type="hidden" name="bill_to_address_line1" value="Tp Hồ Chí Minh">
                        <input type="hidden" name="bill_to_address_postal_code" value="700000">
                        <input type="hidden" name="bill_to_address_city" value="Hồ Chí Minh">
                        <input type="hidden" name="bill_to_company_name" value="Empire">
                        <input type="hidden" name="bill_to_address_state" value="51">
                        <input type="hidden" name="amount" value="<?php echo $order->total_price ?>">
                        <input type="hidden" name="orderCode" value="<?php echo $order->code ?>">
                        <input type="hidden" name="orderId" value="<?php echo $order->id ?>">

<!--                        <input type="hidden" name="line_item_count" value="--><?php //echo $cybersourceParams['line_item_count'] ?><!--">-->
<!--                        <input type="hidden" name="item_0_name" value="--><?php //echo $cybersourceParams['item_0_name'] ?><!--">-->
<!--                        <input type="hidden" name="item_1_name" value="--><?php //echo $cybersourceParams['item_1_name'] ?><!--">-->
<!--                        <input type="hidden" name="item_#_quantity" value="--><?php //echo $cybersourceParams['item_#_quantity'] ?><!--">-->
<!--                        <input type="hidden" name="item_0_unit_price" value="--><?php //echo $cybersourceParams['item_0_unit_price'] ?><!--">-->
<!--                        <input type="hidden" name="item_1_unit_price" value="--><?php //echo $cybersourceParams['item_1_unit_price'] ?><!--">-->

                        <input type="hidden" name="signature" value="<?= \frontend\models\Cybersource::generateSignature($cybersourceParams) ?>">
                        <div class="left-w3-agile left_mobile">
                            <label><?= Yii::t('yii', 'Your reservation code') . ': ' ?></label>
                        </div>
                        <div class="right-agileits right_mobile">
                            <label id=""><?= $order->code ?></label>
                        </div>
                        <div class="left-w3-agile left_mobile">
                            <label><?= Yii::t('yii', 'Total payment amount') . ': ' ?></label>
                        </div>
                        <div class="right-agileits right_mobile">
                            <label id=""><?= number_format($order->total_price) ?> VND</label>
                        </div>
                        <label class="complete"><?= Yii::t('yii', 'Please complete this payment within 10 minutes. Over 10 minutes we will cancel this order') ?></label>
                        <label class="complete" style="color: red!important"><?= Yii::t('yii', 'The reservation date will NOT be changed after you make payment.') ?></label>
                        <div class="timeleft" id="countdown"></div>
                        <div class="left-w3-agile">
                            <button type="button" class="btn-prev btn_ov"><?= Yii::t('yii', 'Cancel') ?></button>
                        </div>
                        <div class="right-agileits">
                            <button type="submit" class="btn_ov" id="btn_confirm_room"><?= Yii::t('yii', 'Pay') ?></button>
                        </div>
                        <!-- <label style="padding: 0px 0px 0px 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> -->
                    </form>
                <?php else: ?>
                    <input type="hidden" id="txt_order_code" value="<?php echo $order->code ?>">
                    <input type="hidden" id="txt_order_id" value="<?php echo $order->id ?>">
                    <div class="left-w3-agile left_mobile">
                        <label><?= Yii::t('yii', 'Your reservation code') . ': ' ?></label>
                    </div>
                    <div class="right-agileits right_mobile">
                        <label><?= $order->code ?></label>
                    </div>
                    <div class="left-w3-agile left_mobile">
                        <label><?= Yii::t('yii', 'Total payment amount') . ': ' ?></label>
                    </div>
                    <div class="right-agileits right_mobile">
                        <label><?= number_format($order->total_price) ?> VND</label>
                    </div>
                    <label><?= Yii::t('yii', 'Please complete this payment within 10 minutes. Over 10 minutes we will cancel this order') ?></label>
                    <label class="complete" style="color: red!important"><?= Yii::t('yii', 'The reservation date will NOT be changed after you make payment.') ?></label>
                    <div class="timeleft" id="countdown"></div>
                    <div class="left-w3-agile">
                        <button type="button" class="btn-prev btn_ov"><?= Yii::t('yii', 'Cancel') ?></button>
                    </div>
                    <div class="right-agileits">
                        <button type="button" class="btn_ov" id="btn_confirm_domestic"><?= Yii::t('yii', 'Pay') ?></button>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close closex">&times;</span>
            <h2><?= Yii::t('yii', 'Choose ATM') ?></h2>
        </div>
        <div class="modal-body">
        </div>
    </div>
</div>
<div id="myModalIndex" class="modal">
    <!-- Modal content -->
    <div class="modal-content-index">
        <div class="modal-header">
            <span class="close ">&times;</span>
            <h2>Do you really want to leave the page?</h2>
        </div>
        <div class="modal-footer">
            <div class="right-agileits">
                <button type="button" class="btn_ov_modal_index" id="id_no"><?= Yii::t('yii', 'No') ?></button>
                <button type="button" class="btn_ov_modal_index" id="id_yes"><?= Yii::t('yii', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Get the modal
        var modalIndex = document.getElementById('myModalIndex');

        // Get the button that opens the modal
        var btn = document.getElementById('myBtn');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName('close')[0];

        // When the user clicks the button, open the modal 

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modalIndex.style.display = 'none';
        };

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


        /**
         * modal chon ngan hang
         */
        /*
         MOdal chon ngan hang
         */
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById('myBtn');

        // Get the <span> element that closes the modal
        var spanX = document.getElementsByClassName('closex')[0];
        spanX.onclick = function() {
            modal.style.display = 'none';
        };
        // When the user clicks the button, open the modal 
        // btn.onclick = function() {
        //     modal.style.display = "block";
        // }
        $('body').on('click', '.btn_bank', function() {
            $.ajax({
                url: '<?= Url::to(['choose-payment-option']) ?>',
                success: function(result) {
                    $('#myModal .modal-content .modal-body').html(result);
                    modal.style.display = 'block';
                }
            });
        });

        $('body').on('click', '.btn-prev', function() {
            $.post('<?= Url::to(['cancel-orders']) ?>', {ordersId: '<?= $order->id ?>'}, function(result) {
                location.href = result;
            });
        });
        $('body').on('click', '#btn_confirm_option', function() {
            let paymentOption = $('input[name="bankcode"]:checked').val();
            let orderCode = $('#txt_order_code').val()
            let orderId = $('#txt_order_id').val()
            modal.style.display = 'none';
            $.blockUI();
            //$.post('<?//= Url::to(['domestic-payment']) ?>//', {paymentOption: paymentOption}, function(result) {
            $.post('<?= Url::to(['site/fake-result']) ?>', {paymentOption: paymentOption, orderCode: orderCode, orderId: orderId}, function(result) {
                if (result.indexOf('http') > -1) {
                    location.href = result;
                } else {
                    alert('Đơn hàng của Quí khách đã quá hạn ở cổng thanh toán. Vui lòng hủy giao dịch và chọn lại phòng. Xin cảm ơn');
                }
            });
        });
        $('#btn_confirm_domestic').on('click', function() {
            $.blockUI();
            $.ajax({
                url: '<?= Url::to(['choose-payment-option']) ?>',
                success: function(result) {
                    $('#myModal .modal-content .modal-body').html(result);
                    modal.style.display = 'block';
                }
            });
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