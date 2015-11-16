<?php
/** Nutrition Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Nutrition extends ResourceAbstract
{
	/**
	 * The display order of the nutrition
	 *
	 * @var integer
	 */
	private $order = 0;
	/**
	 * The default of the ServeMeasurement
	 *
	 * @var ServeMeasurement
	 */
	protected $defaultServeMeasurement = null;
	/**
	 * getter for order
	 *
	 * @return int
	 */
	public function getOrder()
	{
	    return $this->order;
	}
	/**
	 * Setter for order
	 *
	 * @return Nutrition
	 */
	public function setOrder($order)
	{
	    $this->order = $order;
	    return $this;
	}
	/**
	 * Getter for defaultServeMeasurement
	 *
	 * @return ServeMeasurement
	 */
	public function getDefaultServeMeasurement()
	{
	    $this->loadManyToOne('defaultServeMeasurement');
	    return $this->defaultServeMeasurement;
	}
	/**
	 * Setter for defaultServeMeasurement
	 *
	 * @param unkown $value The defaultServeMeasurement
	 *
	 * @return Nutrition
	 */
	public function setDefaultServeMeasurement($value)
	{
	    $this->defaultServeMeasurement = $value;
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::getJson()
	 */
	public function getJson($extra = array(), $reset = false)
	{
	    $array = $extra;
	    $array['defaultServeMeasurement'] = ($this->getDefaultServeMeasurement() instanceof ServeMeasurement ? $this->getDefaultServeMeasurement()->getJson() : null);
	    return parent::getJson($array, $reset);
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'nut');
		DaoMap::setIntType('order', 'int', 10, true, false, 0);
		DaoMap::setManyToOne('defaultServeMeasurement', 'ServeMeasurement', 'nut_dsm', true);

		parent::__loadDaoMap();

		DaoMap::createIndex('order');
		DaoMap::commit();
	}

}