<?php

namespace console\controllers;

use common\models\Inventory;
use common\models\Orders;
use common\models\OrdersDetail;
use common\models\Payment;
use common\utils\helpers\ArrayHelper;
use common\utils\helpers\Mail;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionCheckOrders()
    {
        $count = 0;

        $payments = Payment::find()->where('payment.created_date < (UNIX_TIMESTAMP() - 900)')
                           ->joinWith(['orders'])
                           ->andWhere('response_code is null and modified_date is null')
                           ->andWhere(['orders.payment_status' => 0])
                           ->all();

        $orderIds     = ArrayHelper::getColumn($payments, 'orders_id');
        $inventoryIds = OrdersDetail::find()->where(['orders_id' => $orderIds])->select(['inventory_id'])->createCommand()->queryColumn();
        Inventory::updateAll(['inventory_status' => 0], ['id' => $inventoryIds]);
        /** @var Payment[] $payments */
        foreach ($payments as $payment) {
            /** @var Orders $order */
            $order = Orders::find()->where(['id' => $payment->orders_id])->one();
            $order->updateAttributes(['payment_status' => 4]);
            /** @var Payment $payment */
            $message = 'Đơn hàng hết hạn thanh toán';
            $count   += $payment->updateAttributes([
                'modified_date' => time(),
                'response_code' => -1,
                'message'       => $message,
            ]);

            $mail = new Mail([
                'content' => 'Đơn hàng ' . $payment->order_code . ' đã bị hủy do quá hạn thanh toán. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn',
                'subject' => 'Xác nhận thanh toán',
                'mailTo'  => $payment->customer_email
            ]);
            $mail->send(['html' => 'order-cancel'], [
                'customerName' => $payment->customer_name,
                'orderCode' => $order->code
            ]);
        }

        return $count;
    }

    public function actionCheckOrdersNoEmail()
    {
        $count = 0;

        $payments = Payment::find()->where('payment.created_date < (UNIX_TIMESTAMP() - 900)')
                           ->joinWith(['orders'])
                           ->andWhere('response_code is null and modified_date is null')
                           ->andWhere(['orders.payment_status' => 0])
                           ->all();

        $orderIds     = ArrayHelper::getColumn($payments, 'orders_id');
        $inventoryIds = OrdersDetail::find()->where(['orders_id' => $orderIds])->select(['inventory_id'])->createCommand()->queryColumn();
        Inventory::updateAll(['inventory_status' => 0], ['id' => $inventoryIds]);
        /** @var Payment[] $payments */
        foreach ($payments as $payment) {
            /** @var Orders $order */
            $order = Orders::find()->where(['id' => $payment->orders_id])->one();
            $order->updateAttributes(['payment_status' => 4]);
            /** @var Payment $payment */
            $message = 'Đơn hàng hết hạn thanh toán';
            $count   += $payment->updateAttributes([
                'modified_date' => time(),
                'response_code' => -1,
                'message'       => $message,
            ]);
        }

        return $count;
    }
}