CREATE TABLE `cp_v4p_votelogs` (
  `rtid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `f_site_id` int(10) unsigned NOT NULL,
  `unblock_time` datetime NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(100) DEFAULT '0',
  PRIMARY KEY (`rtid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;