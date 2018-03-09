<?php

/**
 * Logistics_Order
 *
 * @category   	Logistics Api
 * @copyright  	http://nhanh.vn
 * @license    	http://nhanh.vn/license/
 */
class Logistics_Order {

	const TYPE_SHIPPING = 'Shipping';
	const TYPE_SHOPPING = 'Shopping';

	const STATUS_NEW 	 			= 'New';
	const STATUS_CONFIRMED 			= 'Confirmed';
	const STATUS_STORE_CONFIRMED 	= 'StoreConfirmed';

	const PAYMENT_METHOD_COD 	 = 'COD';
	const PAYMENT_METHOD_STORE 	 = 'Store';
	const PAYMENT_METHOD_GATEWAY = 'Gateway';
	const PAYMENT_METHOD_ONLINE  = 'Online';

	const SHIP_FEE_BY_SENDER 	= "Sender";
	const SHIP_FEE_BY_RECEIVER 	= "Receiver";

	/**
	 * @var int
	 */
	protected $autoSend;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $trafficSource;

	/**
	 * @var string
	 */
	protected $code;

	/**
	 * @var string
	 */
	protected $accessDevice;

	/**
	 * @var int
	 */
	protected $depotId;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $customer;

	/**
	 * @var array
	 */
	protected $productList;

	/**
	 * @var int
	 */
	protected $moneyTransfer;

	/**
	 * @var string
	 */
	protected $paymentId;

	/**
	 * @var string
	 */
	protected $paymentMethod;

	/**
	 * @var string
	 */
	protected $paymentGateway;

	/**
	 * @var string
	 */
	protected $paymentCode;

	/**
	 * @var double
	 */
	protected $carrierId;

	/**
	 * @var double
	 */
	protected $carrierServiceId;

	/**
	 * @var double
	 */
	protected $shipFeeBy;

	/**
	 * @var double
	 */
	protected $shipFee;

	/**
	 * @var double
	 */
	protected $codFee;

	/**
	 * @var double
	 */
	protected $customerShipFee;

	/**
	 * @var string
	 */
	protected $deliveryDate;

	/**
	 * @var int
	 */
	protected $status;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $attachedPrintLink;

	/**
	 * @var string
	 */
	protected $fromName;

	/**
	 * @var string
	 */
	protected $fromMobile;

	/**
	 * @var string
	 */
	protected $fromEmail;

	/**
	 * @var string
	 */
	protected $fromAddress;

	/**
	 * @var string
	 */
	protected $fromCityName;

	/**
	 * @var string
	 */
	protected $fromDistrictName;

	/**
	 * @var int
	 */
	protected $weight;

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
	 * @var int
	 */
	protected $serviceType;

	/**
	 * @return the $fromName
	 */
	public function getFromName() {
		return $this->fromName;
	}

	/**
	 * @param string $fromName
	 */
	public function setFromName($fromName) {
		$this->fromName = $fromName;
	}

	/**
	 * @return the $fromMobile
	 */
	public function getFromMobile() {
		return $this->fromMobile;
	}

	/**
	 * @param string $fromMobile
	 */
	public function setFromMobile($fromMobile) {
		$this->fromMobile = $fromMobile;
	}

	/**
	 * @return the $fromEmail
	 */
	public function getFromEmail() {
		return $this->fromEmail;
	}

	/**
	 * @param string $fromEmail
	 */
	public function setFromEmail($fromEmail) {
		$this->fromEmail = $fromEmail;
	}

	/**
	 * @return the $fromAddress
	 */
	public function getFromAddress() {
		return $this->fromAddress;
	}

