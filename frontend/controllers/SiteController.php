<?php

namespace frontend\controllers;

use common\models\Customer;
use common\models\Inventory;
use common\models\Orders;
use common\models\OrdersDetail;
use common\models\Payment;
use common\models\Voucher;
use common\utils\helpers\ArrayHelper;
use common\utils\helpers\Mail;
use common\utils\helpers\TimeHelper;
use frontend\models\CustomerForm;
use frontend\models\Cybersource;
use frontend\models\nusoap_base;
use frontend\models\OrderForm;
use frontend\models\PaymentResult;
use frontend\models\VIBCheckOut;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 * ov@123
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

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

    public function init()
    {
        parent::init();
        $cookies            = Yii::$app->request->cookies;
        $language           = $cookies->getValue('language', 'vi');
        Yii::$app->language = $language;
    }

    /**
     * đa ngôn ngữ
     * @throws \yii\base\InvalidCallException
     */
    public function actionChangeLang()
    {
        $lang = Yii::$app->request->post('lang', ''); //en
        // Yii::$app->language = $lang;
        $cookie = new Cookie([
            'name'  => 'language',
            'value' => $lang,
        ]);
        \Yii::$app->getResponse()->getCookies()->add($cookie);
    }

    /**
     * Form đăng kí
     *
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
//        $mail = new Mail([
//            'content' => '',
//            'subject' => Yii::t('yii', 'Verification code'),
//            'mailTo'  => 'phamquanghieu0206@gmail.com'
//        ]);
//        $mail->send('otp', ['otp' => 123456, 'lang' => Yii::$app->language]);
        $customer = new Customer();

        return $this->render('index', ['customer' => $customer]);
    }

    public function actionCheckVoucher()
    {
        $code = Yii::$app->request->get('voucher');
        /** @var Voucher $voucher */
        $voucher = Voucher::find()->where(['code' => $code])->one();
        if ($voucher == null) {
            return 'voucher_invalid';
        }
        $payments = Payment::find()->where(['voucher_code' => $voucher->code])->andWhere([
            'or',
            ['response_code' => 2],
            ['response_code' => 100],
            ['response_code' => 0],
        ])->all();
        if (count($payments) > 0) {
            return 'voucher_used';
        }

        return 'success';
    }

    /**
     * Action đang kí
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidParamException
     */
    public function actionRegister()
    {
//        session_start();
        // $captcha         = Yii::$app->request->post('6_letters_code', '');
        // $captchaOriginal = $_SESSION['6_letters_code'];

        // if ($captcha != $captchaOriginal) {
        //     return 'captcha_fail';
        // }
        $code  = Yii::$app->request->post('Customer')['code'];
        $name  = Yii::$app->request->post('Customer')['name'];
        $phone = Yii::$app->request->post('Customer')['phone'];
        if (empty($name) || empty($phone)) {
            return 'invalid_form';
        }
        /** @var Voucher $voucher */
        $voucher = Voucher::find()->where(['code' => $code])->one();
        if ($voucher == null) {
            return 'voucher_invalid';
        }
        $payments = Payment::find()->where(['voucher_code' => $voucher->code])->andWhere([
            'or',
            ['response_code' => 0],
            ['response_code' => 2],
            ['response_code' => 100],
        ])->all();
        if (count($payments) > 0) {
            return 'voucher_used';
        }
//        session_destroy();
        $email        = Yii::$app->request->post('Customer')['email'];
        $customerForm = new CustomerForm();

        Yii::$app->session->set('voucher_code', $voucher->code);

        return $customerForm->register($email, $code);
    }

    /**
     * Form nhập mã OTP
     * @throws \yii\base\InvalidParamException
     */
    public function actionAuthenticationOtp()
    {
        $customerEmail = Yii::$app->session->get('customerEmail');

        return $this->render('otp', ['email' => $customerEmail]);
    }

    public function actionResendOtp()
    {
        $otp   = Yii::$app->security->generateOtp();
        $email = Yii::$app->request->post('email');
        $mail  = new Mail([
            'content' => '',
            'subject' => Yii::t('yii', 'Verification code'),
            'mailTo'  => $email,
        ]);
        /** @var Customer $customer */
        $customer = Customer::find()->where(['email' => trim($email)])->one();
        $customer->updateAttributes([
            'otp_date' => time(),
            'OTP'      => $otp,
        ]);

        return $mail->send('otp', ['otp' => $otp, 'lang' => Yii::$app->language]) > 0 ? 'success' : 'fail';
    }

    /**
     * Action kiểm tra mã OTP
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionVerifyOtp()
    {
        $otp          = Yii::$app->request->post('otp');
        $customerForm = new CustomerForm();

        return $customerForm->verifyOtp(trim($otp));
    }

    /**
     * Form chọn ngày
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionChooseDate()
    {
        if (Yii::$app->session->has('customerId') && Customer::isVerified(Yii::$app->session->get('customerId'))) {
//            $customerName = Yii::$app->session->get('customerName');
//            if (Yii::$app->cache->exists('rooms')) {
//                $rooms = Yii::$app->cache->get('rooms');
//            } else {
//                $rooms = Inventory::find()->where(['status' => 1])
//                                  ->groupBy(['stay_date'])->select('stay_date, count(*) as quantity')
//                                  ->createCommand()->queryAll();
//                Yii::$app->cache->set('rooms', $rooms);
//            }
            $rooms        = Inventory::find()->where(['status' => 1])
                                     ->groupBy(['stay_date'])->select('stay_date, count(*) as quantity')
                                     ->createCommand()->queryAll();
            $roomInStocks = [];
            $maxDate      = Yii::$app->db->createCommand('SELECT MAX(stay_date) AS date FROM inventory')->queryScalar();
            $minDate      = Yii::$app->db->createCommand('SELECT MIN(stay_date) AS date FROM inventory')->queryScalar();
            $periods      = TimeHelper::getDatesFromRange(Yii::$app->formatter->asDate($minDate), Yii::$app->formatter->asDate($maxDate));
            $periods      = array_map('strtotime', $periods);
            foreach ($periods as $key => $period) {
                $datas = ArrayHelper::flatten(ArrayHelper::_filter($rooms, function ($data) use ($period) {
                    return $data['stay_date'] == $period;
                }));
                if (empty($datas)) {
                    $roomInStocks[] = ['stay_date' => $period, 'percent' => 0];
                } else {
                    $stocks = Inventory::find()->where([
                        'inventory_status' => 0,
                        'status'           => 1,
                        'stay_date'        => $datas[0],
                    ])->select('stay_date, count(*) as quantity')->createCommand()->queryAll();
                    if ( ! empty($stocks)) {
                        $roomInStocks[] = ['stay_date' => $period, 'percent' => $stocks[0]['quantity'] / $datas[1] * 100];
                    } else {
                        $roomInStocks[] = ['stay_date' => $period, 'percent' => 0];
                    }
                }
            }
            $date    = date('d.m.Y');
            $dateOut = date('d-m-Y', strtotime('+7 days', strtotime($date)));

            /** @var Inventory[] $datas */
            $datesDisabled = TimeHelper::getDatesFromRange($date, $dateOut, 'd-m-Y');

            $dateBlue   = ArrayHelper::getColumn(ArrayHelper::_filter($roomInStocks, function ($data) {
                return $data['percent'] > 50;
            }), 'stay_date');
            $dateYellow = ArrayHelper::getColumn(ArrayHelper::_filter($roomInStocks, function ($data) {
                return $data['percent'] <= 50 && $data['percent'] >= 20;
            }), 'stay_date');
            $dateRed    = ArrayHelper::getColumn(ArrayHelper::_filter($roomInStocks, function ($data) {
                return $data['percent'] < 20;
            }), 'stay_date');

            //var_dump($roomInStocks);die;
            return $this->render('select_day', [
//                'customerName' => $customerName,
                'reds'          => Json::encode($dateRed),
                'yellows'       => Json::encode($dateYellow),
                'blues'         => Json::encode($dateBlue),
                'datesDisabled' => $datesDisabled,
            ]);
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    /**
     * Tìm phòng theo ngày
     * @throws \Exception
     */
    public function actionGetRoom()
    {
        $date     = Yii::$app->request->post('date');
        $next8Day = strtotime(date('Y-m-d', strtotime(' +8 days')));

        //note: code loại voucher mới
        $voucherCode = Yii::$app->session->get('voucher_code');
        $voucher     = Voucher::find()->where(['code' => $voucherCode])->one();

        if (strtotime($date) < $next8Day) {
            return 'rechoose_date';
        }
        if ($voucher->isOldType()) {
            $dateOut = date('d-m-Y', strtotime('+2 days', strtotime($date)));
        } else {
            $dateOut = date('d-m-Y', strtotime('+3 days', strtotime($date)));
        }

        /** @var Inventory[] $datas */
        $periods = TimeHelper::getDatesFromRange($date, $dateOut);
//        $lastIdx = count($periods);
        $datas = [];
        foreach ($periods as $key => $period) {
            $room = Inventory::find()->where([
                'inventory_status' => 0,
                'stay_date'        => strtotime($period . ' 00:00:00'),
                'status'           => 1,
            ])->distinct()->select(['stay_date', 'id'])->one();

            if ($room != null) {
                $datas[] = $room;
            } else {
                if ($key == 2) {
                    $datas[] = [
                        'stay_date' => strtotime($period . ' 00:00:00'),
                        0,
                    ];
                } else {
                    return 'room_empty';
                }
            }
        }

        $roomIds = ArrayHelper::getColumn($datas, 'id');
        array_pop($roomIds);
        $datas[] = $roomIds;

        return $this->asJson($datas);
    }

    /**
     * Form chọn phương thức thanh toán
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionChoosePayment()
    {
        $roomIds = Yii::$app->request->get('roomIds', '');
        $note    = Yii::$app->request->get('note', '');

        //note: code loại voucher mới
        $voucherCode = Yii::$app->session->get('voucher_code');
        $voucher     = Voucher::find()->where(['code' => $voucherCode])->one();

        if (Yii::$app->session->has('customerId')
            && Customer::isVerified(Yii::$app->session->get('customerId'))
            && ! empty($roomIds)
        ) {
            if ($roomIds != '') {
                $roomIds = explode(',', $roomIds);
                if ($voucher->isOldType()) {
                    $roomPrice = 650000;
                } else {
                    $roomPrice = 990000;
                }

                $rooms = Inventory::find()->where(['id' => $roomIds])->orderBy(['inventory.stay_date' => SORT_ASC])->select(['stay_date', 'note'])->all();
                Yii::$app->session->set('roomIds', $roomIds);
                Yii::$app->session->set('note', $note);
                $totalCustomer = explode(',', $note);

                return $this->render('choose_payment', [
                    'roomPrice'     => $roomPrice,
                    'rooms'         => $rooms,
                    'totalCustomer' => $totalCustomer,
                    'isOldVoucher'  => $voucher->isOldType(),
                ]);
            }
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    /**
     * Trang chon the noi dia ATM
     * @throws \yii\base\InvalidParamException
     */
    public function actionChoosePaymentOption()
    {
        return $this->renderPartial('atm');
    }

    /**
     * Xác nhận đơn hàng
     * Nếu KH hợp lệ:
     * + Tạo đơn hàng và chi tiết đơn hàng cho Customer
     * + Cập nhật list kho thành trạng thái reserve
     * Nếu KH không hợp lệ => 404
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionConfirmOrder()
    {
        $customerId = Yii::$app->session->get('customerId', '');
        if ($customerId != '') {
            $paymentType   = Yii::$app->request->post('paymentType');
            $paymentOption = Yii::$app->request->post('paymentOption');

            $roomIds = Yii::$app->session->get('roomIds', []);

            if (empty($roomIds)) {
                return 'room_empty';
            }
            /** @var Inventory[] $inventories */
            $inventorieHasBooks = Inventory::find()->where(['inventory_status' => 2, 'id' => $roomIds])->all();
            if (count($inventorieHasBooks) > 0) {
                return 'rechoose_room';
            }
            $inventories = Inventory::find()->where(['inventory_status' => 0, 'id' => $roomIds])->all();
            $orderForm   = new OrderForm();

            //note: code loại voucher mới
            $voucherCode = Yii::$app->session->get('voucher_code');
            $voucher     = Voucher::find()->where(['code' => $voucherCode])->one();

            $roomPrice = 650000;
            if ( ! $voucher->isOldType()) {
                $roomPrice = 990000;
            }

            $totalAmount = $roomPrice + 2200 + ($roomPrice * 0.025);
            if ($paymentType == 0) {
                $totalAmount = $roomPrice + 2200 + ($roomPrice * 0.012);
            }

            return $orderForm->createOrder($totalAmount, $inventories, $paymentOption, $paymentType);
        }
        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    /**
     * Form xác nhận đơn hàng
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionOrderConfirmation()
    {
        $orders = Yii::$app->session->get('orders', '');
        if (Yii::$app->session->has('customerId')
            && Customer::isVerified(Yii::$app->session->get('customerId'))
            && ! empty($orders)
        ) {
            /** @var Orders $orders */
            if ($orders == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }
            /** @var Customer $customer */
            $customer = Customer::find()->where(['id' => Yii::$app->session->get('customerId')])->one();
            /** @var Payment $payment */
            $payment = Payment::find()->where(['orders_id' => $orders->id])->one();

            $customerName      = Yii::$app->session->get('customerName', '');
            $customerPhone     = Yii::$app->session->get('customerPhone', '');
            $cybersourceParams = [];
            if ($payment->type == 1) {
                $fullname = preg_split('/ +/', $customerName);
                if (count($fullname) == 1) {
                    $surname = $forename = $fullname[0];
                } else {
                    $surname = $fullname[0];
                    unset($fullname[0]);
                    $forename = implode(' ', $fullname);
                }
                $cybersourceParams = [
                    'access_key'           => Cybersource::ACCESS_KEY,
                    'profile_id'           => Cybersource::PROFILE_ID,
                    'transaction_uuid'     => Yii::$app->security->generateUuidV4(),
                    'signed_field_names'   => Cybersource::SIGNED_FIELD_NAME,
                    'unsigned_field_names' => '',
                    'signed_date_time'     => gmdate("Y-m-d\TH:i:s\Z"),
                    'locale'               => Yii::$app->language == 'en' ? 'en-us' : 'vi-vn',
                    'transaction_type'     => 'sale',
                    'reference_number'     => $orders->code,
                    'currency'             => 'VND',
                    'amount'               => $orders->total_price,

                    'line_item_count'   => 2,
                    'item_0_unit_price' => '680000',
                    'item_1_unit_price' => '650000',
                    'item_#_quantity'   => '1',
                    'item_0_name'       => 'Phí đặt phòng',
                    'item_1_name'       => 'Phí thanh toán',

                    'bill_to_email'               => $customer->email,
                    'bill_to_surname'             => $surname,
                    'bill_to_forename'            => $forename,
                    'bill_to_phone'               => $customerPhone,
                    'bill_to_address_country'     => 'VN',
                    'bill_to_address_line1'       => 'Tp Hồ Chí Minh',
                    'bill_to_address_postal_code' => '700000',
                    'bill_to_address_city'        => 'Hồ Chí Minh',
                    'bill_to_company_name'        => 'Empire',
                    'bill_to_address_state'       => '51',
                ];
            }

            return $this->render('order_confirmation', ['order' => $orders, 'customerName' => $customerName, 'cybersourceParams' => $cybersourceParams, 'paymentType' => $payment->type]);
        }
        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    public function actionDomesticPayment()
    {
        $orders        = Yii::$app->session->get('orders', '');
        $customerName  = Yii::$app->session->get('customerName', '');
        $customerPhone = Yii::$app->session->get('customerPhone', '');
        $paymentOption = Yii::$app->request->post('paymentOption');
        /** @var Orders $orders */
        if ($orders == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        /** @var Customer $customer */
        $customer = Customer::find()->where(['id' => Yii::$app->session->get('customerId')])->one();
        $payment  = Payment::find()->where(['orders_id' => $orders->id])->one();
        $payment->updateAttributes([
            'payment_option' => $paymentOption,
        ]);

        $vibCheckout                            = new VIBCheckOut();
        $params['order_id']                     = 'oh' . $orders->id;
        $params['order_code']                   = $orders->code;
        $params['order_description']            = 'Đơn đặt hàng';
        $params['order_total_amount']           = $orders->total_price;
        $params['order_discount_amount']        = 0;
        $params['order_fee_ship']               = 0;
        $params['order_return_url']             = 'https://ohvacation.cocobay.vn/site/payment-domestic-result?order_id=' . $orders->id;
        $params['order_cancel_url']             = 'https://ohvacation.cocobay.vn/site/cancel-payment?order_id=' . $orders->id;
        $params['order_time_limit']             = date('d/m/Y,H:i', time() + 7 * 24 * 3600);
        $params['order_payment_option']         = $paymentOption;
        $params['order_payment_fee_for_sender'] = 0;
        $params['sender_fullname']              = $customerName;
        $params['sender_email']                 = $customer->email;
//        $params['sender_mobile']                = $customerPhone;
        $params['sender_mobile']  = $customerPhone;
        $params['sender_address'] = 'Tp HCM';
        $result                   = $vibCheckout->sendOrder($params);
        if (is_array($result) && $result['result_code'] == '0') {
            return $result['result_data_decode']['payment_url'];
        }

        return $result['result_code'] . '---' . $vibCheckout->merchant_id;
    }

    public function actionFakeResult()
    {
        $orderId   = Yii::$app->request->post('orderId');
        $orderCode = Yii::$app->request->post('orderCode');

        list(, $customerId,) = explode('-', $orderCode);

        /** @var Customer $customer */
        $customer = Customer::find()->where(['id' => $customerId])->one();
        /** @var Orders $order */
        $order = Orders::find()->where(['id' => $orderId])->one();
        /** @var OrdersDetail $inventoryIds */
        $inventoryIds = OrdersDetail::find()->where(['orders_id' => $orderId])->select(['inventory_id'])->createCommand()->queryColumn();
        /** @var Payment $payment */
        $payment = Payment::find()->where(['orders_id' => $orderId])->one();

        Inventory::updateAll(['inventory_status' => 1, 'sold_date' => time()], ['id' => $inventoryIds]);
        $order->updateAttributes(['payment_status' => 1]);
        $transactionFake = 'FAKE' . time();
        $payment->updateAttributes([
            'modified_date'    => strtotime(date('Y-m-d H:i:s')),
            'response_code'    => '1',
            'transaction_info' => $transactionFake,
            'message'          => 'Thanh toán thành công',
        ]);
        /** @var Inventory[] $inventorys */
        $inventorys = Inventory::find()->orderBy(['inventory.stay_date' => SORT_ASC])->where(['id' => $inventoryIds])->all();
        if (count($inventorys) == 1) {
            $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[0]->stay_date));
            $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
        } elseif (count($inventorys) > 1) {
            $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[count($inventorys) - 1]->stay_date));
            $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
        } else {
            $checkOut = '';
        }
        //note: code loại voucher mới
        $voucherCode = Yii::$app->session->get('voucher_code');
        $voucher     = Voucher::find()->where(['code' => $voucherCode])->one();

        $mail = new Mail([
            'subject' => 'Xác nhận thanh toán',
            'mailTo'  => $customer->email,
            'content' => '',
        ]);
        $mail->send(['html' => 'order-confirm'], [
            'customerName'      => $payment->customer_name,
            'orderCode'         => 'FAKE_ORDER' . time(),
            'amount'            => $order->total_price,
            'confimationNumber' => $order->id,
            'arrivalDate'       => Yii::$app->formatter->asDate($inventorys[0]->stay_date),
            'departureDate'     => $checkOut,
            'voucherType'       => $voucher->voucher_type,
            'note'              => $payment->getTotalCustomer(),
        ]);
        if (Yii::$app->language == 'vi') {
            $transStatus = "Mã đặt phòng của Quý khách <span style='color: red'>{$order->code}</span> đã được thanh toán thành công. Quý khách vui lòng mang theo Phiếu quà tặng này và xác nhận khi thanh toán để làm thủ tục nhận phòng.";
        } else {
            $transStatus = "Your reservation code <span style='color: red'>{$order->code}</span> has been successfully paid. Please bring this voucher for check-in.";
        }

        $paymentResult                = new PaymentResult();
        $paymentResult->transStatus   = $transStatus;
        $paymentResult->transactionNo = $transactionFake;

        return $this->render('payment_result', ['paymentResult' => $paymentResult]);
    }

    /**
     * Action hủy giao dịch
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function actionCancelOrders()
    {
        $ordersId    = Yii::$app->request->post('ordersId');
        $transaction = Yii::$app->db->beginTransaction();
        try {
            /** @var Payment $payment */
            $payment = Payment::find()->where(['orders_id' => $ordersId])->one();
            /** @var Orders $order */
            $order = Orders::find()->where(['id' => $payment->orders_id])->one();
            if ($order->payment_status == 0) {
                $payment->updateAttributes([
                    'message'       => 'Đơn hàng đã bị hủy bởi khách hàng vào ngày ' . Yii::$app->formatter->asDatetime(time()),
                    'modified_date' => time(),
                    'response_code' => -2,
                ]);

                list(, $customerId,) = explode('-', $order->code);
                /** @var Customer $customer */
                $customer = Customer::find()->where(['id' => $customerId])->one();
                $order->updateAttributes([
                    'payment_status' => 4,
                    'updated_date'   => strtotime(date('d.m.Y H:i:s')),
                ]);
                $inventoryIds = OrdersDetail::find()->where(['orders_id' => $order->id])->select(['inventory_id'])->createCommand()->queryColumn();
                Inventory::updateAll(['inventory_status' => 0], ['id' => $inventoryIds]);
                $transaction->commit();

                $mail = new Mail([
                    'subject' => 'Xác nhận thanh toán',
                    'mailTo'  => $customer->email,
                    'content' => '',
                ]);
                $mail->send(['html' => 'order-cancel'], [
                    'customerName' => $payment->customer_name,
                    'orderCode'    => $order->code,
                ]);
            }

            return Url::to(['choose-date'], true);
        } catch (Exception $e) {
            $transaction->rollBack();

            return $e->getMessage();
        }
    }

    public function actionPaymentDomesticResult()
    {
        $paymentResult = new PaymentResult();

        if (Yii::$app->session->has('customerId')
            && Customer::isVerified(Yii::$app->session->get('customerId'))
        ) {
            $orderId       = Yii::$app->request->get('order_id');
            $vibCheckout   = new VIBCheckOut();
            $result        = $vibCheckout->checkOrder([
                'order_id' => 'oh' . $orderId,
                'function' => 'checkOrder',
            ]);
            $billStaus     = $result['result_data_decode']['bill_status'];
            $orderCode     = $result['result_data_decode']['order_code'];
            $transactionId = $result['result_data_decode']['bill_id'];
            list(, $customerId,) = explode('-', $orderCode);
            /** @var Orders $order */
            $order = Orders::find()->where(['id' => $orderId])->one();
            /** @var Customer $customer */
            $customer = Customer::find()->where(['id' => $customerId])->one();
            if ($result['result_code'] == 0) {
                /** @var OrdersDetail $inventoryIds */
                $inventoryIds = OrdersDetail::find()->where(['orders_id' => $orderId])->select(['inventory_id'])->createCommand()->queryColumn();
                /** @var Payment $payment */
                $payment = Payment::find()->where(['orders_id' => $orderId])->one();
                //Nếu đơn hàng thanh toán thành công
                if ($billStaus == 2) {
                    //Nếu order trạng thái la hủy giao dịch => order thành trạng thái đã thanh toán - hết hạn
                    if ($order->payment_status == 0) {
                        Inventory::updateAll(['inventory_status' => 1, 'sold_date' => time()], ['id' => $inventoryIds]);
                        $order->updateAttributes(['payment_status' => 1]);
                        $payment->updateAttributes([
                            'modified_date'    => strtotime(date('Y-m-d H:i:s')),
                            'response_code'    => $result['result_code'],
                            'transaction_info' => $transactionId,
                            'message'          => 'Thanh toán thành công',
                        ]);
                        /** @var Inventory[] $inventorys */
                        $inventorys = Inventory::find()->orderBy(['inventory.stay_date' => SORT_ASC])->where(['id' => $inventoryIds])->all();
                        if (count($inventorys) == 1) {
                            $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[0]->stay_date));
                            $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
                        } elseif (count($inventorys) > 1) {
                            $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[count($inventorys) - 1]->stay_date));
                            $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
                        } else {
                            $checkOut = '';
                        }
                        //note: code loại voucher mới
                        $voucherCode = Yii::$app->session->get('voucher_code');
                        $voucher     = Voucher::find()->where(['code' => $voucherCode])->one();

                        $mail = new Mail([
                            'subject' => 'Xác nhận thanh toán',
                            'mailTo'  => $customer->email,
                            'content' => '',
                        ]);
                        $mail->send(['html' => 'order-confirm'], [
                            'customerName'      => $payment->customer_name,
                            'orderCode'         => $orderCode,
                            'amount'            => $order->total_price,
                            'confimationNumber' => $order->id,
                            'arrivalDate'       => Yii::$app->formatter->asDate($inventorys[0]->stay_date),
                            'departureDate'     => $checkOut,
                            'voucherType'       => $voucher->voucher_type,
                            'note'              => $payment->getTotalCustomer(),
                        ]);
                        if (Yii::$app->language == 'vi') {
                            $transStatus = "Mã đặt phòng của Quý khách <span style='color: red'>{$order->code}</span> đã được thanh toán thành công. Quý khách vui lòng mang theo Phiếu quà tặng này và xác nhận khi thanh toán để làm thủ tục nhận phòng.";
                        } else {
                            $transStatus = "Your reservation code <span style='color: red'>{$order->code}</span> has been successfully paid. Please bring this voucher for check-in.";
                        }
                    } else {
                        $order->updateAttributes(['payment_status' => 5]);
                        if (Yii::$app->language == 'vi') {
                            $transStatus = "Đơn hàng: <span style='color: red'>{$order->code}</span> đã bị hủy do quá hạn thanh toán. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn";
                        } else {
                            $transStatus = 'Your order has been canceled. Please contact for information';
                        }
                    }
                } else {
                    $message = '';
                    if ($result['result_code'] == 3) {
                        $message = 'Có lỗi khi thanh toán ở hệ thống ngân hàng thanh toán';
                    }
                    if ($result['result_code'] == 4) {
                        $message = 'Đơn hàng hết hạn thanh toán';
                    }
                    Inventory::updateAll(['inventory_status' => 0], ['id' => $inventoryIds]);
                    //Nếu thanh toán không thành công và don hàng dang la cho thanh toán => status fail
                    $order->updateAttributes(['payment_status' => 3]);
                    $payment->updateAttributes([
                        'modified_date'    => strtotime(date('Y-m-d H:i:s')),
                        'response_code'    => $result['result_code'],
                        'transaction_info' => $transactionId,
                        'message'          => $message,
                    ]);
                    $mail = new Mail([
                        'content' => 'Đơn hàng ' . $order->code . ' thanh toán thất bại. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn',
                        'subject' => 'Xác nhận thanh toán',
                        'mailTo'  => $customer->email,
                    ]);
                    $mail->send();
                    $transStatus = 'Đơn hàng ' . $order->code . ' thanh toán thất bại. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn';
//                    $transStatus = Yii::t('yii', 'Fail transaction');
                }
                Yii::$app->session->removeAll();
