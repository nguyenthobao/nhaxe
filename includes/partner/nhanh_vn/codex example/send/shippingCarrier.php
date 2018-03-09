<title>Logistics | Shipping Carriers</title>
<?php
/**
 * Lấy danh sách các hãng vận chuyển từ nhanh.vn
 * Các hãng vận chuyển và dịch vụ vận chuyển có thể thay đổi theo thời gian
 * Kết quả trả về chỉ trả các hãng + dịch vụ đang hoạt động => Mỗi lần get data thì phải check các id cũ
 * có còn nằm trong danh sách này không, nếu
 */

header('Content-type: text/html; charset=utf-8');

require_once '../Service.php';
require_once '../Config.php';

$config = new Logistics_Config();
$requestUri = $config->getUriConstant(Logistics_Config::URI_SHIPPING_CARRIER);

$service = new Logistics_Service($config, $requestUri);
$result = $service->sendRequest($requestUri);

if($result->code) {
	echo "<h1>Success!</h1>";
	echo "<table border='1' cellspacing='0' cellpadding='0'>";
	echo "<tr>";
	echo "<td>ID Hãng vận chuyển</td>";
	echo "<td>Logo</td>";
	echo "<td>Tên hãng</td>";
	echo "<td>Tên đầy đủ</td>";
	echo "<td>Các dịch vụ của hãng</td>";
	echo "</tr>";
	foreach($result->data as $carrier) {
		echo "<tr>";
		echo "<td>{$carrier->id}</td>";
		echo "<td><img width='150px' src='{$carrier->logo}' /></td>";
		echo "<td>{$carrier->name}</td>";
		echo "<td>{$carrier->businessName}</td>";
		echo "<td>";
			if(isset($carrier->services) && count($carrier->services)) {
				echo "<ul>";
				foreach($carrier->services as $cs) {
					// $cs->id, $cs->name, $cs->description
					echo "<li>". $cs->name .' ('. $cs->description .')</li>';
				}
				echo "</ul>";
			}
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
} else {
	echo "<h1>Failed!</h1>";
	// error messages
	foreach ($result->messages as $message) {
		echo "<p>$message</p>";
	}
}