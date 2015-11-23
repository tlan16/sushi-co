<?php
/** Category Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class Category extends ResourceAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'cat');
				
		parent::__loadDaoMap();

		DaoMap::commit();
	}
	/**
	 * Getting a Category
	 *
	 * @param int $id
	 *
	 * @return Category
	 */
	public static function get($id)
	{
		if(!self::cacheExsits($id)) {
			self::addCache($id, parent::get($id));
		}
		return self::getCache($id);
	}
}