<?php
/**
 * This is the Nutrition details page
 *
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class DetailsController extends DetailsPageAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see BPCPageAbstract::$menuItem
	 */
	public $menuItem = 'nutrition.detail';
	/**
	 * (non-PHPdoc)
	 * @see BPCPageAbstract::$_focusEntityName
	 */
	protected $_focusEntity = 'Nutrition';
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();
		if(!AccessControl::canAccessResourcePage(Core::getRole()))
			die('You do NOT have access to this page');
	}
	/**
	 * Getting The end javascript
	 *
	 * @return string
	 */
	protected function _getEndJs()
	{
		$js = parent::_getEndJs();
		$js .= "pageJs._containerIds=" . json_encode(array(
				'name' => 'name_div'
				,'description' => 'description_div'
				,'order' => 'order_div'
				,'allergents' => 'allergents_div'
				,'comments' => 'comments_div'
				,'saveBtn' => 'save_btn'
		)) . ";";
		$js .= "pageJs.load();";
		if(!AccessControl::canEditAllergentDetailPage(Core::getRole()))
			$js .= "pageJs.readOnlyMode();";
		return $js;
	}
	/**
	 * save the items
	 *
	 * @param unknown $sender
	 * @param unknown $param
	 * @throws Exception
	 *
	 */
	public function saveItem($sender, $params)
	{
		$results = $errors = array ();
		try {
			$focusEntity = $this->getFocusEntity ();
			if (! isset ( $params->CallbackParameter->name ) || ($name = trim ( $params->CallbackParameter->name )) === '')
				throw new Exception ( 'System Error: invalid name passed in.' );

			$description = '';
			if (isset ( $params->CallbackParameter->description ))
				$description = trim ( $params->CallbackParameter->description );

			$order= 0;
			if (isset ( $params->CallbackParameter->order ) && ($tmp = intval($params->CallbackParameter->order)) > 0)
				$order = intval($tmp);

			if (isset ( $params->CallbackParameter->id ) && ! ($entity = $focusEntity::get ( intval ( $params->CallbackParameter->id ) )) instanceof $focusEntity)
				throw new Exception ( 'System Error: invalid id passed in.' );

			Dao::beginTransaction ();

			if (! isset ( $entity ) || ! $entity instanceof $focusEntity)
				$entity = $focusEntity::create ( $name, $description );
			else
				$entity->setName ( $name )->setDescription ( $description );

			$results ['item'] = $entity->setOrder($order)->save ()->getJson ();
			Dao::commitTransaction ();
		} catch ( Exception $ex ) {
			Dao::rollbackTransaction ();
			$errors [] = $ex->getMessage ();
		}
		$params->ResponseData = StringUtilsAbstract::getJson ( $results, $errors );
	}
}
?>
