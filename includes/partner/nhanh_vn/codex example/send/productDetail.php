<title>Logistics | Add product</title>
<?php
/**
 * send/productDetail.php
 *
 * Lấy thông tin sản phẩm từ nhanh.vn
 * request gửi sang là id sản phẩm bên nhanh
 * kết quả trả về là 1 mảng các sản phẩm cha con (nếu sp đó có con)
 */
header('Content-type: text/html; charset=utf-8');

require_once '../Config.php';
require_once '../Service.php';
require_once '../Product.php';


$config = new Logistics_Config(Logistics_Config::APP_ENV);
$requestUri = $config->getUriConstant(Logistics_Config::URI_PRODUCT_DETAIL);

$service = new Logistics_Service($config, $requestUri);
$result = $service->sendRequest(775352); // idNhanh

if($result->code) {
	echo "<h1>Success!</h1>";
	'<pre>'. var_dump($result) .'</pre>';
	// Ngoài các thông số cơ bản của sản phẩm, kết quả trả về có thêm tổng tồn kho,
	// các khái niệm tồn kho tham khảo ở listen/inventory.php
} else {
	echo "<h1>Failed!</h1>";
	// error messages
	foreach ($result->messages as $message) {
		echo "<p>$message</p>";
	}
}