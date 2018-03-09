<title>Logistics | Shipping Fee</title>
<?php
/**
 * Lấy bảng giá vận chuyển từ nhanh.vn
 * 1. Required params:
 * - Tên Thành phố + quận huyện của người gửi
 * - Tên Thành phố + quận huyện của người nhận
 * - Thông tin khối lượng của đơn hàng (shippingWeight) hoặc danh sách productIds các sản phẩm của đơn hàng
 *  (productIds này dùng cho các site sử dụng toàn bộ dịch vụ quản lý kho và có sẵn khối lượng của sản phẩm
 *  trên nhanh.vn, shippingWeight là tổng khối lượng sản phẩm (tính cả vỏ hộp) của đơn hàng)
 *  (Nếu dùng shippingWeight để tính phí thì không cần truyền thêm storeId $config->setStoreId)
 * 2. Optional params:
 * - codMoney: Tổng tiền cần thu hộ (Không bao gồm cước phí vận chuyển và phí thu tiền hộ,
 * thường chỉ tính theo tổng của số lượng sản phẩm * giá sản phẩm trong đơn hàng).
 * Nếu đơn hàng đã chuyển khoản hoặc chỉ phát hàng không cần thu tiền thì ko cần param này
 * 3. Hàng cồng kềnh:
 * - Thông tin cân nặng shippingWeight (đơn vị là gram) và kích thước gói hàng (đơn vị là cm)
 * - Hàng cồng kềnh được tính theo công thức: $w = chiều dài * chiều rộng * chiều cao / 6000
 * - Cân nặng này ($w) so với cân nặng khai báo (setShippingWeight) nếu giá trị nào
 * lớn hơn thì hãng vận chuyển sẽ theo giá trị đó để tính phí
 */

header('Content-type: text/html; charset=utf-8');

require_once '../Service.php';
require_once '../Config.php';
require_once '../Shipment.php';

$shipment = new Logistics_Shipment();
$shipment->setFromCityName('TP. HCM');
$shipment->setFromDistrictName('Quận 3');
$shipment->setToCityName('Hà nội');
$shipment->setToDistrictName('Hoàn Kiếm');
$shipment->setCodMoney(4950000); // tổng tiền thu hộ KHÔNG bao gồm phí vận chuyển + phí thu tiền hộ

// array(productId => quantity)
// $shipment->setProductIds(array(21420 => 1, 23199 => 1));
$shipment->setShippingWeight(3000);


$config = new Logistics_Config();
/**
 * Nếu dùng shippingWeight để tính phí thì không cần truyền thêm storeId
 * storeId chỉ dùng cho các website mô hình sàn, có nhiều gian hàng con
 */
// $config->setStoreId(5);
$requestUri = $config->getUriConstant(Logistics_Config::URI_SHIPPING_FEE);

$service = new Logistics_Service($config, $requestUri);
$result = $service->sendRequest($shipment->prepareData());

if($result->code) {
	echo "<h1>Success!</h1>";
	echo "<table border='1' cellspacing='0' cellpadding='0'>";
	echo "<tr>";
	echo "<td>ID Hãng vận chuyển</td>";
	echo "<td>Tên Hãng vận chuyển</td>";
	echo "<td>ID dịch vụ vận chuyển</td>";
	echo "<td>Tên dịch vụ vận chuyển</td>";
	echo "<td>Mô tả dịch vụ</td>";
	echo "<td>Phí vận chuyển</td>";
	echo "<td>Phí thu tiền hộ</td>";
	echo "<td>Tổng cước</td>";
	echo "</tr>";
	foreach($result->data as $rate) {
		echo "<tr>";
		echo "<td>{$rate->carrierId}</td>";
		echo "<td>{$rate->carrierName}</td>";
		echo "<td>{$rate->serviceId}</td>";
		echo "<td>{$rate->serviceName}</td>";
		echo "<td>{$rate->serviceDescription}</td>";
		echo "<td>{$rate->shipFee}</td>";
		echo "<td>{$rate->codFee}</td>";
		echo "<td>". ($rate->shipFee + $rate->codFee) ."</td>";
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