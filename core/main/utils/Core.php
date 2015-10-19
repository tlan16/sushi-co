<?php
/**
 * Global core settings and operations, This is for runtime only
 *
 * @package    Core
 * @subpackage Utils
 * @author     lhe<helin16@gmail.com>
 */
abstract class Core
{
    /**
     * The storage for the Core at the runtime level
     * 
     * @var array
     */
	private static $_storage = array('user' => null, 'role' => null, 'store' => null);
    /**
     * Setting the role in the core
     * 
     * @param Role $role The role
     */
	public static function setRole(Role $role)
	{
		self::setUser(self::getUser(), $role);
	}
	/**
	 * removing core role
	 */
	public static function rmRole()
	{
	    self::$_storage['role'] = null;
	}
	/**
	 * removing core store
	 */
	public static function rmStore()
	{
	    self::$_storage['store'] = null;
	}
	/**
	 * Set the active user on the core for auditing purposes
	 * 
	 * @param UserAccount $userAccount The useraccount
	 * @param Role        $role        The role
	 */
	public static function setUser(UserAccount $userAccount, Role $role = null, Store $store = null)
	{
		self::$_storage['user'] = $userAccount;
		self::$_storage['role'] = $role;
		self::$_storage['store'] = $store;
	}
	/**
	 * removing core user
	 */
	public static function rmUser()
	{
	    self::$_storage['user'] = null;
	    self::rmRole();
	    self::rmStore();
	}
	/**
	 * Get the current user set against the System for auditing purposes
	 *
	 * @return UserAccount
	 */
	public static function getUser()
	{
		return self::$_storage['user'];
	}
	/**
	 * Get the current user role set against the System for Dao filtering purposes
	 *
	 * @return Role
	 */
	public static function getRole()
	{
		return self::$_storage['role'] instanceof Role ? self::$_storage['role'] : null;
	}
	/**
	 * Get the current store set against the System for Dao filtering purposes
	 *
	 * @return Store|NULL
	 */
	public static function getStore()
	{
		return self::$_storage['store'] instanceof Store ? self::$_storage['store'] : null;
	}
    /**
     * serialize all the components in core
     * 
     * @return string
     */
	public static function serialize()
	{
		return serialize(self::$_storage);
	}
	/**
	 * unserialize all the components and store them in Core
	 * 
	 * @param string $string The serialized core storage string
	 */
	public static function unserialize($string)
	{
		self::$_storage = unserialize($string);
		Core::setUser(self::$_storage['user'], self::$_storage['role'], self::$_storage['store']);
		return self::$_storage;
	}
}

?>