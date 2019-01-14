<?php

namespace backend\controllers;

use backend\models\User;
use common\models\LoginForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'login';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'request-password-reset', 'reset-password'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'modal-change-info', 'change-password'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $this->layout = 'main';

        $this->redirect(Url::to( [ 'inventory/' ] ));
    }

    /**
     * Login action.
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionLogin()
    {
        if ( ! Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        /** @noinspection NotOptimalIfConditionsInspection */
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Chức năng gửi mail reset mật khẩu
     * Nếu có email hợp lệ => Gửi mail co kèm link reset mật khẩu
     * Nếu có email không hợp lệ => Hiện thông báo không thể gửi reset mật khẩu
     * Nếu không co email => Render ra form quên mật khẩu
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('yii', 'Check your email for further instructions.'));

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', Yii::t('yii', 'Sorry, we are unable to reset password for email provided.'));
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Chức năng reset mật khẩu
     * Nếu có token hợp lệ => Render form reset mật khẩu
     * Nếu có token hợp lệ và mật khẩu mới => Thay dổi mật khẩu theo mật khẩu mới
     *
     * @param $token
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('yii', 'New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Form thay đổi thông tin của user
     * @return string
     */
    public function actionModalChangeInfo()
    {
        $user = User::findOne(Yii::$app->user->id);

        return $this->renderPartial('_info', ['user' => $user]);
    }



    public function actionChangePassword()
    {
        $oldPassword = Yii::$app->request->post('old_password');
        $newPassword = Yii::$app->request->post('new_password');

        $user = User::findOne(Yii::$app->user->id);

        if ($user->validatePassword($oldPassword)) {
            $user->setPassword($newPassword);
            if ($user->updateAttributes(['password_hash']) > 0) {
                return 'success';
            }
            return $this->asJson($user->errors);
        }

        return 'wrong_password';
    }
}
