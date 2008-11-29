# --------------------------------------------------------
CREATE TABLE field (
  fid int(10) unsigned NOT NULL auto_increment,
  fname varchar(60) NOT NULL default '',
  forder int(11) unsigned NOT NULL default '0',
  visible int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (fid),
  KEY forder (forder)
) TYPE=MyISAM;



# --------------------------------------------------------
CREATE TABLE data (
  did int(11) unsigned NOT NULL auto_increment,
  data text NOT NULL,
  uid int(11) unsigned NOT NULL default '0',
  regidate int(10) NOT NULL default '0',
  embed varchar(255) NOT NULL default '',
  cat_id int(5) unsigned NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (did),
  KEY regidate (regidate),
  KEY uid (uid),
  KEY embed (embed)
) TYPE=MyISAM;


