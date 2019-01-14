<?php

namespace frontend\models;

use Yii;

class VIBCheckOut
{
    const VERSION = '1.0';
    const FUNCTION_NAME = 'SetExpressCheckout';
    const URL_SERVICE = 'https://www.nganluong.vn/checkout/checkout.api.php?wsdl';

    const MERCHANT_ID = 43;
    const MERCHANT_PASS = 'Ab123456';

//    const MERCHANT_ID = 3;
//    const MERCHANT_PASS = 123456;

    public $merchant_id = '48';
    public $merchant_password = 'Ab123456';
    public $receiver_email = '';
    public $cur_code = 'vnd';

    public function __construct()
    {
        $this->merchant_id       = $this::MERCHANT_ID;
        $this->merchant_password = $this::MERCHANT_PASS;

    }

    public function sendOrder($params)
    {
        $params['function'] = 'sendOrder';

        return $this->call($params);
    }

    public function call($input)
    {
        require Yii::getAlias('@frontend') . '/models/nusoap.php';
        $soap_client = new \nusoap_client($this::URL_SERVICE, true);
        $params      = array(
            'merchant_id' => $this->merchant_id,
            'version'     => $this::VERSION,
            'params'      => $this->encrypt(json_encode($input), $this->merchant_password),
        );

//        echo json_encode($input);
        $result = $soap_client->call('process', $params);
        if (preg_match('/^(\d+)\|(.*)$/', $result, $temp)) {
            $result = array(
                'result_code'        => $temp[1],
                'result_data'        => $temp[2],
                'result_data_decode' => json_decode($this->decrypt($temp[2], $this->merchant_password), true),
            );

            return $result;
        }

        return false;
    }

    public function encrypt($input, $key_seed)
    {
        $input   = trim($input);
        $block   = mcrypt_get_block_size('tripledes', 'ecb');
        $len     = strlen($input);
        $padding = $block - ($len % $block);
        $input   .= str_repeat(chr($padding), $padding);
        // generate a 24 byte key from the md5 of the seed
        $key     = substr(md5($key_seed), 0, 24);
        $iv_size = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB);
        $iv      = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        // encrypt
        $encrypted_data = mcrypt_encrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv);

        // clean up output and return base64 encoded
        return base64_encode($encrypted_data);
    }

    public function decrypt($input, $key_seed)
    {
        $input   = base64_decode($input);
        $key     = substr(md5($key_seed), 0, 24);
        $text    = mcrypt_decrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, '12345678');
        $block   = mcrypt_get_block_size('tripledes', 'ecb');
        $packing = ord($text{strlen($text) - 1});
        if ($packing and ($packing < $block)) {
            for ($P = strlen($text) - 1; $P >= strlen($text) - $packing; $P--) {
                if (ord($text{$P}) != $packing) {
                    $packing = 0;
                }
            }
        }
        $text = substr($text, 0, strlen($text) - $packing);

        return $text;
    }

    public function checkOrder($params)
    {
        return $this->call($params);
    }

    public function getErrorMessage($error_code)
    {
        $arrCode = array(
            '0'  => 'Thành công',
            '1'  => 'Lỗi không xác định',
            '2'  => 'Mã merchant không tồn tại',
            '3'  => 'Merchant đang bị khóa kết nối',
            '4'  => 'Tham số version không đúng hoặc không tồn tại',
            '5'  => 'Tham số params không tồn tại',
            '6'  => 'Không giải mã được tham số params do việc mã hóa chưa đúng 
                            hoặc mật khẩu merchant dùng để mã hóa không đúng',
            '7'  => 'Tên hàm xử lý không đúng',
            '8'  => 'Thiếu tham số đầu vào',
            '9'  => 'order_id không hợp lệ',
            '10' => 'order_id trùng với giá trị các đơn hàng đã gửi trước đó',
            '11' => 'order_id không tồn tại',
            '12' => 'order_code mã đơn hàng không hợp lệ',
            '13' => 'order_description không hợp lệ',
            '14' => 'order_total_amount không hợp lệ',
            '15' => 'order_discount_amount không hợp lệ',
            '16' => 'order_fee_ship không hợp lệ',
            '17' => 'order_return_url không hợp lệ',
            '18' => 'order_cancel_url không hợp lệ',
            '19' => 'order_time_limit không hợp lệ',
            '20' => 'order_payment_option không hợp lệ hoặc không tồn tại',
            '21' => 'order_payment_fee_for_sender chứa giá trị không hợ',
            '22' => 'sender_fullname không hợp lệ',
            '23' => 'sender_email không hợp lệ',
            '24' => 'sender_mobile không hợp lệ',
            '25' => 'sender_address không hợp lệ',
            '26' => 'Không ghi nhận được đơn hàng trên cổng thanh toán',
        );

        return $arrCode[(string)$error_code];
    }
}