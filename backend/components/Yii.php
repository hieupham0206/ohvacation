<?php

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property \yii\web\User $user
 * @property \yii\web\Session $session
 * @property \common\utils\helpers\Security $security
 * @property \backend\components\Permission $permission This property is read-only. Extended component.
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 */
class WebApplication extends yii\web\Application
{
}

///**
// * Class ConsoleApplication
// * Include only Console application related components here
// *
// * @property \app\components\ConsoleUser $user The user component. This property is read-only. Extended component.
// */
//class ConsoleApplication extends yii\console\Application {
//}