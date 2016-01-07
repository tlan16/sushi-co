ALTER TABLE `rawmaterial` ADD `showInStockTake` BOOLEAN NOT NULL DEFAULT TRUE AFTER `position`;
ALTER TABLE `rawmaterial` ADD `showInPlaceOrder` BOOLEAN NOT NULL DEFAULT TRUE AFTER `showInStockTake`;
