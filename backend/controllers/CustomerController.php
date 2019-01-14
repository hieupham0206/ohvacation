<?php

namespace backend\controllers;

use backend\models\table\CustomerTable;
use common\models\Customer;
use common\utils\controller\Controller;
use common\utils\table\TableFacade;
use PHPExcel_IOFactory;
use Yii;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class CustomerController extends Controller
{
    public function actionIndex()
    {
        $customer = new Customer();

        return $this->render('index', ['customer' => $customer]);
    }

    public function actionIndexTable()
    {
        $tableFacade = new TableFacade(new CustomerTable);

        return $tableFacade->getDataTable();
    }

    public function actionView()
    {
        $customerId = Yii::$app->request->get('id', '');
        $customer   = $this->findModel($customerId);

        return $this->render('view', [
            'customer' => $customer
        ]);
    }

    public function actionCreate()
    {
        $customer = new Customer();

        return $this->render('create', [
            'customer' => $customer,
        ]);
    }

    public function actionUpdate()
    {
        $customerId = Yii::$app->request->get('id', '');
        $customer   = $this->findModel($customerId);

        return $this->render('update', [
            'customer' => $customer
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
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidCallException
     */
    public function actionSave()
    {
        $customerId = Yii::$app->request->post('Customer')['id'];
        $customer   = $customerId != '' ? $this->findModel($customerId) : new Customer();

        if ($customer->load(Yii::$app->request->post())) {
            if ($customer->save()) {
                return Url::to(['view', 'id' => $customer->id], true);
            }

            return json_encode($customer->errors);
        }

        throw new ServerErrorHttpException(Yii::t('yii', 'An internal server error occurred.'));
    }

    public function actionDelete()
    {
        $customerId = Yii::$app->request->post('id', '');
        $customer   = Customer::findOne(['id' => $customerId, 'status' => 1]);

        return $customer != null && $customer->updateAttributes(['status' => -1]) > 0;
    }

    /**
     * Select2 ajax Customer.
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\MethodNotAllowedHttpException
     */
    public function actionSelectCustomer()
    {
        if (Yii::$app->request->isAjax) {
            $query     = Yii::$app->request->get('query', '');
            $page      = Yii::$app->request->get('page', 1);
            $offset    = ($page - 1) * 10;
            $customers = Customer::find()->where(['status' => 1])->andFilterWhere(['like', 'name', $query])->select(['id', 'name']);

            return $this->asJson([
                'total_count' => $customers->count(),
                'items'       => $customers->offset($offset)->limit(10)->all()
            ]);
        }

        throw new MethodNotAllowedHttpException(Yii::t('yii', 'Method Not Allowed'));
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * If $customerId == '', return new Customer.
     *
     * @param $customerId
     *
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($customerId)
    {
        if (($model = Customer::findOne(['id' => $customerId, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }
}
