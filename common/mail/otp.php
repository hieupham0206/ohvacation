<?php
/* @var $this yii\web\View */
/* @var $otp string */
/* @var $lang string */
?>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<?php if ($lang == 'vi'): ?>
    Cám ơn Quý khách đã đặt phòng tại website <a href="https://ohvacation.cocobay.vn/" style="color: #3366FF">OHVACATION.COCOBAY.VN</a>. Mã OTP của Quý khách là: <span style='color: red; font-weight: bold'> <?= $otp ?> </span>.
    Quý khách hãy nhập mã vào trang web để hoàn tất giao dịch. Mã này chỉ có giá trị trong 10 phút.
    <br>
    Điều kiện áp dụng: Phiếu quà tặng (Gift Voucher) chỉ áp dụng đối với khách hàng đã tham gia sự kiện tại Công ty Oh Vacation, tên
    khách phải đúng với tên được ghi trên gift voucher. Quý khách vui lòng liên hệ Bộ phận đặt phòng tại Boutique Hotel thuộc
    Cocobay Đà Nẵng để được hướng dẫn tham gia tối thiểu 60 phút tour giới thiệu về kỳ nghỉ của chúng
    tôi. Quý khách sẽ chịu chi phí phòng theo giá niêm yết tại Boutique Hotel thuộc Cocobay Đà Nẵng nếu
    không tham gia tour giới thiệu về kỳ nghỉ.
    <br>
    <h5 style="color: red; font-style: italic"> (*) Đây là email trả lời tự động. Quý khách vui lòng không phản hồi lại theo địa chỉ email này</h5>
<?php else: ?>
    Thanks for booking room at <a href="https://ohvacation.cocobay.vn/" style="color: #3366FF">OHVACATION.COCOBAY.VN</a>. Your OTP code is: <span style='color: red; font-weight: bold'> <?= $otp ?> </span>.
    OTP only valid for 10 minutes
<?php endif ?>
</body>