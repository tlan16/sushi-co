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
(1, 'ServeMesurement', '', 1, '2015-11-25 04:34:11', 10, '2015-11-24 17:34:34', 10);

TRUNCATE TABLE `rawmaterial`;
INSERT INTO `rawmaterial` (`id`, `name`, `description`, `active`, `created`, `createdById`, `updated`, `updatedById`) VALUES
(1, 'Salmon Pin Off', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(2, 'Smoked Salmon Slice', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(3, 'Prawn Tempura', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(4, 'Cooked Prawns Tails Off', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(5, '5LV Sushi Prawn', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(6, 'Seaweed Salad', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(7, 'Ika Sansai Salad', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(8, 'Seavalue Seafood Extender', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(9, 'Masago', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(10, 'Baby Octopus Salad', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(11, 'Frozen Tuna Meat Ground', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(12, 'Brown Rice 22.5 kg', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(13, 'Tuna Poach 3KG', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(14, 'Tuna Poach 1KG', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(15, 'Mayonnaise Poach 1KG', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(16, 'Mini Wasabi', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(17, 'Mini Ginger', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(18, 'JFC Mini Mayonnaise', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(19, 'Soy Fish', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(20, 'Sriracha Sauce', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(21, 'Black Sesame Seed', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(22, 'Soft Shell Crab (70-100)', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(23, 'Daikyo Inari', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(24, 'Edamame', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(25, 'KB''s Prawn Gyoza', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(26, 'KB''s Vege Gyoza', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(27, 'Pork Gyoza', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(28, 'Sushi Rice 25KG', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(29, 'Sushi Rice 18.5KG', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(30, 'Vinegar 18L', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(31, 'Katsu Chicken', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(32, 'Rice Paper', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(33, 'Sushi Sauce', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(34, 'Nori Cut Size', 'imported for stocktack phase', 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:03', 10),
(35, 'Nori Full Size', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(36, 'Fried Shallot', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(37, '5 Star Raw Tuna', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(38, 'Teriyaki Chicken 1KG', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(39, 'Teriyaki Chicken 2.5KG', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(40, 'Cucumber', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(41, 'Salad Mix', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(42, 'Carrot', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(43, 'Avocado', 'imported for stocktack phase', 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10);

TRUNCATE TABLE `rawmaterialinfo`;
INSERT INTO `rawmaterialinfo` (`id`, `entityName`, `entityId`, `value`, `rawMaterialId`, `typeId`, `active`, `created`, `createdById`, `updated`, `updatedById`) VALUES
(1, 'ServeMeasurement', 4, '', 1, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(2, 'ServeMeasurement', 4, '', 2, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(3, 'ServeMeasurement', 5, '', 3, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(4, 'ServeMeasurement', 4, '', 4, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(5, 'ServeMeasurement', 5, '', 5, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(6, 'ServeMeasurement', 4, '', 6, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(7, 'ServeMeasurement', 4, '', 7, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(8, 'ServeMeasurement', 4, '', 8, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(9, 'ServeMeasurement', 6, '', 9, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(10, 'ServeMeasurement', 4, '', 10, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(11, 'ServeMeasurement', 4, '', 11, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(12, 'ServeMeasurement', 7, '', 12, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(13, 'ServeMeasurement', 4, '', 13, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(14, 'ServeMeasurement', 4, '', 14, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(15, 'ServeMeasurement', 4, '', 15, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(16, 'ServeMeasurement', 7, '', 16, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(17, 'ServeMeasurement', 7, '', 17, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(18, 'ServeMeasurement', 7, '', 18, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(19, 'ServeMeasurement', 7, '', 19, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(20, 'ServeMeasurement', 8, '', 20, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(21, 'ServeMeasurement', 7, '', 21, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(22, 'ServeMeasurement', 4, '', 22, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(23, 'ServeMeasurement', 7, '', 23, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(24, 'ServeMeasurement', 9, '', 24, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(25, 'ServeMeasurement', 4, '', 25, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(26, 'ServeMeasurement', 4, '', 26, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(27, 'ServeMeasurement', 4, '', 27, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(28, 'ServeMeasurement', 7, '', 28, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(29, 'ServeMeasurement', 7, '', 29, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(30, 'ServeMeasurement', 10, '', 30, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(31, 'ServeMeasurement', 11, '', 31, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(32, 'ServeMeasurement', 7, '', 32, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(33, 'ServeMeasurement', 8, '', 33, 1, 1, '2015-11-26 00:45:02', 10, '2015-11-25 13:45:02', 10),
(34, 'ServeMeasurement', 7, '', 34, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(35, 'ServeMeasurement', 7, '', 35, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(36, 'ServeMeasurement', 4, '', 36, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(37, 'ServeMeasurement', 11, '', 37, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(38, 'ServeMeasurement', 7, '', 38, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(39, 'ServeMeasurement', 7, '', 39, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(40, 'ServeMeasurement', 11, '', 40, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(41, 'ServeMeasurement', 4, '', 41, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(42, 'ServeMeasurement', 4, '', 42, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10),
(43, 'ServeMeasurement', 11, '', 43, 1, 1, '2015-11-26 00:45:03', 10, '2015-11-25 13:45:03', 10);