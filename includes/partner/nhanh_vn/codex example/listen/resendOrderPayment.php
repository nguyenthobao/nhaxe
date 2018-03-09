<?php
/**
 * Nhận request kiểm tra xem đơn hàng đã nhận được thanh toán chưa
 * Nếu đơn hàng đã có tiền thanh toán rồi thì gửi lại 1 request sang nhanh.vn y như
 * tình huống trong send/orderPayment.php
 * (Phần này dùng cho CSKH bấm nút kiểm tra trên nhanh.vn, nhanh sẽ gửi 1 request sang để check
 * lại, vì có thể đơn hàng nhận được tiền chuyển khoản rồi nhưng chưa đồng bộ được sang nhanh.vn)
 */
require_once '../Config.php';
require_once '../Service.php';
require_once '../Order.php';
require_once '../Customer.php';
require_once '../Product.php';

$storeId = isset($_POST['storeId']) ? $_POST['storeId'] : '';
$data = isset($_POST['data']) ? $_POST['data'] : '';
$checksum = isset($_POST['checksum']) ? $_POST['checksum'] : '';

$logFile = "productStatus_" . date('Ymd-His') . ".log";
$fh = fopen($logFile, 'w') or die("can't open file");

$response = new stdClass();
$response->code = 0;

$config = new Logistics_Config();
if($config->isValidChecksum($data, $checksum)) {
	fwrite($fh, "Success\n");
	$response->code = 1;

	$orderId = $data;
	// @todo check if order got payment money, resend order's payment information (/send/orderPayment.php)
} else {
	// invalid
	fwrite($fh, "Failed!\n");
	$response->messages = array("Invalid checksum");
}

fwrite($fh, print_r($_POST, true));
fclose($fh);

echo json_encode($response);