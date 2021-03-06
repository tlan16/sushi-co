<?php

class ListController extends CRUDPageAbstract
{
    /**
     * The menu item identifier
     *
     * @var string
     */
    public $menuItem = 'product';
    /**
     * Constructor
     */
	public function __construct()
	{
		parent::__construct();
		$this->_focusEntity = 'Product';
	}
	/**
	 * (non-PHPdoc)
	 * @see CRUDPageAbstract::_getEndJs()
	 */
	protected function _getEndJs()
	{
		$js = parent::_getEndJs();
		if(isset($this->Request['cateId'])) {
		    if (!($category = Category::get(trim($this->Request['cateId']))) instanceof Category)
		        die("invalid category provided.");
		    $preValues = array('categories' => array($category->getJson()));
		    $js .= "pageJs.setPreValues(" . json_encode($preValues) . ");";
		}
		$js .= "pageJs.loadSelect2();";
		$js .= "pageJs._bindSearchKey();";
		$js .= "pageJs._setCanEdit(" . (AccessControl::isAdminUser(Core::getRole()) === true ? 'true' : 'false') . ");";
		$js .= 'pageJs.setCallbackId("printLabel", "' . $this->printLabelBtn->getUniqueID(). '")';
		$js .= '.setCallbackId("updateItem", "' . $this->updateItemBtn->getUniqueID(). '");';
		$js .= "pageJs.getSearchCriteria().getResults(true, " . $this->pageSize . ");";
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

			$serachCriteria = isset($param->CallbackParameter->searchCriteria) ? json_decode(json_encode($param->CallbackParameter->searchCriteria), true) : array();

			$where = array(1);
			$params = array();
			$query = $class::getQuery();
			foreach($serachCriteria as $field => $value)
			{
				if((is_array($value) && count($value) === 0) || (is_string($value) && ($value = trim($value)) === ''))
					continue;

				switch ($field)
				{
					case 'pro.name':
					case 'pro.description':
					case 'pro.barcode':
					case 'pro.usedByVariance':
					case 'pro.description':
					case 'pro.description':
						{
							$searchTokens = array();
							StringUtilsAbstract::permute(preg_split("/[\s,]+/", $value), $searchTokens);
							$likeArray = array();
							foreach($searchTokens as $index => $tokenArray)
							{
								$key = md5($field . $index);
								$params[$key] = '%' . implode('%', $tokenArray) . '%';
								$likeArray[] = $field . " like :" . $key;
							}

							$where[] = '(' . implode(' OR ', $likeArray) . ')';
							break;
						}
					case 'pro.size':
					case 'pro.unitPrice':
					case 'pro.labelVersionNo':
						{
							$key = md5($field);
							$where[] =  $field . " = :" . $key;
							$params[$key] = $value;
							break;
						}
					case 'pro.categories':
						{
							$ingredients = explode(',', trim($value));
							if(count($value) > 0)
							{
								$ps = array();
								$keys = array();
								foreach($ingredients as $index => $value){
									$key = md5($field . '_' . $index);
									$keys[] = ':' . $key;
									$ps[$key] = trim($value);
								}
								$key = md5($field . '_' . 'entityName');
								$ps[$key] = 'Category';
								$query->eagerLoad('Product.infos', 'inner join', 'pro_info_cat', 'pro_info_cat.active = 1 and pro.id = pro_info_cat.productId and pro_info_cat.entityName = :' . $key . ' and pro_info_cat.entityId in (' . implode(',', $keys) . ') and pro_info_cat.typeId = ' . ProductInfoType::ID_CATEGORY);
								$params = array_merge($params, $ps);
							}
							break;
						}
				}
			}
			$stats = array();

			$keys['pro_info.typeId'] = md5('pro_info.typeId');
			$params[$keys['pro_info.typeId']] = ProductInfoType::ID_STORE;

			$keys['pro_info.entityName'] = md5('pro_info.entityName');
			$params[$keys['pro_info.entityName']] = ProductInfoType::ENTITY_NAME_STORE;

			$keys['pro_info.entityId'] = md5('pro_info.entityId');
			$params[$keys['pro_info.entityId']] = Core::getStore()->getId();

			$query->eagerLoad('Product.infos', 'inner join', 'pro_info_store', '(pro_info_store.active = 1 and pro_info_store.productId = pro.id and pro_info_store.active = 1 and pro_info_store.typeId = :' . $keys['pro_info.typeId'] . ' and pro_info_store.entityName = :' . $keys['pro_info.entityName'] . ' and (pro_info_store.entityId = :' . $keys['pro_info.entityId'] . ' or pro_info_store.entityId = 0))');

			$objects = $class::getAllByCriteria(implode(' AND ', $where), $params, true, $pageNo, $pageSize, array('name' => 'desc'), $stats);
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
	 * Getting the items
	 *
	 * @param unknown $sender
	 * @param unknown $param
	 * @throws Exception
	 *
	 */
	public function printLabel($sender, $params)
	{
		$results = $errors = array();
		try
		{
			$focusEntity = trim($this->_focusEntity);
			if (!isset ( $params->CallbackParameter->id ) || !($entity = $focusEntity::get(intval($params->CallbackParameter->id))) instanceof $focusEntity )
				throw new Exception ( 'System Error: invalid id passed in.' );
			if (!isset ( $params->CallbackParameter->utcOffset ))
				throw new Exception ( 'System Error: invalid id passed in.' );
			$utcOffset = intval($params->CallbackParameter->utcOffset);
			$newLabel = null;
			$entity->printLabel(null, null, $newLabel);
			$imgFile = LabelPrinter::generateHTML($newLabel, 270, 800, $utcOffset * 60);
			$results['item'] = $imgFile;
		}
		catch(Exception $ex)
		{
			$errors[] = $ex->getMessage() . $ex->getTraceAsString();
		}
		$params->ResponseData = StringUtilsAbstract::getJson($results, $errors);
	}
}