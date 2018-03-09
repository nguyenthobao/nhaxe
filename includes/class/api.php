<?php
/**
 * @Project BNC v2 -> api
 * @File /includes/class/api.php 
 * @author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 10/01/2014, 10:06 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Api{
	private $db,$r;
	private $username = 'bncsysapi';
	private $pass     = 'bncsysapi';
	public function __construct(){
		global $_B;				
		$this->r   = $_B['r'];
		if (!(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == $this->username && $_SERVER['PHP_AUTH_PW'] == $this->pass)) {
		    header("WWW-Authenticate: Basic realm=\"dev3.webbnc.vn\"");
		    header("HTTP/1.0 401 Unauthorized");
		    echo 'Dien thong tin tai khoan va mat khau de truy cap'; 
		    exit();
		}
	}
	//đồng bộ tỉnh thành từ nhanh.vn
	public function updateProvince(){
		die();
		$idbnc   = "01,79,48,31,22,56,89,77,06,24,95,27,83,74,70,60,52,96,92,04,64,02,35,42,30,93,17,33,91,62,12,68,20,10,80,36,40,37,58,25,54,44,49,51,45,94,14,72,34,19,38,46,82,84,08,86,26,15,66,67,11,75,87";
		$idnhanh = "2,3,65,32,21,17,4,5,14,7,70,6,13,8,10,11,9,24,15,25,26,27,28,30,31,68,33,34,35,36,37,38,39,20,40,23,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,19,56,57,58,59,60,61,62,67,71,22,64";
		$name = "Hà Nội,Hồ Chí Minh,Đà Nẵng,Hải Phòng,Quảng Ninh,Khánh Hòa,An Giang,Bà Rịa - Vũng Tàu,Bắc Cạn,Bắc Giang,Bạc Liêu,Bắc Ninh,Bến Tre,Bình Dương,Bình Phước,Bình Thuận,Bình Định,Cà Mau,Cần Thơ,Cao Bằng,Gia Lai,Hà Giang,Hà Nam,Hà Tĩnh,Hải Dương,Hậu Giang,Hoà Bình,Hưng Yên,Kiên Giang,Kon Tum,Lai Châu,Lâm Đồng,Lạng Sơn,Lào Cai,Long An,Nam Định,Nghệ An,Ninh Bình,Ninh Thuận,Phú Thọ,Phú Yên,Quảng Bình,Quảng Nam,Quảng Ngãi,Quảng Trị,Sóc Trăng,Sơn La,Tây Ninh,Thái Bình,Thái Nguyên,Thanh Hoá,Thừa Thiên Huế,Tiền Giang,Trà Vinh,Tuyên Quang,Vĩnh Long,Vĩnh Phúc,Yên Bái,Đắc Lắc,Đắc Nông,Điện Biên,Đồng Nai,Đồng Tháp";
		$idbnc = explode(',',$idbnc);
		$idnhanh = explode(',',$idnhanh);
		$name = explode(',',$name);
		$pro = new Model('address_province');
		foreach ($idbnc as $key => $value) {
			// $pro[$value] = array(
			// 		'nhanh_id' => $idnhanh[$key],
			// 		'name' => $name[$key],
			// 	);
			$pro->where('provinceid',$value);
			$pro->update(array('nhanh_id'=>$idnhanh[$key],'nhanh_name'=>$name[$key]));
		}
	}
	//đồng bộ tỉnh thành từ nhanh.vn
	public function updateDistrict(){
		die();
		$idbnc = "001,007,002,003,006,005,008,004,009,268,271,277,018,274,250,282,280,272,275,016,276,278,020,279,019,281,273,017,269,760,769,773,774,775,778,776,763,766,765,764,768,777,767,762,785,787,787,783,784,786,771,772,761,770,883,887,884,886,889,892,893,894,890,891,888,747,748,750,755,752,754,751,753,256,261,263,264,259,262,260,258,213,219,223,217,218,220,216,222,221,215,718,724,725,721,720,722,723,540,542,549,544,543,548,545,547,550,551,546,688,690,689,691,696,693,697,694,692,695,593,594,596,601,597,598,599,595,602,600,829,836,835,831,832,834,838,833,837,058,061,063,065,064,066,062,060,923,917,916,919,918,925,926,927,924,568,569,572,570,574,575,573,571,576,474,479,481,583,476,482,478,477,080,085,086,087,082,083,088,084,089,196,194,193,205,195,202,198,201,204,199,00,203,206,200,207,731,732,739,740,742,734,738,737,735,741,736,356,365,366,358,362,361,363,359,364,360,964,966,972,969,971,973,967,968,970,040,043,042,048,045,051,052,050,049,053,044,046,047,622,624,627,632,639,633,628,635,625,630,637,629,638,634,626,631,623,024,026,031,034,032,027,029,035,030,033,028,347,352,349,350,353,351,446,443,444,439,447,448,442,445,441,440,436,437,296,295,297,293,292,291,299,294,300,298,288,290,308,304,305,307,303,306,309,312,313,314,311,315,316,318,317,148,156,153,154,151,157,159,152,155,158,150,323,329,330,331,328,333,332,326,325,327,899,900,911,913,908,909,905,914,906,907,903,902,904,910,912,608,613,614,611,616,617,610,615,612,104,107,00,109,108,106,111,110,672,673,680,683,679,675,676,681,682,674,677,678,178,185,181,183,187,186,188,180,182,184,189,794,803,807,806,808,798,796,799,805,800,804,797,802,801,412,413,414,424,422,425,431,417,431,429,419,415,416,420,421,423,428,418,426,427,369,370,373,374,376,372,375,377,582,584,586,587,585,588,589,227,228,235,231,237,233,236,240,232,238,239,234,230,555,557,563,560,561,562,559,564,558,450,455,457,452,456,454,453,503,502,515,508,512,510,516,519,517,518,511,509,504,513,514,506,507,505,522,535,524,531,533,532,529,530,527,526,525,528,536,534,461,462,468,466,470,465,469,464,467,471,941,941,945,943,946,944,947,948,949,951,950,116,121,125,123,120,122,118,126,127,119,124,703,711,708,707,710,709,705,706,712,336,339,343,338,341,342,344,340,164,165,172,173,168,170,171,167,169,380,381,382,386,390,392,400,399,388,384,401,389,403,402,404,385,387,406,391,398,395,396,407,397,393,394,405,815,816,819,820,821,822,823,824,825,818,842,844,845,848,847,850,846,849,070,073,074,00,072,076,075,855,861,863,857,858,860,862,859,243,244,249,246,253,247,248,252,251,123,133,135,137,139,138,140,136,141,643,644,647,657,648,645,651,646,655,653,649,650,654,656,652,866,868,867,873,877,870,876,875,871,869,874,872,494,490,492,495,491,497,493,498,493,660,662,664,667,661,663,666,665,933,932,936,934,935,930,931,954,959,961,956,957,958,960,094,095,102,097,096,098,099,100,101";
		$idnhanh = "2,6,7,8,5,4,1,3,9,63,10,11,15,16,17,18,19,20,21,22,23,24,25,26,27,28,12,555,697,13,14,30,31,32,33,34,35,41,44,43,42,39,40,45,685,557,686,558,688,689,36,37,38,29,86,87,83,81,82,84,85,88,89,90,700,79,78,73,74,76,77,80,75,108,113,109,567,110,111,112,114,97,99,560,561,98,100,101,562,102,103,128,125,129,123,124,126,127,135,130,131,569,132,133,134,136,137,138,139,144,140,142,145,141,570,571,573,143,572,148,147,574,146,576,577,579,149,578,575,116,115,117,118,119,120,568,121,122,104,563,564,105,565,106,107,566,62,64,59,61,60,167,168,580,169,313,309,314,609,310,311,312,315,608,556,72,65,67,68,69,70,71,332,331,623,624,330,333,334,335,336,423,421,419,418,415,413,414,667,420,422,666,559,424,417,416,190,193,191,194,195,200,196,197,198,199,192,361,358,359,360,362,363,364,365,366,367,150,158,155,151,153,154,156,157,152,161,159,160,582,581,583,162,584,163,585,164,165,166,224,214,591,215,225,216,593,594,219,220,221,222,223,592,217,218,213,227,226,595,596,597,228,229,598,230,231,232,237,233,234,235,236,599,239,238,243,244,245,600,248,247,246,240,241,242,249,250,252,254,255,256,257,258,259,260,253,251,52,47,48,49,46,50,51,261,601,263,603,264,265,602,262,275,280,276,273,604,277,278,279,703,281,274,283,282,284,605,285,606,607,286,287,288,298,294,297,300,289,290,291,611,292,293,295,296,299,301,610,612,305,306,613,307,308,302,303,304,316,321,702,317,318,319,614,320,340,338,337,615,339,342,343,616,341,617,618,619,327,322,323,620,324,326,328,621,622,329,325,351,344,346,345,347,350,352,353,354,355,356,357,348,349,389,377,387,375,376,378,380,381,382,383,625,626,627,384,385,386,388,628,390,379,371,372,368,629,369,370,630,631,374,632,633,634,373,635,636,398,394,640,392,393,637,638,639,395,396,397,399,391,402,400,643,645,644,646,401,641,642,404,403,405,647,648,649,650,407,410,652,653,656,657,651,661,408,409,658,659,660,411,412,654,406,655,430,425,662,428,429,663,431,664,432,665,433,701,427,426,437,440,434,438,439,668,669,441,436,435,448,451,442,443,444,445,446,447,449,670,450,458,452,671,453,672,454,455,456,457,459,460,468,461,462,463,464,465,466,467,469,486,483,484,485,487,488,489,482,493,492,674,675,676,677,490,673,491,510,495,508,494,496,497,498,499,500,501,502,503,679,680,504,505,506,507,509,511,512,513,514,515,516,517,678,474,473,471,470,681,472,683,682,684,475,525,518,519,520,521,522,523,524,480,476,477,690,478,479,481,532,526,527,528,529,530,531,533,538,536,534,535,691,692,540,537,539,544,542,693,541,543,694,695,696,545,172,183,170,173,587,174,175,176,177,178,179,180,181,588,182,201,204,208,202,203,206,205,207,209,210,211,212,56,57,54,58,55,586,53,171,699,188,589,590,189,184,185,186,187,266,267,268,269,272,271,270,91,92,93,94,95,96,66,548,551,549,550,552,553,554,546,547";
		$name = "Quận Ba Đình,Quận Hai Bà Trưng,Quận Hoàn Kiếm,Quận Tây Hồ,Quận Đống Đa,Quận Cầu Giấy,Quận Hoàng Mai,Quận Long Biên,Quận Thanh Xuân,Quận Hà Đông,Huyện Ba Vì,Huyện Chương Mỹ,Huyện Gia Lâm,Huyện Hoài Đức,Huyện Mê Linh,Huyện Mỹ Đức,Huyện Phú Xuyên,Huyện Phúc Thọ,Huyện Quốc Oai,Huyện Sóc Sơn,Huyện Thạch Thất,Huyện Thanh Oai,Huyện Thanh Trì,Huyện Thường Tín,Huyện Từ Liêm,Huyện Ứng Hòa,Huyện Đan Phượng,Huyện Đông Anh,Thị xã Sơn Tây,Quận 1,Quận 2,Quận 4,Quận 5,Quận 6,Quận 7,Quận 8,Quận 9,Quận  Tân Bình,Quận Bình Thạnh,Quận Gò Vấp,Quận Phú Nhuận,Quận Bình Tân,Quận Tân Phú,Quận Thủ Đức,Huyện Bình Chánh,Huyện Cần Giờ,Huyện Cần Giờ,huyện Củ Chi,Huyện Hóc Môn,Huyện Nhà Bè,Quận 10,Quận 11,Quận 12,Quận 3,Thành phố Long Xuyên,Thị xã Tân Châu,Thị xã Châu Đốc,Huyện An Phú,Huyện Châu Phú,Huyện Châu Thành,Huyện Chợ Mới,Huyện Thoại Sơn,Huyện Tịnh Biên,Huyện Tri Tôn,Phú Tân,Thành phố Vũng Tàu,Thị xã Bà Rịa,Huyện Châu Đức,Huyện Côn Đảo,Huyện Long Điền,Huyện Tân Thành,Huyện Xuyên Mộc,Huyện Đất Đỏ,Thành phố Bắc Ninh,Thị xã Từ Sơn,Huyện Gia Bình,Huyện Lương Tài,Huyện Quế Võ,Huyện Thuận Thành,Huyện Tiên Du,Huyện Yên Phong,Thành phố Bắc Giang,Huyện  Lục Ngạn,Huyện Hiệp Hòa,Huyện Lạng Giang,Huyện Lục Nam,Huyện Sơn Động,Huyện Tân Yên,Huyện Việt Yên,Huyện Yên Dũng,Huyện Yên Thế,Thị xã Thủ Dầu Một,Thị xã Dĩ An,Thị xã Thuận An,Huyện Bến Cát,Huyện Dầu Tiếng,Huyện Phú Giáo,Huyện Tân Uyên,Thành phố Qui Nhơn,Huyện An Lão,Huyện An Nhơn,Huyện Hoài Ân,Huyện Hoài Nhơn,Huyện Phù Cát,Huyện Phù Mỹ,Huyện Tây Sơn,Huyện Tuy Phước,Huyện Vân Canh,Huyện Vĩnh Thạnh,Thị xã Phước Long,Thị xã Bình Long,Thị xã Đồng Xoài,Huyện Bù Gia Mập,Huyện Bù Đăng,Huyện Bù Đốp,Huyện Chơn Thành,Huyện Hớn Quản,Huyện Lộc Ninh,Huyện Đồng Phú,Thành phố Phan Thiết,Thị xã La Gi,Huyện Bắc Bình,Huyện Hàm Tân,Huyện Hàm Thuận Bắc,Huyện Hàm Thuận Nam,Huyện Tánh Linh,Huyện Tuy Phong,Huyện đảo Phú Quý,Huyện Đức Linh,Thành phố Bến Tre,Huyện Ba Tri,Huyện Bình Đại,Huyện Châu Thành,Huyện Chợ Lách,Huyện Giồng Trôm,Huyện Mỏ Cày Bắc,Huyện Mỏ Cày Nam,Huyện Thạnh Phú,Thị xã Bắc Kạn,Huyện Ba Bể,Huyện Bạch Thông,Huyện Chợ Mới,Huyện Chợ Đồn,Huyện Na Rì,Huyện Ngân Sơn,Huyện Pác Nặm,Quận Thốt Nốt,Quận Ô môn,Quận Ninh Kiều,Quận Cái Răng,Quận Bình Thủy,Huyện Cờ Đỏ,Huyện Phong Điền,Huyện Thới Lai,Huyện Vĩnh Thạnh,Thành phố Nha Trang,Thành phố Cam Ranh,Thị xã Ninh Hòa,Huyện Cam Lâm,Huyện Diên Khánh,Huyện Khánh Sơn,Huyện Khánh Vĩnh,Huyện Vạn Ninh,Huyện đảo Trường Sa,Thành phố Huế,Thị xã Hương Thủy,Huyện A Lưới,Huyện Nam Đông,Huyện Phong Điền,Huyện Phú Lộc,Huyện Phú Vang,Huyện Quảng Điền,Thành phố Lào Cai,Huyện Bắc Hà,Huyện Bảo Thắng,Huyện Bảo Yên,Huyện Bát Xát,Huyện Mường Khương,Huyện Sa Pa,Huyện Si Ma Cai,Huyện Văn Bàn,Thành phố Uông Bí,Thành phố Móng Cái,Thành phố Hạ Long,Huyện Đông Triều,Thị xã Cẩm Phả,Huyện Ba Chẽ,Huyện Bình Liêu,Huyện Hải Hà,Huyện Hoành Bồ,Huyện Tiên Yên,Huyện Tư Nghĩa,Huyện Vân Đồn,Huyện Yên Hưng,Huyện Đầm Hà,Huyện đảo Cô Tô,Thành phố Biên Hòa,Thị xã Long Khánh,Huyện Cẩm Mỹ,Huyện Long Thành,Huyện Nhơn Trạch,Huyện Tân Phú,Huyện Thống Nhất,Huyện Trảng Bom,Huyện Vĩnh Cửu,Huyện Xuân Lộc,Huyện Định Quán,Thành phố Nam Định,Huyện Giao Thủy,Huyện Hải Hậu,Huyện Mỹ Lộc,Huyện Nam Trực,Huyện Nghĩa Hưng,Huyện Trực Ninh,Huyện Vụ Bản,Huyện Xuân Trường,Huyện Ý Yên,Thành phố Cà Mau,Huyện U Minh,Huyện Phú Tân,Huyện Cái Nước,Huyện Năm Căn,Huyện Ngọc Hiển,Huyện Thới Bình,Huyện Trần Văn Thời,Huyện Đầm Dơi,Thị xã Cao Bằng,Huyện Bảo Lạc,Huyện Bảo Lâm,Huyện Hạ Lang,Huyện Hà Quảng,Huyện Hòa An,Huyện Nguyên Bình,Huyện Phục Hòa,Huyện Quảng Uyên,Huyện Thạch An,Huyện Thông Nông,Huyện Trà Lĩnh,Huyện Trùng Khánh,Thành phố Pleiku,Thị xã Ayun Pa,Huyện Chư Păh,Huyện Chư Prông,Huyện Chư Pưh,Huyện Chư Sê,Huyện Ia Grai,Huyện Ia Pa,Huyện KBang,Huyện Kông Chro,Huyện Krông Pa,Huyện Mang Yang,Huyện Phú Thiện,Huyện Đắk Pơ,Huyện Đăk Đoa,Huyện Đức Cơ,Thị xã An Khê,Thành phố Hà Giang,Huyện Đồng Văn,Huyện Bắc Mê,Huyện Bắc Quang,Huyện Hoàng Su Phì,Huyện Mèo Vạc,Huyện Quản Bạ,Huyện Quang Bình,Huyện Vị Xuyên,Huyện Xín Mần,Huyện Yên Minh,Thành phố Phủ Lý,Huyện Bình Lục,Huyện Duy Tiên,Huyện Kim Bảng,Huyện Lý Nhân,Huyện Thanh Liêm,Huyện Cẩm Xuyên,Huyện Can Lộc,Huyện Hương Khê,Huyện Hương Sơn,Huyện Kỳ Anh,Huyện Lộc Hà,Huyện Nghi Xuân,Huyện Thạch Hà,Huyện Vũ Quang,Huyện Đức Thọ,Thành phố Hà Tĩnh,Thị xã Hồng Lĩnh,Huyện Bình Giang,Huyện Cẩm Giàng,Huyện Gia Lộc,Huyện Kim Thành,Huyện Kinh Môn,Huyện Nam Sách,Huyện Ninh Giang,Huyện Thanh Hà,Huyện Thanh Miện,Huyện Tứ Kỳ,Thành phố Hải Dương,Thị xã Chí Linh,Quận Đồ Sơn,Quận Ngô Quyền,Quận Lê Chân,Quận Kiến An,Quận Hồng Bàng,Quận Hải An,Quận Dương Kinh,Huyện An Dương,Huyện An Lão,Huyện Kiến Thụy,Huyện Thuỷ Nguyên,Huyện Tiên Lãng,Huyện Vĩnh Bảo,Huyện đảo Bạch Long Vĩ,Huyện đảo Cát Hải,Thành phố Hoà Bình,Huyện Mai Châu,Huyện Kim Bôi,Huyện Cao Phong,Huyện Kỳ Sơn,Huyện Lạc Sơn,Huyện Lạc Thủy,Huyện Lương Sơn,Huyện Tân Lạc,Huyện Yên Thủy,Huyện Đà Bắc,Thành phố Hưng Yên,Huyện Ân Thi,Huyện Khoái Châu,Huyện Kim Động,Huyện Mỹ Hào,Huyện Phù Cừ,Huyện Tiên Lữ,Huyện Văn Giang,Huyện Văn Lâm,Huyện Yên Mỹ,Thành phố Rạch Giá,Thị xã Hà Tiên,Huyện đảo Phú Quốc,Huyện U Minh Thượng,Huyện An Biên,Huyện An Minh,Huyện Châu Thành,Huyện Giang Thành,Huyện Giồng Riềng,Huyện Gò Quao,Huyện Hòn Đất,Huyện Kiên Lương,Huyện Tân Hiệp,Huyện Vĩnh Thuận,Huyện đảo Kiên Hải,Thành phố Kon Tum,Huyện Kon Plông,Huyện Kon Rẫy,Huyện Ngọc Hồi,Huyện Sa Thầy,Huyện Tu Mơ Rông,Huyện Đắk Glei,Huyện Đắk Hà,Huyện Đăk Tô,Thị xã Lai Châu,Huyện Mường Tè,Huyện Nậm Nhùn,Huyện Phong Thổ,Huyện Sìn Hồ,Huyện Tam Đường,Huyện Tân Uyên,Huyện Than Uyên,Thành phố Đà Lạt,Thành phố Bảo Lộc,Huyện Bảo Lâm,Huyện Cát Tiên,Huyện Di Linh,Huyện Lạc Dương,Huyện Lâm Hà,Huyện Đạ Huoai,Huyện Đạ Tẻh,Huyện Đam Rông,huyện Đơn Dương,Huyện Đức Trọng,Thành phố Lạng Sơn,Huyện Bắc Sơn,Huyện Bình Gia,Huyện Cao Lộc,Huyện Chi Lăng,Huyện Hữu Lũng,Huyện Lộc Bình,huyện Tràng Định,Huyện Văn Lãng,Huyện Văn Quan,Huyện Đình Lập,Thành phố Tân An,Huyện Bến Lức,Huyện Cần Giuộc,Huyện Cần Đước,Huyện Châu Thành,Huyện Mộc Hóa,Huyện Tân Hưng,Huyện Tân Thạnh,Huyện Tân Trụ,Huyện Thạnh Hóa,Huyện Thủ Thừa,Huyện Vĩnh Hưng,Huyện Đức Hòa,Huyện Đức Huệ,Thành phố Vinh,Thị xã Cửa Lò,Thị xã Thái Hòa,Huyện Anh Sơn,Huyện Con Cuông,Huyện Diễn Châu,Huyện Hưng Nguyên,Huyện Kỳ Sơn,Huyện Nam Đàn,Huyện Nghi Lộc,Huyện Nghĩa Đàn,Huyện Quế Phong,Huyện Quỳ Châu,Huyện Quỳ Hợp,Huyện Quỳnh Lưu,Huyện Tân Kỳ,Huyện Thanh Chương,Huyện Tương Dương,Huyện Yên Thành,Huyện Đô Lương,Thành phố Ninh Bình,Thị xã Tam Điệp,Huyện Gia Viễn,Huyện Hoa Lư,Huyện Kim Sơn,Huyện Nho Quan,Huyện Yên Khánh,Huyện Yên Mô,Thành phố Phan Rang-Tháp Chàm,Huyện Bác Ái,Huyện Ninh Hải,Huyện Ninh Phước,Huyện Ninh Sơn,Huyện Thuận Bắc,Huyện Thuận Nam,Thành phố Việt Trì,Thị xã Phú Thọ,Huyện Cẩm Khê,Huyện Hạ Hòa,Huyện Lâm Thao,Huyện Phù Ninh,Huyện Tam Nông,Huyện Tân Sơn,Huyện Thanh Ba,Huyện Thanh Sơn,Huyện Thanh Thủy,Huyện Yên Lập,Huyện Đoan Hùng,Thành phố Tuy Hòa,Thị xã Sông Cầu,Huyện Phú Hòa,Huyện Sơn Hòa,Huyện Sông Hinh,Huyện Tây Hòa,Huyện Tuy An,Huyện Đông Hòa,Huyện Đồng Xuân,Thành phố Đồng Hới,Huyện Bố Trạch,Huyện Lệ Thủy,Huyện Minh Hóa,Huyện Quảng Ninh,Huyện Quảng Trạch,Huyện Tuyên Hóa,Thành phố Hội An,Thành phố Tam Kỳ,Huyện Bắc Trà My,Huyện Duy Xuyên,Huyện Hiệp Đức,Huyện Nam Giang,Huyện Nam Trà My,Huyện Nông Sơn,Huyện Núi Thành,Huyện Phú Ninh,Huyện Phước Sơn,Huyện Quế Sơn,Huyện Tây Giang,Huyện Thăng Bình,Huyện Tiên Phước,Huyện Đại Lộc,Huyện Điện Bàn,Huyện Đông Giang,Thành phố Quảng Ngãi,Huyện Ba Tơ,Huyện Bình Sơn,Huyện Minh Long,Huyện Mộ Đức,Huyện Nghĩa Hành,Huyện Sơn Hà,Huyện Sơn Tây,Huyện Sơn Tịnh,Huyện Tây Trà,Huyện Trà Bồng,Huyện Tư Nghĩa,Huyện đảo Lý Sơn,Huyện Đức Phổ,Thành phố Đông Hà,Thị xã Quảng Trị,Huyện Cam Lộ,Huyện Gio Linh,Huyện Hải Lăng,Huyện Hướng Hóa,Huyện Triệu Phong,Huyện Vĩnh Linh,Huyện Đa Krông,Huyện đảo Cồn Cỏ,Thành phố Sóc Trăng,Huyện Châu Thành,Huyện Cù Lao Dung,Huyện Kế Sách,Huyện Long Phú,Huyện Mỹ Tú,Huyện Mỹ Xuyên,Huyện Ngã Năm,Huyện Thạnh Trị,Huyện Trần Đề,Huyện Vĩnh Châu,Thành phố Sơn La,Huyện Bắc Yên,Huyện Mai Sơn,Huyện Mộc Châu,Huyện Mường La,Huyện Phù Yên,Huyện Quỳnh Nhai,Huyện Sông Mã,Huyện Sốp Cộp,Huyện Thuận Châu,Huyện Yên Châu,Thị xã Tây Ninh,Huyện Bến Cầu,Huyện Châu Thành,Huyện Dương Minh Châu,Huyện Gò Dầu,Huyện Hòa Thành,Huyện Tân Biên,Huyện Tân Châu,Huyện Trảng Bàng,Thành phố Thái Bình,Huyện Hưng Hà,Huyện Kiến Xương,Huyện Quỳnh Phụ,Huyện Thái Thụy,Huyện Tiền Hải,Huyện Vũ Thư,Huyện Đông Hưng,Thành phố Thái Nguyên,Thị xã Sông Công,Huyện Phổ Yên,Huyện Phú Bình,Huyện Phú Lương,Huyện Võ Nhai,Huyện Đại Từ,Huyện Định Hóa,Huyện Đồng Hỷ,Thành phố Thanh Hóa,Thị xã Bỉm Sơn,Thị xã Sầm Sơn,Huyện Bá Thước,Huyện Cẩm Thủy,Huyện Hà Trung,Huyện Hậu Lộc,Huyện Hoằng Hóa,Huyện Lang Chánh,Huyện Mường Lát,Huyện Nga Sơn,Huyện Ngọc Lặc,Huyện Như Thanh,Huyện Như Xuân,Huyện Nông Cống,Huyện Quan Hóa,Huyện Quan Sơn,Huyện Quảng Xương,Huyện Thạch Thành,Huyện Thiệu Hóa,Huyện Thọ Xuân,Huyện Thường Xuân,Huyện Tĩnh Gia,Huyện Triệu Sơn,Huyện Vĩnh Lộc,Huyện Yên Định,Huyện Đông Sơn,Thành phố Mỹ Tho,Thị xã Gò Công,Huyện Cái Bè,Huyện Cai Lậy,Huyện Châu Thành,Huyện Chợ Gạo,Huyện Gò Công Tây,Huyện Gò Công Đông,Huyện Tân Phú Đông,Huyện Tân Phước,Thành phố Trà Vinh,Huyện Càng Long,Huyện Cầu Kè,Huyện Cầu Ngang,Huyện Châu Thành,Huyện Duyên Hải,Huyện Tiểu Cần,Huyện Trà Cú,Thành phố Tuyên Quang,Huyện Chiêm Hóa,Huyện Hàm Yên,Huyện Lâm Bình,Huyện Na Hang,Huyện Sơn Dương,Huyện Yên Sơn,Thành phố Vĩnh Long,Huyện Bình Minh,Huyện Bình Tân,Huyện Long Hồ,Huyện Mang Thít,Huyện Tam Bình,Huyện Trà Ôn,Huyện Vũng Liêm,Thành phố Vĩnh Yên,Thị xã Phúc Yên,Huyện Bình Xuyên,Huyện Lập Thạch,Huyện Sông Lô,Huyện Tam Dương,Huyện Tam Đảo,Huyện Vĩnh Tường,Huyện Yên Lạc,Thành phố Yên Bái,Thị xã Nghĩa Lộ,Huyện Lục Yên,Huyện Mù Căng Chải,Huyện Trạm Tấu,Huyện Trấn Yên,Huyện Văn Chấn,Huyện Văn Yên,Huyện Yên Bình,Thành phố Buôn Ma Thuột,Thị xã Buôn Hồ,Huyện Buôn Đôn,Huyện Cư Kuin,Huyện Cư Mgar,Huyện Ea H'leo,Huyện Ea Kar,Huyện Ea Súp,Huyện Krông Ana,Huyện Krông Bông,Huyện Krông Búk,Huyện Krông Năng,Huyện Krông Pắk,Huyện Lăk,Huyện M'Đrăk,Thành phố Cao Lãnh,Thị xã Hồng Ngự,Thị xã Sa Đéc,Huyện Cao Lãnh,Huyện Châu Thành,Huyện Hồng Ngự,Huyện Lai Vung,Huyện Lấp Vò,Huyện Tam Nông,Huyện Tân Hồng,Huyện Thanh Bình,Huyện Tháp Mười,Quận Ngũ Hành Sơn,Quận Liên Chiểu,Quận Hải Châu,Quận Cẩm Lệ,Quận Thanh Khê,Huyện Hòa Vang,Huyện Sơn Trà,Huyện đảo Hoàng Sa,Quận Sơn Trà,Thị xã Gia Nghĩa,Huyện Cư Jút,Huyện Krông Nô,Huyện Tuy Đức,Huyện Đăk Glong,Huyện Đăk Mil,Huyện Đăk R'Lấp,Huyện Đăk Song,Huyện Châu Thành,Huyện Châu Thành A,Huyện Long Mỹ,Huyện Phụng Hiệp,Huyện Vị Thủy,Thành phố Vị Thanh,Thị xã Ngã Bảy (Tân Hiệp cũ),Thành phố Bạc Liêu,Huyện Giá Rai,Huyện Hoà Bình,Huyện Hồng Dân,Huyện Phước Long,Huyện Vĩnh Lợi,Huyện Đông Hải,Thành phố Điện Biên Phủ,Thị xã Mường Lay,Huyện Mường Ảng,Huyện Mường Chà,Huyện Mường Nhé,Huyện Tủa Chùa,Huyện Tuần Giáo,Huyện Điện Biên,Huyện Điện Biên Đông";
		$idbnc = explode(',',$idbnc);
		$idnhanh = explode(',',$idnhanh);
		$name = explode(',',$name);
		$pro = new Model('address_district');
		foreach ($idbnc as $key => $value) {
			// $pro[$value] = array(
			// 		'nhanh_id' => $idnhanh[$key],
			// 		'name' => $name[$key],
			// 	);
			$pro->where('districtid',$value);
			$pro->update(array('nhanh_id'=>$idnhanh[$key],'nhanh_name'=>$name[$key]));
		}
	}
	public function getProvince(){
		$pro = new Model('address_province');
		$result = $pro->get(null,null,'*');
		header('Content-Type: application/json');
		echo json_encode($result);
		exit();
	}
	public function getDistrict(){
		$id = $this->r->get_int('id','GET');
		$dis = new Model('address_district');
		$dis->where('provinceid',$id);
		$result = $dis->get(null,null,'*');
		header('Content-Type: application/json');
		echo json_encode($result);
		die();
	}

	public function getWard(){
		$iddis = $this->r->get_int('id','GET');
		$ward = new Model('address_ward');
		$ward->where('districtid',$iddis);
		$result = $ward->get(null,null,'*');
		header('Content-Type: application/json');
		echo json_encode($result);
		die();
	}

	public function getProvinceByID(){
		$id = $this->r->get_string('id','GET');
		$pro = new Model('address_province');
		$pro->where('provinceid',$id);
		$result = $pro->getOne(null,'*');
		header('Content-Type: application/json');
		echo json_encode($result);
		die();
	}
	public function getDistrictByID(){
		$id = $this->r->get_string('id','GET');
		$dis = new Model('address_district');
		$dis->where('districtid',$id);
		$result = $dis->getOne(null,'*');
		header('Content-Type: application/json');
		echo json_encode($result);
		die();
	}

}