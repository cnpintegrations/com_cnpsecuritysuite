CREATE TABLE IF NOT EXISTS `#__cnpsecuritysuite_keys` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`apikey` VARCHAR(255)  NOT NULL ,
`vendor` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__cnpsecuritysuite_keys` (`vendor`) VALUES
('Watchfuli'),
('Pingdom');

