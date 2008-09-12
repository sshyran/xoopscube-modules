-- 
-- `cubookmarken_bm`
-- 

CREATE TABLE `{prefix}_cubookmarken_bm` (
  `bm_id` int(11) unsigned NOT NULL auto_increment,
  `bm_title` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `memo` text NOT NULL,
  `reg_unixtime` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bm_id`),
  KEY `url` (`url`),
  KEY `uid` (`uid`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- `cubookmarken_tag`
-- 

CREATE TABLE `{prefix}_cubookmarken_tag` (
  `tag_id` int(11) unsigned NOT NULL auto_increment,
  `tag_name` varchar(64) NOT NULL default '',
  `bm_id` int(11) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `reg_unixtime` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tag_id`),
  KEY `tag_name` (`tag_name`),
  KEY `bm_id` (`bm_id`),
  KEY `uid` (`uid`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

