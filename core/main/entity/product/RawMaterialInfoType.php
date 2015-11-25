<?php
/** RawMaterialInfoType Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class RawMaterialInfoType extends InfoTypeAbstract
{
	const ID_SERVEMESUREMENT = 1;
	const ID_COST = 2;
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'raw_mat_info_type');

		parent::__loadDaoMap();

		DaoMap::commit();
	}
}