<?php

/**
 * Logistics_Customer
 *
 * @category   	Logistics library
 * @copyright  	http://nhanh.vn
 * @license    	http://nhanh.vn/license/
 */
class Logistics_Customer {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $mobile;

	/**
	 * @var string
	 */
	protected $cityName;

	/**
	 * @var string
	 */
	protected $districtName;

	/**
	 * @var string
	 */
	protected $address;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return the $mobile
	 */
	public function getMobile() {
		return $this->mobile;
	}

	/**
	 * @param string $mobile
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
		return $this;
	}

	/**
	 * @return the $cityName
	 */
	public function getCityName() {
		return $this->cityName;
	}

	/**
	 * @param string $cityName
	 */
	public function setCityName($cityName) {
		$this->cityName = $cityName;
		return $this;
	}

	/**
	 * @return the $districtName
	 */
	public function getDistrictName() {
		return $this->districtName;
	}

	/**
	 * @param string $districtName
	 */
	public function setDistrictName($districtName) {
		$this->districtName = $districtName;
		return $this;
	}

	/**
	 * @return the $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @param string $address
	 */
	public function setAddress($address) {
		$this->address = $address;
		return $this;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return array(
			'customerCityName' => trim($this->getCityName()),
			'customerDistrictName' => trim($this->getDistrictName()),
			'customerName' => trim($this->getName()),
			'customerMobile' => trim($this->getMobile()),
			'customerEmail' => trim($this->getEmail()),
			'customerAddress' => trim($this->getAddress())
		);
	}
}