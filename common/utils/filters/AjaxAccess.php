<?php
namespace common\utils\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;

class AjaxAccess extends ActionFilter
{
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(['site/login']);
        }

        if (Yii::$app->request->isAjax) {
            return parent::beforeAction($action);
        }

        throw new MethodNotAllowedHttpException(Yii::t('yii', 'Method Not Allowed'));
    }
}