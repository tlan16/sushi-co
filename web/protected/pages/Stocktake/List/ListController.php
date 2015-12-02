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
	protected  $view = '';
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();
		if(isset($this->Request['view']))
		{
			$this->view = trim($this->Request['view']);
			$this->menuItem = $this->view;
		}
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
		$js .= "pageJs._view = '" . $this->view . "';";
		$js .= 'pageJs.setCallbackId("stocktake", "' . $this->stocktakeBtn->getUniqueID(). '");';
		return $js;
	}
	public function stocktake($sender, $param)
	{
		$result = $errors = array();
		try
		{
			if(!is_array($data = $param->CallbackParameter) || count($data) === 0)
				throw new Exception('Invalid Form Data');
			$dataArray = array();
			$totalArray =  array(
					'Shop Qty' => 0,
					'Store Room Qty' => 0,
					'Order Qty' => 0,
					'Total Price' => 0
			);
			foreach ($data as $row) {
				if (!isset($row->item) || !isset($row->item->id)
					|| !($rawMaterial = RawMaterial::get($row->item->id)) instanceof RawMaterial
					|| !isset($row->item->serverMeasurement) 
					|| !isset($row->item->serverMeasurement->id) 
					|| !($info = RawMaterialInfo::get($row->item->serverMeasurement->id)) instanceof RawMaterialInfo
				)
					continue;

				$serveMeasurement = ServeMeasurement::get(intval($info->getEntityId()));
				if($info->getEntityName() !== 'ServeMeasurement' || !$serveMeasurement instanceof ServeMeasurement)
					continue;
				
				$unitPrice = StringUtilsAbstract::getValueFromCurrency($info->getValue());
				if(isset($row->unitPrice))
					$unitPrice = StringUtilsAbstract::getValueFromCurrency($row->unitPrice);

				$stocktakeShop = 0;
				if(isset($row->stocktakeShop))
					$stocktakeShop = doubleval($row->stocktakeShop);

				$stocktakeStoreRoom = 0;
				if(isset($row->stocktakeStoreRoom))
					$stocktakeStoreRoom = doubleval($row->stocktakeStoreRoom);

				$orderQty = 0;
				if(isset($row->orderQty))
					$orderQty = doubleval($row->orderQty);

				$newData =  array('Raw Material' => $rawMaterial->getName(),
									'Unit' => $serveMeasurement->getName(),
									'Unit Price' => StringUtilsAbstract::getValueFromCurrency($unitPrice),
									'Shop Qty' => $stocktakeShop,
									'Store Room Qty' => $stocktakeStoreRoom,
									'Order Qty' => $orderQty,
									'Total Price' => ($stocktakeShop + $stocktakeStoreRoom + $orderQty) * $unitPrice
				);
				$totalArray['Shop Qty'] += $newData['Shop Qty'];
				$totalArray['Store Room Qty'] += $newData['Store Room Qty'];
				$totalArray['Order Qty'] += $newData['Order Qty'];
				$totalArray['Total Price'] += $newData['Total Price'];
				
				$dataArray[] = $newData;
			}
			
			$fileName = implode('_', array($this->view, Core::getStore()->getName(), 'Timezone_' . UDate::TIME_ZONE_MELB, trim(UDate::now(UDate::TIME_ZONE_MELB)))) . '.xlsx';
			$fileName = str_replace(' ', '_', $fileName);
			$fileName = str_replace("/", '_', $fileName); // windows doesn't like "/" in filename
			$fileName = str_replace(":", '_', $fileName); // windows doesn't like ":" in filename
			$filePath = '/tmp/' . $fileName;
			$title = "Stock Take for [" . Core::getStore()->getName() . ']';
			$this->_genFile($filePath, $title, $dataArray, $totalArray);
			if(!is_file($filePath))
			    throw new Exception("No file can't generated.");
		    $from = SystemSettings::getByType(SystemSettings::TYPE_EMAIL_DEFAULT_SYSTEM_EMAIL)->getValue();
			$recipients = array('helin16@gmail.com');
			if(($tmp1 = SystemSettings::getByType(SystemSettings::TYPE_EMAIL_RECEIPIENTS)) instanceof SystemSettings && is_array($tmp2 = explode(';', $tmp1->getValue())))
				$recipients = $tmp2;
			$subject = $title;
			$body = $subject . "\n An Stocktake has been submitted by " . Core::getUser()->getPerson()->getFullName() . "\n Please see attached file for details.";
			$assets = array(Asset::registerAsset(basename($filePath), file_get_contents($filePath), Asset::TYPE_TMP));
			foreach ($recipients as $index => $recipient)
			{
				if(filter_var($recipient, FILTER_VALIDATE_EMAIL))
					EmailSender::addEmail($from, $recipient, $subject, $body, $assets);
				else unset($recipients[$index]);
			}
			unlink($filePath);
			
			$result['email'] = json_encode($recipients);
			$result['asset'] = $assets[0]->getJson();
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage();
		}
		$param->ResponseData = StringUtilsAbstract::getJson($result, $errors);
	}
	private static function addExcelRow(PHPExcel &$objPHPExcel, $data, $activeSheetIndex = 0, $startColNo = 0)
	{
		$activeSheet = $objPHPExcel->setActiveSheetIndex(0);
		$rowNo = intval($activeSheet->getHighestRow());
		$rowNo++;
		$colNo = $startColNo;
		if(!is_array($data))
			$data = array($data);
		foreach ($data as $row)
			$activeSheet->setCellValueByColumnAndRow($colNo++, $rowNo, $row);
	}
	private function _genFile($filePath, $title, array $data = array(), array $totalArray = array())
	{
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
			->setTitle($title)
			->setSubject($title)
			->setDescription($title);
		
		switch ($this->view)
		{
			case 'stocktake':
				{
					foreach ($data as &$row)
						unset($row['Order Qty']);
					unset($totalArray['Order Qty']);
					break;
				}
			case 'placeorder':
				{
					foreach ($data as $index => &$row)
					{
						if(doubleval($row['Order Qty']) === doubleval(0))
							unset($data[$index]);
						else 
						{
							unset($row['Shop Qty']);
							unset($row['Store Room Qty']);
						}
					}
					unset($totalArray['Shop Qty']);
					unset($totalArray['Store Room Qty']);
					break;
				}
		}
		
		array_unshift($data, array_keys($data[0])); // add header row
		foreach ($data as $row)
			self::addExcelRow($objPHPExcel, $row);
		
		if(count($totalArray) > 0)
		{
			self::addExcelRow($objPHPExcel, '');
			$totalArray = array(array_keys($totalArray), $totalArray);
			foreach ($totalArray as $row)
				self::addExcelRow($objPHPExcel, $row);
		}
			
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($filePath);
		return $this;
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
