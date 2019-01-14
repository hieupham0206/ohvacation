<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = Yii::t('yii', 'Report');
$this->params['breadcrumbs'][] = $this->title;
/* @var $role backend\models\Role */
?>
<div class="role-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-group">
        <a class="btn btn-primary" href="<?= Url::to(['inventory-report']) ?>" title="Báo cáo tồn kho">Báo cáo tồn kho</a>
        <a class="btn btn-primary" href="<?= Url::to(['revenue-report']) ?>" title="Báo cáo doanh thu">Báo cáo doanh thu</a>
    </div>
</div>
<script>
    $(function () {
    });
</script>