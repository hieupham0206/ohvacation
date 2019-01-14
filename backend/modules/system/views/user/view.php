<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user backend\models\User */

$this->title                   = $user->username;
$this->params['breadcrumbs'][] = [ 'label' => 'Users', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view ">
    <h1><?= Html::encode( $this->title ) ?></h1>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_username"><?= $user->getAttributeLabel( 'username' ) ?></label>
                <input type="text" class="form-control" value="<?= $user->username ?>" id="txt_username" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_email"><?= $user->getAttributeLabel( 'email' ) ?></label>
                <input type="text" class="form-control" value="<?= $user->email ?>" id="txt_email" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_phone"><?= $user->getAttributeLabel( 'phone' ) ?></label>
                <input type="text" class="form-control" value="<?= $user->phone ?>" id="txt_phone" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_status"><?= $user->getAttributeLabel( 'status' ) ?></label>
                <input type="text" class="form-control" value="<?= $user->getStatus() ?>" id="txt_status" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_extension"><?= $user->getAttributeLabel('extension') ?></label>
                <input type="text" class="form-control number" value="<?= $user->extension ?>" readonly>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <a type="button" class="btn btn-default" href="<?= Url::to( [ 'index' ] ) ?>">Hủy</a>
            <a type="button" class="btn btn-success" href="<?= Url::to( [ 'update', 'id' => $user->id ] ) ?>">Cập nhật</a>
        </div>
    </div>
</div>
