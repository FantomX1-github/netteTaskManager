-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `time` double NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `task` (`task_id`, `name`, `desc`, `time`) VALUES
(1,	'dasad',	'predsa',	0),
(2,	'dasd',	'dasda',	4.5),
(3,	'fer',	'dasda',	30.1666666667),
(4,	'fer11',	'dasda',	12.75);

-- 2014-11-19 13:28:55
