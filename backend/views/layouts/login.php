<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\assets\TeamAsset;
use common\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

AppAsset::register( $this );
TeamAsset::register( $this );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode( $this->title ) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
	<?php
	NavBar::begin( [
		'brandLabel' => Yii::$app->name,
		'brandUrl'   => Yii::$app->homeUrl,
		'options'    => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	] );
	if ( Yii::$app->user->isGuest ) {
		$menuItems[] = [ 'label' => Yii::t( 'yii', 'Login' ), 'url' => [ '/site/login' ] ];
	} else {
		$menuItems[] = '<li>'
		               . Html::beginForm( [ '/site/logout' ], 'post' )
		               . Html::submitButton(
				Yii::t( 'yii', 'Logout' ) . ' (' . Yii::$app->user->identity->username . ')',
				[ 'class' => 'btn btn-link' ] )
		               . Html::endForm()
		               . '</li>';
	}
	echo Nav::widget( [
		'options' => [ 'class' => 'navbar-nav navbar-right' ],
		'items'   => $menuItems,
	] );
	NavBar::end();
	?>
    <div class="container">
        <?= Alert::widget() ?>
		<?= $content ?>
    </div>
</div>
<!--<footer class="footer">-->
<!--    <div class="container">-->
<!--        <p class="pull-left">&copy; My Company --><?php //date( 'Y' ) ?><!--</p>-->
<!--        <p class="pull-right">--><?php //Yii::powered() ?><!--</p>-->
<!--    </div>-->
<!--</footer>-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
