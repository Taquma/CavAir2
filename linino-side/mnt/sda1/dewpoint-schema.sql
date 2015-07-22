
CREATE SCHEMA `dewpoints` DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_unicode_ci;

USE `dewpoints`;

CREATE TABLE `dht22_datas` (

    `id` INT(11) NOT NULL AUTO_INCREMENT,

    `temperature_inside` FLOAT NOT NULL,

    `temperature_outside` FLOAT NOT NULL,

    `humidity_inside` FLOAT NOT NULL,

    `humidity_outside` FLOAT NOT NULL,

    `dewpoint_inside` FLOAT NOT NULL,

    `dewpoint_outside` FLOAT NOT NULL,

    `dewpoints_difference` FLOAT NOT NULL,

    `fan_state` enum('0','1') NOT NULL DEFAULT '0',

    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,



    PRIMARY KEY (`id`)

) 
ENGINE = InnoDB 
DEFAULT CHARACTER SET = utf8 
COLLATE = utf8_unicode_ci;


 
