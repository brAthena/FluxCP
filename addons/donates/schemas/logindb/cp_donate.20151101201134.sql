CREATE TABLE IF NOT EXISTS `cp_donate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `userid` varchar(23) NOT NULL,
  `email` varchar(39) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `payment` float NOT NULL,
  `payment_ip` varchar(35) NOT NULL,
  `payment_type` varchar(23) NOT NULL,
  `payment_code` varchar(50) NOT NULL,
  `payment_notification_code` varchar(50) NOT NULL,
  `payment_status` tinyint(3) NOT NULL DEFAULT '0',
  `payment_status_pagseguro` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;