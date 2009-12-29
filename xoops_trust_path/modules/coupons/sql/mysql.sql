# --------------------------------------------------------
CREATE TABLE cat (
  cid smallint(5) unsigned NOT NULL auto_increment,
  pid smallint(5) unsigned NOT NULL default '0',
  corder int(11) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  imgurl varchar(255) NOT NULL default '',
  PRIMARY KEY  (cid),
  KEY pid (pid),
  KEY corder (corder)
) TYPE=MyISAM;



# --------------------------------------------------------
CREATE TABLE coupons (
  lid int(11) unsigned NOT NULL auto_increment,
  cid smallint(5) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  starttime int(10) NOT NULL default '0',
  endtime int(10) NOT NULL default '0',
  uid int(11) unsigned NOT NULL default '0',
  status tinyint(2) NOT NULL default '0',
  regidate int(10) NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  embed varchar(255) NOT NULL default '',
  PRIMARY KEY  (lid),
  KEY cid (cid),
  KEY status (status),
  KEY title (title),
  KEY embed (embed)
) TYPE=MyISAM;



# --------------------------------------------------------
CREATE TABLE text (
  lid int(11) unsigned NOT NULL default '0',
  description text NOT NULL,
  KEY lid (lid)
) TYPE=MyISAM;

