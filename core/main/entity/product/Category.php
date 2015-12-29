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
	 * The position for display
	 * 
	 * @var int
	 */
	private $position = 0;
	/**
	 * getter for position
	 *
	 * @return int
	 */
	public function getPosition()
	{
	    return $this->position;
	}
	/**
	 * Setter for position
	 *
	 * @return Category
	 */
	public function setPosition($position)
	{
	    $this->position = $position;
	    return $this;
	}


	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'cat');
				
		parent::__loadDaoMap();

		DaoMap::setIntType('position','int', 8);

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