<?php
Prado::using('System.Security.TUser');

class WebUser extends TUser
{
	public function saveToString()
	{
		$a = array(Core::serialize(), parent::saveToString());
		return serialize($a);
	}

	/**
	 * Load the userAccount from the session
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	public function loadFromString($data)
	{
		if(!empty($data))
		{
			list($coreStuff, $str) = unserialize($data);
			Core::unserialize($coreStuff);

			return parent::loadFromString($str);
		}
		else
			return $this;
	}
}
?>