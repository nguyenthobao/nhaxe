<title>Logistics | listen/productApproved.php</title>
<?php
/**
 * @category Logistics Listener
 *
 * Nhận id sản phẩm đã được duyệt từ bên nhanh.vn gửi sang
 * Json:
 * [
 * 		idNhanh => {idNhanh, id, status...},
 * 		idNhanh => {idNhanh, id, status...}
 * ]
 */

header('Content-type: text/html; charset=utf-8');

require_once '../Service.php';
require_once '../Config.php';
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
	foreach($products as $idNhanh => $status) {
		$id = isset($product->id) ? $product->id : null; // id VG gửi sang Nhanh
		$storeId = $product->storeId; // id gian hàng bên VG
		$idNhanh = isset($product->idNhanh) ? $product->idNhanh : null; // id sp Nhanh gửi sang VG
		/**
		 * $status:
		 * New: Sản phẩm mới được thêm vào danh sách chờ duyệt
		 * Approving: Sản phẩm đang được duyệt
		 * Approved: Sản phẩm đã được duyệt
		 * Deny: Sản phẩm không được duyệt
		 */
	}
	$response->data = $ids; // danh sách ids đã insert vào database => trả về cho nhanh.vn
} else {
	// invalid
	fwrite($fh, "Failed!\n");
	$response->messages = array("Invalid checksum");
}

fwrite($fh, print_r($_POST, true));
fclose($fh);
echo json_encode($response);