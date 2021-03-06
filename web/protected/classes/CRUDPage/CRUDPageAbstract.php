<?php
/**
 * The CRUDPage Page Abstract
 *
 * @package    Web
 * @subpackage Class
 * @author     lhe<helin16@gmail.com>
 */
abstract class CRUDPageAbstract extends BPCPageAbstract
{
	/**
	 * The default page size to get items
	 *
	 * @var int
	 */
	public $pageSize = 10;
	/**
	 * The focusing entity
	 *
	 * @var string
	 */
	protected $_focusEntity = '';
	/**
	 * @var TCallback
	 */
	private $_getItemsBtn;
	/**
	 * @var TCallback
	 */
	private $_saveItemsBtn;
	/**
	 * @var TCallback
	 */
	private $_delItemsBtn;
	/**
	 * loading the page js class files
	 */
	protected function _loadPageJsClass()
	{
		parent::_loadPageJsClass();
		$thisClass = __CLASS__;
		$cScripts = self::getLastestJS(__CLASS__);
		if (isset($cScripts['js']) && ($lastestJs = trim($cScripts['js'])) !== '')
			$this->getPage()->getClientScript()->registerScriptFile($thisClass . 'Js', $this->publishFilePath(dirname(__FILE__) . DIRECTORY_SEPARATOR . $lastestJs));
		if (isset($cScripts['css']) && ($lastestCss = trim($cScripts['css'])) !== '')
			$this->getPage()->getClientScript()->registerStyleSheetFile($thisClass . 'Css', $this->publishFilePath(dirname(__FILE__) . DIRECTORY_SEPARATOR . $lastestCss),'screen');
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see TControl::onInit()
	 */
	public function onInit($param)
	{
		parent::onInit($param);

		$this->_getItemsBtn = new TCallback();
		$this->_getItemsBtn->ID = 'getItemsBtn';
		$this->_getItemsBtn->OnCallback = 'Page.getItems';
		$this->getControls()->add($this->_getItemsBtn);

		$this->_saveItemsBtn = new TCallback();
		$this->_saveItemsBtn->ID = 'saveItemBtn';
		$this->_saveItemsBtn->OnCallback = 'Page.saveItem';
		$this->getControls()->add($this->_saveItemsBtn);

		$this->_delItemsBtn = new TCallback();
		$this->_delItemsBtn->ID = 'delItemsBtn';
		$this->_delItemsBtn->OnCallback = 'Page.deleteItems';
		$this->getControls()->add($this->_delItemsBtn);
	}
	/**
	 * (non-PHPdoc)
	 * @see TPage::onPreInit()
	 */
	public function onPreInit($param)
	{
		parent::onPreInit($param);
		if(isset($_REQUEST['blanklayout']) && trim($_REQUEST['blanklayout']) === '1')
			$this->getPage()->setMasterClass("Application.layout.BlankLayout");
	}
	/**
	 * Getting The end javascript
	 *
	 * @return string
	 */
	protected function _getEndJs()
	{
		$js = parent::_getEndJs();
		$js .= "pageJs.setCallbackId('getItems', '" . $this->_getItemsBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('deleteItems', '" . $this->_delItemsBtn->getUniqueID() . "')";
		$js .= ".setCallbackId('saveItem', '" . $this->_saveItemsBtn->getUniqueID() . "')";
		$js .= ".setHTMLIds('item-list', 'searchPanel', 'total-found-count');";
		$js .= "if(pageJs.init) {pageJs.init();}";
		$js .= "pageJs.getSearchCriteria();";
		$js .= "pageJs._focusEntity = '" . $this->getFocusEntity() . "';";
		$js .= "pageJs.loadSelect2();";
		$js .= "pageJs._bindSearchKey();";
		return $js;
	}
	/**
	 * Getting the items
	 *
	 * @param unknown $sender
	 * @param unknown $param
	 * @throws Exception
	 *
	 */
	public function getItems($sender, $param)
	{
		$results = $errors = array();
		try
		{
			$class = trim($this->_focusEntity);
			$pageNo = 1;
			$pageSize = DaoQuery::DEFAUTL_PAGE_SIZE;
			if(isset($param->CallbackParameter->pagination))
			{
				$pageNo = $param->CallbackParameter->pagination->pageNo;
				$pageSize = $param->CallbackParameter->pagination->pageSize;
			}
			$stats = array();
			$objects = $class::getAll(true, $pageNo, $pageSize, array(), $stats);
			$results['pageStats'] = $stats;
			$results['items'] = array();
			foreach($objects as $obj)
				$results['items'][] = $obj->getJson();
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
	}
	/**
	 * delete the items
	 *
	 * @param unknown $sender
	 * @param unknown $param
	 * @throws Exception
	 *
	 */
	public function deleteItems($sender, $param)
	{
		$results = $errors = array();
		try
		{
			$class = trim($this->_focusEntity);
			$ids = isset($param->CallbackParameter->ids) ? $param->CallbackParameter->ids : array();
			$deactivate = isset($param->CallbackParameter->deactivate) ? ($param->CallbackParameter->deactivate===true) : false;
			if(count($ids) > 0)
			{
				if($deactivate === true || $deactivate === false)
				{
					$results['items'] = array();
					foreach ($ids as $id)
					{
						$obj = $class::get($id);
						if($obj instanceof $class)
							$obj->setActive(!$deactivate)->save();
						$results['items'][] = $obj->getJson();
					}
				}
				else $class::deleteByCriteria('id in (' . str_repeat('?', count($ids)) . ')', $ids);
			}
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
	}
	/**
	 * save the items
	 *
	 * @param unknown $sender
	 * @param unknown $param
	 * @throws Exception
	 *
	 */
	public function saveItem($sender, $param)
	{
		$results = $errors = array();
		try
		{
			$class = trim($this->_focusEntity);
			if(!isset($param->CallbackParameter->item))
				throw new Exception("System Error: no item information passed in!");
				$item = (isset($param->CallbackParameter->item->id) && ($item = $class::get($param->CallbackParameter->item->id)) instanceof $class) ? $item : null;
				$name = trim($param->CallbackParameter->item->name);
				$description = trim($param->CallbackParameter->item->description);
					
				if($item instanceof $class)
				{
					$item->setName($name)
					->setDescription($description)
					->save();
				}
				else
				{
					$item = $class::create($name, $description);
				}
				$results['item'] = $item->getJson();
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
	}
	/**
	 * getting the focus entity
	 *
	 * @return string
	 */
	public function getFocusEntity()
	{
		return trim($this->_focusEntity);
	}
	public function getItem($sender, $param)
	{
		$results = $errors = array();
		try
		{
			$class = trim($this->_focusEntity);
			$ids = isset($param->CallbackParameter->ids) ? $param->CallbackParameter->ids : array();
			$deactivate = isset($param->CallbackParameter->deactivate) ? ($param->CallbackParameter->deactivate===true) : false;
			if(count($ids) > 0)
			{
				if($deactivate === true)
				{
					foreach ($ids as $id)
					{
						$obj = $class::get($id);
						if($obj instanceof $class)
							$obj->setActive(false)->save();
					}
				}
				else $class::deleteByCriteria('id in (' . str_repeat('?', count($ids)) . ')', $ids);
			}
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($results, $errors);
	}
}
?>