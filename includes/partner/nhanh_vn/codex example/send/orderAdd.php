<title>Logistics | Add order</title>
<?php
/**
 * Gửi thông tin đơn hàng sang nhanh.vn
 * Dùng cả cho tình huống insert và update thông tin đơn hàng
 */
header('Content-type: text/html; charset=utf-8');

require_once '../Config.php';
require_once '../Service.php';
require_once '../Store.php';
require_once '../Order.php';
require_once '../Customer.php';
require_once '../Product.php';

$customer = new Logistics_Customer();
$customer->setName("Customer Name");
$customer->setMobile("0988666999");
$customer->setCityName("Hà Nội");
$customer->setDistrictName("Quận Hoàn Kiếm");
$customer->setAddress("Address");
$customer->setEmail("customer@mail.com");

// product's information
$product1 = new Logistics_Product();
$product1->setId(123456);
// id sản phẩm bên nhanh, dùng trong tình huống nhận sp từ nhanh về, thì khi gửi đơn hàng sang bên nhanh
// dùng id sp của nhanh
$product1->setIdNhanh(16);
$product1->setCode("SP01");
$product1->setName("Product 1");
$product1->setType(Logistics_Product::TYPE_PRODUCT);
$product1->setQuantity(1);
$product1->setImportPrice(120000);
$product1->setPrice(150000);

$productList[] = $product1;

$product2 = new Logistics_Product();
$product2->setId(123457);
$product2->setIdNhanh(521901);
$product2->setCode("SP02");
$product2->setName("Product 2");
$product2->setType(Logistics_Product::TYPE_PRODUCT);
$product2->setQuantity(3);
$product2->setImportPrice(130000);
$product2->setPrice(170000);

$productList[] = $product2;

$order = new Logistics_Order();
// $order->setServiceType(Logistics_Store::SERVICE_TYPE_FULFILLMENT);
$order->setDepotId(1); // id kho hàng bên nhanh.vn (dùng cho cucre.vn tích hợp cả kho hàng)
// $order->setAutoSend(1); // Dùng cho gian hàng click nút Gửi hãng vận chuyển bên quản trị gian hàng VG
// nếu đơn lẻ dùng cái autoSend này thì không setDepotId mà set trực tiếp địa chỉ nhận hàng
$order->setFromName('Tên người gửi');
$order->setFromMobile('0999999999');
$order->setFromEmail('email@domain.com'); // optional
$order->setFromAddress('Địa chỉ người gửi');
$order->setFromCityName('Tên thành phố người gửi');
$order->setFromDistrictName('Tên quận huyện người gửi');

$order->setType(Logistics_Order::TYPE_SHIPPING); // TYPE_SHOPPING | TYPE_SHIPPING
$order->setId(1234567);
$order->setAccessDevice("Desktop"); // optional: Desktop | Mobile | Tablet | Android App | iOS App...
$order->setTrafficSource("www.facebook.com"); // optional
$order->setCustomer($customer);
$order->setProductList($productList);
$order->setDescription("Description"); // optional

/** shipping information: used for $order->setType(Logistics_Order::TYPE_SHIPPING) **/

/**
 * - Thông tin cân nặng (gram) và kích thước gói hàng (đơn vị là cm)
 * - Hàng cồng kềnh được tính theo công thức: $w = chiều dài * chiều rộng * chiều cao / 6000
 * - Cân nặng này ($w) so với cân nặng khai báo (setWeight) nếu giá trị nào
 * lớn hơn thì hãng vận chuyển sẽ theo giá trị đó để tính phí
 */
$order->setWeight(300);
$order->setLength(40);
$order->setWidth(20);
$order->setHeight(40);

// carrierId + carrierServiceId + codFee + shipFee get from shippingFee.php
$order->setCarrierId(2); // id hãng vận chuyển
$order->setCarrierServiceId(6); // id dịch vụ vận chuyển (Giao nhanh | Giao thường | Hỏa tốc...)
/**
 * - codFee: Phí thu tiền hộ. Khi đơn hàng cần thu tiền tại nhà, thì hãng vận chuyển sẽ tính phí thu tiền hộ.
 * - shipFee và codFee lấy từ send/shippingFee
 * - customerShipFee là Phí người gửi báo cho người nhận. VD dịch vụ vận chuyển báo shipFee = 20k, codFee = 15k
 * => tổng phí là 35k
 * nhưng người bán chỉ muốn báo người nhận là phí 10k thì gửi sang customerShipFee là 10k thôi
 * (Như vậy tổng thu người nhận chỉ là Tổng giá trị sản phẩm + 10k)
 * - setShipFee: Set người chịu phí là người nhận hay người gửi hay người nhận
 * 	(Nếu ko set thì mặc định là người nhận chịu)
 */
$order->setShipFee(20000);
$order->setCodFee(15000);
$order->setCustomerShipFee(10000);
// $order->setDeliveryDate("2014-07-18"); // format yyyy-MM-dd and must be greater than or equals current date


/** Gửi đơn hàng sang nhanh.vn **/

$config = new Logistics_Config();
// $config->setStoreId(2335458); // private storeId, used for website has multiple store account
$requestUri = $config->getUriConstant(Logistics_Config::URI_ORDER_ADD);

$service = new Logistics_Service($config, $requestUri);
$result = $service->sendRequest($order->prepareData());

if($result->code) {
	echo "<h1>Success!<h1>";
} else {
	echo "<h1>Failed!</h1>";
	// error messages
	foreach ($result->messages as $message) {
		echo "<p>$message</p>";
	}
}