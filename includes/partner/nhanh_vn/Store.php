<?php

/**
 * Logistics_Store
 *
 * @category   	Logistics library
 * @copyright  	http://nhanh.vn
 * @license    	http://nhanh.vn/license/
 */
class Logistics_Store {

	const SERVICE_TYPE_FULFILLMENT 	= 'fulfillment';
	const SERVICE_TYPE_GOLD 		= 'gold';
	const SERVICE_TYPE_SILVER 		= 'silver';

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var int
	 */
	protected $serviceType;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $displayName;

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
	 * @var string
	 */
	protected $adminEmail;

	/**
	 * @var string
	 */
	protected $mobile;

	/**
	 * @var string
	 */
	protected $website;

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param number $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return the $serviceType
	 */
	public function getServiceType() {
		return $this->serviceType;
	}

	/**
	 * @param number $serviceType
	 */
	public function setServiceType($serviceType) {
		$this->serviceType = $serviceType;
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
	}

	/**
	 * @return the $displayName
	 */
	public function getDisplayName() {
		return $this->displayName;
	}

	/**
	 * @param string $displayName
	 */
	public function setDisplayName($displayName) {
		$this->displayName = $displayName;
		return $this;
	}

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
	 * @return the $adminEmail
	 */
	public function getAdminEmail() {
		return $this->adminEmail;
	}

	/**
	 * @param string $adminEmail
	 */
	public function setAdminEmail($adminEmail) {
		$this->adminEmail = $adminEmail;
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
	 * @return the $website
	 */
	public function getWebsite() {
		return $this->website;
	}

	/**
	 * @param string $website
	 */
	public function setWebsite($website) {
		$this->website = $website;
		return $this;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'id' 			=> trim($this->getId()),
			'serviceType'	=> trim($this->getServiceType()),
			'name' 			=> trim($this->getName()),
			'displayName' 	=> trim($this->getDisplayName()),
			'cityName'		=> trim($this->getCityName()),
			'districtName'	=> trim($this->getDistrictName()),
			'address' 		=> trim($this->getAddress()),
			'email' 		=> trim($this->getEmail()),
			'adminEmail' 	=> trim($this->getAdminEmail()),
			'mobile' 		=> trim($this->getMobile()),
			'website' 		=> trim($this->getWebsite())
		);
	}
}