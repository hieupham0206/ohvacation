<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception \yii\base\Exception */
use yii\helpers\Html;
use yii\helpers\Url;

$this->context->layout = 'error';
$this->title           = $name;
$statusCode            = $exception->statusCode;
?>
<div class="site-error">
    <h1><?= Html::encode( $this->title ) ?></h1>
    <div class="alert alert-danger">
		<?= nl2br( Html::encode( $message ) ) ?>
    </div>
    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>
    <div>
	    <?php if ( Yii::$app->user->identity != null ): ?>
            <a href="<?= Url::to( [ '/' ] ) ?>" class="btn btn-info"><?= Yii::t('yii', 'Home'); ?></a>
	    <?php endif ?>
    </div>
</div>
