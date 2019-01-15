<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

// AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $customer \common\models\Customer */
$language = 'vi';

// get a session variable. The following usages are equivalent:
if (isset(Yii::$app->request->cookies['language']->value)) {
    $language = Yii::$app->request->cookies['language']->value;
}
$this->title = 'OHVacation - Đặt phòng';
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl . '/templates_2/css/bootstrap.min.css' ?>">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl . '/templates_2/css/style.css' ?>">
<script src="<?= Yii::$app->request->baseUrl . '/templates_2/js/jquery-2.1.4.min.js' ?>"></script>
<input type="hidden" class="check_lang" value="<?= $language ?>">
<div class="navbar-wrapper">
    <div class="container-fluid container_header">
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
                <div id="navbar" class="col-xs-12 navbar_fix_padding ">
                    <ul class="nav navbar-nav">
                        <li>
                            <div class="styled-select">
                                <select id="select_lang">
                                    <option value="vi">VN</option>
                                    <option value="en">EN</option>
                                </select>
                            </div>
                        </li>
                        <li class="li_email">
                            <a href="#">
                                <span class="glyphicon glyphicon-envelope"></span> info@ohvacation.com
                            </a>
                        </li>
                        <li>
                            <a href="#" class="a_float_left">
                                <span class="glyphicon glyphicon-earphone"></span>Hotline: 19006967
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 note_csh">
                    <ul>
                        <li><a class="s_holine"><?= Yii::t('yii', 'If you are the owner, please contact Hotline numbers'); ?></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluid container_form">
        <div class="container ">
            <div class="col-xs-12 col-md-2 logo" style="padding:0">
                <a href="/">
                    <img src="<?= Yii::$app->request->baseUrl . '/templates_2/img/logo.png' ?>">
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10 content_form">
                <?php $form = ActiveForm::begin(['id' => 'form_register']); ?>
                <div class="form_input">
                    <div class="col-xs-12 col-sm-6 col-5 col-info-voucher">
                        <?= $form->field($customer, 'code')->textInput(['class' => 'form-control alphanum', 'autocomplete' => 'off', 'id' => 'txt_code']) ?>
                        <p class="text-info-voucher">
                            <?= Yii::t('yii', 'Write the number printed on the voucher') ?>
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-5 col-info-voucher">
                        <?= $form->field($customer, 'name')->textInput(['class' => 'form-control string', 'autocomplete' => 'off']) ?>
                        <p>&nbsp;</p>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-5 col-info-voucher">
                        <?= $form->field($customer, 'phone')->textInput(['class' => 'form-control number', 'autocomplete' => 'off']) ?>
                        <p>&nbsp;</p>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-5 col-info-voucher">
                        <?= $form->field($customer, 'email')->textInput(['class' => 'form-control', 'autocomplete' => 'off']) ?>
                        <p>&nbsp;</p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-5-btn btn_book">
                        <button type="submit" class="btn btn-success" id="btn_register">Book Now</button>
                        <p style="width: 110px;font-style:italic"><?= Yii::t('yii', '*Required Information') ?></p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
<!--                <div class="div_menu">-->
<!--                    <ul class="menu">-->
<!--                        <li><a href="#">--><?//= Yii::t('yii', 'HOME PAGE') ?><!--</a></li>-->
<!--                        <li><a href="#">--><?//= Yii::t('yii', 'OH!VACATION') ?><!--</a></li>-->
<!--                        <li><a href="#">--><?//= Yii::t('yii', 'NAMAN RETREAT') ?><!--</a></li>-->
<!--                        <li><a href="#">--><?//= Yii::t('yii', 'COCOBAY') ?><!--</a></li>-->
<!--                        <li><a href="#">--><?//= Yii::t('yii', 'VACATION OWNERSHIP') ?><!--</a></li>-->
<!--                        <li><a href="#">--><?//= Yii::t('yii', 'NEWS & EVENTS') ?><!--</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">

    <div class="content-slider" style="display: block;">
        <!-- Jssor Slider Begin -->
        <!-- ================================================== -->
        <div id="slider1_container">
            <!-- Slides Container -->
            <div u="slides" class="slides_img">
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh01.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh02.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh03.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh04.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh05.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh06.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh07.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh08.jpg"/>
                </div>
                <div>
                    <img src="<?= Yii::getAlias( '@web') ?>/img/cocobay/Hinh09.jpg"/>
                </div>
            </div>
            <!-- bullet navigator container -->
            <!--  <div u="navigator" class="jssorb21">
                 bullet navigator item prototype
                 <div u="prototype"></div>
             </div> -->
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora21l">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora21r">
            </span>
            <!-- <a id="stop" href="#">Stop</a> -->
        </div>
        <!-- Jssor Slider End -->
    </div>
</div>
<div class="container-fluid marketing" style="display: none;">
    <div class="videoWrapper">
        <!-- Copy & Pasted from YouTube -->
        <!-- <div id="player"></div>autoplay autoplay-->
        <video id="videoid" playsinline loop>
            <source src="<?= Yii::getAlias( '@web') ?>/video/output2.mp4" type="video/mp4" preload="none">
<!--            <source src="https://s3-ap-southeast-1.amazonaws.com/ebank-vtc/ohv/output2.mp4" type="video/mp4">-->
        </video>
    </div>
