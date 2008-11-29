CREATE TABLE `{prefix}_{dirname}_favorites` (
  `id` int(11) NOT NULL auto_increment,
  `mid` int(8) unsigned NOT NULL default '0',
  `uid` int(8) unsigned NOT NULL default '0',
  `fuid` int(8) unsigned NOT NULL default '0',
  `weight` int(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uni` (`mid`,`uid`,`fuid`),
  KEY `uid` (`uid`)
) TYPE=MyISAM;
