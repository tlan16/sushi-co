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
	public $menuItem = 'rawmaterial.detail';
	/**
	 * (non-PHPdoc)
	 * @see BPCPageAbstract::$_focusEntityName
	 */
	protected $_focusEntity = 'RawMaterial';
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();
		if(!AccessControl::canUpdateRawMaterial(Core::getRole()))
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
				'name' => 'name_div'
				,'description' => 'description_div'
				,'serverMeasurement' => 'serverMeasurement_div'
				,'unitPrice' => 'unitPrice_div'
				,'position' => 'position_div'
				,'showInPlaceOrder' => 'showInPlaceOrder_div'
				,'showInStockTake' => 'showInStockTake_div'
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
//		die(var_dump($params->CallbackParameter));
		$results = $errors = array();
		try
		{
			$focusEntity = $this->getFocusEntity();
			
			$entity = null;
			if (isset ( $params->CallbackParameter->id ) && !($entity = $focusEntity::get(intval($params->CallbackParameter->id))) instanceof $focusEntity )
				throw new Exception ( 'System Error: invalid id passed in.' );
			
			if (!isset ( $params->CallbackParameter->name ) || ($name = trim ( $params->CallbackParameter->name )) === '')
				throw new Exception ( 'System Error: invalid name passed in.' );
			
			if(!isset($params->CallbackParameter->serveMeasurement) || !($serveMeasurement = ServeMeasurement::get(intval($params->CallbackParameter->serveMeasurement))) instanceof ServeMeasurement)
				throw new Exception ( 'System Error: invalid Serve Measurement (unit) passed in.' );
			
			$description = '';
			if (isset ( $params->CallbackParameter->description ) )
				$description = trim($params->CallbackParameter->description);
			
			$unitPrice = doubleval(0);
			if (isset ( $params->CallbackParameter->unitPrice ) )
				$unitPrice = StringUtilsAbstract::getValueFromCurrency($params->CallbackParameter->unitPrice);

			$position = 0;
			if (isset ( $params->CallbackParameter->position ) )
				$position = intval($params->CallbackParameter->position);

			$showInPlaceOrder = true;
			if (isset ( $params->CallbackParameter->showInPlaceOrder ) )
				$showInPlaceOrder = boolval($params->CallbackParameter->showInPlaceOrder);

			$showInStockTake = true;
			if (isset ( $params->CallbackParameter->showInStockTake ) )
				$showInStockTake = boolval($params->CallbackParameter->showInStockTake);

			Dao::beginTransaction();

			if(!isset($entity) || !$entity instanceof $focusEntity)
				$entity = $focusEntity::create($name, $description);
			else
				$entity->setName($name)->setDescription($description);
			
			$entity->clearServeMeasurements()->addServeMeasurement($serveMeasurement, $unitPrice);
			$entity->setPosition($position)->setShowInPlaceOrder(intval($showInPlaceOrder))->setShowInStocktake(intval($showInStockTake));

			$results ['item'] = $entity->save()->getJson ();
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
