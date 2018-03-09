<?php
/**
 * Nhận thông tin tồn kho từ nhanh.vn gửi sang.
 * Các khái niệm về số tồn:
 * - remain: tổng tồn
 * - shipping: số lượng đang giao hàng
 * - hold: số lượng đang tạm giữ
 * - damaged: số lượng hàng lỗi
 * - availabel: số có thể bán => dùng số này để hiện lên website cho đặt hàng
 *
 * available = remain - shipping - damaged - hold
 * VD:
 * - Còn tồn 10 nhưng đang chuyển hàng mất 2 cái, 2 cái trong kho bị lỗi,
 * 			3 cái tạm giữ do khách đặt rồi (chưa xác nhận), thì số Có thể bán chỉ còn là 10 - 2 - 2 - 3 = 5
 * - Nếu xác nhận đơn hàng xong thì 3 cái tạm giữ có thể sẽ chuyển thành số đang chuyển hàng,
 * 		hoặc khách hủy thì sẽ về 0
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

	$products = json_decode($data);
	if(!is_array($products) || !count($products)) {
		// sp ko có tồn, cần cập nhật số lượng về 0
	}
	foreach($products as $product) {
		$id 		= $product->id;
		// dùng trong tình huống nhận thông tin sp từ nhanh về thì cập nhật số tồn theo id sp bên nhanh
		$idNhanh 	= $product->idNhanh;
		// tồn tổng các kho cộng lại
		$remain 	= $product->remain;
		$shipping 	= $product->shipping;
		$damaged 	= $product->damaged;
		$hold 		= $product->hold;
		$available 	= $product->available;
		// tồn theo từng kho nếu doanh nghiệp có nhiều kho
		if(isset($product->depots)) {
			foreach($product->depots as $depotId => $inventory) {
				$remain 	= $inventory->remain;
				$shipping 	= $inventory->shipping;
				$damaged 	= $inventory->damaged;
				$hold 		= $inventory->hold;
				$available 	= $inventory->available;
			}
		}
	}
} else {
	// invalid
	fwrite($fh, "Failed!\n");
	$response->messages = array("Invalid checksum");
}

fwrite($fh, print_r($_POST, true));
fclose($fh);

echo json_encode($response);