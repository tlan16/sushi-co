ALTER TABLE `nutrition` ADD `defaultServeMeasurementId` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `order`, ADD INDEX (`defaultServeMeasurementId`) ;

update `nutrition` set `defaultServeMeasurementId` = 1  where id = 1;
update `nutrition` set `defaultServeMeasurementId` = 3 where id = 2;
update `nutrition` set `defaultServeMeasurementId` = 1 where id = 3;
update `nutrition` set `defaultServeMeasurementId` = 1 where id = 4;
update `nutrition` set `defaultServeMeasurementId` = 2 where id = 5;
update `nutrition` set `defaultServeMeasurementId` = 1 where id = 6;
update `nutrition` set `defaultServeMeasurementId` = 1 where id = 7;
update `nutrition` set `defaultServeMeasurementId` = 1 where id = 8;