<?php

/**
 * Logistics_Config
 *
 * @category   	Logistics library
 * @copyright  	http://nhanh.vn
 * @license    	http://nhanh.vn/license/
 */
class Logistics_Config {

	/**
	 * application environment
	 * @var string
	 */
 	const APP_ENV = 'testing';
//  	const APP_ENV = 'production';

	const URI_STORE_ADD			= 1;
	const URI_ORDER_ADD			= 2;
	const URI_ORDER_UPDATE		= 3;
	const URI_ORDER_CANCEL		= 4;
	const URI_PRODUCT_ADD		= 5;
	const URI_PRODUCT_STATUS	= 6;
	const URI_PRODUCT_DELETE	= 7;
	const URI_PRODUCT_DETAIL	= 8;
	const URI_SHIPPING_FEE		= 9;
	const URI_SHIPPING_TRACKING	= 10;
	const URI_SHIPPING_CARRIER	= 11;
	const URI_SHIPPING_PICKUP	= 12;

	/**
	 * @var array
	 */
	protected $apiAccounts = array(
		'testing' => array(
			'host' 			=> 'http://vanck.dev.nhanh.vn',
			'merchantId'    => 2509,
			'apiUsername' 	=> 'webbnc.net',
			'apiPassword' 	=> '5e6r7tuhfbdvatwq3e45rydhgsfaweff',
			'shareKey'		=> 'dryfugdbserytujgfdsw5e67rtujgnbv',
		),
		'production' => array(
			'host' 			=> 'https://nhanh.vn',
			'merchantId'    => 2509,
			'apiUsername' 	=> 'webbnc.net',
			'apiPassword' 	=> '5e6r7tuhfbdvatwq3e45rydhgsfaweff',
			'shareKey'		=> 'dryfugdbserytujgfdsw5e67rtujgnbv',
		),
// 		'testing' => array(
// 			'host' 			=> 'http://vanck.dev.nhanh.vn',
// 			'merchantId'    => 4,
// 			'apiUsername' 	=> 'vatgia.com',
// 			'apiPassword' 	=> 'pd9aiman17d0aus716epcka8hf41apms',
// 			'shareKey'		=> '9bkaufhqo8d6ay2mchay1635ayaso19d',
// 		),
// 		'production' => array(
// 			'host' 			=> 'https://nhanh.vn',
// 			'merchantId'    => 4,
// 			'apiUsername' 	=> 'vatgia.com',
// 			'apiPassword' 	=> 'pd9aiman17d0aus716epcka8hf41apms',
// 			'shareKey'		=> '9bkaufhqo8d6ay2mchay1635ayaso19d',
// 		),
	);

	/**
	 * @var array
	 */
	protected $uris = array(
		self::URI_STORE_ADD			=> '/api/store/add',
		self::URI_ORDER_ADD			=> '/api/order/add',
		self::URI_ORDER_UPDATE		=> '/api/order/update',
		self::URI_ORDER_CANCEL		=> '/api/order/cancel',
		self::URI_PRODUCT_ADD 		=> '/api/product/add',
		self::URI_PRODUCT_DETAIL	=> '/api/product/detail',
		self::URI_PRODUCT_STATUS 	=> '/api/product/status',
		self::URI_PRODUCT_DELETE 	=> '/api/product/delete',
		self::URI_SHIPPING_FEE		=> '/api/shipping/fee',
		self::URI_SHIPPING_TRACKING => '/api/shipping/trackingframe',
		self::URI_SHIPPING_CARRIER 	=> '/api/shipping/carrier',
		self::URI_SHIPPING_PICKUP 	=> '/api/shipping/pickupframe',
	);

	/**
	 * @var string
	 */
	protected $staging;

	/**
	 * for available locale, please see http://nhanh.vn/system/resource/locales
	 * @link http://nhanh.vn/system/resource/locales
	 * @var string
	 */
	protected $locale = 'vi_VN';

	/**
	 * @var int
	 */
	protected $merchantId;

	/**
	 * @var string
	 */
	protected $apiUsername;

	/**
	 * @var string
	 */
	protected $apiPassword;

