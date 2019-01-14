<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $customer \common\models\Customer */
/* @var $paymentResult \frontend\models\PaymentResult */
$language = 'vi';

// get a session variable. The following usages are equivalent:
if (isset(Yii::$app->request->cookies['language']->value)) {
    $language = Yii::$app->request->cookies['language']->value;
}

$this->title = 'Payment Result';
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
        <div class="login-form form_margin">
            <div class="table_left">
                <h2 style="color: #fff; font-size: 14px; "><?= $paymentResult->transStatus ?></h2>
            </div>
            <button type="button" class="btn_ov btn-prev" id=""><?= Yii::t('yii', 'Home') ?> <i class="glyphicon glyphicon-home"></i></button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table_payment_result').DataTable({
            'lengthChange': false,
            'searching': false,
            paging: false,
            'sort': false,
            'info': false
        });
        $('body').on('click', '.btn-prev', function() {
            location.href = '<?= Url::to(['index']) ?>';
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