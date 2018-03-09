<title>Logistics | listen/productAdd.php</title>
<?php
/**
 * @category Logistics Listener
 *
 * Nhận thông tin sản phẩm do nhanh.vn gửi sang
 * Json:
 * [
 * 		idNhanh => {idNhanh, categoryId, code, name, image, images, price, status...},
 * 		idNhanh => {idNhanh, categoryId, code, name, image, images, price, status...}
 * ]
 *
 * Trong đó:
 * - idNhanh: id sản phẩm bên nhanh
 * - parentId: id sản phẩm cha
 * - categoryId: id danh mục bên VG
 * - code: mã sản phẩm
 * - name: tên sản phẩm
 * - image: ảnh đại diện
 * - images: array các ảnh khác của sản phẩm đó
 * - price: giá bán
 * - vat: VAT (cần cộng thêm cho giá sản phẩm để hiện thị lên website)
 * - advantages: ưu điểm (đặc điểm nổi bật)
 * - description: mô tả ngắn
 * - content: bài viết chi tiết
 * - status: trạng thái của sản phẩm có thể là 1 trong 2 trạng thái sau:
 *      + Active: Đang bán => Hiển thị trên website
 *      + Inactive: Ngừng bán => Khổng hiển thị trên website
 * - inventory: [ // Tồn kho, tham khảo thêm các khái niemj về tồn ở listen/inventory.php
 *      available: Số Tồn có thể bán => Số hiện trên website (= remain - shipping - hold - damaged)
 *      remain: Tổng tồn,
 *      shipping: Tổng đang giao hàng
 *      hold: Tổng đang tạm giữ
 *      damaged: Tổng bị sản phẩm lỗi
 *      depots: [ // Tồn theo từng kho
 *      	depotId => [available:, remain: ...],
 *      	...
 *      ]
 * ]
 * chú ý nếu inventory là null | mảng rỗng thì cập nhật số tồn | có thể bán về 0
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
	// valid
	fwrite($fh, "Success\n");
	$response->code = 1;

	$products = json_decode($data);
	$ids = []; // lưu các ids để sẽ trả dữ liệu lại cho nhanh trong tình huống thêm mới sp
	foreach($products as $productId => $product) {
		$id = $product->id; // id VG gửi sang nhanh
		$idNhanh = isset($product->idNhanh) ? $product->idNhanh : null; // id sp nhanh bắn sang
		$code = $product->code;
		$categoryId = $product->categoryId;
		$parentId = $product->parentId;
		$name = $product->name;
		$image = $product->image;
		$images = isset($product->images) ? $product->images : array();
		$price = $product->price;
		$previewLink = $product->previewLink;
		$status = $product->status;
		$advantages = $product->advantages;
		$description = $product->description;
		$content = $product->content;
		$shippingWeight = $product->shippingWeights;
		$width = $product->width;
		$length = $product->length;
		$height = $product->height;
		$vat = $product->vat;
		$createdDateTime = $product->createdDateTime;
		$inventory = $product->inventory;

		$attributes = $product->attributes;
		if(isset($attributes->color)) { // Màu sắc
			$colorValue = $attributes->color->value;
		}
		if(isset($attributes->size)) { // Kích cỡ
			$sizeValue = $attributes->size->value;
		}
		/**
		 * @todo check productId is existed, insert and update into database
		 * to get $id and uncomment $ids[$productId] = $id;
		 */
		// $ids[$productId] = $id;
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