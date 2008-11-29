# Table structure for table `items`

CREATE TABLE items (
  lid int(11) unsigned NOT NULL auto_increment,
  cid int(5) unsigned NOT NULL default '0',
  uid int(8) unsigned NOT NULL default '0',
  description text NOT NULL default '',
  stats int(2) unsigned NOT NULL default '0',
  regdate int(10) NOT NULL default '0',
  clicks int(11) unsigned NOT NULL default '0',
  ASIN varchar(16) NOT NULL default '',
  title varchar(255) NOT NULL default '',
  Creator varchar(255) NOT NULL default '',
  Manufacturer varchar(255) NOT NULL default '',
  ProductGroup varchar(255) NOT NULL default '',
  MediumImage varchar(255) NOT NULL default '',
  DetailPageURL varchar(255) NOT NULL default 'http://www.amazon.co.jp/',
  IsAdult int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (lid),
  KEY cid (cid),
  KEY uid (uid),
  KEY stat (stats)
) TYPE=MyISAM;

# --------------------------------------------------------
# Table structure for table `cat`

CREATE TABLE cat (
  cid int(5) unsigned NOT NULL auto_increment,
  pid int(5) unsigned NOT NULL default '0',
  corder int(5) unsigned NOT NULL default '0',
  ctitle varchar(50) NOT NULL default '',
  PRIMARY KEY  (cid),
  KEY pid (pid),
  KEY corder (corder)
) TYPE=MyISAM;
