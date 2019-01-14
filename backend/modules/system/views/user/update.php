<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user backend\models\User */
$this->title                   = Yii::t( 'yii', 'Update {model}', [ 'model' => mb_convert_case( Yii::t( 'yii', 'User' ), MB_CASE_LOWER, 'UTF-8' ) ] ) . ': ' . $user->username;
$this->params['breadcrumbs'][] = [ 'label' => 'Người dùng', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $user->username, 'url' => [ 'view', 'id' => $user->id ] ];
$this->params['breadcrumbs'][] = Yii::t( 'yii', 'Update' );
?>
<h1><?= Html::encode( $this->title ) ?></h1>
<?= $this->render( '_form', [
	'user' => $user,
] ) ?>
