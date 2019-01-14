<?php

namespace common\utils\filters;

use backend\models\User;
use Yii;
use yii\base\ActionFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class PermissionAccess extends ActionFilter
{
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($event)
    {
        /** @var User $user */
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(['site/login']);
        }

        if (Yii::$app->permission->can($this->owner->id, $event->id)) {
            return parent::beforeAction($event);
        }

        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this page.'));
    }
}