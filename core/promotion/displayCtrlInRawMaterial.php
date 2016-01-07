<?php
include_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . 'bootstrap.php');

foreach(RawMaterial::getAllByCriteria('active = :active', array('active' => false), false) as $rawMaterial)
{
    echo trim($rawMaterial) . ' ... ';
    $rawMaterial->setShowInPlaceOrder(0)->save();
    $rawMaterial->setActive(1)->save();
    echo 'done' . PHP_EOL;
}