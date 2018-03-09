<?php
/**
 * @Project BNC v2
 * @File class/payment_bk_pro.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 2014/12/25, 13:30 [PM]
 */

class PaymentBaokim {
    function __construct() {
        include_once DIR_PAYMENT . 'payment_call_resfull.php';
        // include_once DIR_PAYMENT . 'payment_defined.php';
        $this->call_restfull = new Baokim_PaymentPro_Model_CallRestful();
        //Khoi tao 1 stdClass rong
        // $this->getConfigData['business_account'] = 'dev.baokim@bk.vn';
        $this->getConfigData['api_username']  = 'paymentbnc';
        $this->getConfigData['api_password']  = '7qULy3TcrZNK8PvOeV1G7X9hbm2Cj';
        $this->getConfigData['api_signature'] = '-----BEGIN PRIVATE KEY-----
MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCWQdkhXQrlbnJc
qUQQReW1NZblxcKt3HpfUA70UxyRlqWgrEKkwgCENhCWeiCKvfTlv8rZGV4hJYFw
DVszvB04UsjbzOTG5ea5uRbBfp1rHiPXOYwVvUEZZadqhBj3fJNwfWVvdGRYxOFG
6+OgBzdeMbdMhkm8EWYjjXLUPE0mRCvysgT6bSwD+CA4+l6+kIiuV4N1UpICDbFQ
fAhtFuvcajWR8GTRK7dIGpknlSwfMx4gxgsFWLCmJi/sxZHScHXbjpbCTBY/OKYx
GwrKfOmkNCaAFKYIeVex7ZlVYAP7k7khMDOvUArIP1oVdO5IrxnKK8rn757JuNpm
crjQVRDdAgMBAAECggEACmNlEqRvI2ueZn+hYAqlFgEtfJdOnVyX7U0Iq6WvXPVw
YApo1SFAjeN7BBxPcagubU/0Q0w4sMv6Bfg2bP49eu5mSqQA0SuF5yM/yoLpeUVt
Lu0gnUQnYw0fJQMbAslPHEDfKXR/l4+ND60xYJf/IPkI9jZ2lJUTXbPi03+Tyehj
jnDI1rEilq3eNEE7UZsvOblVsqDaaxdXR6HwU53jNkbjaPCo2dMmhjMvAmhjTLuN
n6zILKA4mql8Mh5EY+g0FnyyxBGU45a3DwqJNdp9qVdrdtA/jTndITPmqlpPQGIl
jiLWUKBdODOSlBYeVUGyD7hfUc2syqCrfDjisQ7B1QKBgQDGTZzvr/BhgJb74aSr
3s0Q5e4f2KOVTLjZV5Sdfv6cXBMoCGWn4WD6sPf4Vfrwm1tL6JO6QAK+x+HKnPJ4
Mb1STbta9sYS3RQWNSdq4C/pWMwNrpdwXNmfGvDJPT30uGN7gpPVe/9omOUveXO7
LT/wlnsrFWOzIJksgwGStZS0RwKBgQDB+ZYrTIXfJWUMChM5A3FiJg51EpE1jNWy
zAfoRXzjv0ZnNkHr+Tow2M3sYcRl05KIThhyemUS3uI1FWC3Tve60jOqCf4T0K21
AVeO8X49YVLrqXJ0Psg2EmGPKWxhCOovQK+qVfenvxlfro2/Qvt896msL5oRf5IH
OHP6i+UXuwKBgGAjrqsxtCvBKPHy4mAFA4xmvPypjh1K9e9BG6cDs7LgnNTyxT4P
8XF4rK+0F5Xg6/EwT7ajY/FUfK47Sv5ktvGZB/VA4KSylBN0L6kMCY5q43rao0bx
bPxLFmOqEkh7wJdXpg6BMEFopuxOSIJ9nJsqiYpIs25bpodC+FdFO1PvAoGAd9jp
u57wJ8tG/4VKEzPZXjb9P8BVD60QbAQ77nrgiyanLSYM3OuD1KJfuOk/G1r5clYu
LK0KvfoP8ZRfyWJ1FWzClxDNdxi7+tX1b1AuG2aCgTCUktYnhaEdvgJuABYt+zwQ
TUIIXhBocQG8equ8Dp5GqyhOHPmhE+0BW5AL3/kCgYAdbyF8ZpAjzCTV3zXMHnaG
hH9R9yryC0YLqG5H3ZkerIB/WcQP+9pgjHnbC7kH7WTQfp4I2vZVeoXgMYcXVzt8
x9pRd5jyHMsUBH8QcEz1cjXxwWWLFHwHbRRoVecTj3GG9zhCWapZIp5UvEsJNRqv
5SwKCdBpcTlQWfFSEAhZKA==
-----END PRIVATE KEY-----';
        $this->getConfigData['test_mode'] = false;

        //API request
        $this->api_seller_info = '/payment/rest/payment_pro_api/get_seller_info';
        $this->api_pay_by_card = '/payment/rest/payment_pro_api/pay_by_card';
        $this->api_payment     = '/payment/order/version11';
        if ($this->getConfigData['test_mode'] == true) {
            $this->server = 'http://kiemthu.baokim.vn/';
        } else {
            $this->server = 'https://www.baokim.vn/';
        }

    }

