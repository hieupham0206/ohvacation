<?php
use frontend\assets\AppAsset;

AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $customer \common\models\Customer */

$this->title = 'Choose ATM';
?>
<style>
    input[type="radio"] {
        display: inline !important;
        margin: 5px auto;
    }

    ul.bankList {
        clear: both;
        height: 202px;
        width: 636px;
    }

    ul.bankList li {
        list-style-position: outside;
        list-style-type: none;
        cursor: pointer;
        float: left;
        margin-right: 0;
        padding: 5px 2px;
        text-align: center;
        width: 90px;
    }

    .list-content li {
        list-style: none outside none;
        margin: 0 0 10px;
    }

    .list-content li .boxContent {
        display:;
        width: 636px;
        border: 1px solid #cccccc;
        padding: 10px;
    }

    .list-content li.active .boxContent {
        display: block;
    }

    .list-content li .boxContent ul {
        height: 380px;
    }

    i.VISA, i.MASTE, i.AMREX, i.JCB, i.VCB, i.TCB, i.MB, i.VIB, i.ICB, i.EXB, i.ACB, i.HDB, i.MSB, i.NVB,
    i.DAB, i.SHB, i.OJB, i.SEA, i.TPB, i.PGB, i.BIDV, i.AGB, i.SCB, i.VPB, i.VAB, i.GPB, i.SGB, i.NAB, i.BAB, i.ABB, i.OCB, i.LVB, i.BVB {
        width: 80px;
        height: 30px;
        display: block;
        background: url(https://www.nganluong.vn/webskins/skins/nganluong/checkout/version3/images/bank_logo.png) no-repeat;
    }

    i.MASTE {
        background-position: 0 -31px
    }

    i.AMREX {
        background-position: 0 -62px
    }

    i.JCB {
        background-position: 0 -93px;
    }

    i.VCB {
        background-position: 0 -124px;
    }

    i.TCB {
        background-position: 0 -155px;
    }

    i.MB {
        background-position: 0 -186px;
    }

    i.VIB {
        background-position: 0 -217px;
    }

    i.ICB {
        background-position: 0 -248px;
    }

    i.EXB {
        background-position: 0 -279px;
    }

    i.ACB {
        background-position: 0 -310px;
    }

    i.HDB {
        background-position: 0 -341px;
    }

    i.MSB {
        background-position: 0 -372px;
    }

    i.NVB {
        background-position: 0 -403px;
    }

    i.DAB {
        background-position: 0 -434px;
    }

    i.SHB {
        background-position: 0 -465px;
    }

    i.OJB {
        background-position: 0 -496px;
    }

    i.SEA {
        background-position: 0 -527px;
    }

    i.TPB {
        background-position: 0 -558px;
    }

    i.PGB {
        background-position: 0 -589px;
    }

    i.BIDV {
        background-position: 0 -620px;
    }

    i.AGB {
        background-position: 0 -651px;
    }

    i.SCB {
        background-position: 0 -682px;
    }

    i.VPB {
        background-position: 0 -713px;
    }

    i.VAB {
        background-position: 0 -744px;
    }

    i.GPB {
        background-position: 0 -775px;
    }

    i.SGB {
        background-position: 0 -806px;
    }

    i.NAB {
        background-position: 0 -837px;
    }

    i.BAB {
        background-position: 0 -868px;
    }

    i.ABB {
        background-position: 0 -958px;
    }

    i.OCB {
        background-position: 0 -997px;
    }

    i.BVB {
        background-position: 0 -1049px;
    }

    i.LVB {
        background-position: 0 -1086px;
    }

    ul.cardList li {
        cursor: pointer;
        float: left;
        margin-right: 0;
        padding: 5px 4px;
        text-align: center;
        width: 90px;
    }

    /**/
    @media (max-width: 375px) {
        ul.cardList li {
            width: 80px;
        }
    }
</style>
<div class="boxContent">
    <ul class="cardList clearfix">
        <li class="bank-online-methods ">
            <label for="vcb_ck_on">
                <i class="VCB" title="TechComBank – Ngân hàng kỹ thương Việt Nam"></i>
                <input type="radio" value="VCB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="tcb_ck_on">
                <i class="TCB" title="Ngân hàng Nam Á"></i>
                <input type="radio" value="TCB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="bnt_atm_agb_ck_on">
                <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                <input type="radio" value="AGB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="bidv_ck_on">
                <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                <input type="radio" value="BIDV" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="sml_atm_scb_ck_on">
                <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                <input type="radio" value="SCB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="sml_atm_exb_ck_on">
                <i class="EXB" title="Ngân hàng Xuất Nhập Khẩu"></i>
                <input type="radio" value="EXB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="bnt_atm_pgb_ck_on">
                <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                <input type="radio" value="PGB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="bnt_atm_gpb_ck_on">
                <i class="GPB" title="Ngân hàng TMCP Dầu khí Toàn Cầu"></i>
                <input type="radio" value="GPB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="nab_ck_on">
                <i class="NAB" title="Ngân hàng Nam Á"></i>
                <input type="radio" value="NAB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="bnt_atm_sgb_ck_on">
                <i class="SGB" title="Ngân hàng Sài Gòn Công Thương"></i>
                <input type="radio" value="SGB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="vnbc_ck_on">
                <i class="ABB" title="Ngân hàng An Bình"></i>
                <input type="radio" value="ABB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="vib_ck_on">
                <i class="VIB" title="VIB - Ngân Hàng Quốc Tế"></i>
                <input type="radio" value="VIB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="mb_ck_on">
                <i class="MB" title="MB - Ngân hàng TMCP Quân Đội"></i>
                <input type="radio" value="MB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="MSB_ck_on">
                <i class="MSB" title="MaritimeBank – Ngân hàng TMCP Hàng Hải Việt Nam"></i>
                <input type="radio" value="MSB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="ojb_ck_on">
                <i class="OJB" title="Ngân hàng TMCP Đại Dương (OceanBank)"></i>
                <input type="radio" value="OJB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="sml_atm_bab_ck_on">
                <i class="BAB" title="Ngân hàng Bắc Á"></i>
                <input type="radio" value="BAB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="icb_ck_on">
                <i class="ICB" title="VietinBank - Ngân hàng TMCP Công thương Việt Nam"></i>
                <input type="radio" value="ICB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="shb_ck_on">
                <i class="SHB" title="SHB - Ngân hàng TMCP Sài Gòn - Hà Nội"></i>
                <input type="radio" value="SHB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="VPB_ck_on">
                <i class="VPB" title="VP Bank - Ngân hàng Việt Nam Thịnh Vượng"></i>
                <input type="radio" value="VPB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="DAB_ck_on">
                <i class="DAB" title="Dong A Bank - Ngân hàng TMCP Đông Á"></i>
                <input type="radio" value="DAB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="TPB_ck_on">
                <i class="TPB" title="TienphongBank - Ngân hàng Tiên phong"></i>
                <input type="radio" value="TPB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="ACB_ck_on">
                <i class="ACB" title="ACB - Ngân hàng Á Châu"></i>
                <input type="radio" value="ACB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="OCB_ck_on">
                <i class="OCB" title="OCB - Ngân hàng Phương Đông"></i>
                <input type="radio" value="OCB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="HDB_ck_on">
                <i class="HDB" title="HDBank - Ngân hàng TMCP Phát Triển TP Hồ Chí Minh"></i>
                <input type="radio" value="HDB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="NVB_ck_on">
                <i class="NVB" title="NaviBank - Ngân hàng TMCP Quốc dân"></i>
                <input type="radio" value="NVB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="VAB_ck_on">
                <i class="VAB" title="VietABank - Ngân hàng Việt Á"></i>
                <input type="radio" value="VAB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="LVB_ck_on">
                <i class="LVB" title="LienVietPostBank - Ngân hàng Bưu điện Liên Việt"></i>
                <input type="radio" value="LVB" name="bankcode">
            </label></li>
        <li class="bank-online-methods ">
            <label for="BVB_ck_on">
                <i class="BVB" title="BaoVietBank - Ngân hàng Bảo Việt"></i>
                <input type="radio" value="BVB" name="bankcode">
            </label>
        </li>
    </ul>
    <div class="modal-footer">
        <div class="left-w3-agile">
        </div>
        <div class="right-agileits">
            <button type="submit" class="btn_ov_modal btn-send btn-next-otp" id="btn_confirm_option"><?= Yii::t('yii', 'Choose') ?></button>
        </div>
    </div>
</div>
<script>
    $(function() {

    });
</script>