<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\assets\TeamAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
TeamAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Kho phòng', 'url' => ['/inventory']],
        ['label' => Yii::t('yii', 'Voucher'), 'url' => ['/voucher']],
        ['label' => 'Giao dịch', 'url' => ['/payment']],
        ['label' => 'Báo cáo', 'url' => ['/report']],
    ];
    if (Yii::$app->user->identity->username == 'chau.bui') {
        $menuItems = [
            ['label' => 'Kho phòng', 'url' => ['/inventory']],
            ['label' => 'Báo cáo', 'url' => ['/report']],
            ['label' => 'Giao dịch', 'url' => ['/payment']],
        ];
    }
    if (Yii::$app->permission->isAdmin()) {
        $menuItems[] = ['label' => 'Người dùng', 'url' => ['/system/user']];
    }
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('yii', 'Login'), 'url' => ['login']];
    } else {
        $menuItems[] = '<li><a href="javascript:void(0)" id="link_profile">Đổi mật khẩu</a></li>';
        $menuItems[] = '<li>'
                       . Html::beginForm(['/site/logout'], 'post')
                       . Html::submitButton(Yii::t('yii', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link'])
                       . Html::endForm()
                       . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => [
                'label' => Yii::t('yii', 'Home'),
                'url'   => Yii::$app->homeUrl,
//                'template' => "<li><i class=\"glyphicon glyphicon-home\"></i> {link}</li>"
            ],
            'options'  => [
                'class' => 'breadcrumb' //class cho thẻ ul, mặc định là breadcrumb
            ],
            //'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
        ]) ?>
        <!--     Menu widget http://www.bsourcecode.com/yiiframework2/menu-widget-in-yii-framework-2-0/   -->
        <?php
        //        echo Menu::widget( [
        //		    'items'          => [
        //			    [ 'label' => 'Home', 'url' => [ 'site/index' ] ],
        //			    [ 'label' => 'Customer', 'url' => [ 'customer/index' ], 'visible' => Yii::$app->permission->can( 'customer', 'view' ) ],
        //		    ],
        //		    'options' => [
        //			    'class' => 'subnav-menu'
        //		    ],
        //	    ] );
        ?>
        <?= $content ?>
    </div>
    <div class="modal modal-wide fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal modal-wide fade" id="modal-md">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal modal-wide fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
            </div>
        </div>
    </div>
</div>
<!--<footer class="footer">-->
<!--    <div class="container">-->
<!--        <p class="pull-left">&copy; My Company --><?php //date('Y') ?><!--</p>-->
<!--        <p class="pull-right">--><?php //Yii::powered() ?><!--</p>-->
<!--    </div>-->
<!--</footer>-->
<!--Notification-->
<script>
    //    $(function () {
    //        let es = new EventSource('<?//= Yii::$app->request->baseUrl ?>//' + '/noti.php');
    //        let listener = function (event) {
    //            let type = event.type;
    //            console.log(type + ": " + (type === "message" ? event.data : es.url));
    //        };
    //        es.addEventListener("open", listener);
    //        es.addEventListener("message", listener);
    //        es.addEventListener("error", listener);
    //        let run = function(){
    //            if (Offline.state === 'up')
    //                Offline.check();
    //        };
    //        Offline.options = {checks: {xhr: {url: '/connection-test'}}};
    //        setInterval(run, 5000);
    //    });
    $(function() {
        let body = $("body");
        $('#link_profile').on('click', function() {
            utils.showModal({}, '<?= Url::to(['/site/modal-change-info']) ?>', $('#modal-lg'));
        });
        body.on('submit', '#form_change_password', function() {
            if (utils.validate("form_change_password")) {
                let formData = new FormData(document.getElementById("form_change_password"));
                utils.submitForm("<?= Url::to(['/site/change-password']) ?>", formData).then(function (result) {
                    if (result == 'success') {
                        body.noti({
                            type: 'success',
                            content: 'Success'
                        });
                        $('#modal-lg').modal('hide');
                    } else if (result == 'wrong_password') {
                        body.noti({
                            type: 'error',
                            content: 'Mật khẩu cũ không chính xác'
                        });
                    } else {
                        body.noti({
                            type: 'error',
                            content: 'Fail'
                        });
                    }
                });
            } else {
                $('.error').first().focus();
            }
            return false;
        })
    });
</script>
<!--End Notification-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
