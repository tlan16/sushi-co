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
		$js .= "pageJs._view = 'stockTake';";
		$js .= "pageJs._view = 'placeOrder';";
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
			foreach ($data as $row) {
				if (!isset($row->item) || !isset($row->item->id)
					|| !($rawMaterial = RawMaterial::get($row->item->id)) instanceof RawMaterial
					|| !isset($row->item->serverMeasurement) 
					|| !isset($row->item->serverMeasurement->id) 
					|| !($info = RawMaterialInfo::get($row->item->serverMeasurement->id)) instanceof RawMaterialInfo
				)
					continue;

				$unitPrice = StringUtilsAbstract::getCurrency($info->getValue());
				$serveMeasurement = ServeMeasurement::get(intval($info->getEntityId()));
				if($info->getEntityName() !== 'ServeMeasurement' || !$serveMeasurement instanceof ServeMeasurement)
					continue;

				$stocktakeShop = 0;
				if(isset($row->stocktakeShop))
					$stocktakeShop = doubleval($row->stocktakeShop);

				$stocktakeStoreRoom = 0;
				if(isset($row->stocktakeStoreRoom))
					$stocktakeStoreRoom = doubleval($row->stocktakeStoreRoom);

				$dataArray[] = array('Raw Material' => $rawMaterial->getName(),
									'Unit' => $serveMeasurement->getName(),
									'Unit Price' => StringUtilsAbstract::getValueFromCurrency($unitPrice),
									'Shop Qty' => $stocktakeShop,
									'Store Room Qty' => $stocktakeStoreRoom
				);
			}
// 			array_unshift($result, array_keys($result[0])); // header row
			$filePath = '/tmp/Stocktake_' . str_replace(' ', "_", Core::getStore()->getName()) . '.xls';
			$title = "Stock Take for [" . Core::getStore()->getName() . ']';
			$this->_genFile($filePath, $title, $dataArray);
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
	private function _genFile($filePath, $title, array $data = array())
	{
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
			->setTitle($title)
			->setSubject($title)
			->setDescription($title);
		
		$activeSheet = $objPHPExcel->setActiveSheetIndex(0);
		$startColNo = 1;
		$rowNo = 1;
		$colNo = $startColNo;
		//store row
		$activeSheet->setCellValueByColumnAndRow($colNo++, $rowNo, 'SUSHI STOCKTAKE SHEET')
			->setCellValueByColumnAndRow($colNo++, $rowNo, '')
			->setCellValueByColumnAndRow($colNo++, $rowNo, 'Store:')
			->setCellValueByColumnAndRow($colNo++, $rowNo, Core::getStore()->getName())
			->mergeCellsByColumnAndRow($colNo - 1, $rowNo, $colNo + 1, $rowNo);
		//date row
		$rowNo++;
		$colNo = $startColNo;
		$activeSheet->setCellValueByColumnAndRow($colNo++, $rowNo, '')
			->setCellValueByColumnAndRow($colNo++, $rowNo, '')
			->setCellValueByColumnAndRow($colNo++, $rowNo, 'Date:')
			->setCellValueByColumnAndRow($colNo++, $rowNo, UDate::now()->format('d/m/Y'))
			->mergeCellsByColumnAndRow($colNo - 1, $rowNo, $colNo + 1, $rowNo);
		//title row
		$rowNo++;
		$colNo = $startColNo;
		$activeSheet->setCellValueByColumnAndRow($colNo++, $rowNo, 'Product')
			->setCellValueByColumnAndRow($colNo++, $rowNo, 'Unit')
			->setCellValueByColumnAndRow($colNo++, $rowNo, 'Cost')
			->setCellValueByColumnAndRow($colNo++, $rowNo, 'Stocktak Qty (Shop)')
			->setCellValueByColumnAndRow($colNo++, $rowNo, 'Stocktak Qty (Store Room)')
			->setCellValueByColumnAndRow($colNo++, $rowNo, 'Value');
		$totalValueSum = 0;
		foreach($data as $rowData) {
			$rowNo++;
			$colNo = $startColNo;
			$unitPrice = StringUtilsAbstract::getValueFromCurrency($rowData['Unit']);
			$totalValue = (intval($rowData['Shop Qty']) + intval($rowData['Store Room Qty'])) * $unitPrice;
			$totalValueSum += $totalValue;
			$activeSheet->setCellValueByColumnAndRow($colNo++, $rowNo, $rowData['Raw Material'])
				->setCellValueByColumnAndRow($colNo++, $rowNo, $rowData['Unit'])
				->setCellValueByColumnAndRow($colNo++, $rowNo, StringUtilsAbstract::getCurrency($unitPrice))
				->setCellValueByColumnAndRow($colNo++, $rowNo, $rowData['Shop Qty'])
				->setCellValueByColumnAndRow($colNo++, $rowNo, $rowData['Store Room Qty'])
				->setCellValueByColumnAndRow($colNo++, $rowNo, StringUtilsAbstract::getCurrency($totalValue));
		}
		$rowNo++;
		$colNo = $startColNo;
		$activeSheet->setCellValueByColumnAndRow($colNo++, $rowNo, 'Total')
			->setCellValueByColumnAndRow($colNo++, $rowNo, '')
			->setCellValueByColumnAndRow($colNo++, $rowNo, '')
			->setCellValueByColumnAndRow($colNo++, $rowNo, '')
			->setCellValueByColumnAndRow($colNo++, $rowNo, '')
			->setCellValueByColumnAndRow($colNo++, $rowNo, StringUtilsAbstract::getCurrency($totalValueSum));
	
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
