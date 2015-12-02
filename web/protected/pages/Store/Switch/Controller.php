<?php
class Controller extends BPCPageAbstract
{
	public $menuItem = 'stores';
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * Getting The end javascript
	 *
	 * @return string
	 */
	protected function _getEndJs()
	{
		$user = Core::getUser();
		$currentStoreId = intval(Core::getStore()->getId());
		$stores = $user->getStores();

		$storesJson = array();
		foreach ($stores as $store)
		{
		    $roles = $user->getRoles($store);
		    foreach($roles as $role)
		    {
    		    $extraInfo = array();
    		    $extraInfo['role'] = $role->getJson();
    		    if(intval($store->getId()) === $currentStoreId)
    		        $extraInfo['selected'] = true;
    		    $storesJson[$store->getName() . ' - ' . $role->getName()] = $store->getJson($extraInfo);
		    }
		}
		ksort($storesJson);
		$js = parent::_getEndJs();
		$js .= 'pageJs._preData=(' . json_encode(array(
				'stores' => array_values($storesJson)
				,'containerId' => 'resultDiv'
		)) . ');';
		$js .= 'pageJs.load();';
		$js .= 'pageJs.setCallbackId("switchStore", "' . $this->switchStoreBtn->getUniqueID(). '");';
		return $js;
	}
	public function switchStore($sender, $param)
	{
		$results = $errors = array();
		try
		{
			if(!isset($param->CallbackParameter->storeId) || !($store = Store::get(intval($param->CallbackParameter->storeId))) instanceof Store)
				throw new Exception('Invalid Store Passed in');
			if(!isset($param->CallbackParameter->roleId) || !($role = Role::get(intval($param->CallbackParameter->roleId))) instanceof Role)
				throw new Exception('Invalid Role Passed in');
			Core::setUser(Core::getUser(), $role, $store);
			$authManager=$this->Application->getModule('auth');
			$authManager->updateSessionUser($this->User);
			$results['item'] = $store;
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
	}
}
