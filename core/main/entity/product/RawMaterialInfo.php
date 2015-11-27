<?php
/** RawMaterialInfo Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class RawMaterialInfo extends InfoAbstract
{
	/**
	 * The RawMaterial of the RawMaterialInfo
	 *
	 * @var RawMaterial
	 */
	protected $rawMaterial;
	/**
	 * Getter for rawMaterial
	 *
	 * @return RawMaterial
	 */
	public function getRawMaterial()
	{
	    $this->loadManyToOne('rawMaterial');
	    return $this->rawMaterial;
	}
	/**
	 * Setter for rawMaterial
	 *
	 * @param RawMaterial $value The rawMaterial
	 *
	 * @return RawMaterialInfo
	 */
	public function setRawMaterial($value)
	{
	    $this->rawMaterial = $value;
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'raw_mat_info');
		parent::__loadDaoMap();

		DaoMap::commit();
	}
}