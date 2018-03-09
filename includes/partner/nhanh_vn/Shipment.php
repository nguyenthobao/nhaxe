<?php

/**
 * Logistics_Shipment
 *
 * @category   	Logistics library
 * @copyright  	http://giaonhan.net
 * @license    	http://giaonhan.net/license/
 */
class Logistics_Shipment {

	/**
	 * @var string
	 */
	protected $fromCityName;

	/**
	 * @var string
	 */
	protected $fromDistrictName;

	/**
	 * @var string
	 */
	protected $toCityName;

	/**
	 * @var string
	 */
	protected $toDistrictName;

	/**
	 * @var double
	 */
	protected $shippingWeight;

	/**
	 * @var int
	 */
	protected $width;

	/**
	 * @var int
	 */
	protected $height;

	/**
	 * @var int
	 */
	protected $length;

	/**
	 * @var double
	 */
	protected $codMoney;

	/**
	 * @var array
	 */
	protected $productIds;

	/**
	 * @return the $fromCityName
	 */
	public function getFromCityName() {
		return $this->fromCityName;
	}

	/**
	 * @param string $fromCityName
	 */
	public function setFromCityName($fromCityName) {
		$this->fromCityName = $fromCityName;
		return $this;
	}

	/**
	 * @return the $fromDistrictName
	 */
	public function getFromDistrictName() {
		return $this->fromDistrictName;
	}

	/**
	 * @param string $fromDistrictName
	 */
	public function setFromDistrictName($fromDistrictName) {
		$this->fromDistrictName = $fromDistrictName;
		return $this;
	}

	/**
	 * @return the $toCityName
	 */
	public function getToCityName() {
		return $this->toCityName;
	}

	/**
	 * @param string $toCityName
	 */
	public function setToCityName($toCityName) {
		$this->toCityName = $toCityName;
		return $this;
	}

	/**
	 * @return the $toDistrictName
	 */
	public function getToDistrictName() {
		return $this->toDistrictName;
	}

	/**
	 * @param string $toDistrictName
	 */
	public function setToDistrictName($toDistrictName) {
		$this->toDistrictName = $toDistrictName;
		return $this;
	}

	/**
	 * @return the $codMoney
	 */
	public function getCodMoney() {
		return $this->codMoney;
	}

	/**
	 * @param number $codMoney
	 */
	public function setCodMoney($codMoney) {
		$this->codMoney = $codMoney;
	}

	/**
	 * @return the $shippingWeight
	 */
	public function getShippingWeight() {
		return $this->shippingWeight;
	}

	/**
	 * @param number $shippingWeight
	 */
	public function setShippingWeight($shippingWeight) {
		$this->shippingWeight = $shippingWeight;
		return $this;
	}

	/**
	 * @return the $productIds
	 */
	public function getProductIds() {
		return $this->productIds;
	}

	/**
	 * @param multitype: $productIds
	 */
	public function setProductIds($productIds) {
		$this->productIds = $productIds;
		return $this;
	}

	/**
	 * @param int $productId
	 */
	public function addProductId($productId) {
		$this->productIds[$productId] = $productId;
	}

	/**
	 * @return the $width
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * @param number $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * @return the $height
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * @param number $height
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * @return the $length
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @param number $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	public function prepareData() {
		return array(
			'fromCityName' => trim($this->getFromCityName()),
			'fromDistrictName' => trim($this->getFromDistrictName()),
			'toCityName' => trim($this->getToCityName()),
			'toDistrictName' => trim($this->getToDistrictName()),
			'codMoney' => trim($this->getCodMoney()),
			'productIds' => $this->getProductIds(),
			'shippingWeight' => trim($this->getShippingWeight()),
			'width' => trim($this->getWidth()),
			'height' => trim($this->getHeight()),
			'length' => trim($this->getLength())
		);
	}
}