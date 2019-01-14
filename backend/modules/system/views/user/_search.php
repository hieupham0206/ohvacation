<?php

/* @var $this yii\web\View */
/* @var $user \backend\models\User */
?>
<form id="form_user_search" class="search-form">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_username"><?= $user->getAttributeLabel('username') ?></label>
                <input type="text" class="form-control" name="username" id="txt_username">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_email"><?= $user->getAttributeLabel('email') ?></label>
                <input type="text" class="form-control" name="email" id="txt_email">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="txt_phone"><?= $user->getAttributeLabel('phone') ?></label>
                <input type="text" class="form-control" name="phone" id="txt_phone">
            </div>
        </div>
<!--        <div class="col-md-3">-->
<!--            <div class="form-group">-->
<!--                <label for="select_status">--><?php // $user->getAttributeLabel('status') ?><!--</label>-->
<!--                <select name="status" id="select_status" class="select">-->
<!--                    <option></option>-->
<!--                    <option value="--><?php //\common\models\User::STATUS_ACTIVE ?><!--">--><?php // Yii::t('yii', 'Active'); ?><!--</option>-->
<!--                    <option value="--><?php //\common\models\User::STATUS_INACTIVE ?><!--">--><?php // Yii::t('yii', 'Disabled'); ?><!--</option>-->
<!--                </select>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-md-3">
            <div class="form-group pull-right" style="margin-top: 22px">
                <a type="button" class="btn btn-default" id="btn_reset_filter"><?= Yii::t('yii', 'Reset') ?></a>
                <button class="btn btn-info" id="btn_filter"><?= Yii::t('yii', 'Search') ?></button>
            </div>
        </div>
    </div>
</form>