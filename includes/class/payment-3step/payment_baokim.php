<?php
/**
 * @Project BNC v2
 * @File class/payment_bk_pro.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 2014/12/25, 13:30 [PM]
 */
include_once DIR_PAYMENT . 'payment_call_resfull.php';
class PaymentBaokim {

	/**
	 * Call API GET_SELLER_INFO
	 *  + Create bank list show to frontend
	 *
	 * @internal param $method_code
	 * @return string
	 */
	public function get_seller_info() {
		$param = array(
			'business' => EMAIL_BUSINESS,
		);
		$call_restfull = new CallRestful();
		$call_API      = $call_restfull->call_API("GET", $param, BAOKIM_API_SELLER_INFO);
		if (is_array($call_API)) {
			if (isset($call_API['error'])) {
				return "<strong style='color:red'>call_API" . json_encode($call_API['error']) . "- code:" . $call_API['status'] . "</strong> - " . "System error. Please contact to administrator";
			}
		}

		$seller_info = json_decode($call_API, true);
		if (!empty($seller_info['error'])) {
			return "<strong style='color:red'>eller_info" . json_encode($seller_info['error']) . "</strong> - " . "System error. Please contact to administrator";
		}

		$banks = $seller_info['bank_payment_methods'];

		return $banks;
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
		//$base_url = "http://" . $_SERVER['SERVER_NAME'];
		//$url_success = $base_url.'/success';
		//$url_cancel = $base_url.'/cancel';
		$total_amount = str_replace('.', '', $data['total_amount']);

		$params['business']               = strval(EMAIL_BUSINESS);
		$params['bank_payment_method_id'] = intval($data['bank_payment_method_id']);
		$params['transaction_mode_id']    = '1'; // 2- trực tiếp
		$params['escrow_timeout']         = 3;

		$params['order_id']      = $data['order_id'];
		$params['total_amount']  = $total_amount;
		$params['shipping_fee']  = '0';
		$params['tax_fee']       = '0';
		$params['currency_code'] = 'VND'; // USD

		$params['url_success'] = $data['url_success'];
		$params['url_cancel']  = $data['url_cancel'];
		$params['url_detail']  = '';

		$params['order_description'] = 'Thanh toán đơn hàng từ Website ' . $data['web_url'] . ' với mã đơn hàng ' . $data['order_id'];
		$params['payer_name']        = $data['payer_name'];
		$params['payer_email']       = $data['payer_email'];
		$params['payer_phone_no']    = $data['payer_phone_no'];
		$params['payer_address']     = $data['address'];

		$call_restfull = new CallRestful();
		$result        = json_decode($call_restfull->call_API("POST", $params, BAOKIM_API_PAY_BY_CARD), true);

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
	public function createRequestUrl($data) {

		$total_amount = str_replace('.', '', $data['total_amount']);
		//$currency = 'VND'; // USD
		// Mảng các tham số chuyển tới baokim.vn
		$sercure_pass = $data['sercure_pass'];
		unset($data['sercure_pass']);
		$params = array(
			'merchant_id'       => strval($data['merchant_id']),
			'order_id'          => strval($data['order_id']),
			'business'          => strval($data['business']),
			'total_amount'      => strval($total_amount),
			'shipping_fee'      => strval('0'),
			'tax_fee'           => strval('0'),
			'order_description' => strval('Thanh toán đơn hàng từ Website ' . $data['web_url'] . ' với mã đơn hàng ' . $data['order_id']),
			'url_success'       => strtolower($data['url_success']),
			'url_cancel'        => strtolower($data['url_cancel']),
			'url_detail'        => strtolower(''),
			'payer_name'        => strval($data['payer_name']),
			'payer_email'       => strval($data['payer_email']),
			'payer_phone_no'    => strval($data['payer_phone_no']),
			'shipping_address'  => strval($data['address']),
			'currency'          => strval($data['currency']),
		);
		ksort($params);
		$params['checksum'] = hash_hmac('SHA1', implode('', $params), $sercure_pass);

		//Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào
		$redirect_url = BAOKIM_URL . BAOKIM_API_PAYMENT;
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
	public function verifyResponseUrl($url_params = array()) {
		if (empty($url_params['checksum'])) {
			echo "invalid parameters: checksum is missing";
			return FALSE;
		}

		$checksum = $url_params['checksum'];
		unset($url_params['checksum']);

		ksort($url_params);

		if (strcasecmp($checksum, hash_hmac('SHA1', implode('', $url_params), SECURE_PASS)) === 0) {
			return TRUE;
		} else {
			return FALSE;
		}

	}
	public function generateBankImage($banks, $payment_method_type) {
		$return = array();
		if (is_array($banks)) {
			foreach ($banks as $bank) {
				//$file_headers = @get_headers($bank['logo_url']);
				//if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
				if ($bank['payment_method_type'] == $payment_method_type) {
					$arr      = explode('/', $bank['logo_url']);
					$img_name = array_pop($arr);
					$img_name = str_replace('.png', '.gif', $img_name);

					$return[] = array(
						'id'       => $bank['id'],
						'logo_url' => $img_name,
						'title'    => $bank['name'],
					);
				}
				//}
			}
		}

		return $return;
	}
	public function getPaymentMethod($type = 'BAOKIM', $key = null) {
		if ($type == 'BAOKIM') {
			$methods = array(
				8 =>'Chuyển khoản qua ngân hàng (Tùy chọn)',
				7 => 'Thanh toán tại nhà',
				1 => 'Thanh toán bằng thẻ ngân hàng nội địa',
				6 => 'Thanh toán bằng Ví điện tử Bảo Kim',
				2 => 'Thanh toán bằng thẻ quốc tế Visa/Master card',
				3 => 'Thanh toán bằng internet Banking',
				4 => 'Chuyển khoản tại máy ATM',
				5 => 'Chuyển khoản tại quầy giao dịch Ngân hàng',
			);
			if ($key != null) {
				return $methods[$key];
			}
		}
		return $methods;
	}
}