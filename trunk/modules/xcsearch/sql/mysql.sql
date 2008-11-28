#
# Table structure for table `xcsearch_rank`
#

CREATE TABLE xcsearch_rank (
  query varchar(128) NOT NULL default '',
  day  int(10) UNSIGNED NOT NULL default '0',
  year  int(4) UNSIGNED NOT NULL default '0',
  month int(2) UNSIGNED NOT NULL default '0',
  count int(6) UNSIGNED NOT NULL default '0',
  cxid  int(5) UNSIGNED NOT NULL default '0',
  PRIMARY KEY  (query, day),
  KEY day (day),
  KEY year (year),
  KEY month (year, month)
) TYPE=MyISAM;



#
# Table structure for table `xcsearch_cx`
#

CREATE TABLE xcsearch_cx (
  cxid int(5) UNSIGNED NOT NULL auto_increment,
  cxtitle  varchar(128) NOT NULL default '',
  cxvalue  varchar(40) NOT NULL default '',
  cxorder int(5) UNSIGNED NOT NULL default '0',
  PRIMARY KEY (cxid),
  KEY cxvalue (cxvalue),
  KEY cxorder (cxorder)
) TYPE=MyISAM;

INSERT INTO xcsearch_cx VALUES ( 1 , 'XOOPS Cube' , '000876635602239701517:sgphpglxyi8' , 0 );