    /**
     * Call API GET_SELLER_INFO
     *  + Create bank list show to frontend
     *
     * @internal param $method_code
     * @return string
     */
    public function get_seller_info($get_banks = 1) {
        $data = array(
            'business' => 'payment@webbnc.vn',
        );
        $call_API = $this->call_restfull->call_API("GET", $data, $this->api_seller_info, $this->getConfigData);
        if (is_array($call_API)) {
            if (isset($call_API['error'])) {
                return "<strong style='color:red'>call_API" . json_encode($call_API['error']) . "- code:" . $call_API['status'] . "</strong> - " . "System error. Please contact to administrator";
            }
        }

        $seller_info = json_decode($call_API, true);
        if (!empty($seller_info['error'])) {
            return "<strong style='color:red'>seller_info" . json_encode($seller_info['error']) . "</strong> - " . "System error. Please contact to administrator";
        }

        if ($get_banks == 1) {
            return $seller_info['bank_payment_methods'];
        } else {
            return $seller_info;
        }

    }

    /**
     * Call API PAY_BY_CARD
     *  + Get Order info
     *  + Sent order, action payment
     *
     * @param $orderid
     * @return mixed
     */
    public function pay_by_card($data) {

        $result = json_decode($this->call_restfull->call_API('POST', $data, $this->api_pay_by_card, $this->getConfigData), true);

        return $result;
    }
    /**
     * Cấu hình phương thức thanh toán với các tham số
     * E-mail Bảo Kim - E-mail tài khoản bạn đăng ký với BaoKim.vn.
     * Merchant ID - là “mã website” được Baokim cấp khi bạn đăng ký tích hợp.
     * Mã bảo mật - là “mật khẩu” được Baokim cấp khi bạn đăng ký tích hợp
     * Vd : 12f31c74fgd002b1
     * Server Bảo Kim
     * Trang ​Kiểm thử - server để test thử phương thức thanh. .toán
     * Trang thực tế - Server thực tế thực hiện thanh toán.
     * https://www.baokim.vn/payment/order/version11' => ('Trang thực tế'),
     * http://kiemthu.baokim.vn/payment/order/version11' => ('Trang kiểm thử')
     * Chọn Save configuration để áp dụng thay đổi
     * Hàm xây dựng url chuyển đến BaoKim.vn thực hiện thanh toán, trong đó có tham số mã hóa (còn gọi là public key)
     * @param $order_id                Mã đơn hàng
     * @param $business            Email tài khoản người bán
     * @param $total_amount            Giá trị đơn hàng
     * @param $shipping_fee            Phí vận chuyển
     * @param $tax_fee                Thuế
     * @param $order_description    Mô tả đơn hàng
     * @param $url_success            Url trả về khi thanh toán thành công
     * @param $url_cancel            Url trả về khi hủy thanh toán
     * @param $url_detail            Url chi tiết đơn hàng
     * @param null $payer_name
     * @param null $payer_email
     * @param null $payer_phone_no
     * @param null $shipping_address
     * @return url cần tạo
     */
    // public function createRequestUrl($data) {
    //     echo '<pre>';
    //     print_r(12312);
    //     echo '</pre>';
    //     die();
    //     //$currency = 'VND'; // USD
    //     // Mảng các tham số chuyển tới baokim.vn
    //     $sercure_pass = $data['sercure_pass'];
    //     unset($data['sercure_pass']);
    //     ksort($data);
    //     $str_combined     = $sercure_pass . implode('', $data);
    //     $data['checksum'] = strtoupper(md5($str_combined));
    //     //Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào
    //     $redirect_url = $this->server . $this->api_payment;
    //     if (strpos($redirect_url, '?') === false) {
    //         $redirect_url .= '?';
    //     } else if (substr($redirect_url, strlen($redirect_url) - 1, 1) != '?' && strpos($redirect_url, '&') === false) {
    //         // Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
    //         $redirect_url .= '&';
    //     }

