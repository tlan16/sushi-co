<?php
/**
 * This is the Question details page
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
	public $menuItem = 'DefaultNutrition.detail';
	/**
	 * (non-PHPdoc)
	 * @see BPCPageAbstract::$_focusEntityName
	 */
	protected $_focusEntity = 'DefaultNutrition';
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
		$js .= "pageJs.setPreData(" . json_encode(array()) . ");";
		$js .= "pageJs._containerIds=" . json_encode(array(
				'nutrition' => 'nutrition_div'
				,'serveMeasurement' => 'serveMeasurement_by_div'
				,'description' => 'description_div'
				,'comments' => 'comments_div'
				,'saveBtn' => 'save_btn'
		)) . ";";
		$js .= "pageJs.load();";
		$js .= "pageJs.bindAllEventNObjects();";
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

		$results = $errors = array();
		try
		{
			$focusEntity = $this->getFocusEntity();
			if (!isset ( $params->CallbackParameter->nutrition ) || !($nutrition = Nutrition::get(intval($params->CallbackParameter->nutrition))) instanceof Nutrition)
				throw new Exception ( 'System Error: invalid nutrition passed in.' );
			if (!isset ( $params->CallbackParameter->serveMeasurement ) || !($serveMeasurement = ServeMeasurement::get(intval($params->CallbackParameter->serveMeasurement))) instanceof ServeMeasurement)
				throw new Exception ( 'System Error: invalid serveMeasurement passed in.' );
			$description = '';
			if (isset ( $params->CallbackParameter->description ) )
				$description = trim($params->CallbackParameter->description);
			
			Dao::beginTransaction();

			$entity = DefaultNutrition::create($nutrition, $serveMeasurement, $description);
			
			$results ['item'] = $entity->getJson ();
			Dao::commitTransaction ();
		}
		catch(Exception $ex)
		{
			Dao::rollbackTransaction();
			$errors[] = $ex->getMessage();
		}
		$params->ResponseData = StringUtilsAbstract::getJson($results, $errors);
	}
}
?>
