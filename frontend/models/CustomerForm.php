<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 5/4/2017
 * Time: 9:43 AM
 */

namespace frontend\models;

use common\models\Customer;
use common\models\Orders;
use common\models\Voucher;
use common\utils\helpers\Mail;
use Yii;
use yii\helpers\Url;

class CustomerForm
{
    /**
     * Hàm đăng kí KH
     * Nếu voucher không hợp lệ => Voucher invalid
     * Nếu KH chưa tồn tại => Tạo mới KH
     * Nếu đăng kí thành công lưu session tên KH, SDT, gửi mail báo đăng kí thanh công
     *
     * @param $email
     *
     * @param $code : mã voucher của KH
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\Exception
     */
    public function register($email, $code)
    {
        /** @var Customer $customer */
        $customer = Customer::find()->where(['email' => trim($email)])->one();

        /** @var Voucher $voucher */
        $voucher = Voucher::find()->where(['code' => $code])->one();

        $otp = Yii::$app->security->generateOtp();
        if ($customer === null) {
            $customer               = new Customer();
            $customer->created_date = strtotime(date('d.m.Y H:i:s'));
        }

        if ($customer->load(Yii::$app->request->post())) {
            if ($customer->isNewRecord) {
                $customer->is_verified   = 0;
                $customer->verified_date = null;
                $customer->OTP           = $otp;
                $customer->otp_date      = strtotime(date('d.m.Y H:i:s'));
                if ( ! $customer->save()) {
                    return json_encode($customer->errors);
                }
            } else {
                $customer->is_verified   = 0;
                $customer->verified_date = null;
                $customer->OTP           = $otp;
                $customer->otp_date      = strtotime(date('d.m.Y H:i:s'));
                $customer->updateAttributes(['is_verified', 'verified_date', 'OTP', 'otp_date']);
            }
        }
        Yii::$app->session->set('customerName', Yii::$app->request->post('Customer')['name']);
        Yii::$app->session->set('customerPhone', Yii::$app->request->post('Customer')['phone']);
        Yii::$app->session->set('customerEmail', Yii::$app->request->post('Customer')['email']);
        Yii::$app->session->set('voucherId', $voucher->id);

        $mail = new Mail([
            'content' => '',
            'subject' => Yii::t('yii', 'Verification code'),
            'mailTo'  => $customer->email
        ]);
        $mail->send('otp', ['otp' => $otp, 'lang' => Yii::$app->language]);

        Yii::$app->session->set('verify', 1);

        return Url::to(['authentication-otp'], true);
    }

    /**
     * Hàm kiểm tra mã OTP
     *
     * @param $otp
     *
     * @return string
     * url: otp chính xác
     * otp_expire: mã otp hết hạn
     * fail: mã otp không chính xác
     *
     * @throws \yii\base\InvalidParamException
     */
    public function verifyOtp($otp)
    {
        /** @var Customer $customer */
        $customer = Customer::find()->andFilterWhere(['OTP' => $otp])->one();

        if ($customer != null) {
            $time = $customer->otp_date + 600 >= time();
            if ($time) {
                $customer->OTP           = null;
                $customer->is_verified   = 1;
                $customer->verified_date = strtotime(date('d.m.Y H:i:s'));
                if ($customer->save(false)) {
                    Yii::$app->session->set('customerId', $customer->id);

                    return Url::to(['choose-date'], true);
                }
            } else {
                return 'otp_expire';
            }
        }

        return 'fail';
    }
}