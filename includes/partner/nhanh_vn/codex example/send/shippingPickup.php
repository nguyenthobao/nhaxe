<title>Logistics | Shipping Tracking</title>
<?php
/**
 * send/shippingPickup.php
 * Hiện thông tin phiếu gửi đơn hàng bên nhanh.vn
 */
header('Content-type: text/html; charset=utf-8');

require_once '../Service.php';
require_once '../Config.php';
require_once '../Shipment.php';

$config = new Logistics_Config();
$data = array(
	'merchantId' => $config->getMerchantId(),
	'storeId' => 1882416, // id của gian hàng
	'privateId' => 818265 // id của đơn hàng
);
$data['checksum'] = $config->createChecksum(implode('', $data));

$requestUri = $config->getUriConstant(Logistics_Config::URI_SHIPPING_PICKUP, $data);
echo '<iframe frameBorder="0" src="'. $requestUri .'" width="100%" height="100%"></iframe>';