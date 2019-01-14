<?php

namespace backend\modules\system;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\system\controllers';

    public $defaultRoute = '/user/index';

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        if ( ! parent::beforeAction($action)) {
            return false;
        }

        if ( ! $this->checkAccess()) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this page.'));
        }

        return true;
    }

    /**
     * @return boolean whether the module can be accessed by the current user
     */
    protected function checkAccess()
    {
        if (Yii::$app->permission->isAdmin()) {
            return true;
        }
        Yii::warning('Access to Admin module is denied due to permission', __METHOD__);

        return false;
    }
}
