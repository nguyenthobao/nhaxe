<?php
/**
 * listen/orderStatus.php
 *
 * Nhận trạng thái đơn hàng bên nhanh.vn gửi sang
 */
require_once '../Config.php';
require_once '../Service.php';
require_once '../Order.php';
require_once '../Customer.php';
require_once '../Product.php';

$storeId = isset($_POST['storeId']) ? $_POST['storeId'] : '';
$data = isset($_POST['data']) ? $_POST['data'] : '';
$checksum = isset($_POST['checksum']) ? $_POST['checksum'] : '';

$logFile = "orderStatus_" . date('Ymd-His') . ".log";
$fh = fopen($logFile, 'w') or die("can't open file");

$response = new stdClass();
$response->code = 0;

$config = new Logistics_Config();
if($config->isValidChecksum($data, $checksum)) {
	// valid
	fwrite($fh, "Success\n");
	$response->code = 1;

	// @todo update order status to your database:
	$orders = json_decode($data);
	foreach($orders as $orderId => $order) {
		$type = $order->type;
		/**
		 * $type's values: Loại đơn hàng
		 *
		 * Shipping: Chuyển hàng
		 * Shopping: Mua tại quầy
		 * Deposit: Đơn đặt cọc
		 * Trial: Đơn dung thử
		 * Temporary: Đơn đặt nhanh (CSKH sẽ bổ sung thông tin sau)
		 */

		$shipFee = $order->shipFee; // if type = Shipping
		$status = $order->status;

		/**
		 * $status's values: Trạng thái đơn hàng
			* New         => Mới
			* Confirming  => Đang xác nhận
			* Confirmed   => Đã xác nhận
			* Packing     => Đang đóng gói sản phẩm
			* ChangeDepot => Đổi kho xuất hàng
			* Pickup      => Chờ đi nhận
			* Pickingup   => Đang đi nhận
			* Pickedup    => Đã nhận hàng
			* Shipping    => Đang giao hàng
			* Success     => Thành công
			* Failed      => Thất bại (Không liên lạc được khách)
			* Canceled    => Khách hủy
			* Aborted     => Hệ thống hủy (Gọi nhiều lần không được / sai thông tin...)
			* SoldOut     => Hết hàng
			* Returning   => Đang chuyển hoàn
			* Returned    => Đã chuyển hoàn
		 */

		$reason = $order->reason;

		/**
			* $reason's values: Lý do đơn hàng
			* Same                 => 'Đơn trùng'
			* WrongProduct         => 'Đặt nhầm sản phẩm'
			* HighShipFee          => 'Phí vận chuyển cao'
			* NotTransfer          => 'Không muốn chuyển khoản'
			* CannotCall           => 'Không gọi được khách'
			* CustomerCancel       => 'Khách không muốn mua nữa',
			* CustomerNotAtHome    => 'Khách hàng đi vắng'
			* Bought               => 'Đã mua tại quầy',
			* WaitingTranfer       => 'Chờ chuyển khoản'
			* Soldout              => 'Hết hàng'
			* NotPleasureDeliverer => 'Khách hàng không hài lòng về NVVC',
			* ShippingLongTime     => 'Thời gian giao hàng lâu',
			* WrongAddress         => 'Sai địa chỉ giao hàng',
			* CannotWaitShipping   => 'Không chờ giao hàng được',
			* Other                => 'Lý do khác',
		 */

		$productList = $order->productList;
		foreach($productList as $productId => $product) {
			$price = $product->price;
			$quantity = $product->quantity;
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