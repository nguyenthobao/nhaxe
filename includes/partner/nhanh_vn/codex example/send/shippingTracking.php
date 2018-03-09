<title>Logistics | Shipping Tracking</title>
<?php
/**
 * send/shippingTracking.php
 * Hiện thông tin lịch trình đơn hàng bên nhanh.vn
 */
header('Content-type: text/html; charset=utf-8');

require_once '../Service.php';
require_once '../Config.php';
require_once '../Shipment.php';

$config = new Logistics_Config();
$data = array(
	'merchantId' => $config->getMerchantId(),
	'storeId' => 528496, // id của gian hàng
	'privateId' => 816706 // id của đơn hàng
);
$data['checksum'] = $config->createChecksum(implode('', $data));

$requestUri = $config->getUriConstant(Logistics_Config::URI_SHIPPING_TRACKING, $data);
echo '<iframe frameBorder="0" src="'. $requestUri .'" width="100%" height="100%"></iframe>';