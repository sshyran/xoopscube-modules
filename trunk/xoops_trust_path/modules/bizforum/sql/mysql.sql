CREATE TABLE {prefix}_{dirname}_post (
  `post_id` int(11) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL,
  `guest_name` varchar(16) NOT NULL,
  `p_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `bodytext` text NOT NULL,
  `reg_unixtime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`post_id`),
  KEY `uid` (`uid`),
  KEY `p_id` (`p_id`),
  KEY `topic_id` (`topic_id`),
  KEY `reg_unixtime` (`reg_unixtime`)
) TYPE=MyISAM;

CREATE TABLE {prefix}_{dirname}_topic (
  `topic_id` int(11) unsigned NOT NULL auto_increment,
  `topic_title` varchar(255) NOT NULL,
  `cat_id` smallint(5) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `guest_name` varchar(16) NOT NULL,
  `external_link` varchar(64) NOT NULL,
  `bodytext` text NOT NULL,
  `option` text NOT NULL,
  `reg_unixtime` int(11) unsigned NOT NULL,
  `last_id` mediumint(8) unsigned NOT NULL,
  `last_unixtime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`topic_id`),
  KEY `uid` (`uid`),
  KEY `p_id` (`cat_id`),
  KEY `topic_id` (`last_unixtime`),
  KEY `reg_unixtime` (`reg_unixtime`)
) TYPE=MyISAM;
