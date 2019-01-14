<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<!--     <link rel="stylesheet" href="<?php // Yii::$app->request->baseUrl . '/templates_2/css/font-awesome.css' ?>"> -->
    <!--    <script src="--><?php //Yii::$app->request->baseUrl . '/templates/js/jquery-2.1.4.min.js' ?><!--"></script>-->
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-15680284-11', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body>
<?php $this->beginBody() ?>


<?= $content ?>


<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
        </div>
       
        <div class="modal-body">
        </div>
        
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">
    let lang = $('html').attr('lang');
    $(document).ready(function() {
        //BlockUI
        if ($.isFunction($.blockUI)) {
            let message = lang === 'vi' ? 'Vui lòng đợi...' : 'Please wait...';
            //BlockUI default config
            $.extend(true, $.blockUI.defaults, {
                message: '<i class="fa fa-spinner fa-spin"></i> ' + message,
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: 0.5,
                    color: '#fff',
                },
                baseZ: 9999,
            });
        }
        //UnblockUI moi khi ajax chạy xong
        $(document).ajaxComplete($.unblockUI);
    });
</script>
