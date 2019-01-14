<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 3/27/2017
 * Time: 1:39 PM
 */

namespace frontend\models;

class Cybersource
{
    const SECRET_KEY = 'c0c2989d317848c59dd3572f85de7dfd1b196249b8b9478eaf33111db65184ed51ebc25a5233448fba8b110e03f7c6652f3924689ea344348c6def656e21d552fe7bdf35e53b447eb1a856f8650f636502808ba9107248cc9459a30227c083642c14615befa9497b91ef31a23525c8c90e5803070bf5493aa1cb3984e52f6e7c';
    const PROFILE_ID = '4FBF8641-E503-4437-906F-8AA726C59AA5';
    const ACCESS_KEY = '442aacdd2d4f35b98344ced44986eb18';
    const PAYMENT_URL = 'https://testsecureacceptance.cybersource.com/pay';
//    const SIGNED_FIELD_NAME = 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_email,bill_to_phone,bill_to_address_country,bill_to_address_postal_code,bill_to_address_line1,bill_to_address_city,bill_to_surname,bill_to_forename';
//    const SIGNED_FIELD_NAME = 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,line_item_count,item_0_unit_price,item_1_unit_price,item_#_quantity,item_0_name,item_1_name,signed_date_time,locale,transaction_type,reference_number,currency,bill_to_email,bill_to_phone,bill_to_address_country,bill_to_address_postal_code,bill_to_address_line1,bill_to_address_city,bill_to_surname,bill_to_forename';

//    const SECRET_KEY = '0cc47f5e5abc4a97aa469fc82f87c2120eecfb59bb144ee48dd88ea1a4264742a2cfe796b5584587a15a713d2276285ee3b22d9682f2484793f1f769640dda1042affdfc74ef46b9826d65aec14fda52ce2bc9a3dcb24232878aae5ffd3bf0acb34eebc5e79644e5861c386db1e17f32f2d3b171e5dc43cbae6f79dfbedd445d';
//    const PROFILE_ID = '8AF7C5B9-F77C-48B8-A54C-8724AADB172B';
//    const ACCESS_KEY = 'fd33720e10423e20b6303d96a4e3bff8';
//    const PAYMENT_URL = 'https://secureacceptance.cybersource.com/pay';
    const SIGNED_FIELD_NAME = 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_email,bill_to_phone,bill_to_address_country,bill_to_address_postal_code,bill_to_address_line1,bill_to_address_city,bill_to_surname,bill_to_forename,bill_to_company_name,bill_to_address_state';

    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public static function generateSignature($cybersourceParams)
    {
        $signedFieldNames = explode(',', self::SIGNED_FIELD_NAME);
        $dataToSign       = [];
        foreach ($signedFieldNames as $field) {
            $dataToSign[] = $field . '=' . $cybersourceParams[$field];
        }

        $dataToSign = implode(',', $dataToSign);

        return base64_encode(hash_hmac('sha256', $dataToSign, self::SECRET_KEY, true));
    }
}