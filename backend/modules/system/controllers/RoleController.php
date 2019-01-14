<?php

namespace backend\modules\system\controllers;

use backend\models\Module;
use backend\models\ModuleChild;
use backend\models\Role;
use backend\models\table\RoleTable;
use common\utils\table\TableFacade;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class RoleController extends Controller
{
    public function actionIndex()
    {
        $role = new Role();

        return $this->render('index', ['role' => $role]);
    }

    public function actionIndexTable()
    {
        $tableFacade = new TableFacade(new RoleTable);

        return $tableFacade->getDataTable();
    }

    public function actionCreate()
    {
        $role           = new Role();
        $modules        = Module::find()->all();
        $moduleChildren = ModuleChild::find()->all();

        return $this->render('create', [
            'role'           => $role,
            'modules'        => $modules,
            'moduleChildren' => $moduleChildren
        ]);
    }

    public function actionUpdate()
    {
        $roleId         = Yii::$app->request->get('id', '');
        $role           = $this->findModel($roleId);
        $modules        = Module::find()->all();
        $moduleChildren = ModuleChild::find()->all();
        $roles          = get_object_vars(json_decode($role->role));

        return $this->render('update', [
            'role'           => $role,
            'modules'        => $modules,
            'moduleChildren' => $moduleChildren,
            'roles'          => $roles
        ]);
    }

    /**
     * @return string:
     * - url: lưu thành công
     * - chuỗi: lưu thất bại, trả về lỗi
     * - An internal server error occurred: không load được model
     * @throws \yii\base\InvalidParamException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public function actionSave()
    {
        $roleId = Yii::$app->request->post('Role')['id'];
        $roles  = json_decode(Yii::$app->request->post('roles'), true);
        $role   = ! empty($roleId) ? $this->findModel($roleId) : new Role();

        if ($role->load(Yii::$app->request->post())) {
            $role->role = json_encode($roles);
            if ($role->save(false)) {
                Yii::$app->cache->delete('permission_' . $role->id);
            }

            return $this->redirect(['index']);
        }

        throw new ServerErrorHttpException(Yii::t('yii', 'An internal server error occurred.'));
    }

    public function actionDelete()
    {
        $roleId = Yii::$app->request->post('id', '');
        $role   = Role::findOne(['id' => $roleId, ['>=', 'status', 0]]);

        return $role != null && $role->updateAttributes(['status' => -1]) > 0;
    }

    /**
     * Select2 ajax Role
     * @return string
     * @throws \yii\web\MethodNotAllowedHttpException
     * @throws \yii\base\InvalidParamException
     */
    public function actionSelectRole()
    {
        if (Yii::$app->request->isAjax) {
            $query  = Yii::$app->request->get('query', '');
            $page   = Yii::$app->request->get('page', 1);
            $offset = ($page - 1) * 10;
            $roles  = Role::find()->active()->andFilterWhere(['like', 'name', $query])->select(['id', 'name']);

            return $this->asJson([
                'total_count' => $roles->count(),
                'items'       => $roles->offset($offset)->limit(10)->all(),
            ]);
        }

        throw new MethodNotAllowedHttpException(Yii::t('yii', 'Method Not Allowed'));
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $roleId
     *
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($roleId)
    {
        if (($model = Role::findOne(['id' => $roleId, ['>=', 'status', 0]])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }
}
