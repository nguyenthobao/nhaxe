<?php

/**
 * Logistics_Service
 *
 * @category   	Logistics library
 * @copyright  	http://nhanh.vn
 * @license    	http://nhanh.vn/license/
 */
class Logistics_Service {

	/**
	 * The server will use this parameter to process your request
	 */
	const SERVICE_VERSION = '0.1.6'; // please DO NOT change or remove this value

	/**
	 * @var Logistics_Config
	 */
	protected $config;

	/**
	 * @var string
	 */
	protected $requestUri;

	/**
	 * @return Logistics_Config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param Logistics_Config $config
	 */
	public function setConfig($config) {
		$this->config = $config;
		return $this;
	}

	/**
	 * @return the $requestUri
	 */
	public function getRequestUri() {
		return $this->requestUri;
	}

	/**
	 * @param string $requestUri
	 */
	public function setRequestUri($requestUri) {
		$this->requestUri = $requestUri;
		return $this;
	}

	/**
	 * @param Logistics_Config $config
	 * @param string $requestUri
	 */
	public function __construct($config, $requestUri) {
		$this->setConfig($config);
		$this->setRequestUri($requestUri);
	}

	/**
	 * @return array
	 */
	public function getServiceParams() {
		return array('serviceVersion' => self::SERVICE_VERSION);
	}

	/**
	 * @return boolean
	 */
	public function checkServiceParams()
	{
		if(!function_exists('curl_init')) {
			echo "curl extension is required to process your request";
			return false;
		}
		if(!self::SERVICE_VERSION) {
			echo "service version is required";
			return false;
		}
		if(!$this->getRequestUri()) {
			echo "request uri is required";
			return false;
		}
		return $this->getConfig()->isValid();
	}

	/**
	 * @return array
	 */
	public function preparePostFields($data)
	{
		$dataJson = json_encode($data);
		$postFields = array(
			'data' => $dataJson,
			'checksum' => $this->getConfig()->createChecksum($dataJson)
		);
		return array_merge(
			$this->getServiceParams(),
			$this->getConfig()->toArray(),
			$postFields
		);
	}

	/**
	 * @return stdClass
	 */
	public function sendRequest($data)
	{
		if(!$this->checkServiceParams()) {
			return false;
		}

		$curl = curl_init($this->getRequestUri());
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->preparePostFields($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$curlResult = curl_exec($curl);

		if(curl_error($curl) == "") {
			$response = json_decode($curlResult);
		} else {
			$response = new stdClass();
			$response->code = 0;
			$response->messages = array(curl_error($curl));
		}
		curl_close($curl);

		return $response;
	}
}