</div><!-- /.container -->
<div class="video-controls">
    <div class="mute">
        <button type="button" class="btn_vol_0">
            <span class="glyphicon glyphicon-volume-up"></span>
        </button>
        <button type="button" class="btn_vol_1" style="display: none">
            <span class="glyphicon glyphicon-volume-off"></span>
        </button>
    </div>
    <div class="play">
        <button type="button" class="btn_play">
            <span class="glyphicon glyphicon-play"></span>
        </button>
        <button type="button" class="btn_pause" style="display: none">
            <span class="glyphicon glyphicon-pause"></span>
        </button>
    </div>
</div>
<script src="<?= Yii::$app->request->baseUrl . '/templates_2/js/bootstrap.min.js' ?>"></script>
<script src="<?= Yii::$app->request->baseUrl . '/templates_2/js/docs.min.js' ?>"></script>
<script src="<?= Yii::$app->request->baseUrl . '/templates_2/js/ie10-viewport-bug-workaround.js' ?>"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl . '/templates_2/js/jssor.slider.mini.js' ?>"></script>
<script type="text/javascript">
    var video = document.getElementById('videoid');
    $(document).ready(function() {



        // $('#link_refresh_captcha').on('click', function() {
        //           let img = document.images['captchaimg'];
        //           img.src = img.src.substring(0, img.src.lastIndexOf('?')) + '?rand=' + Math.random() * 1000;
        //       });

        $('#form_register').on('beforeSubmit', function() {
            $.blockUI();
            let formData = new FormData(document.getElementById('form_register'));
            formData.append('verify', 1);
            $.ajax({
                url: '<?= Url::to(['register']) ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false
            }).then(function(result) {

                if (result.indexOf('http') > -1) {
                    location.href = result;
                } else if (result === 'voucher_invalid') {
                    alert('Mã voucher không chính xác');
                } else if (result === 'voucher_used') {
                    alert('Mã voucher này đã được sử dụng. Vui lòng nhập mã Voucher khác!');
                } else if (result === 'invalid_form') {
                    alert('Vui lòng nhập đầy đủ thông tin!');
                }
            });
            return false;
        });
        $('#txt_code').on('change', function() {
            let self = $(this);
            $.get('<?= Url::to(['check-voucher']) ?>', {voucher: $(this).val()}, function(result) {
                if (result == 'voucher_used') {
                    alert('Mã voucher này đã được sử dụng. Vui lòng nhập mã Voucher khác!');
                    self.select();
                } else if (result === 'voucher_invalid') {
                    alert('Mã voucher không chính xác');
                    self.select();
                }
            });
        });
        /* js ngôn ngữ */
        $('#select_lang option').each(function() {
            if ($(this).val() == $('.check_lang').val()) {
                $(this).prop('selected', true);
            }
        });

        $('body').on('change', '#select_lang', function() {
            $.ajax({
                method: 'POST',
                url: '<?= Url::to(['site/change-lang'])?>',
                data: {
                    lang: $(this).val()
                }
            }).success(function() {
                location.reload();
            });

        });

    });

    jQuery(document).ready(function($) {

        var options = {
            $FillMode: 4,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5
            // contain for large image, actual size for small image, default value is 0
            $AutoPlay: 1,                                    //[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
            $Idle: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
            $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

            $ArrowKeyNavigation: true,                    //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
            $SlideEasing: $Jease$.$OutQuint,          //[Optional] Specifies easing for right to left animation, default value is $Jease$.$OutQuad
            $SlideDuration: 400,                               //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
            $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
            //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
            // $SlideHeight: 444,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
            $SlideSpacing: 0,                           //[Optional] Space between each slide in pixels, default value is 0
            $Cols: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
            $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
            $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
            $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
            $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)

            $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                // $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                $Scale: false                                   //Scales bullets navigator or not while slider scale
            },

            $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
            }
        };

        var jssor_slider1 = new $JssorSlider$('slider1_container', options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizing
        function ScaleSlider() {
            var bodyWidth = document.body.clientWidth;
            if (bodyWidth) {
                console.log(bodyWidth);
                jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                // xu lý video
                if (bodyWidth < 1024) {

                    video.pause();
                    $('.marketing').css('display', 'none');
                    $('.video-controls').css('display', 'none');
                } else {
                    $('.s_holine').show();
                    $('.marketing').css('display', 'none');

                    $('body').on('click', '.btn_play', function() {
                        video.play();
                        video.volume = 1;
                        $(this).hide();
                        $('.btn_pause').show();
                        $('.videoWrapper').css('display', 'block');
                        $('.content-slider').css('display', 'none');
                        $('.marketing').css('display', 'block');

                    });
                    $('body').on('click', '.btn_pause', function() {
                        video.pause();
                        video.volume = 0;
                        $(this).hide();
                        $('.btn_play').show();

                        $('.videoWrapper').css('display', 'none');
                        $('.content-slider').css('display', 'block');
                    });
                    $('body').on('click', '.btn_vol_0', function() {
                        video.volume = 0;
                        $(this).hide();
                        $('.btn_vol_1').show();
                    });

                    $('body').on('click', '.btn_vol_1', function() {
                        video.volume = 1;
                        $(this).hide();
                        $('.btn_vol_0').show();
                    });

                }
            }

            else {

                window.setTimeout(ScaleSlider, 30);
            }
        }

        ScaleSlider();

        $(window).bind('load', ScaleSlider);
        $(window).bind('resize', ScaleSlider);
        $(window).bind('orientationchange', ScaleSlider);
        //responsive code end
    });
</script>

