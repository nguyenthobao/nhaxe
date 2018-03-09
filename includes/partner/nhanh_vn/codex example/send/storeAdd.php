<title>Logistics | Add store</title>
<?php
header('Content-type: text/html; charset=utf-8');

require_once '../Config.php';
require_once '../Service.php';
require_once '../Store.php';

$store = new Logistics_Store();
// required information
$store->setId(124);
// $store->setServiceType(Logistics_Store::SERVICE_TYPE_FULFILLMENT);
$store->setName("shopmp3"); // private store name: http://vatgia.com/shopmp3
$store->setDisplayName("Store Name");
$store->setAddress("Store's address");
$store->setCityName("Hà nội");
$store->setDistrictName("Quận Hai Bà Trưng");
$store->setEmail("storemail@store.com");
$store->setMobile("0988999999");
$store->setWebsite("http://example.com");

$config = new Logistics_Config(Logistics_Config::APP_ENV);
$requestUri = $config->getUriConstant(Logistics_Config::URI_STORE_ADD);

$service = new Logistics_Service($config, $requestUri);
$result = $service->sendRequest($store->toArray());

if($result->code) {
	echo "<h1>Success!<h1>";
} else {
	echo "<h1>Failed!</h1>";
	// error messages
	foreach ($result->messages as $message) {
		echo "<p>$message</p>";
	}
}