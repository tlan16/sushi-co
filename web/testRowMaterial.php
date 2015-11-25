<?php
require_once dirname(__FILE__) . '/bootstrap.php';
Core::setUser(UserAccount::get(UserAccount::ID_SYSTEM_ACCOUNT));

function getRandString($prefix = '')
{
	return $prefix . trim($now = UDate::now(UDate::TIME_ZONE_MELB)) . '_' . md5(rand(0, PHP_INT_MAX));
}
function readData($filePath)
{
	include_once dirname(__FILE__) . '/data/parsecsv.lib.php';
	$csv = new parseCSV();
	$csv->auto($filePath);
	return $csv->data;
}
function importRowData($filePath)
{
	// create RawMaterialInfoTypes
	RawMaterialInfoType::create('Serve Measurement');
	RawMaterialInfoType::create('Cost');
	
	$data = readData($filePath);
	foreach ($data as $row)
	{
		if(isset($row['RowMaterial']) && ($RowMaterial = trim($row['RowMaterial'])) !== '' && isset($row['ServeMeasurement']) && ($ServeMeasurement = trim($row['ServeMeasurement'])) !== '')
		{
			$ServeMeasurement = ServeMeasurement::create($ServeMeasurement, 'imported for stocktack phase');
			echo getObjCreatedMsg($ServeMeasurement);
			$RowMaterial = RawMaterial::create($RowMaterial, 'imported for stocktack phase');
			echo getObjCreatedMsg($RowMaterial);
			$RowMaterial->addServeMeasurement($ServeMeasurement)->save();
			echo 'addServeMeasurement done' . PHP_EOL;
		}
	}
}
function getObjCreatedMsg(BaseEntityAbstract $obj)
{
	return get_class($obj) . '[' . $obj->getId() . '] created' . PHP_EOL;
}
try {
	$transStarted = false;
	try {Dao::beginTransaction();} catch(Exception $e) {$transStarted = true;}

	importRowData(dirname(__FILE__) . "/data/Stocktack.csv");

	if($transStarted === false)
		Dao::commitTransaction();
} catch (Exception $ex) {
	if($transStarted === false)
		Dao::rollbackTransaction();
		throw $ex;
}