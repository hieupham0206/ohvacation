<?php

namespace backend\modules\system\controllers;

use backend\models\Module;
use backend\models\ModuleChild;
use backend\models\table\ModuleTable;
use common\utils\helpers\Inflector;
use common\utils\model\ModelBuilder;
use common\utils\table\TableFacade;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ModuleController extends Controller
{
    public function actionAjaxTable()
    {
        $tableFacade = new TableFacade(new ModuleTable(Yii::$app->request->post()));

        return $tableFacade->getDataTable();
    }

    public function actionIndex()
    {
        $module = new Module();

        return $this->render('index', ['module' => $module]);
    }

    public function actionCreate()
    {
        $module      = new Module();
        $moduleChild = new ModuleChild();

        return $this->render('form', ['module' => $module, 'moduleChild' => $moduleChild, 'moduleChildren' => null]);
    }

    public function actionUpdate()
    {
        $moduleId       = Yii::$app->request->get('id', '');
        $module         = $this->findModel($moduleId);
        $moduleChild    = new ModuleChild();
        $moduleChildren = ModuleChild::find()->where(['module_id' => $moduleId])->all();

        return $this->render('form', [
            'module'         => $module,
            'moduleChildren' => $moduleChildren,
            'moduleChild'    => $moduleChild
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidCallException
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionSaveModule()
    {
        $moduleId = Yii::$app->request->post('Module')['id'];
        $module   = $moduleId !== '' ? $this->findModel($moduleId) : new Module();

        if ($module->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($flag = $module->save()) {
                    $builder = new ModelBuilder($module->id);
                    $builder->setSubModel(ModuleChild::className())
                            ->setRelation('moduleChildren');
                    $flag = Model::saveMultiple($module, $builder);
                }
                if ($flag) {
                    $transaction->commit();

                    return $this->redirect(['index']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }

            return 'fail';
        }

        throw new ServerErrorHttpException(Yii::t('yii', 'An internal server error occurred.'));
    }

    /**
     * Finds the Module model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $moduleId
     *
     * @return Module the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($moduleId)
    {
        if (($model = Module::findOne(['id' => $moduleId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    public function actionLoadController()
    {
        $controllerPath = Yii::getAlias('@app/controllers/');
        $files          = scandir($controllerPath);
        $modules        = Module::find()->select(['name'])->createCommand()->queryColumn();
        $excludes       = array_merge($modules, ['role', 'user', 'module', 'site']);
        $datas          = [];
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                $fileName = Inflector::camel2id(str_replace('Controller', '', pathinfo($file, PATHINFO_FILENAME)), '-');
                if ( ! Inflector::inArray($fileName, $excludes)) {
                    $datas[] = $fileName;
                }
            }
        }

        return json_encode($datas);
    }
}