//                return $this->render('payment_result', ['paymentResult' => $paymentResult]);
            } else {
                //	            $mail = new Mail([
                //		            'content' => 'Đơn hàng ' . $order->code . ' thanh toán thất bại. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn',
                //		            'subject' => 'Xác nhận thanh toán',
                //		            'mailTo'  => $customer->email
                //	            ]);
                //	            $mail->send();
                $transStatus = 'Đơn hàng ' . $order->code . ' thanh toán thất bại. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn';
            }
            $paymentResult->transStatus   = $transStatus;
            $paymentResult->transactionNo = $transactionId;
            $paymentResult->orderInfo     = $orderCode;

            return $this->render('payment_result', ['paymentResult' => $paymentResult]);
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    public function actionCancelPayment()
    {
        $ordersId    = Yii::$app->request->get('order_id');
        $transaction = Yii::$app->db->beginTransaction();
        try {
//            $vibCheckout = new VIBCheckOut();
//            $result      = $vibCheckout->checkOrder([
//                'order_id' => $ordersId,
//                'function' => 'checkOrder'
//            ]);
//            $billStaus     = $result['result_data_decode']['bill_status'];
//            if ($billStaus !== 2) {
//                $message = 'Có lỗi khi thanh toán ở hệ thống ngân hàng thanh toán';
//            } else {
//                $message = 'Đơn hàng đã bị hủy vào ngày ' . Yii::$app->formatter->asDatetime(time());
//            }
            $message = 'Đơn hàng đã bị hủy vào ngày ' . Yii::$app->formatter->asDatetime(time());
            /** @var Payment $payment */
            $payment = Payment::find()->where(['orders_id' => $ordersId])->one();
            $payment->updateAttributes([
                'message'       => $message,
                'modified_date' => time(),
                'response_code' => -2,
            ]);
            /** @var Orders $order */
            $order = Orders::find()->where(['id' => $payment->orders_id])->one();

            /** @var Customer $customer */
            $order->updateAttributes([
                'payment_status' => 3,
                'updated_date'   => strtotime(date('d.m.Y H:i:s')),
            ]);
            $inventoryIds = OrdersDetail::find()->where(['orders_id' => $order->id])->select(['inventory_id'])->createCommand()->queryColumn();
            Inventory::updateAll(['inventory_status' => 0], ['id' => $inventoryIds]);
            $transaction->commit();

            return $this->redirect(Url::to(['choose-date'], true));
        } catch (Exception $e) {
            $transaction->rollBack();

            return $e->getMessage();
        }
    }

    /**
     * Trang nhận kết quả trả về cua cybersource
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionPaymentResult()
    {
        Yii::error(json_encode([
            Yii::$app->request->post(),
            Yii::$app->request->method,
            Yii::$app->request,
        ]));

        try {
            if (Yii::$app->request->isPost) {
                // Define Variables
                $orderCode     = Yii::$app->request->post('req_reference_number', Yii::t('yii', 'No Value Returned'));
                $message       = Yii::$app->request->post('message', Yii::t('yii', 'No Value Returned'));
                $decision      = Yii::$app->request->post('decision', Yii::t('yii', 'No Value Returned'));
                $code          = Yii::$app->request->post('reason_code', -1);
                $transactionId = Yii::$app->request->post('transaction_id', Yii::t('yii', 'No Value Returned'));
                $amount        = Yii::$app->request->post('req_amount', Yii::t('yii', 'No Value Returned'));
//            var_dump(Yii::$app->request->post());die;
                $paymentResult = new PaymentResult();
                list(, $customerId, $orderId) = explode('-', $orderCode);
                /** @var Orders $order */
                $order = Orders::find()->where(['id' => $orderId])->one();

                /** @var Payment $payment */
                $payment = Payment::find()->where(['orders_id' => $order->id])->one();
                /** @var OrdersDetail $inventoryIds */
                $inventoryIds = OrdersDetail::find()->where(['orders_id' => $orderId])->select(['inventory_id'])->createCommand()->queryColumn();
                /** @var Customer $customer */
                $customer = Customer::find()->where(['id' => $customerId])->one();
