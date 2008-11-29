CREATE TABLE IF NOT EXISTS `{prefix}_{dirname}_choice` (
  `choice_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `enq_id` mediumint(8) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`choice_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `{prefix}_{dirname}_enq` (
  `enq_id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `cat_id` smallint(5) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `type` tinyint(2) unsigned NOT NULL,
  `pub_unixtime` int(11) unsigned NOT NULL,
  `end_unixtime` int(11) unsigned NOT NULL,
  `choices` text NOT NULL,
  `description` text NOT NULL,
  `option` text NOT NULL,
  `reg_unixtime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`enq_id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `{prefix}_{dirname}_poll` (
  `poll_id` int(11) unsigned NOT NULL auto_increment,
  `enq_id` mediumint(8) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `choice_id` int(11) unsigned NOT NULL,
  `ip` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `reg_unixtime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`poll_id`)
) ENGINE=MyISAM;
