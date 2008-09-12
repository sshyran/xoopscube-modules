CREATE TABLE `{prefix}_{dirname}_comment` (
  `com_modid` int(5) unsigned NOT NULL default '0',
  `com_itemid` int(8) unsigned NOT NULL default '0',
  `com_id` int(8) unsigned NOT NULL default '0',
  `com_text` text NOT NULL,
  `com_uid` int(8) unsigned NOT NULL default '0',
  `com_name` varchar(255) NOT NULL default '',
  `com_ip` varchar(32) NOT NULL default '',
  `com_time` int(10) unsigned NOT NULL default '0',
  `com_status` tinyint(1) unsigned NOT NULL default '0',
  `com_xcode` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY (`com_modid`, `com_itemid`, `com_id`)
) TYPE = MyISAM;
