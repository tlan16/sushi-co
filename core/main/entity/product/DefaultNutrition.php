<?php

class DefaultNutrition extends BaseEntityAbstract
{
	/**
	 * The nutrition
	 * 
	 * @var Nutrition
	 */
	protected $nutrition;
	/**
	 * The Serve Measurement
	 * 
	 * @var ServeMeasurement
	 */
	protected $serveMeasurement;
	/**
	 * The description
	 * 
	 * @var string
	 */
	private $description = '';
	/**
	 * getter for nutrition
	 *
	 * @return Nutrition
	 */
	public function getNutrition()
	{
		$this->loadManyToOne('nutrition');
	    return $this->nutrition;
	}
	/**
	 * Setter for nutrition
	 *
	 * @return DefaultNutrition
	 */
	public function setNutrition($nutrition)
	{
	    $this->nutrition = $nutrition;
	    return $this;
	}
	/**
	 * getter for serveMeasurement
	 *
	 * @return ServeMeasurement
	 */
	public function getServeMeasurement()
	{
		$this->loadManyToOne('serveMeasurement');
	    return $this->serveMeasurement;
	}
	/**
	 * Setter for serveMeasurement
	 *
	 * @return DefaultNutrition
	 */
	public function setServeMeasurement($serveMeasurement)
	{
	    $this->serveMeasurement = $serveMeasurement;
	    return $this;
	}
	/**
	 * getter for description
	 *
	 * @return string
	 */
	public function getDescription()
	{
	    return $this->description;
	}
	/**
	 * Setter for description
	 *
	 * @return DefaultNutrition
	 */
	public function setDescription($description)
	{
	    $this->description = $description;
	    return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseEntityAbstract::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'df_nut');
		DaoMap::setManyToOne('nutrition', 'Nutrition', 'df_nut_nut');
		DaoMap::setManyToOne('serveMeasurement', 'ServeMeasurement', 'df_nut_srv_mgm');
		DaoMap::setStringType('description', 'varchar', 100);
		parent::__loadDaoMap();

		DaoMap::commit();
	}
	/**
	 * (non-PHPdoc)
	 * @see InfoEntityAbstract::getJson()
	 */
	public function getJson($extra = array(), $reset = false)
	{
		$array = $extra;
		$array['nutrition'] = ($this->getNutrition() instanceof Nutrition ? $this->getNutrition()->getJson() : null);
		$array['serveMeasurement'] = ($this->getServeMeasurement() instanceof ServeMeasurement ? $this->getServeMeasurement()->getJson() : null);
		return parent::getJson($array, $reset);
	}
	/**
	 * Creating a DefautNutrition
	 * 
	 * @param Nutrition $nutrition
	 * @param ServeMeasurement $measurement
	 * @param string $description
	 * @param bool $active.
	 * 
	 * @return DefaultNutrition
	 */
	public static function create(Nutrition $nutrition, ServeMeasurement $serveMeasurement, $description = '', $active = true)
	{
		$active = (intval($active) === 1);
		$objs = self::getAllByCriteria('nutritionId = ? and serveMeasurementId = ?', array($nutrition->getId(), $serveMeasurement->getId()), false, 1, 1);
		$obj = ( count($objs) > 0 ? $objs[0] : new self() );
		$obj->setNutrition($nutrition)->setServeMeasurement($serveMeasurement)->setDescription($description)->setActive($active)->save();
		return $obj;
	}
}