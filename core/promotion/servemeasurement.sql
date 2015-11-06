TRUNCATE TABLE `servemeasurement`;
INSERT INTO `servemeasurement` (`id`, `name`, `description`, `active`, `created`, `createdById`, `updated`, `updatedById`) VALUES
(1, 'g', 'Gram', 1, NOW(), 10, NOW(), 10),
(2, 'mg', 'Mini-Gram', 1, NOW(), 10, NOW(), 10),
(3, 'Cal', 'Calorie', 1, NOW(), 10, NOW(), 10);