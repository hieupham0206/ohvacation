<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<div class="container_fix" style="max-width: 800px;height: auto;left: 0;right: 0;margin: auto;padding-left: 15px;padding-right: 15px;">
    <div style="width: 100%">
        <div class="border_right" style="float: left; width: 50%;padding-left: 15px;">
            <p class="p_h1" style="font-weight: bold; font-size: 20px;">XÁC NHẬN ĐẶT PHÒNG</p>
        </div>
        <div class="border_right" style="float: right; width: 20%;">
            <p class="solid" style="top:30px;font-weight: bold;"> Mã xác nhận: <a href="#" style="color: red;text-decoration: none;"><?= $confimationNumber ?></a></p>
        </div>
    </div>
    <br>
    <div class="col-12" style="width: 100%;padding-top: 40px; padding-left: 15px;padding-right: 15px;">
        <div class="fix-top-bottom">
            <p class="" style="top:30px;font-weight: bold; font-size: 20px; text-align: left"></p>
            <p style="text-align: left">Kính gửi: <a href="#" style="color: #000;font-weight:bold;text-decoration: none;"><?= $customerName ?></a></p>
            <p>Cám ơn Quý khách đã quan tâm và sử dụng dịch vụ nghỉ dưỡng tại Boutique Hotel thuộc Cocobay Đà Nẵng.</p>
            <p>Theo yêu cầu của Quý khách, Chúng tôi xin được xác nhận thông tin đặt phòng của Quý khách như sau:</p>
            <table>
                <tbody>
                <tr>
                    <td><p style="font-weight: bold;">Tên khách hàng</p></td>
                    <td><p style="margin-left: 30px"><?= $customerName ?></p></td>
                </tr>
                <tr>
                    <td><p style="font-weight: bold;">Mã Đặt phòng</p></td>
                    <td><p style="margin-left: 30px"><?= $orderCode ?></p></td>
                </tr>
                <tr>
                    <td><p style="font-weight: bold;">Loại phòng</p></td>
                    <td><p style="margin-left: 30px">01 Superior Room</p></td>
                </tr>
                <tr>
                    <td><p style="font-weight: bold;">Ngày check in</p></td>
                    <td><p style="margin-left: 30px"><?= $arrivalDate ?></p></td>
                </tr>
                <tr>
                    <td><p style="font-weight: bold;">Ngày check out</p></td>
                    <td><p style="margin-left: 30px"><?= $departureDate ?></p></td>
                </tr>
                <tr>
                    <td><p style="font-weight: bold;">Số lượng khách</p></td>
                    <td><p style="margin-left: 30px"><?= $note ?></p></td>
                </tr>
                <tr>
                    <td><p style="font-weight: bold;">Tổng phí đã thanh toán</p></td>
                    <td><p style="margin-left: 30px"><?= number_format( $amount ) ?> VND</p></td>
                </tr>
                </tbody>
            </table>
            <div style="width: 100%">
                <p style="font-weight: bold;">Lưu ý:</p>
                <div style="padding-left: 30px;">
                    <ul class="b" style="list-style-type: square;">
                        <li>Chi phí trên đã bao gồm giá trị lưu trú 03 ngày 02 đêm nghỉ dưỡng tại Boutique Hotel thuộc Cocobay Đà
                            Nẵng;
                        </li>
                        <li>Không bao gồm vé máy bay, chi phí đi lại, ăn uống và các chi phí cá nhân phát sinh khác;</li>
                        <li>Phí đặt phòng không được hoàn lại trong bất kỳ trường hợp nào.</li>
                        <li>Quý khách vui lòng mang theo Phiếu quà tặng (Gift voucher), email xác nhận đặt phòng, CMND/ Hộ chiếu (người lớn) và Giấy khai sinh/ Hộ chiếu (nếu có trẻ em đi kèm) để làm thủ tục khi nhận phòng.</li>
                        <li>Điều kiện áp dụng: Phiếu quà tặng (Gift Voucher) chỉ áp dụng đối với Khách hàng đã tham gia sự kiện tại Công ty Oh Vacation, tên khách hàng phải đúng với tên được ghi trên gift voucher. Quý khách vui lòng liên hệ Bộ phận
                            đặt phòng tại Boutique Hotel - hotline: 19006967 (nhấn phím số 3) - thuộc Cocobay Đà Nẵng để được hướng dẫn tham gia tối thiểu 60 phút tour giới thiệu về kỳ nghỉ của chúng tôi tại Cocobay Đà Nẵng. Quý khách sẽ chịu chi phí phòng theo
                            giá niêm yết tại Boutique Hotel thuộc Cocobay Đà Nẵng nếu không tham gia tour giới thiệu về kỳ nghỉ.
                        </li>
                    </ul>
                </div>
                <p style="font-weight: bold;">Thời gian nhận / trả phòng:</p>
                <p>Nhận phòng lúc 14g00. Trả phòng lúc 12g00 (trưa).</p>
                <p>Trả phòng từ 14g00 đến 18g00 thanh toán 50% tiền phòng (theo giá niêm yết).</p>
                <p>Trả phòng sau 18g00 thanh toán 100% tiền phòng (theo giá niêm yết).</p>
                <br>
                <p style="font-weight: bold;">Quý khách có thể đặt phòng trực tuyến ngay hôm nay tại Website: <a href="https://ohvacation.cocobay.vn/" style="color: #3366FF">OHVACATION.COCOBAY.VN</a> với nhiều ưu đãi hấp dẫn dành cho Quý
                    khách khi trở thành Chủ sở hữu kỳ nghỉ của các Dự án tại Cocobay Đà Nẵng.</p>
                <h5 style="color: red; font-style: italic"> (*) Đây là email trả lời tự động. Quý khách vui lòng không phản hồi lại theo địa chỉ email này</h5>
            </div>
            <p style="font-weight: bold;">Phụ thu ăn sáng nếu có nhu cầu:</p>
            <table border="1" cellspacing="0" cellpadding="5" style="width: 100%">
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">Người lớn</td>
                    <td colspan="2" style="text-align: center; font-weight: bold;">Trẻ em từ 4 -12 tuổi</td>
                </tr>
                <tr>
                    <td style="text-align: center; font-weight: bold;">Đặt trước tối thiểu 3 ngày</td>
                    <td style="text-align: center; font-weight: bold;">Đặt tại khách sạn</td>
                    <td style="text-align: center; font-weight: bold;">Đặt trước tối thiểu 3 ngày</td>
                    <td style="text-align: center; font-weight: bold;">Đặt tại khách sạn</td>
                </tr>
                <tr>
                    <td style="text-align: center;">VND 150.000 net/người/suất</td>
                    <td style="text-align: center;">VND 185.000 net/người/suất</td>
                    <td style="text-align: center;">VND 75.000 net/trẻ/suất</td>
                    <td style="text-align: center;">VND 93.000 net/trẻ/suất</td>
                </tr>
            </table>
            <p style="font-weight: bold;">Dịch vụ đưa đón sân bay: </p>
            <div style="padding-left: 30px;">
                <ul class="b" style="list-style-type: square;">
                    <li>Xe chung (tối thiểu 2 khách): VND 200.000net/khách/chiều</li>
                    <li>Xe 4-6 chỗ: VND 900.000 net/xe/chiều</li>
                    <li>Xe 16 chỗ: VND 1.125.000net/xe/chiều</li>
                    <li>Coco citi tour: VND 250.000net/người/24giờ</li>
                </ul>
            </div>
            <p style="font-weight: bold;">Thời gian nhận / trả phòng:</p>
            <p>Nhận phòng lúc 14g00. Trả phòng lúc 12g00 (trưa).</p>
            <p>Hỗ trợ cho phép trả phòng đến 14g00, trong trường hợp còn phòng trống .</p>
            <p>Trả phòng từ 14g00 đến 18g00 thanh toán 50% tiền phòng (theo giá niêm yết).</p>
            <p>Trả phòng sau 18g00 thanh toán 100% tiền phòng (theo giá niêm yết).</p>
            <br>
            <p style="font-weight: bold;">Quý khách có thể đặt phòng trực tuyến ngay hôm nay tại Website: <a href="https://OHVACATION.COCOBAY.VN"> OHVACATION.COCOBAY.VN </a> với nhiều ưu đãi hấp dẫn dành cho Quý khách khi trở thành Chủ sở hữu kỳ nghỉ
                của các Dự án tại Cocobay Đà Nẵng.</p>
        </div>
    </div>
    <div class="col-12" style="width: 100%;padding-top: 40px;">
        <div style="text-align: center;">
            <img src="https://ohvacation.cocobay.vn/bg.png" width="100%" height="153px">
        </div>
    </div>
</div>
</body>
</html>
