<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $customer \common\models\Customer */
$language = 'vi';

// get a session variable. The following usages are equivalent:
if (isset(Yii::$app->request->cookies['language']->value)) {
    $language = Yii::$app->request->cookies['language']->value;
}
$this->title = 'Voucher';
//TODO: minh them nut "Gui lai ma OTP" nhe
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl . '/templates/css/style.css' ?>">
<input type="hidden" class="check_lang" value="<?= $language ?>">
<div class="overlay"></div>
<div class="container container_otp">
    <div id="contact">
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
                <li class="li_1">
                    <span class="step "><?= Yii::t('yii', 'Confirm information') ?></span>
                </li>
                <li data-target="#step2">
                    <span class="step ">&nbsp;</span>
                </li>
                <li data-target="#step3" class="">
                    <span class="step ">&nbsp;</span>
                </li>
                <li data-target="#step4">
                    <span class="step ">&nbsp;</span>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="bootstrapWizard form-wizard">
                <li class="active" data-target="#step1">
                    <a href="javascript:void(0)" class="active" title="<?= Yii::t('yii', 'Confirm information') ?>">
                        <span class="step step_2">1</span>
                    </a>
                </li>
                <li data-target="#step2">
                    <a href="javascript:void(0)" class="" title="<?= Yii::t('yii', 'Choose check-in date') ?>">
                        <span class="step">2</span>
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
        <h3><?= Yii::t('yii', 'An authentication code has been sent to:') ?> <?= $email ?></h3>
        <div class="login-form form_otp">
            <label for="txt_otp"> <?= Yii::t('yii', 'OTP code (send guests) is valid for 10 minutes') ?></label>
           
                <input type="text" id="txt_otp">
           
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <button type="button" width="100%" class="btn_resend" id="btn_resend_otp"><?= Yii::t('yii', 'Resend OTP (if you have not received your OTP Code)') ?></button>
           

            <div class="left-w3-agile">
                <button type="button" class="btn_ov btn-prev" id=""><?= Yii::t('yii', 'Previous') ?></button>
            </div>
           
            <div class="right-agileits">
                <button type="button" class="btn_ov" id="btn_otp"><?= Yii::t('yii', 'Confirm') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content-index">
        <div class="modal-header">
            <span class="close">&times;</span>
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
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById('myBtn');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName('close')[0];

        // When the user clicks the button, open the modal 

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = 'none';
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
        $('body').on('click', '#check_index', function() {
            modal.style.display = 'block';
        });
        $('body').on('click', '#id_no', function() {
            modal.style.display = 'none';
        });
        $('body').on('click', '#id_yes', function() {
            location.href = '<?= Url::to(['index']) ?>';
        });

        $('body').on('click', '.btn-prev', function() {
            location.href = '<?= Url::to(['index']) ?>';
        });
        $('body').on('click', '#btn_otp', function() {
            let otp = $('#txt_otp').val();
            if (otp !== '') {
                $.blockUI();
                $.post('<?= Url::to(['verify-otp']) ?>', {otp: otp}, function(result) {
                    if (result.indexOf('http') > -1) {
                        location.href = result;
                    } else if (result === 'otp_expire') {
                        alert('Mã OTP đã hết hạn');
                    } else {
                        alert('Mã OTP không chính xác');
                    }
                });
            } else {
                alert('Mã OTP không được để trống');
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
        $("#btn_resend_otp").on('click', function() {
            $.blockUI();
            $.post("<?= Url::to(['resend-otp']) ?>", {email: '<?= $email ?>'}, function(result) {
                if (result == 'success') {
                    $.unblockUI();
                }
            });
        })
    });
</script>

