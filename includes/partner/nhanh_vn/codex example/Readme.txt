NHANH.VN - PHP API VERSION 0.1.6
-------------------------------

* Giới thiệu
* Yêu cầu hệ thống

GIỚI THIỆU
----------

Các tính năng đồng bộ với hệ thống Nhanh.vn chia thành 2 phần:

1. send: Merchant gửi request sang Nhanh.vn
- storeAdd.php: Gửi thông tin gian hàng
- productAdd.php: Gửi thông tin sản phẩm 
- productDetail.php: Lấy thông tin sản phẩm theo id sản phẩm của Nhanh.vn 
	(Dùng trong tình huống sản phẩm được bắn từ Nhanh.vn sang merchant, bên merchant lưu id sản phẩm của Nhanh)
- orderAdd.php: Gửi thông tin đơn hàng
- orderUpdate.php: Cập nhật thông tin đơn hàng (Cập nhật thông tin chuyển khoản, trạng thái đơn hàng)
- shippingCarrier.php: Lấy danh sách các hãng vận chuyển từ Nhanh.vn

- shippingFee.php: Lấy bảng giá vận chuyển từ Nhanh.vn
- shippingTracking.php: Lấy rhông tin lịch trình đơn hàng bên Nhanh.vn
- shippingPickup.php: Lấy thông tin phiếu gửi đơn hàng bên nhanh.vn

2. listen: nhanh gửi request sang merchant
Merchant cần implement các chắc năng bên dưới và gửi url của các chức năng cho Nhanh.vn cập nhật cài đặt của merchant
- inventory.php: Nhận thông tin tồn kho từ Nhanh.vn gửi sang
- orderStatus.php: Nhận trạng thái đơn hàng bên Nhanh.vn gửi sang
- productAdd.php: Nhận thông tin sản phẩm do Nhanh.vn gửi sang
- resendOrderPayment.php: Nhận thông tin kiểm tra tình trạng thanh toán của đơn hàng do Nhanh.vn gửi sang
	(Dùng trong tình huống khi CSKH xử lý đơn trên Nhanh.vn, 
	khách báo đã chuyển khoản nhưng trên Nhanh chưa nhận được thông tin này, 
	nếu nhận được request này thì merchant check nếu có thông tin chuyển khoản thì gửi lại 1 request 
	sang nhanh theo api send/orderUpdate.php)
	
YÊU CẦU HỆ THỐNG
----------------

- PHP: enable curl extension
- Khi triển khai trên môi trường thật, merchant cần cung cấp các địa chỉ IP servers cho bên Nhanh
	(Môi trường test thì không cần)
- Trong file Config.php có 1 biến đánh dấu môi trường
	const APP_ENV = 'testing';
	// const APP_ENV = 'production';
	
