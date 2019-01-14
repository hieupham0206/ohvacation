<?php

namespace backend\modules\system\controllers;

use backend\models\table\UserTable;
use backend\models\User;
use common\utils\controller\Controller;
use common\utils\table\TableFacade;
use Yii;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UserController extends Controller
{
    public function actionIndex()
    {
        $user = new User();

        return $this->render('index', ['user' => $user]);
    }

    public function actionIndexTable()
    {
        $tableFacade = new TableFacade(new UserTable);

        return $tableFacade->getDataTable();
    }

    public function actionView()
    {
        $userId = Yii::$app->request->get('id', '');

        return $this->render('view', [
            'user' => $this->findModel($userId),
        ]);
    }

    public function actionCreate()
    {
        $user = new User();

        return $this->render('create', [
            'user' => $user,
        ]);
    }

    public function actionUpdate()
    {
        $userId = Yii::$app->request->get('id', '');
        if ($userId == 1) {
            $userId = null;
        }
        $user   = $this->findModel($userId);

        return $this->render('update', [
            'user' => $user,
        ]);
    }

    /**
     * @return string:
     * - url: luu thành công
     * - chuỗi: lưu thất bại, trả về lỗi
     * - An internal server error occurred: không load được model
     * @throws \yii\base\InvalidParamException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public function actionSave()
    {
        $userId = Yii::$app->request->post('User')['id'];
        $user   = $userId !== '' ? $this->findModel($userId) : new User();

        if ($user->load(Yii::$app->request->post())) {
        	$user->extension = Yii::$app->request->post('User')['extension'];
            $user->generateAuthKey();
            if ($user->save()) {
                return Url::to(['index'], true);
            }

            return json_encode($user->errors);
        }

        throw new ServerErrorHttpException(Yii::t('yii', 'An internal server error occurred.'));
    }

    public function actionDelete()
    {
        $userId = Yii::$app->request->post('id', '');
        $user   = $this->findModel($userId);

        return $user != null && $user->updateAttributes(['status' => -1]) > 0;
    }

    /**
     * Select2 ajax User
     * @return string
     * @throws \yii\web\MethodNotAllowedHttpException
     * @throws \yii\base\InvalidParamException
     */
    public function actionSelectUser()
    {
        if (Yii::$app->request->isAjax) {
            $query  = Yii::$app->request->get('query', '');
            $page   = Yii::$app->request->get('page', 1);
            $offset = ($page - 1) * 10;
            $users  = User::find()->where(['status' => 1])->andFilterWhere(['like', 'username', $query])->select(['id', 'username']);

            return $this->asJson([
                'total_count' => $users->count(),
                'items'       => $users->offset($offset)->limit(10)->all(),
            ]);
        }

        throw new MethodNotAllowedHttpException(Yii::t('yii', 'Method Not Allowed'));
    }

    /**
     * Thay đổi trạng thái user: active <=> inactive
     * @return bool thay đổi thành công hay không thành công
     * @throws NotFoundHttpException
     */
    public function actionToggleStatus()
    {
        $userId = Yii::$app->request->post('id', '');
        $user   = $this->findModel($userId);

        return $user->status < 1 ? $user->updateAttributes(['status' => 1]) > 0 : $user->updateAttributes(['status' => 0]) > 0;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $userId
     *
     * @return User|\yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($userId)
    {
        if (($model = User::find()->where(['id' => $userId])->visible()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

	public function actionSql() {
		return Yii::$app->db->createCommand('ALTER TABLE `user` ADD `extension` VARCHAR(20) NULL AFTER `type`;')->execute();
    }
}
