CREATE TABLE menu (
  subid int(8) unsigned NOT NULL auto_increment,
  blockid int(4) unsigned NOT NULL default 0,
  title varchar(255) default NULL,
  url varchar(255) default NULL,
  flow varchar(255) default NULL,
  sortnum int(8) unsigned NOT NULL default 0,
  hiera int(2) unsigned NOT NULL default 0,
  flag int(1) unsigned NOT NULL default 0,
  PRIMARY KEY (subid),
  KEY (blockid),
  KEY (url),
  KEY (sortnum)
) TYPE=MyISAM;



CREATE TABLE addurl (
  addid int(8) unsigned NOT NULL auto_increment,
  subid int(8) unsigned NOT NULL default 0,
  url varchar(255) default NULL,
  PRIMARY KEY (addid),
  KEY (subid),
  KEY (url)
) TYPE=MyISAM;



CREATE TABLE access (
  subid int(8) unsigned NOT NULL default 0,
  groupid smallint(5) default NULL,
  visible tinyint(1) NOT NULL default 0,
  UNIQUE KEY (subid,groupid),
  KEY (subid),
  KEY (groupid)
) TYPE=MyISAM;
