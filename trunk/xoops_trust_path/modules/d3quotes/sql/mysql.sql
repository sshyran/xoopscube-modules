# phpMyAdmin MySQL-Dump
# version 2.3.3pl1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Apr 06, 2003 at 06:40 PM
# Server version: 3.23.54
# PHP Version: 4.3.0
# Database : `xoops2`
# --------------------------------------------------------

#
# Table structure for table `citas`
#

CREATE TABLE citas (
  id int(11) NOT NULL auto_increment,
  texto text NOT NULL default '',
  autor text NOT NULL default '',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;

