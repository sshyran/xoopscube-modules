#-----------------------------------------------
#---------- IMGTag D3 Module Database Structure
#---------- Original Work By GIJOE
#-----------------------------------------------

#
# Table structure for table `prefix_mydirname_cat`
#

CREATE TABLE cat (
  cid int(5) unsigned NOT NULL auto_increment,
  pid int(5) unsigned NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  imgurl varchar(150) NOT NULL default '',
  weight int(5) unsigned NOT NULL default 0,
  depth int(5) unsigned NOT NULL default 0,
  description text,
  allowed_ext varchar(255) NOT NULL default 'jpg|jpeg|gif|png',
  PRIMARY KEY (cid),
  KEY (weight),
  KEY (depth),
  KEY (pid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prefix_mydirname_photos`
# Column `img` added By KickassAMD v1.01 IMGTag (Holds image filename)
# Column `size` added By KickassAMD v1.0.1 IMGTag (Holds image filesize)
# Column `share` added By KickassAMD v1.0.1 IMGTag (Holds share setting)
#

CREATE TABLE photos (
  lid int(11) unsigned NOT NULL auto_increment,
  img text NOT NULL,
  cid int(5) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  ext varchar(10) NOT NULL default '',
  res_x int(11) NOT NULL default '0',
  res_y int(11) NOT NULL default '0',
  size int(11) NOT NULL default '0',
  submitter int(11) unsigned NOT NULL default '0',
  share int(11) NOT NULL default '0',
  status tinyint(2) NOT NULL default '0',
  date int(10) NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  rating double(6,4) NOT NULL default '0.0000',
  votes int(11) unsigned NOT NULL default '0',
  comments int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (lid),
  KEY (cid),
  KEY (date),
  KEY (status),
  KEY (title)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prefix_mydirname_text`
#

CREATE TABLE text (
  lid int(11) unsigned NOT NULL default '0',
  description text NOT NULL,
  KEY lid (lid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prefix_mydirname_votedata`
#

CREATE TABLE votedata (
  ratingid int(11) unsigned NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  ratinguser int(11) unsigned NOT NULL default '0',
  rating tinyint(3) unsigned NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY (lid),
  KEY (ratinguser),
  KEY (ratinghostname)
) TYPE=MyISAM;

