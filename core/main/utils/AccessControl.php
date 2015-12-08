<?php

Abstract class AccessControl
{
	private static $_cache;
	public static function canAccessDevelopingPage(Role $role)
	{
		switch($role->getId())
		{
			case Role::ID_SYSTEM_DEVELOPER:
				{
					return true;
				}
		}
		return false;
	}
	public static function canAccessAllergentListingPage(Role $role)
	{
		switch($role->getId())
		{
			default:
				{
					return true;
				}
		}
		return false;
	}
	public static function isAdminUser(Role $role)
	{
	    return Core::getStore() instanceof Store && intval(Core::getStore()->getId()) === Store::ID_HEADQUQRTER && in_array(intval($role->getId()), array(Role::ID_ADMIN_USER, Role::ID_SYSTEM_ADMIN, Role::ID_SYSTEM_DEVELOPER));
	}
	public static function isStoreAdmin(Role $role)
	{
	  return in_array(intval($role->getId()), array(Role::ID_ADMIN_USER, Role::ID_SYSTEM_ADMIN, Role::ID_SYSTEM_DEVELOPER));
	}
	public static function canAccessResourcePage(Role $role)
	{
		return self::isAdminUser($role);
	}
	public static function canAccessAllergentDetailPage(Role $role)
	{
		switch($role->getId())
		{
			default:
				{
					return true;
				}
		}
		return false;
	}
	public static function canEditAllergentDetailPage(Role $role)
	{
		switch($role->getId())
		{
			default:
				{
					return true;
				}
		}
		return false;
	}
	public static function canAccessUserPage(Role $role)
	{
		return self::isAdminUser($role);
	}

// 	/**
// 	 * THis function checks if a page can be accesed by the Logged User's Role
// 	 * The Role can be passed as an argument or will be fetched automatically
// 	 *
// 	 * @param unknown $pageHandler
// 	 * @param Role $role
// 	 * @throws Exception
// 	 * @return boolean
// 	 */
// 	public static function checkIfCanAccessPage($pageHandler, Role $role = false)
// 	{
// 		if(($pageHandler = trim($pageHandler)) === '')
// 			throw new Exception('To check access you must specifiy the page Handler');

// 		$role = ($role === false ? Core::getRole() : $role);
// 		if(!$role instanceof Role)
// 			return false;

// 		switch($pageName)
// 		{
// 			case PageHandler::PRODUCT_LISTING_PAGE:
// 			{
// 				return true;
// 			}
// 			case PageHandler::PRODUCT_LISTING_PAGE:
// 			{
// 				return true;
// 			}
// 			default:
// 			{
// 				return false;
// 			}
// 		}

// 		return false;
// 	}
}