# phpMyAdmin MySQL-Dump
# version 2.2.2
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# --------------------------------------------------------

#
# Table structure for table `broken`
#

CREATE TABLE broken (
  reportid int(5) NOT NULL auto_increment,
  lid int(11) NOT NULL default '0',
  sender int(11) NOT NULL default '0',
  ip varchar(20) NOT NULL default '',
  PRIMARY KEY  (reportid),
  KEY (lid),
  KEY (sender),
  KEY (ip)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `cat`
#

CREATE TABLE cat (
  cid int(5) unsigned NOT NULL auto_increment,
  pid int(5) unsigned NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  imgurl varchar(150) NOT NULL default '',
  shotsdir varchar(150) NOT NULL default '',
  cat_weight smallint(5) NOT NULL default '0',
  submit_message  text,
  PRIMARY KEY  (cid),
  KEY pid (pid)
) TYPE=MyISAM;

INSERT INTO cat (
  cid, pid, title, imgurl, cat_weight, submit_message )
  VALUES (
    '1', '0', 'Sample', '', '0', ''
);
# --------------------------------------------------------

#
# Table structure for table `downloads`
#

CREATE TABLE downloads (
  lid int(11) unsigned NOT NULL auto_increment,
  cid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(250) NOT NULL default '',
  filename varchar(50) NOT NULL default '',
  ext varchar(10) NOT NULL default '',
  homepage varchar(100) NOT NULL default '',
  version varchar(10) NOT NULL default '',
  size int(8) NOT NULL default '0',
  platform varchar(50) NOT NULL default '',
  logourl varchar(60) NOT NULL default '',
  description text,
  html tinyint(1) NOT NULL default '0',
  smiley tinyint(1) NOT NULL default '0',
  br tinyint(1) NOT NULL default '0',
  xcode tinyint(1) NOT NULL default '0',
  submitter int(11) NOT NULL default '0',
  mail varchar(250) NOT NULL default '',
  date int(10) NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  rating double(6,4) NOT NULL default '0.0000',
  votes int(11) unsigned NOT NULL default '0',
  visible tinyint(1) NOT NULL default '1',
  cancomment tinyint(2) NOT NULL default '1',
  comments int(11) unsigned NOT NULL default '0',
  kanrisya text,
  PRIMARY KEY  (lid),
  KEY (cid),
  KEY (visible),
  KEY (cancomment)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `unapproval`
#

CREATE TABLE unapproval (
  requestid int(11) unsigned NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  cid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(250) NOT NULL default '',
  filename varchar(50) NOT NULL default '',
  ext varchar(10) NOT NULL default '',
  homepage varchar(100) NOT NULL default '',
  version varchar(10) NOT NULL default '',
  size int(8) NOT NULL default '0',
  platform varchar(50) NOT NULL default '',
  logourl varchar(60) NOT NULL default '',
  description text,
  html tinyint(1) NOT NULL default '0',
  smiley tinyint(1) NOT NULL default '0',
  br tinyint(1) NOT NULL default '0',
  xcode tinyint(1) NOT NULL default '0',
  submitter int(11) NOT NULL default '0',
  mail varchar(250) NOT NULL default '',
  date int(10) NOT NULL default '0',
  visible tinyint(1) NOT NULL default '1',
  cancomment tinyint(2) NOT NULL default '1',
  notify tinyint(2) NOT NULL default '1',
  kanrisya text,
  PRIMARY KEY  (requestid),
  KEY lid (lid),
  KEY cid (cid),
  KEY title (title(40))
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `downloads_history`
#

CREATE TABLE downloads_history (
  id int(11) unsigned NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  cid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(250) NOT NULL default '',
  filename varchar(50) NOT NULL default '',
  ext varchar(10) NOT NULL default '',
  description text,
  date int(10) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY  (lid),
  KEY (cid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `user_access`
#

CREATE TABLE user_access (
  cid mediumint(5) default NULL,
  uid mediumint(8) default NULL,
  groupid smallint(5) default NULL,
  can_read tinyint(1) NOT NULL default 0,
  can_post tinyint(1) NOT NULL default 0,
  can_edit tinyint(1) NOT NULL default 0,
  can_delete tinyint(1) NOT NULL default 0,
  post_auto_approved tinyint(1) NOT NULL default 0,
  edit_auto_approved tinyint(1) NOT NULL default 0,
  html tinyint(1) NOT NULL default 0,
  upload tinyint(1) NOT NULL default 0,
  KEY (cid),
  KEY (uid),
  KEY (groupid),
  KEY (can_post)
) TYPE=MyISAM;

INSERT INTO user_access (
  cid, groupid, can_read, can_post, can_edit, can_delete, post_auto_approved,edit_auto_approved,html,upload )
  VALUES (
    '1', '1', '1', '1', '1', '1', '1', '1', '0', '1'
);
# --------------------------------------------------------

#
# Table structure for table `votedata`
#

CREATE TABLE votedata (
  ratingid int(11) unsigned NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  ratinguser int(11) NOT NULL default '0',
  rating tinyint(3) unsigned NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY (lid),
  KEY (ratinguser),
  KEY (ratingtimestamp)
) TYPE=MyISAM;
