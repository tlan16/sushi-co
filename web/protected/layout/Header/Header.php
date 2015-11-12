<?php
/**
 * Header template
 *
 * @package    Web
 * @subpackage Layout
 * @author     lhe
 */
class Header extends TTemplateControl
{
    /**
     * (non-PHPdoc)
     * @see TControl::onLoad()
     */
	public function onLoad($param)
	{
	}
	/**
	 *
	 * @param unknown $sender
	 * @param unknown $param
	 */
	public function logout($sender, $param)
	{
		$auth = $this->getApplication()->Modules['auth'];
		$auth->logout();
		$this->Response->Redirect('/');
	}
	
	public function getStoreChangeBtn()
	{
		if(UserAccountInfo::countByCriteria('active = 1 and entityName = :eName and typeId = :typeId and userAccountId = :uid', array('eName' => 'Role', 'typeId' => UserAccountInfoType::ID_ROLE, 'uid' => Core::getUser()->getId())) > 1) {
			return '<li><a href="/store/switch.html">Change Store</a></li>';
		}
		return '';
	}
}
?>