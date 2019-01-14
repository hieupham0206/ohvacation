<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 3/28/2017
 * Time: 10:05 AM
 */

namespace frontend\models;

/**
 * Class PaymentResult
 * @property double $amount
 * @property string $message
 * @property string $responseCode
 * @property string $transactionNo
 * @property string $transStatus
 * @property string $orderInfo
 * @package frontend\models
 */
class PaymentResult
{
    public $amount;
    public $message;
    public $orderInfo;
    public $responseCode;
    public $transactionNo;
    public $transStatus;
}