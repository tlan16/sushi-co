<?php
/**
 * This is the listing page for manufacturer
 *
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class ListController extends BPCPageAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see BPCPageAbstract::$menuItem
	 */
	public $menuItem = 'system.messages';
	protected $_focusEntity = 'Message';
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * (non-PHPdoc)
	 * @see CRUDPageAbstract::_getEndJs()
	 */
	protected function _getEndJs()
	{
		// BPC Class _getEndJs()
		$js = 'if(typeof(PageJs) !== "undefined"){';
		$js .= 'var pageJs = new PageJs();';
		$js .= 'pageJs.setHTMLID("main-form", "' . $this->getPage()->getForm()->getClientID() . '"); ';
		$js .= $this->_preGetEndJs();
		$js .= '}';

		$js .= "if(pageJs.init) {pageJs.init();}";
		$js .= "pageJs";
		$js .= ";";
		return $js;
	}
}
?>
