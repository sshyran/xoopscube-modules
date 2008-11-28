CREATE TABLE `{prefix}_xcat_cat` (
  `cat_id` smallint(5) unsigned NOT NULL auto_increment,
  `cat_title` varchar(255) NOT NULL default '',
  `gr_id` smallint(5) unsigned NOT NULL default '0',
  `p_id` smallint(5) unsigned NOT NULL default '0',
  `modules` text NOT NULL,
  `imageurl` text NOT NULL,
  `cat_desc` text NOT NULL,
  `cat_depth` smallint(5) unsigned NOT NULL default '0',
  `weight` smallint(5) unsigned NOT NULL default '0',
  `options` text NOT NULL,
  PRIMARY KEY  (`cat_id`),
  KEY `gr_id` (`gr_id`),
  KEY `p_id` (`p_id`),
  KEY `weight` (`weight`)
) ENGINE=MyISAM;

CREATE TABLE `{prefix}_xcat_gr` (
  `gr_id` smallint(5) unsigned NOT NULL auto_increment,
  `gr_title` varchar(255) NOT NULL default '',
  `level` tinyint(3) unsigned NOT NULL default '0',
  `actions` text NOT NULL,
  PRIMARY KEY  (`gr_id`)
) ENGINE=MyISAM;


CREATE TABLE `{prefix}_xcat_permit` (
  `permit_id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_id` smallint(5) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `permissions` text NOT NULL,
  PRIMARY KEY  (`permit_id`),
  KEY `uid` (`uid`),
  KEY `groupid` (`groupid`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM;


CREATE TABLE `{prefix}_xcat_mod` (
  `mod_id` mediumint(8) unsigned NOT NULL auto_increment,
  `gr_id` smallint(5) unsigned NOT NULL,
  `mid` smallint(5) unsigned NOT NULL,
  `dir_name` varchar(25) NOT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `option` text NOT NULL,
  PRIMARY KEY  (`mod_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mid` (`mid`),
  KEY `weight` (`weight`)
) ENGINE=MyISAM;