	/**
	 * @param string $fromAddress
	 */
	public function setFromAddress($fromAddress) {
		$this->fromAddress = $fromAddress;
	}

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
	}

	/**
	 * @return the $autoSend
	 */
	public function getAutoSend() {
		return $this->autoSend;
	}

	/**
	 * @param number $autoSend
	 */
	public function setAutoSend($autoSend) {
		$this->autoSend = $autoSend;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return the $trafficSource
	 */
	public function getTrafficSource() {
		return $this->trafficSource;
	}

	/**
	 * @param number $trafficSource
	 */
	public function setTrafficSource($trafficSource) {
		$this->trafficSource = $trafficSource;
		return $this;
	}

	/**
     * @return the $accessDevice
     */
    public function getAccessDevice() {
        return $this->accessDevice;
    }

	/**
     * @param string $accessDevice
     */
    public function setAccessDevice($accessDevice) {
        $this->accessDevice = $accessDevice;
    }

	/**
	 * @return the $depotId
	 */
	public function getDepotId() {
		return $this->depotId;
	}

	/**
	 * @param number $depotId
	 */
	public function setDepotId($depotId) {
		$this->depotId = $depotId;
		return $this;
	}

	/**
	 * @return the $code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param string $code
	 */
	public function setCode($code) {
		$this->code = $code;
		return $this;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * @return Logistics_Customer
	 */
	public function getCustomer() {
		return $this->customer;
	}

	/**
	 * @param string $customer
	 */
	public function setCustomer($customer) {
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @return the $productList
	 */
	public function getProductList() {
		return $this->productList;
	}

	/**
	 * @param array $productList
	 */
	public function setProductList($productList) {
		$this->productList = $productList;
		return $this;
	}

	/**
	 * @return the $moneyTransfer
	 */
	public function getMoneyTransfer() {
		return $this->moneyTransfer;
	}

	/**
	 * @param int $moneyTransfer
	 */
	public function setMoneyTransfer($moneyTransfer) {
		$this->moneyTransfer = $moneyTransfer;
		return $this;
	}

	/**
     * @return the $paymentId
     */
    public function getPaymentId() {
        return $this->paymentId;
    }

	/**
     * @param string $paymentId
     */
    public function setPaymentId($paymentId) {
        $this->paymentId = $paymentId;
    }

	/**
	 * @return the $paymentMethod
	 */
	public function getPaymentMethod() {
		return $this->paymentMethod;
	}

	/**
	 * @param string $paymentMethod
	 */
	public function setPaymentMethod($paymentMethod) {
		$this->paymentMethod = $paymentMethod;
		return $this;
	}

	/**
	 * @return the $paymentGateway
	 */
	public function getPaymentGateway() {
		return $this->paymentGateway;
	}

	/**
	 * @param string $paymentGateway
	 */
	public function setPaymentGateway($paymentGateway) {
		$this->paymentGateway = $paymentGateway;
		return $this;
	}

	/**
	 * @return the $paymentCode
	 */
	public function getPaymentCode() {
		return $this->paymentCode;
	}

	/**
	 * @param string $paymentCode
	 */
	public function setPaymentCode($paymentCode) {
		$this->paymentCode = $paymentCode;
		return $this;
	}

	/**
	 * @return the $carrierId
	 */
	public function getCarrierId() {
		return $this->carrierId;
	}

	/**
	 * @param number $carrierId
	 */
	public function setCarrierId($carrierId) {
		$this->carrierId = $carrierId;
	}

	/**
	 * @return the $carrierServiceId
	 */
	public function getCarrierServiceId() {
		return $this->carrierServiceId;
	}

	/**
	 * @param number $carrierServiceId
	 */
	public function setCarrierServiceId($carrierServiceId) {
		$this->carrierServiceId = $carrierServiceId;
	}

	/**
	 * @return the $codFee
	 */
	public function getCodFee() {
		return $this->codFee;
	}

	/**
	 * @param number $codFee
	 */
	public function setCodFee($codFee) {
		$this->codFee = $codFee;
	}

	/**
	 * @return the $shipFeeBy
	 */
	public function getShipFeeBy() {
		return $this->shipFeeBy;
	}

	/**
	 * @param number $shipFeeBy
	 */
	public function setShipFeeBy($shipFeeBy) {
		$this->shipFeeBy = $shipFeeBy;
	}

	/**
	 * @return the $shipFee
	 */
	public function getShipFee() {
		return $this->shipFee;
	}

	/**
	 * @param number $shipFee
	 */
	public function setShipFee($shipFee) {
		$this->shipFee = $shipFee;
		return $this;
	}

	/**
	 * @return the $customerShipFee
	 */
	public function getCustomerShipFee() {
		return $this->customerShipFee;
	}

	/**
	 * @param number $customerShipFee
	 */
	public function setCustomerShipFee($customerShipFee) {
		$this->customerShipFee = $customerShipFee;
	}

	/**
	 * @return the $prePaid
	 */
	public function getPrePaid() {
		return $this->prePaid;
	}

	/**
	 * @param number $prePaid
	 */
	public function setPrePaid($prePaid) {
		$this->prePaid = $prePaid;
		return $this;
	}

	/**
	 * @return the $deliveryDate
	 */
	public function getDeliveryDate() {
		return $this->deliveryDate;
	}

	/**
	 * @param string $deliveryDate
	 */
	public function setDeliveryDate($deliveryDate) {
		$this->deliveryDate = $deliveryDate;
		return $this;
	}

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param int $status
	 */
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return the $attachedPrintLink
	 */
	public function getAttachedPrintLink() {
		return $this->attachedPrintLink;
	}

	/**
	 * @param string $attachedPrintLink
	 */
	public function setAttachedPrintLink($attachedPrintLink) {
		$this->attachedPrintLink = $attachedPrintLink;
		return $this;
	}

	/**
	 * @return the $weight
	 */
	public function getWeight() {
		return $this->weight;
	}

	/**
	 * @param number $weight
	 */
	public function setWeight($weight) {
		$this->weight = $weight;
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
	 * @return array
	 */
	public function toArray()
	{
		return array(
			"id" => trim($this->getId()),
			"trafficSource" => trim($this->getTrafficSource()),
		    "accessDevice" => trim($this->getAccessDevice()),
			"depotId" => trim($this->getDepotId()),
			"type" => trim($this->getType()),
			"status" => trim($this->getStatus()),
			"moneyTransfer" => trim($this->getMoneyTransfer()),
		    "paymentId" => trim($this->getPaymentId()),
			"paymentMethod" => trim($this->getPaymentMethod()),
			"paymentGateway" => trim($this->getPaymentGateway()),
			"paymentCode" => trim($this->getPaymentCode()),
			"carrierId" => trim($this->getCarrierId()),
			"carrierServiceId" => trim($this->getCarrierServiceId()),
			"codFee" => trim($this->getCodFee()),
			"shipFeeBy" => trim($this->getShipFeeBy()),
			"shipFee" => trim($this->getShipFee()),
			"customerShipFee" => trim($this->getCustomerShipFee()),
			"deliveryDate" => trim($this->getDeliveryDate()),
			"description" => trim($this->getDescription()),
			"attachedPrintLink" => trim($this->getAttachedPrintLink()),
			"autoSend" => trim($this->getAutoSend()),
			"fromName" => trim($this->getFromName()),
			"fromEmail" => trim($this->getFromEmail()),
			"fromAddress" => trim($this->getFromAddress()),
			"fromMobile" => trim($this->getFromMobile()),
			"fromCityName" => trim($this->getFromCityName()),
			"fromDistrictName" => trim($this->getFromDistrictName()),
			"weight" => trim($this->getWeight()),
			"width" => trim($this->getWidth()),
			"height" => trim($this->getHeight()),
			"length" => trim($this->getLength()),
			"serviceType" => trim($this->getServiceType())
		);
	}

	/**
	 * @return array
	 */
	public function prepareData()
	{
		if(!is_array($this->getProductList()) || !count($this->getProductList())) {
			throw new Exception("Product list is required");
		}
		$products = array();
		foreach($this->getProductList() as $product) {
			/* @var $product Logistics_Product */
			$products[] = $product->toArray();
		}
		return array_merge(
			$this->toArray(),
			$this->getCustomer()->toArray(),
			array('productList' => json_encode($products))
		);
	}
}