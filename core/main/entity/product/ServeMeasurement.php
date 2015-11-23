<?php
/** ServeManagement Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class ServeMeasurement extends ResourceAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'srv_mgm');
				
		parent::__loadDaoMap();

		DaoMap::commit();
	}
	/**
	 * Getting a ServeMeasurement
	 * 
	 * @param int $id
	 * 
	 * @return ServeMeasurement
	 */
	public static function get($id)
	{
		if(!self::cacheExsits($id)) {
			self::addCache($id, parent::get($id));
		}
		return self::getCache($id);
	}
	
}