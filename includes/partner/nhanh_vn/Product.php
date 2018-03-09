<?php

/**
 * Logistics_Product
 *
 * @category   	Logistics Api
 * @copyright  	http://nhanh.vn
 * @license    	http://nhanh.vn/license/
 */
class Logistics_Product {

	const TYPE_PRODUCT 	= 'Product';
	const TYPE_VOUCHER 	= 'Voucher';

	const STATUS_ACTIVE 	= 'Active';
	const STATUS_INACTIVE 	= 'Inactive';

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var int
	 */
	protected $idNhanh;

	/**
	 * @var int
	 */
	protected $categoryId;

	/**
	 * @var int
	 */
	protected $baseCategoryId;

	/**
	 * @var string
	 */
	protected $categoryName;

	/**
	 * @var int
	 */
	protected $categoryParentId;

	/**
	 * @var string
	 */
	protected $categoryParentName;

	/**
	 * @var int
	 */
	protected $parentId;

	/**
	 * @var string
	 */
	protected $code;

	/**
	 * @var string
	 */
	protected $barcode;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $image;

	/**
	 * @var array
	 */
	protected $images;

	/**
	 * @var int
	 */
	protected $importPrice;

	/**
	 * @var int
	 */
	protected $price;

	/**
	 * @var int
	 */
	protected $wholesalePrice;

	/**
	 * @var int
	 */
	protected $marketPrice;

	/**
	 * @var int
	 */
	protected $quantity;

	/**
	 * @var double
	 */
	protected $shippingWeight;

	/**
	 * @var string
	 */
	protected $saleAccount;

	/**
	 * @var string
	 */
	protected $startDate;

	/**
	 * @var string
	 */
	protected $endDate;

	/**
	 * @var int
	 */
	protected $warranty;

	/**
	 * @var string
	 */
	protected $status;

	/**
	 * @var string
	 */
	protected $vat;

	/**
	 * @var int
	 */
	protected $countryCode;

	/**
	 * @var int
	 */
	protected $addToApproveList;

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
	 * @return the $idNhanh
	 */
	public function getIdNhanh() {
		return $this->idNhanh;
	}

	/**
	 * @param number $idNhanh
	 */
	public function setIdNhanh($idNhanh) {
		$this->idNhanh = $idNhanh;
	}

	/**
	 * @return the $categoryId
	 */
	public function getCategoryId() {
		return $this->categoryId;
	}

	/**
	 * @param number $categoryId
	 */
	public function setCategoryId($categoryId) {
		$this->categoryId = $categoryId;
		return $this;
	}

	/**
	 * @return the $baseCategoryId
	 */
	public function getBaseCategoryId() {
		return $this->baseCategoryId;
	}

	/**
	 * @param number $baseCategoryId
	 */
	public function setBaseCategoryId($baseCategoryId) {
		$this->baseCategoryId = $baseCategoryId;
	}

	/**
     * @return the $categoryName
     */
    public function getCategoryName() {
        return $this->categoryName;
    }

