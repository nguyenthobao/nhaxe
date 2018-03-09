<?php
/**
 * @Project BNC v2 -> Controller
 * @File includes/class/payment.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 23/12/2014, 03:28 [PM]
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
//cấu hình cho trang thegioitructuyen.vn//
//mật khẩu website : 9f596c05487a10d8
//Tên miềnhttp://thegioitructuyen.vn/
//Mã website : 17946
//define('EMAIL_BUSINESS','huongnb6869@gmail.com');//Email Bảo kim
//define('MERCHANT_ID','17946');                // Mã website tích hợp
//define('SECURE_PASS','9f596c05487a10d8');   // Mật khẩu
//Ket thuc cấu hình cho trang thegioitructuyen.vn//

//trang kho dien may
// define('EMAIL_BUSINESS','huongnb6869@gmail.com');//Email Bảo kim
// define('MERCHANT_ID','17950');                // Mã website tích hợp
// define('SECURE_PASS','4c5dcf4b997d77f7');   // Mật khẩu
//Ket thuc cấu hình cho trang thegioitructuyen.vn//



//CẤU HÌNH TÀI KHOẢN (Configure account)
// define('EMAIL_BUSINESS','huongnb6869@gmail.com');//Email Bảo kim
// define('MERCHANT_ID','15915');                // Mã website tích hợp
// define('SECURE_PASS','1bb45eec75a1c3ef');   // Mật khẩu

// Cấu hình tài khoản tích hợp
define('API_USER','nbhbnc');  //API USER
define('API_PWD','N0kfXMVCYLl1xFre00pu1DsZ142BQ');       //API PASSWORD
define('PRIVATE_KEY_BAOKIM','-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDQF0ckBIdX9pUs
hjHX7bEx3Xnub6eTAJ8rS9UhuYHG4As28kGtWRoPTKDCLy6jNJMkqZBySFQU/9oq
I1ryBVRwEb6wpC0VzAAwOyADIB1mxrRXGeeTCc2wnlXqecOPk1lLnyfwfuTQnG+h
5OzQ0J7xr/0ZcoFJYc+E3FiRkp/tNJCrYX9j+NalQlj/uxLhKCtl1dhLhU15HWXi
ToNT15hoOUuyPjBs7UKmoGcRCIocjuBCBh5289u2oJ6RfY+kHVtfAcJqPN+q1tky
7V46PcF1YSm7YIZw94n4eJmM4S6u9L7BrECzWhnAq+MAA65X43GyVzYZsCdxTuhR
H4IcBdzvAgMBAAECggEALL3Eiwb6PryC6HbWArJVlf4juFODeUT59Coy4jRrpeII
J0FBQ89TnhSAwB+67FZiiNB4gUnx4i38r3C4ni7tL8dw87PpCbW6GKStxl5CVBXH
Mq8cLm4+LopsuKSDmrw4x9ypjrkJ45yvF+UL0f35HsgTKESJbci9ALkLxgj7n9l5
DHuYMPAmuNpD24gpMUjVx2/wb1w0JYj9ikuLNvsv91Zks87KazZzV/rXa22t4+e9
wuWaxTHQMdShF60M5BHQsysci8vQ+kB46PirR3vrdoCxpZpDkuxQE1Yrjk8gQjCB
DjCuV9Ae1EzaD7Rv/6zR+mUcoSg2F/QSfhXIRaRTEQKBgQD1iDz09i6Z0BKz8bKJ
vZT2dRAwotToTL5bWcfvN3CQHVaOvvKQD/PHC+Fsb5niYw86omrTRrhyRasOMv7N
wurMDSCKJFYYiLAvYMRMEoaXZ0qYThU1x3URvWO3u6psoFzLzjkZaVDnXUd/sZbq
5MmXiGyct5d99HtpsUXhjmVLSQKBgQDY9mcA+yoKrAAWUMM/17mFawuaQ5MZi9by
M6B58KXEIt/CA/beziSe7sSV54Vp1cYuA693P6Cr0GWfjTzjr/ybLwBYnPRDKZwY
kA5cJirpQvikreG4vbbPg7FvOa77JvFGWI60Pin+8rRDrz/N0j+FHf8uwKS/gPch
o8BLhWLudwKBgQDs00zghngqei0gDbhE7Wy6T+2ey+CKdEODv1R+oz3ac8Hii8FR
PWHIkugK/JY0a5Hr328kfGk6J4K3fm6RLznkOaEyPZwhq+4stKyCJ7hUXxfvUhlZ
NxrvUnrVZJkcj40SM8aVgSS9FRb6zuOfi6/6jmccvmTL474KEygxSHThqQKBgQCU
XWtysE6/nX8xw2jBb7PeGKWGiE8/WPFUDxneSUISLgb1leBr3GwOgxjLqdcB2L39
GWgUE967n3be9KZ+zQng1PNXpX0jsICeC2TGfxM5ECMX+hAxVQp+PYBInxmZhbfY
cxajCx+MyEudPWpURUJKtYibYAFJM9fLmT8WZdCRYQKBgQDlmeK/2QpzBr0SwmDe
h8EKtQN1Hr4IFd7B1J+tFshQSE9lLxR9AJ1+g+O3+2DSDTDEX7/boYQxC9N0ZXND
cp1qpem/XFBp/ZqSkcYnO4KoJ6D0Uz7EsxZatDKIeCC9IHAlJf/SqsfxvzHaNXu2
Tfb7aq+zvMUe4Qny595CxHrOxw==
-----END PRIVATE KEY-----');
define('BAOKIM_API_SELLER_INFO','/payment/rest/payment_pro_api/get_seller_info');
define('BAOKIM_API_PAY_BY_CARD','/payment/rest/payment_pro_api/pay_by_card');
define('BAOKIM_API_PAYMENT','/payment/order/version11');

define('BAOKIM_URL','https://www.baokim.vn');
//define('BAOKIM_URL','http://kiemthu.baokim.vn');


?>