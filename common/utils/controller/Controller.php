<?php

namespace common\utils\controller;

use common\utils\filters\AjaxAccess;
use common\utils\filters\PermissionAccess;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

abstract class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
//            'verbs'      => [
//                'class'   => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                    'save'   => ['POST'],
//                ],
//            ],
//            'ajax'       => [
//                'class' => AjaxAccess::className(),
//                'only'  => ['index-table', 'delete', 'save']
//            ],
//            'permission' => [
//                'class' => PermissionAccess::className(),
//                'only'  => ['create', 'update', 'delete', 'view', 'index']
//            ],
            // allow authenticated users
            'access'     => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function redirectIndex()
    {
        $this->redirect(Url::to(['index']));
    }
}