//                nếu trang thanh toán xac nhận thành công
                if ($decision == 'ACCEPT') {
                    $transStatus = '';
                    if ($code == 100 && $order != null) {
                        if ($order->payment_status == 4) {
                            if (Yii::$app->language == 'vi') {
                                $transStatus = "Đơn hàng: <span style='color: red'>{$order->code}</span> đã bị hủy do quá hạn thanh toán. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn";
                            } else {
                                $transStatus = 'Your order has been canceled. Please contact for information';
                            }
                            $order->updateAttributes(['payment_status' => 5]);
                            $payment->updateAttributes([
                                'modified_date' => strtotime(date('Y-m-d H:i:s')),
                                'response_code' => -1,
                            ]);
                        } elseif ($order->payment_status == 0) {
                            $order->updateAttributes(['payment_status' => 1]);
                            Inventory::updateAll(['inventory_status' => 1, 'sold_date' => time()], ['id' => $inventoryIds]);
                            $payment->updateAttributes([
                                'modified_date'    => strtotime(date('Y-m-d H:i:s')),
                                'response_code'    => $code,
                                'transaction_info' => $transactionId,
                                'message'          => $message,
                            ]);
                            /** @var Inventory[] $inventorys */
                            $inventorys = Inventory::find()->orderBy(['inventory.stay_date' => SORT_ASC])->where(['id' => $inventoryIds])->all();
                            if (count($inventorys) == 1) {
                                $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[0]->stay_date));
                                $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
                            } elseif (count($inventorys) > 1) {
                                $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[count($inventorys) - 1]->stay_date));
                                $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
                            } else {
                                $checkOut = '';
                            }
                            //note: code loại voucher mới
                            $voucherCode = Yii::$app->session->get('voucher_code');
                            $voucher     = Voucher::find()->where(['code' => $voucherCode])->one();

                            $mail = new Mail([
                                'subject' => 'Xác nhận thanh toán',
                                'mailTo'  => $customer->email,
                                'content' => '',
                            ]);
                            $mail->send(['html' => 'order-confirm'], [
                                'customerName'      => $payment->customer_name,
                                'orderCode'         => $orderCode,
                                'amount'            => $order->total_price,
                                'confimationNumber' => $order->id,
                                'arrivalDate'       => Yii::$app->formatter->asDate($inventorys[0]->stay_date),
                                'departureDate'     => $checkOut,
                                'voucherType'       => $voucher->voucher_type,
                                'note'              => $payment->getTotalCustomer(),
                            ]);
                            if (Yii::$app->language == 'vi') {
                                $transStatus = "Mã đặt phòng của Quý khách <span style='color: red'>{$order->code}</span> đã được thanh toán thành công. Quý khách vui lòng mang theo Phiếu quà tặng này và xác nhận khi thanh toán để làm thủ tục nhận phòng.";
                            } else {
                                $transStatus = "Your reservation code <span style='color: red'>{$order->code}</span> has been successfully paid. Please bring this voucher for check-in.";
                            }
                        } elseif ($order->payment_status == 1) {
                            if (Yii::$app->language == 'vi') {
                                $transStatus = "Mã đặt phòng của Quý khách <span style='color: red'>{$order->code}</span> đã được thanh toán thành công. Quý khách vui lòng mang theo Phiếu quà tặng này và xác nhận khi thanh toán để làm thủ tục nhận phòng.";
                            } else {
                                $transStatus = "Your reservation code <span style='color: red'>{$order->code}</span> has been successfully paid. Please bring this voucher for check-in.";
                            }
                        }
                        $paymentResult->transStatus = $transStatus;
                    } else {
                        $transStatus = Yii::t('yii', 'Fail transaction');
                    }
                } else {
                    $transStatus = $message;
                }

                $paymentResult->message       = $message;
                $paymentResult->transStatus   = $transStatus;
                $paymentResult->transactionNo = $transactionId;
                $paymentResult->amount        = $amount;
                $paymentResult->orderInfo     = $orderCode;

                return $this->render('payment_result', ['paymentResult' => $paymentResult]);
            }

            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        } catch (Exception $e) {
            Yii::$app->cache->set('error' . time(), $e->getMessage());
            Yii::error($e->getMessage());

            return $e->getMessage();
        }
    }

    public function actionPaymentResultWs()
    {
        try {
            if (Yii::$app->request->isPost) {
                // Define Variables
                $orderCode     = Yii::$app->request->post('req_reference_number', Yii::t('yii', 'No Value Returned'));
                $message       = Yii::$app->request->post('message', Yii::t('yii', 'No Value Returned'));
                $decision      = Yii::$app->request->post('decision', Yii::t('yii', 'No Value Returned'));
                $code          = Yii::$app->request->post('reason_code', -1);
                $transactionId = Yii::$app->request->post('transaction_id', Yii::t('yii', 'No Value'));
//            $amount        = Yii::$app->request->post('req_amount', Yii::t('yii', 'No Value Returned'));

                list(, $customerId, $orderId) = explode('-', $orderCode);
                /** @var Orders $order */
                $order = Orders::find()->where(['id' => $orderId])->one();
                /** @var OrdersDetail $inventoryIds */
                $inventoryIds = OrdersDetail::find()->where(['orders_id' => $orderId])->select(['inventory_id'])->createCommand()->queryColumn();
                /** @var Customer $customer */
                $customer = Customer::find()->where(['id' => $customerId])->one();
                /** @var Payment $payment */
                $payment = Payment::find()->where(['orders_id' => $order->id])->one();
                //nếu trang thanh toán chấp nhận giao dịch
                if ($decision == 'ACCEPT') {
                    //nếu thanh toán thành công
                    if ($code == 100) {
                        if ($order->payment_status == 0) {
                            $order->updateAttributes(['payment_status' => 1]);
                            Inventory::updateAll(['inventory_status' => 1, 'sold_date' => time()], ['id' => $inventoryIds]);
                            $payment->updateAttributes([
                                'modified_date'    => strtotime(date('Y-m-d H:i:s')),
                                'response_code'    => $code,
                                'transaction_info' => $transactionId,
                                'message'          => $message,
                            ]);
                            /** @var Inventory[] $inventorys */
                            $inventorys = Inventory::find()->orderBy(['inventory.stay_date' => SORT_ASC])->where(['id' => $inventoryIds])->all();
                            if (count($inventorys) == 1) {
                                $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[0]->stay_date));
                                $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
                            } elseif (count($inventorys) > 1) {
                                $dateIn   = date('d.m.Y H:i:s', strtotime('+1 day', $inventorys[count($inventorys) - 1]->stay_date));
                                $checkOut = Yii::$app->formatter->asDate(strtotime($dateIn));
                            } else {
                                $checkOut = '';
                            }
                            $mail = new Mail([
                                'subject' => 'Xác nhận thanh toán',
                                'mailTo'  => $customer->email,
                                'content' => '',
                            ]);
                            $mail->send(['html' => 'order-confirm'], [
                                'customerName'      => $payment->customer_name,
                                'orderCode'         => $orderCode,
                                'amount'            => $order->total_price,
                                'confimationNumber' => $order->id,
                                'arrivalDate'       => Yii::$app->formatter->asDate($inventorys[0]->stay_date),
                                'departureDate'     => $checkOut,
                                'note'              => $payment->getTotalCustomer(),
                            ]);
                        } elseif ($order->payment_status == 4) {
                            //Nếu order trạng thái la hủy giao dịch => order thành trạng thái đã thanh toán - hết hạn
                            $order->updateAttributes(['payment_status' => 5]);
                            $payment->updateAttributes([
                                'modified_date' => strtotime(date('Y-m-d H:i:s')),
                                'response_code' => -1,
                            ]);
                        }
                    }
                    Yii::$app->session->removeAll();
                } elseif ($decision == 'CANCEL') {
                    Inventory::updateAll(['inventory_status' => 0], ['id' => $inventoryIds]);
                    //Nếu KH hủy giao dịch và don hàng dang la cho thanh toán => status hủy giao dịch
                    $order->updateAttributes(['payment_status' => 4]);
                    /** @var Payment $payment */
                    $payment = Payment::find()->where(['order_code' => $orderCode])->one();
                    $payment->updateAttributes([
                        'modified_date'    => strtotime(date('Y-m-d H:i:s')),
                        'response_code'    => $code,
                        'transaction_info' => $transactionId,
                        'message'          => $message,
                    ]);
                } else {
                    Inventory::updateAll(['inventory_status' => 0], ['id' => $inventoryIds]);
                    //Nếu thanh toán không thành công và don hàng dang la cho thanh toán => status fail
                    $order->updateAttributes(['payment_status' => 3]);
                    $payment->updateAttributes([
                        'modified_date'    => strtotime(date('Y-m-d H:i:s')),
                        'response_code'    => $code,
                        'transaction_info' => $transactionId,
                        'message'          => $message,
                    ]);
                    $mail = new Mail([
                        'content' => 'Đơn hàng ' . $order->code . ' thanh toán thất bại. Vui lòng đặt phòng lại hoặc liên hệ để được hướng dẫn',
                        'subject' => 'Xác nhận thanh toán',
                        'mailTo'  => $customer->email,
                    ]);
                    $mail->send();
                }
            }
        } catch (Exception $e) {
            Yii::$app->cache->set('error' . time(), $e->getMessage());
            Yii::error($e->getMessage());
//            return $e->getMessage();
        }

//        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    public function actionSetup()
    {
        Yii::$app->cache->set('abc', 'test');
        Yii::$app->session->set('voucher_code', '0028013');
        Yii::$app->session->set('voucherId', 44455);//test
        Yii::$app->session->set('customerId', 9679);//test
        Yii::$app->session->set('customerName', 'Quang Hieu');//test
        Yii::$app->session->set('customerPhone', '01682405889');//test
    }

    public function actionSetupOld()
    {
        Yii::$app->cache->set('abc', 'test');
        Yii::$app->session->set('voucher_code', '0028012');
        Yii::$app->session->set('voucherId', 44454);//test
        Yii::$app->session->set('customerId', 9679);//test
        Yii::$app->session->set('customerName', 'Quang Hieu');//test
        Yii::$app->session->set('customerPhone', '01682405889');//test
    }
}

