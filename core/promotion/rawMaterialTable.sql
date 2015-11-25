DROP TABLE IF EXISTS `rawmaterial`;
CREATE TABLE `rawmaterial` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL DEFAULT '',
    `description` varchar(255) NOT NULL DEFAULT '',
    `active` bool NOT NULL DEFAULT 1,
    `created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
    `createdById` int(10) unsigned NOT NULL DEFAULT 0,
    `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `updatedById` int(10) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
    ,INDEX (`createdById`)
    ,INDEX (`updatedById`)
    ,INDEX (`active`)
    ,INDEX (`created`)
    ,INDEX (`updated`)
    ,INDEX (`name`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rawmaterialinfo`;
CREATE TABLE `rawmaterialinfo` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `entityName` varchar(50) NOT NULL DEFAULT '',
    `entityId` int(10) unsigned NOT NULL DEFAULT 0,
    `value` varchar(255) NOT NULL DEFAULT '',
    `rawMaterialId` int(10) unsigned NOT NULL DEFAULT 0,
    `typeId` int(10) unsigned NOT NULL DEFAULT 0,
    `active` bool NOT NULL DEFAULT 1,
    `created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
    `createdById` int(10) unsigned NOT NULL DEFAULT 0,
    `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `updatedById` int(10) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
    ,INDEX (`rawMaterialId`)
    ,INDEX (`typeId`)
    ,INDEX (`createdById`)
    ,INDEX (`updatedById`)
    ,INDEX (`active`)
    ,INDEX (`created`)
    ,INDEX (`updated`)
    ,INDEX (`value`)
    ,INDEX (`entityId`)
    ,INDEX (`entityName`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `rawmaterialinfotype`;
CREATE TABLE `rawmaterialinfotype` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL DEFAULT '',
    `description` varchar(255) NOT NULL DEFAULT '',
    `active` bool NOT NULL DEFAULT 1,
    `created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
    `createdById` int(10) unsigned NOT NULL DEFAULT 0,
    `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `updatedById` int(10) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
    ,INDEX (`createdById`)
    ,INDEX (`updatedById`)
    ,INDEX (`active`)
    ,INDEX (`created`)
    ,INDEX (`updated`)
    ,INDEX (`name`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

TRUNCATE TABLE `rawmaterialinfotype`;
INSERT INTO `rawmaterialinfotype` (`id`, `name`, `description`, `active`, `created`, `createdById`, `updated`, `updatedById`) VALUES
(1, 'ServeMesurement', '', 1, '2015-11-25 04:34:11', 10, '2015-11-24 17:34:34', 10),
(2, 'Cost', '', 1, '2015-11-25 04:35:37', 10, '2015-11-24 17:35:37', 10);
