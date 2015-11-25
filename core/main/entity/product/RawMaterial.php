<?php
/** RawMaterial Entity
 *
 * @package    Core
 * @subpackage Entity
 * @author     lhe<helin16@gmail.com>
 */
class RawMaterial extends InfoEntityAbstract
{
	/**
	 * (non-PHPdoc)
	 * @see BaseEntity::__loadDaoMap()
	 */
	public function __loadDaoMap()
	{
		DaoMap::begin($this, 'raw_mat');

		parent::__loadDaoMap();

		DaoMap::commit();
	}
	/**
	 * Gets ServeMeasurement
	 *
	 * @param bool  $activeOnly
	 * @param int   $pageNo
	 * @param int   $pageSize
	 * @param array $orderBy
	 * @param array $stats
	 * @return Ambigous <Ambigous, multitype:, multitype:BaseEntityAbstract >
	 */
	public function getServeMeasurements($activeOnly = true, $pageNo = null, $pageSize = DaoQuery::DEFAUTL_PAGE_SIZE, $orderBy = array(), &$stats = array())
	{
		$objArray = array();
		$array = RawMaterialInfo::getAllByCriteria('rawMaterialId = ? and typeId = ?', array($this->getId(), RawMaterialInfoType::ID_SERVEMESUREMENT), $activeOnly, $pageNo, $pageSize, $orderBy, $stats);
		if (count($array) > 0) {
		    $ids = array();
			foreach($array as $infoObj)
				$ids[] = ((trim($infoObj->getEntityId()) !== '') ? trim($infoObj->getEntityId()) : trim($infoObj->getValue()));
			$ids = array_unique($ids);
			$objArray = ServeMeasurement::getAllByCriteria('id IN (' . implode(", ", array_fill(0, count($ids), '?')) . ')', $ids);
		}
		return $objArray;
	}

	/**
	 * Clear all the ServeMeasurements of the RawMaterial
	 * @return RawMaterial
	 */
	public function clearServeMeasurements()
	{
		RawMaterialInfo::deleteByCriteria('rawMaterialId = ? and typeId = ?', array($this->getId(), RawMaterialInfoType::ID_SERVEMESUREMENT));
		return $this;
	}
	/**
	 * add a ServeMeasurement to self
	 *
	 * @param ServeMeasurement $serveMeasurement The measurement; BOX, BAG, KG...
	 * @param string           $value            The price of the raw material
	 *
	 * @return RawMaterial
	 */
	public function addServeMeasurement(ServeMeasurement $serveMeasurement, $value = '')
	{
		$this->addInfo(RawMaterialInfoType::get(RawMaterialInfoType::ID_SERVEMESUREMENT), $serveMeasurement, $value, false);
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see InfoEntityAbstract::getJson()
	 */
	public function getJson($extra = array(), $reset = false)
	{
		$array = $extra;
		$measurement = $unitPrice = null;
		if (count($rawMaterialInfo = RawMaterialInfo::getAllByCriteria('rawMaterialId = ? and typeId = ? and entityName=>', array($this->getId(), RawMaterialInfoType::ID_SERVEMESUREMENT, 'ServeMeasurement'), true, 1,1)) > 0) {
		    $measurement = $rawMaterialInfo[0]->getJson();
		    $unitPrice = StringUtilsAbstract::getValueFromCurrency($rawMaterialInfo[0]->getValue());
		}
		$array['serverMeasurement'] = $measurement;
		$array['unitPrice'] = $unitPrice;
		return parent::getJson($array, $reset);
	}
	/**
	 * (non-PHPdoc)
	 * @see InfoEntityAbstract::create()
	 * @return RawMaterial
	 */
	public static function create($name, $description = '')
	{
		return parent::create($name, $description);
	}
}