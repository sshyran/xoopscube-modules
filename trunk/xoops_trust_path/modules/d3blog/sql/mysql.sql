#
# Table structure for table d3blog
#
# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# --------------------------------------------------------

#
# Table Structure category
#

CREATE TABLE category (
  cid mediumint(5) unsigned NOT NULL auto_increment,
  pid mediumint(5) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  weight mediumint(5) unsigned NOT NULL default '0',
  imgurl varchar(150) NOT NULL default '',
  created int(10) NOT NULL default '0',
  PRIMARY KEY  (cid),
  KEY pid (pid)
) TYPE=MyISAM;
INSERT INTO category (
  cid, pid, `name`, weight, imgurl, created)
  VALUES (
    '1', '0', 'Sample', '0', '', '1051983686'
);
# --------------------------------------------------------

#
# Table Structure entry
#

CREATE TABLE entry (
  bid int(8) NOT NULL auto_increment,
  uid int(8) NOT NULL default '0',
  cid mediumint(5) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  excerpt text NOT NULL,
  body text NOT NULL,
  dohtml tinyint(1) UNSIGNED NOT NULL default '0',
  doxcode tinyint(1) UNSIGNED NOT NULL default '1',
  doimage tinyint(1) UNSIGNED NOT NULL default '1',
  dobr tinyint(1) UNSIGNED NOT NULL default '0',
  groups text NOT NULL,
  comments int(10) NOT NULL default '0',
  counter int(10) NOT NULL default '0',
  trackbacks int(10) NOT NULL default '0',
  approved tinyint(1) NOT NULL default '0',
  notified tinyint(1) NOT NULL default '0',
  published int(10) NOT NULL default '0',
  modified int(10) NOT NULL default '0',
  created int(10) NOT NULL default '0',
  PRIMARY KEY  (bid),
  KEY cid (cid),
  KEY uid (uid)
) TYPE=MyISAM;
# --------------------------------------------------------


#
# Table Structure trackback
#

CREATE TABLE trackback (
  tid int(8) NOT NULL auto_increment,
  bid int(8) NOT NULL,
  blog_name varchar(255) NOT NULL,
  title varchar(255) NOT NULL,
  excerpt text NOT NULL,
  url varchar(150) NOT NULL,
  trackback_url varchar(150) NOT NULL,
  direction int(1) NOT NULL default '0',
  `host` varchar(15) NOT NULL,
  tbkey varchar(12) NOT NULL,
  approved int(1) NOT NULL default '0',
  created int(10) NOT NULL default '0',
  PRIMARY KEY (tid),
  KEY bid (bid),
  KEY tbkey (tbkey),
  KEY trackback_url (trackback_url)
) TYPE=MyISAM;
