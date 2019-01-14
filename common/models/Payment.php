<?php

namespace common\models;

use common\models\base\PaymentBase;

class Payment extends PaymentBase
{
    const PAYMENT_WAITING = 0;
    const PAYMENT_SUCCESS = 1;
    const PAYMENT_FAIL = 3;
    const PAYMENT_CANCEL = 4;

    /**
     * Tạo nhanh payment
     *
     * @param $params
     *
     * @return bool
     */
    public static function createPayment($params)
    {
        $totalPrice    = $params['total_price'];
        $orderCode     = $params['order_code'];
        $voucherCode   = $params['voucher_code'];
        $type          = $params['type'];
        $customerName  = $params['customer_name'];
        $customerPhone = $params['customer_phone'];
        $customerEmail = $params['customer_email'];
        $ordersId      = $params['orders_id'];
        $customerId    = $params['customer_id'];
        $ip            = $params['ip'];
        $note          = $params['note'];
        $paymentOption = $params['payment_option'];

        $payment                 = new Payment();
        $payment->total_price    = $totalPrice;
        $payment->ip             = $ip;
        $payment->type           = $type;
        $payment->order_code     = $orderCode;
        $payment->voucher_code   = $voucherCode;
        $payment->customer_name  = $customerName;
        $payment->customer_email = $customerEmail;
        $payment->customer_phone = $customerPhone;
        $payment->customer_note  = $note;
        $payment->customer_id    = $customerId;
        $payment->orders_id      = $ordersId;
        $payment->payment_option = $paymentOption;
        $payment->created_date   = time();

        return $payment->save(false);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_name'    => 'Tên khách hàng',
            'customer_phone'   => 'Số điện thoại',
            'customer_email'   => 'Email',
            'transaction_info' => 'Mã giao dịch',
            'total_price'      => 'Tổng tiền',
            'order_code'       => 'Mã đơn hàng',
            'response_code'    => 'Response Code',
            'message'          => 'Message',
            'type'             => 'Loại thanh toán',
            'note'             => 'Ghi chú',
            'orders_id'        => 'Orders',
            'customer_id'      => 'Customer',
            'voucher_code'     => 'Mã voucher',
            'created_date'     => 'Ngày giao dịch',
            'date_from'        => 'Ngày giao dịch từ',
            'date_to'          => 'Ngày giao dịch đến',
            'modified_date'    => 'Ngày thanh toán',
            'status'           => 'Trạng thái',
            'total_customer'   => 'Tổng số khách',
        ];
    }

    public function getType()
    {
        if ($this->type == 0) {
            return 'Nội địa' . '/' . $this->payment_option;
        }

        return 'Visa/Mastercard';
    }

    public function getStatus($status)
    {
        if ($status == 0) {
            return 'Chờ thanh toán';
        }
        if ($status == 1) {
            return 'Thành công';
        }
        if ($status == 3) {
            return 'Thất bại';
        }
        if ($status == 4) {
            return 'Hủy giao dịch';
        }

        if ($status == 5) {
            return 'Đã thanh toán - Hết hạn';
        }
    }

    public function getTotalCustomer()
    {
        if ( ! empty($this->customer_note)) {
            $customers = explode(',', $this->customer_note);

//            return "Người lớn: {$customers[0]}, Trẻ em: {$customers[1]}";
            return "{$customers[0]} người lớn và {$customers[1]} trẻ em";
        }

        return '';
    }
}