    //     // Tạo đoạn url chứa tham số
    //     $url_params = '';
    //     foreach ($data as $key => $value) {
    //         if ($url_params == '') {
    //             $url_params .= $key . '=' . urlencode($value);
    //         } else {
    //             $url_params .= '&' . $key . '=' . urlencode($value);
    //         }
    //     }
    //     return $redirect_url . $url_params;
    // }

    public function createRequestUrl($data) {
        $sercure_pass = $data['sercure_pass'];
        unset($data['sercure_pass']);
        // $order_id = time();
        // $total_amount = str_replace('.','',$data['total_amount']);
        // $base_url = "http://" . $_SERVER['SERVER_NAME'];
        // $url_success = $base_url.'/success';
        // $url_cancel = $base_url.'/cancel';
        // $currency = 'VND'; // USD
        // Mảng các tham số chuyển tới baokim.vn
        $params = $data;
        //$params['merchant_id']=strval(MERCHANT_ID);
        // $params = array(
        //  'merchant_id'       =>  strval(MERCHANT_ID),
        //  'order_id'          =>  strval($order_id),
        //  'business'          =>  strval(EMAIL_BUSINESS),
        //  'total_amount'      =>  strval($total_amount),
        //  'shipping_fee'      =>  strval('0'),
        //  'tax_fee'           =>  strval('0'),
        //  'order_description' =>  strval('Thanh toán đơn hàng từ Website '. $base_url . ' với mã đơn hàng ' . $order_id),
        //  'url_success'       =>  strtolower($url_success),
        //  'url_cancel'        =>  strtolower($url_cancel),
        //  'url_detail'        =>  strtolower(''),
        //  'payer_name'        =>  strval($data['payer_name']),
        //  'payer_email'       =>  strval($data['payer_email']),
        //  'payer_phone_no'    =>  strval($data['payer_phone_no']),
        //  'shipping_address'  =>  strval($data['address']),
        //  'currency' => strval($currency),

        // );
        ksort($params);

        $params['checksum'] = hash_hmac('SHA1', implode('', $params), $sercure_pass);

        //Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào
        $redirect_url = $this->server . $this->api_payment;
        if (strpos($redirect_url, '?') === false) {
            $redirect_url .= '?';
        } else if (substr($redirect_url, strlen($redirect_url) - 1, 1) != '?' && strpos($redirect_url, '&') === false) {
            // Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
            $redirect_url .= '&';
        }

        // Tạo đoạn url chứa tham số
        $url_params = '';
        foreach ($params as $key => $value) {
            if ($url_params == '') {
                $url_params .= $key . '=' . urlencode($value);
            } else {
                $url_params .= '&' . $key . '=' . urlencode($value);
            }

        }

        return $redirect_url . $url_params;
    }

