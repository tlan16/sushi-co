<?php
/** Allergent Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Allergent extends ResourceAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'algt');
		
		parent::__loadDaoMap();

		DaoMap::commit();
	}
	/**
	 * Getting a Allergent
	 *
	 * @param int $id
	 *
	 * @return Allergent
	 */
	public static function get($id)
	{
		if(!self::cacheExsits($id)) {
			self::addCache($id, parent::get($id));
		}
		return self::getCache($id);
	}
}