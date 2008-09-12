#
#
#

CREATE TABLE `movie` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL default '',
  `file` text NOT NULL default '',
  `image_file` text NOT NULL default '',
  `file_url` text NOT NULL,
  `image_file_url` text NOT NULL,  
  `total_time` int(11) NOT NULL default '0',
  `file_type` tinyint(4) NOT NULL default '0',
  `file_size` int(11) NOT NULL default '0',
  `randam_code` varchar(8) NOT NULL default '',
  `desc` text NOT NULL,
  `genre` int(11) NOT NULL default '0',
  `tag_lock` tinyint(1) NOT NULL default '0',
  `valid` tinyint(1) NOT NULL default '1',
  `owner` int(11) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0',
  `comment` int(11) NOT NULL default '0',
  `comment_up_time` int(11) NOT NULL default '0',
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user` int(11) NOT NULL default '0',
  `mod_user` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;

CREATE TABLE `comment` (
  `id` int(11) NOT NULL auto_increment,
  `movie_id` int(11) NOT NULL default '0',
  `comment` text NOT NULL,
  `comment_time` int(11) NOT NULL default '0',
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) NOT NULL default '0',
  `reg_user` int(11) NOT NULL default '0',
  `mod_user` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user` int(11) NOT NULL default '0',
  `mod_user` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) TYPE=MyISAM ;

CREATE TABLE `tag_movie` (
  `id` int(11) NOT NULL auto_increment,
  `tags_id` int(11) NOT NULL default '0',
  `movie_id` int(11) NOT NULL default '0',
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) NOT NULL default '0',
  `reg_user` int(11) NOT NULL default '0',
  `mod_user` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;

CREATE TABLE report (
  id int(11) NOT NULL auto_increment,
  movie_id int(11) NOT NULL default '0',
  category int(11) NOT NULL default '0',
  comment text NOT NULL,
  reg_time int(11) NOT NULL default '0',
  mod_time int(11) NOT NULL default '0',
  reg_user int(11) NOT NULL default '0',
  mod_user int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY movie_id (movie_id)
) TYPE=MyISAM;

		    
CREATE TABLE `genre` (
  `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
  `parent_id` int( 11 ) NOT NULL default '0',
  `name` tinytext NOT NULL ,
  `iorder` int( 11 ) NOT NULL default '0',
  `reg_time` int( 11 ) NOT NULL default '0',
  `mod_time` int( 11 ) default NULL ,
  `reg_user` int( 11 ) NOT NULL default '0',
  `mod_user` int( 11 ) default NULL ,
  PRIMARY KEY ( id )
) TYPE = MYISAM ;
