DROP TABLE IF EXISTS `defaultnutrition`;
CREATE TABLE `defaultnutrition` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`nutritionId` int(10) unsigned NOT NULL DEFAULT 0,
	`serveMeasurementId` int(10) unsigned NOT NULL DEFAULT 0,
	`description` varchar(100) NOT NULL DEFAULT '',
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`nutritionId`)
	,INDEX (`serveMeasurementId`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,INDEX (`active`)
	,INDEX (`created`)
	,INDEX (`updated`)
) ENGINE=innodb DEFAULT CHARSET=utf8;