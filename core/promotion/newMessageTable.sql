CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transId` varchar(32) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `from` varchar(200) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(200) NOT NULL DEFAULT '',
  `body` longtext NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '',
  `attachAssetIds` longtext NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
  `createdById` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedById` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `createdById` (`createdById`),
  KEY `updatedById` (`updatedById`),
  KEY `transId` (`transId`),
  KEY `type` (`type`),
  KEY `from` (`from`),
  KEY `to` (`to`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `sushico`.`systemsettings` (`id`, `type`, `value`, `description`, `active`, `created`, `createdById`, `updated`, `updatedById`) VALUES (NULL, 'system_email_recipients', 'helin16@gmail.com;franklan118@gmail.com;', '', '1', '2015-09-16 00:57:44', '10', '2015-09-15 14:57:44', '10')