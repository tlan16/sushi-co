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
	private static $_storage = array('userId' => null, 'roleId' => null, 'storeId' => null);
    /**
     * Setting the role in the core
     *
     * @param Role $role The role
     */
	public static function setRole(Role $role)
	{
		self::setUser(self::getUser(), $role, self::getStore());
	}
	/**
	 * removing core role
	 */
	public static function rmRole()
	{
	    self::$_storage['role'] = null;
	    self::rmStore();
	}
	/**
	 * removing core store
	 */
	public static function rmStore()
	{
	    self::$_storage['store'] = null;
	    self::rmRole();
	}
	/**
	 * Set the active user on the core for auditing purposes
	 *
	 * @param UserAccount $userAccount The useraccount
	 * @param Role        $role        The role
	 */
	public static function setUser(UserAccount $userAccount, Role $role = null, Store $store = null)
	{
		self::$_storage['userId'] = $userAccount->getId();
		self::$_storage['roleId'] = $role instanceof Role ? $role->getId() : null;
		self::$_storage['storeId'] = $store instanceof Store ? $store->getId() : null;
	}
	/**
	 * removing core user
	 */
	public static function rmUser()
	{
	    self::$_storage['userId'] = null;
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
		return UserAccount::get(self::$_storage['userId']);
	}
	/**
	 * Get the current user role set against the System for Dao filtering purposes
	 *
	 * @return Role
	 */
	public static function getRole()
	{
		return Role::get(self::$_storage['roleId']);
	}
	/**
	 * Get the current store set against the System for Dao filtering purposes
	 *
	 * @return Store|NULL
	 */
	public static function getStore()
	{
		return Store::get(self::$_storage['storeId']);
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
		$userAccount = UserAccount::get(self::$_storage['userId']);
		$role = ($role = Role::get(self::$_storage['roleId'])) instanceof Role ? $role : null;
		$store = ($store = Store::get(self::$_storage['storeId'])) instanceof Store ? $store : null;

		Core::setUser($userAccount, $role, $store);
		return self::$_storage;
	}
}

?>