    /**
     * Hàm thực hiện xác minh tính chính xác thông tin trả về từ BaoKim.vn
     * @param $url_params chứa tham số trả về trên url
     * @return true nếu thông tin là chính xác, false nếu thông tin không chính xác
     */
    public function verifyResponseUrl($url_params = array(), $sercure_pass) {
        if (empty($url_params['checksum'])) {
            echo "invalid parameters: checksum is missing";

            return FALSE;
        }
        $checksum = $url_params['checksum'];
        unset($url_params['checksum']);

        ksort($url_params);
        $str_combined = $sercure_pass . implode('', $url_params);
        if (strtoupper(md5($str_combined)) === $checksum) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /**
     * [generateBankImage description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-19
     * @param  [type]                     $banks               [description]
     * @param  [type]                     $payment_method_type [description]
     * @return [type]                                          [description]
     */
    public function generateBankImage($banks, $payment_method_type) {
        $return = array();
        if (is_array($banks)) {
            foreach ($banks as $bank) {
                if ($bank['payment_method_type'] == $payment_method_type) {
                    $img_name = str_replace('.png', '.gif', array_pop(explode('/', $bank['logo_url'])));
                    $tmp_fee  = intval($bank['fix_fee']);
                    if ($tmp_fee === 0) {
                        $tmp_fee = 'Miễn phí';
                    } else {
                        $tmp_fee = formatNumber($tmp_fee, $bank['fee_currency_code']);
                    }
                    $return[] = array(
                        'id'       => $bank['id'],
                        'logo_url' => $img_name,
                        'title'    => $bank['name'],
                        'bank_id'  => $bank['bank_id'],
                        'tooltip'  => '<strong>' . $bank['name'] . '</strong><br/>' . 'Phí thanh toán: ' . $tmp_fee . '<br/>' . 'Thời gian hoàn thành: ' . $bank['complete_time'] . '',
                    );
                }
            }
        }

        return $return;
    }

    /**
     * [getPaymentMethod description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-19
     * @param  string                     $type [description]
     * @param  [type]                     $key  [description]
     * @return [type]                           [description]
     */
    public function methodLang($lang = 'vi') {
        global $_B;
        $lang = 'vi';
        if ($_B['lang'] != false) {
            $lang = $_B['lang'];
        }
        if ($lang == 'vi') {
            $methods = array(

                1 => array(
                    'title'  => 'Thanh toán bằng thẻ ngân hàng nội địa',
                    'slogan' => '',
                    'status' => false,
                    'cf'     => 'LOCAL_CARD',
                ),
                2 => array(
                    'title'  => 'Thanh toán bằng thẻ quốc tế Visa/Master card',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'CREDIT_CARD',
                ),
                3 => array(
                    'title'  => 'Thanh toán bằng internet Banking',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'INTERNET_BANKING',
                ),
                4 => array(
                    'title'  => 'Chuyển khoản tại máy ATM',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'ATM_TRANSFER',
                ),
                5 => array(
                    'title'  => 'Chuyển khoản tại quầy giao dịch Ngân hàng',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'BANK_TRANSFER',
                ),
                6 => array(
                    'title'  => 'Thanh toán bằng Ví điện tử Bảo Kim',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'BAO_KIM',
                ),
                7 => array(
                    'title'  => 'Thanh toán tại nhà',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'AT_HOME',
                ),
                8 => array(
                    'title'  => 'Chuyển khoản qua ngân hàng (Tùy chọn)',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'BANK_TRANSFER_CUSTOM',
                ),
                9 => array(
                    'title'  => 'Thanh toán tại cửa hàng',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'IN_STORE_PAY',
                ),

            );
        } elseif ($lang == 'en') {
            $methods = array(
                1 => array(
                    'title'  => 'Pay by domestic bank cards',
                    'slogan' => '',
                    'status' => false,
                    'cf'     => 'LOCAL_CARD',
                ),
                2 => array(
                    'title'  => 'Payment with VISA / Mastercard',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'CREDIT_CARD',
                ),
                3 => array(
                    'title'  => 'Payment by Internet Banking',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'INTERNET_BANKING',
                ),
                4 => array(
                    'title'  => 'Transfer at ATMs',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'ATM_TRANSFER',
                ),
                5 => array(
                    'title'  => 'Transfer bank',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'BANK_TRANSFER',
                ),
                6 => array(
                    'title'  => 'Payments by Bao Kim',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'BAO_KIM',
                ),
                7 => array(
                    'title'  => 'Payment at home',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'AT_HOME',
                ),
                8 => array(
                    'title'  => 'Bank transfer (Optional)',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'BANK_TRANSFER_CUSTOM',
                ),
                9 => array(
                    'title'  => 'In-store payments',
                    'slogan' => '',
                    'status' => true,
                    'cf'     => 'IN_STORE_PAY',
                ),

            );

        }

        return $methods;
    }
    /**
     * @param $type
     * @param $key
     * @return mixed
     */
    public function getPaymentMethod($type = 'BAOKIM', $key = null) {

        if ($type == 'BAOKIM') {
            $methods = $this->methodLang();
            if ($key != null) {
                return $methods[$key];
            }
        }

        return $methods;
    }
}