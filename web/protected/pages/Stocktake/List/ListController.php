<?php
/**
 * This is the listing page for ProductCodeType
 *
 * @package    Web
 * @subpackage Controller
 * @author     lhe<helin16@gmail.com>
 */
class ListController extends CRUDPageAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see BPCPageAbstract::$menuItem
	 */
	public $menuItem = 'stocktake';
	protected $_focusEntity = 'RawMaterial';
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
	 * (non-PHPdoc)
	 * @see CRUDPageAbstract::_getEndJs()
	 */
	protected function _getEndJs()
	{
		$js = parent::_getEndJs();
		$js .= "pageJs.getResults(true, " . $this->pageSize . ");";
		$js .= "pageJs.loadSelect2();";
		$js .= "pageJs._bindSearchKey();";
		$js .= 'pageJs.setCallbackId("stocktake", "' . $this->stocktakeBtn->getUniqueID(). '");';
		return $js;
	}
	public function stocktake($sender, $param)
	{
		$result = $errors = array();
		try
		{
// 			print_r($param->CallbackParameter);
			if(!is_array($data = $param->CallbackParameter) || count($data) === 0)
				throw new Exception('Invalid Form Data');
			foreach ($data as $row)
			{
				if(!isset($row->item) || !isset($row->item->id) || !($rawMaterial = RawMaterial::get($row->item->id)) instanceof RawMaterial
					|| !isset($row->item->serverMeasurement) || !isset($row->item->serverMeasurement->id) || !($info = RawMaterialInfo::get($row->item->serverMeasurement->id)) instanceof RawMaterialInfo )
					continue;
				
				$unitPrice = $info->getValue();
				$serveMeasurement = ServeMeasurement::get(intval($info->getEntityId()));
				if($info->getEntityName() !== 'ServeMeasurement' || !$serveMeasurement instanceof ServeMeasurement)
					continue;
					
				$stocktakeShop = 0;
				if(isset($row->stocktakeShop))
					$stocktakeShop = doubleval($row->stocktakeShop);
				
				$stocktakeStoreRoom = 0;
				if(isset($row->stocktakeStoreRoom))
					$stocktakeStoreRoom = doubleval($row->stocktakeStoreRoom);
				
				$result[] = array('Raw Material' => $rawMaterial->getName(), 
									'Unit' => $serveMeasurement->getName(), 
									'Unit Price' => $unitPrice,
									'Shop Qty' => $stocktakeShop,
									'Store Room Qty' => $stocktakeStoreRoom
				);
			}
			array_unshift($result, array_keys($result[0])); // header row
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getActiveSheet()->fromArray($result, NULL, 'A1');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
			$objWriter->save('test.csv');
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($result, $errors);
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

			$stats = array();

			$objects = RawMaterial::getAll(true);
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
}
?>
