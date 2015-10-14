<?php

class Label extends BaseEntityAbstract
{
	/**
	 * @var String
	 */
	private $name;
	
	/**
	 * @var UDate
	 */
	private $printedDate;
	
	/**
	 * @var UDate
	 */
	private $useByDate;
	
	/**
	 * @var UserAccount
	 */
	private $printedBy;
	
	/**
	 * @var Int ???
	 */
	private $printedPrice;
	
	/**
	 * @var Integer
	 */
	private $versionNo;
	
	protected $product;
	
	public function getProduct()
	{
		$this->loadManyToOne('product');
		return $this->product;
	}
	
	public function setProduct(Product $product)
	{
		$this->product = $product;
		return $this;
	}
	
	/**
	 * 
	 */
	public function getName()
	{
		return $this->name;
	}
	
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	public function getPrintedDate()
	{
		return $this->printedDate;
	}
	
	public function setPrintedDate($date)
	{
		if(($date = UDate::validateDate($date)) === false)
			throw new Exception('Invalid Use By Date ['.$date.'] provided');
		
		$this->printedDate = trim($date);
		return $this;
	}
	
	public function getUseByDate()
	{
		return $this->useByDate;
	}
	
	public function setUseByDate($date)
	{
		if(($date = UDate::validateDate($date)) === false)
			throw new Exception('Invalid Use By Date ['.$date.'] provided');

		$this->useByDate = trim($date);
		return $this;
	}
	
	public function getPrintedBy()
	{
		$this->loadManyToOne('printedBy');
		return $this->printedBy;
	}
	
	public function setPrintedBy(UserAccount $user)
	{
		$this->printedBy = $user;
		return $this;
	}
	
	public function getVersionNo()
	{
		return $this->versionNo;
	}
	
	public function setVersionNo($versionNo)
	{
		$this->versionNo = $versionNo;
		return $this;
	}
	
	public function getPrintedPrice()
	{
		return $this->printedPrice;
	}
	
	public function setPrintedPrice($printedPrice)
	{
		$printedPrice = StringUtilsAbstract::getValueFromCurrency($printedPrice);
		
		if(!is_numeric($printedPrice))
			throw new Exception('A valid price must be provided to set the Printed Price');
		
		$this->printedPrice = $printedPrice;
		return $this;
	}
	
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'lbl');
		DaoMap::setStringType('name', 'varchar', 100);
		DaoMap::setDateType('printedDate');
		DaoMap::setDateType('useByDate');
		DaoMap::setManyToOne('printedBy', 'UserAccount');
		DaoMap::setStringType('versionNo', 'varchar', 10); 
		DaoMap::setIntType('printedPrice', 'double', '10,4'); 
		DaoMap::setManyToOne('product', 'Product', 'pro'); 
		parent::__loadDaoMap();
		
		DaoMap::createIndex('useByDate');
		DaoMap::createIndex('name');
		DaoMap::createIndex('versionNo');
		DaoMap::commit();
	}
	
	
}