	/**
	 * @var string
	 */
	protected $shareKey;

	/**
	 * @var int
	 */
	protected $storeId;

	/**
	 * @return the $staging
	 */
	public function getStaging() {
		return $this->staging;
	}

	/**
	 * @param string $staging
	 */
	public function setStaging($staging) {
		$this->staging = $staging;
		return $this;
	}

	/**
	 * @return the $locale
	 */
	public function getLocale() {
		return $this->locale;
	}

	/**
	 * @param string $locale
	 */
	public function setLocale($locale) {
		$this->locale = $locale;
		return $this;
	}

	/**
	 * @return the $merchantId
	 */
	public function getMerchantId() {
		return $this->merchantId;
	}

	/**
	 * @param number $merchantId
	 */
	public function setMerchantId($merchantId) {
		$this->merchantId = $merchantId;
		return $this;
	}

	/**
	 * @return the $storeId
	 */
	public function getStoreId() {
		return $this->storeId;
	}

	/**
	 * @param number $storeId
	 */
	public function setStoreId($storeId) {
		$this->storeId = $storeId;
		return $this;
	}

	/**
	 * @return the $apiUsername
	 */
	public function getApiUsername() {
		return $this->apiUsername;
	}

	/**
	 * @param string $apiUsername
	 */
	public function setApiUsername($apiUsername) {
		$this->apiUsername = $apiUsername;
		return $this;
	}

	/**
	 * @return the $apiPassword
	 */
	public function getApiPassword() {
		return $this->apiPassword;
	}

	/**
	 * @param string $apiPassword
	 */
	public function setApiPassword($apiPassword) {
		$this->apiPassword = $apiPassword;
		return $this;
	}

	/**
	 * @return the $shareKey
	 */
	public function getShareKey() {
		return $this->shareKey;
	}

	/**
	 * @param string $shareKey
	 */
	public function setShareKey($shareKey) {
		$this->shareKey = $shareKey;
		return $this;
	}

	/**
	 * constructor
	 * @param string $staging local | testing | production
	 */
	public function __construct($staging = self::APP_ENV)
	{
		$this->setStaging($staging);

		$this->setApiUsername($this->apiAccounts[$staging]['apiUsername']);
		$this->setApiPassword($this->apiAccounts[$staging]['apiPassword']);
		$this->setMerchantId($this->apiAccounts[$staging]['merchantId']);
		$this->setShareKey($this->apiAccounts[$staging]['shareKey']);
	}

	/**
	 * get uri
	 * @param string $uriConstant
	 * @return string
	 */
	public function getUriConstant($uriConstant, $data = null)
	{
		$uri = $this->apiAccounts[$this->getStaging()]['host'] . $this->uris[$uriConstant];
		if(is_array($data) && count($data)) {
			foreach($data as $key => $val) {
				$data[$key] = $key .'='. $val;
			}
			$uri .= '?'. implode('&', $data);
		}
		return $uri;
	}

	/**
	 * validate checksum
	 * @return boolean
	 */
	public function createChecksum($data)
	{
		$combinedKey = md5($this->getApiPassword() . $this->getShareKey());
		$accessKey = md5($combinedKey . $data);
		return md5($accessKey . $data);
	}

	/**
	 * validate checksum
	 * @return boolean
	 */
	public function isValidChecksum($data, $checksum) {
		return $this->createChecksum($data) == $checksum;
	}

	/**
	 * validate configs
	 * @return boolean
	 */
	public function isValid()
	{
		if(!$this->getMerchantId()) {
			echo 'merchantId is required';
			return false;
		}
		if(!$this->getApiUsername()) {
			echo 'apiUsername is required';
			return false;
		}
		if(!$this->getApiPassword()) {
			echo 'apiPassword is required';
			return false;
		}
		if(!$this->getShareKey()) {
			echo 'shareKey is required';
			return false;
		}
		return true;
	}

	/**
	 * convert config to array
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'merchantId' => trim($this->getMerchantId()),
			'apiUsername' => trim($this->getApiUsername()),
			'storeId' => trim($this->getStoreId()),
			'locale' => trim($this->getLocale())
		);
	}
}