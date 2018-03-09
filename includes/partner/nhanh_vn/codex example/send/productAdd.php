<title>Logistics | Add product</title>
<?php
/**
 * Gửi thông tin sản phẩm sang nhanh.vn: (Hỗ trợ tối đa 200 sản phẩm 1 lần gửi sang)
 * - nếu id chưa tồn tại thì nhanh.vn sẽ insert bản ghi mới
 * - nếu id đã tồn tại thì nhanh.vn sẽ cập nhật thông tin
 */
header('Content-type: text/html; charset=utf-8');

require_once '../Config.php';
require_once '../Service.php';
require_once '../Product.php';

$productList = array();

// product's information
$product1 = new Logistics_Product();
// $product1->setIdNhanh($idNhanh); // dùng trong tình huống mà đồng bộ 2 chiều với VG (bắn sp từ nhanh sang VG, sửa bên VG thì lại bắn lại thay đổi về nhanh theo idNhanh)
$product1->setId(125186155);
$product1->setCategoryId(1); // optional
$product1->setBaseCategoryId(1); // optional (id danh mục bên nhanh.vn)
$product1->setCode("P0131"); // optional
$product1->setName("Product 131");
$product1->setCategoryId(675); // optional: id of product category id
$product1->setImportPrice(120000); // optional
$product1->setPrice(150000);
$product1->setType(Logistics_Product::TYPE_PRODUCT); // optional
$product1->setAddToApproveList(true);
// $product1->setSaleAccount("cucre_kd_huynv"); // optional

// optional: weight (gram)
// $product1->setShippingWeight(); // used for calculating shipping fee

// optional: product's image
$product1->setImage("http://imgcr.vatgia.vn/pictures/phagia/medium/medium_uje1355456611.jpg");
// other product images
$product1->addImage("http://imgcr.vatgia.vn/pictures/phagia/medium/medium_arn1358241429.jpg");

$productList[] = $product1->toArray();

$product2 = new Logistics_Product();
$product2->setId(125186156);
$product2->setParentId(123453); // optional
$product2->setCode("P0141");
$product2->setName("Product 141");
$product2->setType(Logistics_Product::TYPE_PRODUCT);
$product2->setImportPrice(1300000); // optional
$product2->setPrice(1700000);
$product2->setAddToApproveList(true);
$productList[] = $product2->toArray();

$config = new Logistics_Config(Logistics_Config::APP_ENV);
$config->setStoreId(5); // private storeId, used for website has multiple store account
$requestUri = $config->getUriConstant(Logistics_Config::URI_PRODUCT_ADD);

$service = new Logistics_Service($config, $requestUri);
$result = $service->sendRequest($productList);

if($result->code) {
	echo "<h1>Success!</h1>";
} else {
	echo "<h1>Failed!</h1>";
	// error messages
	foreach ($result->messages as $message) {
		echo "<p>$message</p>";
	}
}