	/**
     * @param string
     */
    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }

	/**
     * @return the $categoryParentId
     */
    public function getCategoryParentId() {
        return $this->categoryParentId;
    }

	/**
     * @param number $categoryParentId
     */
    public function setCategoryParentId($categoryParentId) {
        $this->categoryParentId = $categoryParentId;
    }

	/**
     * @return the $categoryParentName
     */
    public function getCategoryParentName() {
        return $this->categoryParentName;
    }

	/**
     * @param string $categoryParentName
     */
    public function setCategoryParentName($categoryParentName) {
        $this->categoryParentName = $categoryParentName;
    }

	/**
	 * @return the $parentId
	 */
	public function getParentId() {
		return $this->parentId;
	}

	/**
	 * @param number $parentId
	 */
	public function setParentId($parentId) {
		$this->parentId = $parentId;
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
     * @return the $barcode
     */
    public function getBarcode() {
        return $this->barcode;
    }

	/**
     * @param string $barcode
     */
    public function setBarcode($barcode) {
        $this->barcode = $barcode;
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
	 * @return the $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param string $image
	 */
	public function setImage($image) {
		$this->image = $image;
		return $this;
	}

	/**
	 * @return the $images
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * @param multitype: $images
	 */
	public function setImages($images) {
		$this->images = $images;
		return $this;
	}

	/**
	 * @param multitype: $images
	 */
	public function addImage($image) {
		$this->images[] = trim($image);
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
	 * @return the $importPrice
	 */
	public function getImportPrice() {
		return $this->importPrice;
	}

	/**
	 * @param int $importPrice
	 */
	public function setImportPrice($importPrice) {
		$this->importPrice = $importPrice;
		return $this;
	}

	/**
	 * @return the $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @param int $price
	 */
	public function setPrice($price) {
		$this->price = $price;
		return $this;
	}

	/**
	 * @return the $wholesalePrice
	 */
	public function getWholesalePrice() {
		return $this->wholesalePrice;
	}

	/**
	 * @param number $wholesalePrice
	 */
	public function setWholesalePrice($wholesalePrice) {
		$this->wholesalePrice = $wholesalePrice;
		return $this;
	}

	/**
	 * @return the $marketPrice
	 */
	public function getMarketPrice() {
		return $this->marketPrice;
	}

	/**
	 * @param number $marketPrice
	 */
	public function setMarketPrice($marketPrice) {
		$this->marketPrice = $marketPrice;
		return $this;
	}

	/**
	 * @return the $quantity
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
		return $this;
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
	 * @return the $saleAccount
	 */
	public function getSaleAccount() {
		return $this->saleAccount;
	}

	/**
	 * @param string $saleAccount
	 */
	public function setSaleAccount($saleAccount) {
		$this->saleAccount = $saleAccount;
		return $this;
	}

	/**
	 * @return the $startDate
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * @param string $startDate
	 */
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
		return $this;
	}

	/**
	 * @return the $endDate
	 */
	public function getEndDate() {
		return $this->endDate;
	}

	/**
	 * @param string $endDate
	 */
	public function setEndDate($endDate) {
		$this->endDate = $endDate;
		return $this;
	}

	/**
     * @return the $warranty
     */
    public function getWarranty() {
        return $this->warranty;
    }

	/**
     * @param number $warranty
     */
    public function setWarranty($warranty) {
        $this->warranty = $warranty;
    }

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param string $status
	 */
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}

	/**
	 * @return the $vat
	 */
	public function getVat() {
		return $this->vat;
	}

	/**
	 * @param string $vat
	 */
	public function setVat($vat) {
		$this->vat = $vat;
	}

	/**
	 * @return the $countryCode
	 */
	public function getCountryCode() {
		return $this->countryCode;
	}

	/**
	 * @param number $countryCode
	 */
	public function setCountryCode($countryCode) {
		$this->countryCode = $countryCode;
	}

	/**
	 * @return the $addToApproveList
	 */
	public function getAddToApproveList() {
		return $this->addToApproveList;
	}

	/**
	 * @param number $addToApproveList
	 */
	public function setAddToApproveList($addToApproveList) {
		$this->addToApproveList = $addToApproveList;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return array(
			'id'				=> trim($this->getId()),
			'idNhanh'			=> trim($this->getIdNhanh()),
			'baseCategoryId'	=> trim($this->getBaseCategoryId()),
			'categoryId'		=> trim($this->getCategoryId()),
			'categoryName'		=> trim($this->getCategoryName()),
			'categoryParentId'	=> trim($this->getCategoryParentId()),
			'parentId'			=> trim($this->getParentId()),
			'code'				=> trim($this->getCode()),
			'barcode'			=> trim($this->getBarcode()),
			'name'				=> trim($this->getName()),
			'image'				=> trim($this->getImage()),
			'images'			=> $this->getImages(),
			'type'				=> trim($this->getType()),
			'shippingWeight'	=> trim($this->getShippingWeight()),
			'importPrice'		=> trim($this->getImportPrice()),
			'price'				=> trim($this->getPrice()),
			'wholesalePrice'	=> trim($this->getWholesalePrice()),
			'marketPrice'		=> trim($this->getMarketPrice()),
			'quantity'			=> trim($this->getQuantity()),
			'saleAccount'		=> trim($this->getSaleAccount()),
			'startDate'			=> trim($this->getStartDate()),
			'endDate'			=> trim($this->getEndDate()),
			'warranty'			=> trim($this->getWarranty()),
			'status'			=> trim($this->getStatus()),
			'vat' 				=> trim($this->getVat()),
			'countryCode'		=> trim($this->getCountryCode()),
			'addToApproveList'	=> trim($this->getAddToApproveList())
		);
	}
}