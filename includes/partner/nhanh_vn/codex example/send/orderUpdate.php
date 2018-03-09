<title>Logistics | Update order</title>
<?php
/**
 * Gửi cập nhật thông tin đơn hàng sang nhanh.vn, các thông tin có thể cập nhật:
 * - Trạng thái đơn hàng: Khi CSKH xác nhận, Khi gian hàng xác nhận đơn hàng
 * - Trạng thái thanh toán: khi nhận được xác nhận từ cổng thanh toán
 */
header('Content-type: text/html; charset=utf-8');

require_once '../Config.php';
require_once '../Service.php';
require_once '../Order.php';
require_once '../Customer.php';
require_once '../Product.php';

$order = new Logistics_Order();
$order->setId(1234567);
$order->setCode("CR2473505736C"); // optional

// Thông tin thanh toán
$order->setPaymentId("123456"); // optional
$order->setPaymentCode("F0A99717A40A48"); // optional
$order->setPaymentGateway("Baokim"); // optional (name of pament gateway)
$order->setMoneyTransfer(500000); // optional
$order->setDescription("Description"); // optional

/**
 * Trạng thái đơn hàng:
 * - Logistics_Order::STATUS_CONFIRMED : Trạng thái khi CSKH xác nhận đơn hàng
 * - Logistics_Order::STATUS_STORE_CONFIRMED : Trạng thái khi gian hàng xác nhận đơn hàng
 */
$order->setStatus(Logistics_Order::STATUS_CONFIRMED);

$config = new Logistics_Config();
$config->setStoreId(7); // private storeId, used for website has multiple store account
$requestUri = $config->getUriConstant(Logistics_Config::URI_ORDER_UPDATE);

$service = new Logistics_Service($config, $requestUri);
$result = $service->sendRequest($order->toArray());

if($result->code) {
	echo "<h1>Success!<h1>";
} else {
	echo "<h1>Failed!</h1>";
	// error messages
	foreach ($result->messages as $message) {
		echo "<p>$message</p>";
	}
}