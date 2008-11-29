

DROP TABLE IF EXISTS xoops_waffle0_column;
DROP TABLE IF EXISTS xoops_waffle0_config;
DROP TABLE IF EXISTS xoops_waffle0_data1;
DROP TABLE IF EXISTS xoops_waffle0_data2;
DROP TABLE IF EXISTS xoops_waffle0_data3;
DROP TABLE IF EXISTS xoops_waffle0_data4;
DROP TABLE IF EXISTS xoops_waffle0_data5;
DROP TABLE IF EXISTS xoops_waffle0_data6;
DROP TABLE IF EXISTS xoops_waffle0_data7;
DROP TABLE IF EXISTS xoops_waffle0_data8;
DROP TABLE IF EXISTS xoops_waffle0_data9;
DROP TABLE IF EXISTS xoops_waffle0_data10;
DROP TABLE IF EXISTS xoops_waffle0_file;
DROP TABLE IF EXISTS xoops_waffle0_grant_group;
DROP TABLE IF EXISTS xoops_waffle0_grant_user;
DROP TABLE IF EXISTS xoops_waffle0_image;
DROP TABLE IF EXISTS xoops_waffle0_option;
DROP TABLE IF EXISTS xoops_waffle0_table;


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_column`
--

CREATE TABLE `xoops_waffle0_column` (
  `id` int(11) NOT NULL auto_increment,
  `table_id` int(11) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `desc` tinytext NOT NULL,
  `type` tinyint(4) NOT NULL default '0',
  `valid` tinyint(4) NOT NULL default '0',
  `uniq` tinyint(4) NOT NULL default '0',
  `not_null` tinyint(4) NOT NULL default '0',
  `default` mediumtext NOT NULL,
  `order` int(11) NOT NULL default '0',
  `primary_key` int(11) NOT NULL default '0',
  `fixed` tinyint(4) NOT NULL default '0',
  `serial` tinyint(4) NOT NULL default '0',
  `detailview` int(11) NOT NULL default '0',
  `insertview` tinyint(4) default NULL,
  `updateview` tinyint(4) default NULL,
  `listview` tinyint(4) NOT NULL default '0',
  `updatable` tinyint(4) default NULL,
  `search` tinyint(4) NOT NULL default '0',
  `maxlength` int(11) NOT NULL default '0',
  `size` int(11) NOT NULL default '0',
  `rows` int(11) default NULL,
  `cols` int(11) default NULL,
  `rel_table` tinytext,
  `rel_column` tinytext,
  `rel_v_column` tinytext,
  `rel_where` tinytext,
  `rel_type` tinytext,
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) NOT NULL default '0',
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_column`
--

INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (1,1,'t1_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656172,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (2,1,'t1_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656172,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (3,1,'t1_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656172,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (4,1,'t1_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656172,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (5,1,'t1_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656172,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (6,2,'t2_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1157960015,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (7,2,'t2_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1157960015,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (8,2,'t2_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1157960015,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (9,2,'t2_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1157960015,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (10,2,'t2_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1157960015,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (11,3,'t3_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656129,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (12,3,'t3_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656129,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (13,3,'t3_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656129,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (14,3,'t3_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656129,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (15,3,'t3_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1144656129,0,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (16,4,'t4_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (17,4,'t4_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (18,4,'t4_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (19,4,'t4_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (20,4,'t4_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (21,5,'t5_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (22,5,'t5_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (23,5,'t5_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (24,5,'t5_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (25,5,'t5_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (26,6,'t6_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (27,6,'t6_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (28,6,'t6_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (29,6,'t6_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (30,6,'t6_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (31,7,'t7_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (32,7,'t7_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (33,7,'t7_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (34,7,'t7_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (35,7,'t7_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (36,8,'t8_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (37,8,'t8_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (38,8,'t8_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (39,8,'t8_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (40,8,'t8_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (41,9,'t9_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (42,9,'t9_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (43,9,'t9_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (44,9,'t9_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (45,9,'t9_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (46,10,'t10_id','ID',1,1,1,1,'',0,1,1,1,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (47,10,'t10_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (48,10,'t10_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,1,1,1,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (49,10,'t10_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (50,10,'t10_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,1,1,0,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (51,1,'t1_c1','国名',2,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144645021,1144656172,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (52,1,'t1_c2','国旗',13,0,0,0,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144645038,1144656172,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (53,1,'t1_c3','首都',2,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144645054,1144656172,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (54,1,'t1_c4','通貨',2,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144645099,1144656172,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (55,1,'t1_c5','ccTLD',2,0,0,0,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144645122,1144656172,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (56,2,'t2_c1','名前',2,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144646946,1157960015,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (57,2,'t2_c2','フォーム',15,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,0,5,30,NULL,NULL,NULL,NULL,NULL,1144646981,1157960015,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (58,2,'t2_c3','HTMLソース',3,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,0,5,30,NULL,NULL,NULL,NULL,NULL,1144646996,1157960015,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (59,3,'t3_c1','名前',2,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144655783,1144656129,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (60,3,'t3_c2','年齢層',8,0,0,1,'1',100,0,0,0,1,1,1,1,1,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,1144655834,1144656129,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (61,3,'t3_c3','居住地',7,0,0,1,'1',100,0,0,0,1,1,1,1,1,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,1144655971,1144656129,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (62,3,'t3_c4','メールアドレス',6,0,0,1,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,NULL,NULL,NULL,NULL,NULL,1144656026,1144656129,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (63,3,'t3_c5','メールマガジンを受け取る',9,0,0,0,'1',100,0,0,0,1,1,1,1,1,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,1144656050,1144656129,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (64,3,'t3_c6','ご意見・ご要望',3,0,0,0,'',100,0,0,0,1,1,1,1,1,1,255,0,5,30,NULL,NULL,NULL,NULL,NULL,1144656071,1144656129,1,1);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (65,4,'t4_c1','メーカー名',2,1,0,0,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,'waffle0_data','t_id','',NULL,NULL,1145434088,NULL,1,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (66,4,'t4_c2','所在地',2,1,0,0,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,'waffle0_data','t_id','',NULL,NULL,1145434115,NULL,1,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (67,5,'t5_c1','名前',2,1,0,0,'',100,0,0,0,1,1,1,1,1,1,255,32,0,0,'waffle0_data','t_id','',NULL,NULL,1145434133,NULL,1,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (68,5,'t5_c2','文具メーカー',22,1,0,0,'',100,0,0,0,1,1,1,1,1,0,0,0,0,0,'waffle0_data4','t4_id','t4_c1',NULL,NULL,1145434154,NULL,1,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (69,5,'t5_c3','値段',1,1,0,0,'',100,0,0,0,1,1,1,1,1,0,0,0,0,0,'waffle0_data','t_id','',NULL,NULL,1145434168,NULL,1,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (70,2,'t2_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (71,3,'t3_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (72,1,'t1_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (73,4,'t4_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (74,5,'t5_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (75,6,'t6_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (76,7,'t7_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (77,8,'t8_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (78,9,'t9_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (79,10,'t10_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_config`
--

CREATE TABLE `xoops_waffle0_config` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `value` mediumtext NOT NULL,
  `flag_serialize` tinyint(1) NOT NULL default '0',
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) NOT NULL default '0',
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_config`
--

INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (3,'data1_index','5',0,1144645021,1144645122,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (5,'waffle0_data1.yml','---\nname: waffle0_data1\ndesc: アジアの国\nvalid: 1\nvalidable: \nvalidable_column: t1_valid\ncreate_datetime_column_name: t1_reg_time\nupdate_datetime_column_name: t1_mod_time\ncreate_user_id_column_name: t1_reg_user_id\nupdate_user_id_column_name: t1_mod_user_id\ncolumns: \n  - \n    name: t1_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t1_c1\n    desc: 国名\n    type: string\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t1_c2\n    desc: 国旗\n    type: image_url\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t1_c3\n    desc: 首都\n    type: string\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t1_c4\n    desc: 通貨\n    type: string\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t1_c5\n    desc: ccTLD\n    type: string\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t1_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t1_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t1_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t1_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144645022,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (9,'waffle0_data2.yml','---\nname: waffle0_data2\ndesc: HTMLフォーム\nvalid: 1\nvalidable: \nvalidable_column: t2_valid\ncreate_datetime_column_name: t2_reg_time\nupdate_datetime_column_name: t2_mod_time\ncreate_user_id_column_name: t2_reg_user_id\nupdate_user_id_column_name: t2_mod_user_id\ncolumns: \n  - \n    name: t2_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    listview: 1\n  - \n    name: t2_c1\n    desc: 名前\n    type: string\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t2_c2\n    desc: フォーム\n    type: htmltext\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    rows: 5\n    cols: 30\n  - \n    name: t2_c3\n    desc: HTMLソース\n    type: textarea\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    rows: 5\n    cols: 30\n  - \n    name: t2_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    listview: 1\n  - \n    name: t2_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    listview: 1\n  - \n    name: t2_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n  - \n    name: t2_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n',0,1144646618,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (10,'waffle0_data3.yml','---\nname: waffle0_data3\ndesc: アンケートフォーム\nvalid: 1\nvalidable: \nvalidable_column: t3_valid\ncreate_datetime_column_name: t3_reg_time\nupdate_datetime_column_name: t3_mod_time\ncreate_user_id_column_name: t3_reg_user_id\nupdate_user_id_column_name: t3_mod_user_id\ncolumns: \n  - \n    name: t3_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t3_c1\n    desc: 名前\n    type: string\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t3_c2\n    desc: 年齢層\n    type: select\n    not_null: 1\n    default: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    enum: \n      - |\n        〜10才\n        \n      - |\n        11才〜15才\n        \n      - |\n        16才〜20才\n        \n      - |\n        21才〜30才\n        \n      - |\n        31才〜50才\n        \n      - |\n        51才〜\n        \n  - \n    name: t3_c3\n    desc: 居住地\n    type: radio\n    not_null: 1\n    default: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    enum: \n      - |\n        北海道\n        \n      - |\n        東北\n        \n      - |\n        関東\n        \n      - |\n        北陸\n        \n      - |\n        近畿\n        \n      - |\n        中国\n        \n      - |\n        四国\n        \n      - |\n        九州\n        \n      - |\n        沖縄\n        \n      - |\n        海外\n        \n  - \n    name: t3_c4\n    desc: メールアドレス\n    type: email\n    not_null: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t3_c5\n    desc: メールマガジンを受け取る\n    type: checkbox\n    default: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t3_c6\n    desc: ご意見・ご要望\n    type: textarea\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    rows: 5\n    cols: 30\n  - \n    name: t3_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t3_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t3_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t3_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144646618,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (11,'waffle0_data4.yml','---\nname: waffle0_data4\ndesc: 文具メーカー\nvalid: 1\nvalidable: \nvalidable_column: t4_valid\ncreate_datetime_column_name: t4_reg_time\nupdate_datetime_column_name: t4_mod_time\ncreate_user_id_column_name: t4_reg_user_id\nupdate_user_id_column_name: t4_mod_user_id\ncolumns: \n  - \n    name: t4_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t4_c1\n    desc: メーカー名\n    type: string\n    valid: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t4_c2\n    desc: 所在地\n    type: string\n    valid: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t4_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t4_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t4_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t4_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144646619,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (12,'waffle0_data5.yml','---\nname: waffle0_data5\ndesc: 文房具\nvalid: 1\nvalidable: \nvalidable_column: t5_valid\ncreate_datetime_column_name: t5_reg_time\nupdate_datetime_column_name: t5_mod_time\ncreate_user_id_column_name: t5_reg_user_id\nupdate_user_id_column_name: t5_mod_user_id\ncolumns: \n  - \n    name: t5_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t5_c1\n    desc: 名前\n    type: string\n    valid: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    maxlength: 255\n    size: 32\n  - \n    name: t5_c2\n    desc: 文具メーカー\n    type: relation\n    valid: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n    rel_table: waffle0_data4\n    rel_column: t4_id\n    rel_v_column: t4_c1\n    rel_where: \n    rel_type: \n  - \n    name: t5_c3\n    desc: 値段\n    type: integer\n    valid: 1\n    order: 100\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t5_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t5_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t5_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t5_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\nrel_exists: 1\n',0,1144646619,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (13,'waffle0_data6.yml','---\nname: waffle0_data6\ndesc: table6\nvalid: 0\nvalidable: \nvalidable_column: t6_valid\ncreate_datetime_column_name: t6_reg_time\nupdate_datetime_column_name: t6_mod_time\ncreate_user_id_column_name: t6_reg_user_id\nupdate_user_id_column_name: t6_mod_user_id\ncolumns: \n  - \n    name: t6_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t6_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t6_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t6_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t6_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144646619,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (14,'waffle0_data7.yml','---\nname: waffle0_data7\ndesc: table7\nvalid: 0\nvalidable: \nvalidable_column: t7_valid\ncreate_datetime_column_name: t7_reg_time\nupdate_datetime_column_name: t7_mod_time\ncreate_user_id_column_name: t7_reg_user_id\nupdate_user_id_column_name: t7_mod_user_id\ncolumns: \n  - \n    name: t7_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t7_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t7_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t7_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t7_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144646619,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (15,'waffle0_data8.yml','---\nname: waffle0_data8\ndesc: table8\nvalid: 0\nvalidable: \nvalidable_column: t8_valid\ncreate_datetime_column_name: t8_reg_time\nupdate_datetime_column_name: t8_mod_time\ncreate_user_id_column_name: t8_reg_user_id\nupdate_user_id_column_name: t8_mod_user_id\ncolumns: \n  - \n    name: t8_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t8_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t8_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t8_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t8_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144646619,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (16,'waffle0_data9.yml','---\nname: waffle0_data9\ndesc: table9\nvalid: 0\nvalidable: \nvalidable_column: t9_valid\ncreate_datetime_column_name: t9_reg_time\nupdate_datetime_column_name: t9_mod_time\ncreate_user_id_column_name: t9_reg_user_id\nupdate_user_id_column_name: t9_mod_user_id\ncolumns: \n  - \n    name: t9_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t9_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t9_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t9_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t9_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144646619,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (17,'waffle0_data10.yml','---\nname: waffle0_data10\ndesc: table10\nvalid: 0\nvalidable: \nvalidable_column: t10_valid\ncreate_datetime_column_name: t10_reg_time\nupdate_datetime_column_name: t10_mod_time\ncreate_user_id_column_name: t10_reg_user_id\nupdate_user_id_column_name: t10_mod_user_id\ncolumns: \n  - \n    name: t10_id\n    desc: ID\n    type: integer\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 0\n    primary_key: 1\n    fixed: 1\n    serial: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t10_reg_time\n    desc: 登録日時\n    type: epoctime\n    valid: 1\n    not_null: 1\n    order: 1100\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t10_mod_time\n    desc: 更新日時\n    type: epoctime\n    valid: 1\n    order: 1200\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    listview: 1\n    updatable: 1\n  - \n    name: t10_reg_user_id\n    desc: 登録ユーザID\n    type: user_id\n    valid: 1\n    uniq: 1\n    not_null: 1\n    order: 1300\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n  - \n    name: t10_mod_user_id\n    desc: 更新ユーザID\n    type: user_id\n    valid: 1\n    order: 1400\n    fixed: 1\n    detailview: 1\n    insertview: 1\n    updateview: 1\n    updatable: 1\n',0,1144646619,1160663204,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (18,'data2_index','3',0,1144646946,1144646996,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (20,'data3_index','6',0,1144655783,1144656071,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (22,'data4_index','2',0,1145434088,1145434115,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (23,'data5_index','3',0,1145434133,1145434168,1,1);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (37,'waffle0_table.yml.cache','O:9:\"wafflemap\":27:{s:4:\"yaml\";a:3:{s:4:\"name\";s:13:\"waffle0_table\";s:4:\"desc\";s:20:\"テーブル情報テーブル\";s:7:\"columns\";a:17:{i:0;a:6:{s:4:\"name\";s:2:\"id\";s:4:\"desc\";s:10:\"テーブルID\";s:4:\"type\";s:7:\"integer\";s:11:\"primary_key\";b:1;s:6:\"serial\";b:1;s:8:\"listview\";b:1;}i:1;a:8:{s:4:\"name\";s:4:\"name\";s:4:\"desc\";s:4:\"名前\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:63;s:4:\"size\";i:40;s:8:\"listview\";b:1;s:4:\"uniq\";b:1;}i:2;a:5:{s:4:\"name\";s:7:\"summary\";s:4:\"desc\";s:4:\"概要\";s:4:\"type\";s:8:\"textarea\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:1024;}i:3;a:5:{s:4:\"name\";s:5:\"valid\";s:4:\"desc\";s:4:\"有効\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;}i:4;a:4:{s:4:\"name\";s:5:\"order\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;}i:5;a:4:{s:4:\"name\";s:9:\"validable\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;}i:6;a:5:{s:4:\"name\";s:3:\"rss\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;s:7:\"default\";i:0;}i:7;a:7:{s:4:\"name\";s:11:\"rss_top_url\";s:4:\"desc\";s:14:\"RSSのトップURL\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;}i:8;a:7:{s:4:\"name\";s:9:\"rss_title\";s:4:\"desc\";s:13:\"RSSのタイトル\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;}i:9;a:7:{s:4:\"name\";s:11:\"rss_summary\";s:4:\"desc\";s:9:\"RSSの概要\";s:4:\"type\";s:8:\"textarea\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;}i:10;a:7:{s:4:\"name\";s:14:\"rss_url_column\";s:4:\"desc\";s:16:\"RSSのURLのカラム\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;}i:11;a:7:{s:4:\"name\";s:16:\"rss_title_column\";s:4:\"desc\";s:21:\"RSSのタイトルのカラム\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;}i:12;a:6:{s:4:\"name\";s:15:\"rss_body_column\";s:4:\"desc\";s:17:\"RSSの本文のカラム\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:8:\"listview\";b:1;}i:13;a:5:{s:4:\"name\";s:8:\"reg_time\";s:4:\"desc\";s:8:\"登録日時\";s:4:\"type\";s:8:\"epoctime\";s:8:\"not_null\";b:0;s:8:\"listview\";b:1;}i:14;a:4:{s:4:\"name\";s:8:\"mod_time\";s:4:\"desc\";s:8:\"更新日時\";s:4:\"type\";s:8:\"epoctime\";s:8:\"not_null\";b:0;}i:15;a:4:{s:4:\"name\";s:11:\"reg_user_id\";s:4:\"desc\";s:12:\"登録ユーザID\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;}i:16;a:3:{s:4:\"name\";s:11:\"mod_user_id\";s:4:\"desc\";s:12:\"更新ユーザID\";s:4:\"type\";s:7:\"integer\";}}}s:9:\"mydirname\";s:7:\"waffle0\";s:16:\"all_select_limit\";i:65536;s:10:\"column_map\";a:17:{s:2:\"id\";a:8:{s:4:\"name\";s:2:\"id\";s:4:\"desc\";s:10:\"テーブルID\";s:4:\"type\";s:7:\"integer\";s:11:\"primary_key\";b:1;s:6:\"serial\";b:1;s:8:\"listview\";b:1;s:3:\"key\";i:0;s:15:\"not_insert_form\";i:1;}s:4:\"name\";a:9:{s:4:\"name\";s:4:\"name\";s:4:\"desc\";s:4:\"名前\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:63;s:4:\"size\";i:40;s:8:\"listview\";b:1;s:4:\"uniq\";b:1;s:3:\"key\";i:1;}s:7:\"summary\";a:6:{s:4:\"name\";s:7:\"summary\";s:4:\"desc\";s:4:\"概要\";s:4:\"type\";s:8:\"textarea\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:1024;s:3:\"key\";i:2;}s:5:\"valid\";a:6:{s:4:\"name\";s:5:\"valid\";s:4:\"desc\";s:4:\"有効\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;s:3:\"key\";i:3;}s:5:\"order\";a:6:{s:4:\"name\";s:5:\"order\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;s:3:\"key\";i:4;s:4:\"desc\";s:5:\"order\";}s:9:\"validable\";a:6:{s:4:\"name\";s:9:\"validable\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;s:3:\"key\";i:5;s:4:\"desc\";s:9:\"validable\";}s:3:\"rss\";a:7:{s:4:\"name\";s:3:\"rss\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:8:\"listview\";b:1;s:7:\"default\";i:0;s:3:\"key\";i:6;s:4:\"desc\";s:3:\"rss\";}s:11:\"rss_top_url\";a:8:{s:4:\"name\";s:11:\"rss_top_url\";s:4:\"desc\";s:14:\"RSSのトップURL\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;s:3:\"key\";i:7;}s:9:\"rss_title\";a:8:{s:4:\"name\";s:9:\"rss_title\";s:4:\"desc\";s:13:\"RSSのタイトル\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;s:3:\"key\";i:8;}s:11:\"rss_summary\";a:8:{s:4:\"name\";s:11:\"rss_summary\";s:4:\"desc\";s:9:\"RSSの概要\";s:4:\"type\";s:8:\"textarea\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;s:3:\"key\";i:9;}s:14:\"rss_url_column\";a:8:{s:4:\"name\";s:14:\"rss_url_column\";s:4:\"desc\";s:16:\"RSSのURLのカラム\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;s:3:\"key\";i:10;}s:16:\"rss_title_column\";a:8:{s:4:\"name\";s:16:\"rss_title_column\";s:4:\"desc\";s:21:\"RSSのタイトルのカラム\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:4:\"size\";i:40;s:8:\"listview\";b:1;s:3:\"key\";i:11;}s:15:\"rss_body_column\";a:7:{s:4:\"name\";s:15:\"rss_body_column\";s:4:\"desc\";s:17:\"RSSの本文のカラム\";s:4:\"type\";s:6:\"string\";s:8:\"not_null\";b:1;s:9:\"maxlength\";i:254;s:8:\"listview\";b:1;s:3:\"key\";i:12;}s:8:\"reg_time\";a:7:{s:4:\"name\";s:8:\"reg_time\";s:4:\"desc\";s:8:\"登録日時\";s:4:\"type\";s:8:\"epoctime\";s:8:\"not_null\";b:0;s:8:\"listview\";b:1;s:3:\"key\";i:13;s:15:\"not_insert_form\";i:1;}s:8:\"mod_time\";a:6:{s:4:\"name\";s:8:\"mod_time\";s:4:\"desc\";s:8:\"更新日時\";s:4:\"type\";s:8:\"epoctime\";s:8:\"not_null\";b:0;s:3:\"key\";i:14;s:15:\"not_insert_form\";i:1;}s:11:\"reg_user_id\";a:6:{s:4:\"name\";s:11:\"reg_user_id\";s:4:\"desc\";s:12:\"登録ユーザID\";s:4:\"type\";s:7:\"integer\";s:8:\"not_null\";b:1;s:3:\"key\";i:15;s:15:\"not_insert_form\";i:1;}s:11:\"mod_user_id\";a:5:{s:4:\"name\";s:11:\"mod_user_id\";s:4:\"desc\";s:12:\"更新ユーザID\";s:4:\"type\";s:7:\"integer\";s:3:\"key\";i:16;s:15:\"not_insert_form\";i:1;}}s:14:\"primary_key_no\";i:0;s:16:\"primary_key_name\";s:2:\"id\";s:27:\"create_datetime_column_name\";s:8:\"reg_time\";s:27:\"update_datetime_column_name\";s:8:\"mod_time\";s:26:\"create_user_id_column_name\";s:11:\"reg_user_id\";s:26:\"update_user_id_column_name\";s:11:\"mod_user_id\";s:8:\"listview\";a:13:{s:2:\"id\";i:1;s:4:\"name\";i:1;s:5:\"valid\";i:1;s:5:\"order\";i:1;s:9:\"validable\";i:1;s:3:\"rss\";i:1;s:11:\"rss_top_url\";i:1;s:9:\"rss_title\";i:1;s:11:\"rss_summary\";i:1;s:14:\"rss_url_column\";i:1;s:16:\"rss_title_column\";i:1;s:15:\"rss_body_column\";i:1;s:8:\"reg_time\";i:1;}s:13:\"list_epoctime\";a:2:{s:8:\"reg_time\";i:1;s:8:\"mod_time\";i:1;}s:10:\"table_name\";s:19:\"xoops_waffle0_table\";s:12:\"image_exists\";b:0;s:11:\"file_exists\";b:0;s:15:\"php_code_exists\";N;s:10:\"rel_exists\";N;s:9:\"rel_table\";a:0:{}s:10:\"rel_column\";a:0:{}s:12:\"rel_v_column\";a:0:{}s:9:\"rel_where\";a:0:{}s:8:\"rel_type\";a:0:{}s:14:\"rel_table_list\";a:0:{}s:15:\"rel_table_alias\";a:0:{}s:7:\"rel_sql\";s:0:\"\";s:9:\"rel_exist\";b:0;s:14:\"php_code_exist\";b:0;}',1,1160663469,NULL,1,NULL);
INSERT INTO `xoops_waffle0_config` (`id`, `name`, `value`, `flag_serialize`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (33,'table_no','10',0,1160663203,NULL,1,NULL);

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data1`
--

CREATE TABLE `xoops_waffle0_data1` (
  `t1_id` int(11) NOT NULL auto_increment,
  `t1_reg_time` int(11) NOT NULL default '0',
  `t1_mod_time` int(11) default NULL,
  `t1_reg_user_id` int(11) NOT NULL default '0',
  `t1_mod_user_id` int(11) default NULL,
  `t1_valid` tinyint(4) default NULL,
  `t1_c1` mediumtext,
  `t1_c2` text,
  `t1_c3` mediumtext,
  `t1_c4` mediumtext,
  `t1_c5` mediumtext,
  PRIMARY KEY  (`t1_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data1`
--

INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (1,1144645182,0,1,0,1,'インド','images/flag/india_50.gif','デリー','インド・ルピー (INR)','.IN');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (2,1144645360,0,1,0,1,'インドネシア共和国','images/flag/indonesia_50.gif','ジャカルタ','ルピア (IDR)','.ID');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (3,1144645456,0,1,0,1,'カンボジア王国','images/flag/cambodia_50.gif','プノンペン','リエル (KHRR)','.KH');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (4,1144645564,0,1,0,1,'朝鮮民主主義人民共和国','images/flag/d_korea_50.gif','平壌','北朝鮮ウォン (KPW)','.KP');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (5,1144645667,0,1,0,1,'シンガポール共和国','images/flag/singapore_50.gif','シンガポール','シンガポールドル (S$) (SGD)','.SG');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (6,1144645761,1144646284,1,1,1,'スリランカ民主社会主義共和国','images/flag/sri_lanka_50.gif','スリ・ジャヤワルダナプラ・コッテ','スリランカ・ルピー (LKR)','.LK');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (7,1144645853,0,1,0,1,'タイ王国','images/flag/thailand_50.gif','バンコク','バーツ (THB)','.TH');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (8,1144646100,0,1,0,1,'台湾','images/flag/taiwan_50.gif','台北市','元','.tw');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (9,1144646158,0,1,0,1,'大韓民国','images/flag/korea_50.gif','ソウル','ウォン (KRW)','.KR');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (10,1144646236,0,1,0,1,'中華人民共和国','images/flag/china_50.gif','北京','人民元 (CNY)','.CN');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (11,1144646375,0,1,0,1,'日本','images/flag/japan_50.gif','東京','円 (JPY)','.JP');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (12,1144646455,0,1,0,1,'パキスタン・イスラム共和国','images/flag/pakistan_50.gif','ショーカット・アジーズ','パキスタン・ルピー (PKR)','.PK');
INSERT INTO `xoops_waffle0_data1` (`t1_id`, `t1_reg_time`, `t1_mod_time`, `t1_reg_user_id`, `t1_mod_user_id`, `t1_valid`, `t1_c1`, `t1_c2`, `t1_c3`, `t1_c4`, `t1_c5`) VALUES (13,1144646549,0,1,0,1,'バングラデシュ人民共和国','images/flag/bangladesh_50.gif','カレダ・ジア','タカ (BDT)','.BD');

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data2`
--

CREATE TABLE `xoops_waffle0_data2` (
  `t2_id` int(11) NOT NULL auto_increment,
  `t2_reg_time` int(11) NOT NULL default '0',
  `t2_mod_time` int(11) default NULL,
  `t2_reg_user_id` int(11) NOT NULL default '0',
  `t2_mod_user_id` int(11) default NULL,
  `t2_valid` tinyint(4) default NULL,
  `t2_c1` mediumtext,
  `t2_c2` mediumtext,
  `t2_c3` mediumtext,
  PRIMARY KEY  (`t2_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data2`
--

INSERT INTO `xoops_waffle0_data2` (`t2_id`, `t2_reg_time`, `t2_mod_time`, `t2_reg_user_id`, `t2_mod_user_id`, `t2_valid`, `t2_c1`, `t2_c2`, `t2_c3`) VALUES (1,1144647155,0,1,0,1,'ボタン','<INPUT TYPE=\"button\" NAME=\"button_name\" VALUE=\"ボタン\">','<INPUT TYPE=\"button\" NAME=\"button_name\" VALUE=\"ボタン\">');
INSERT INTO `xoops_waffle0_data2` (`t2_id`, `t2_reg_time`, `t2_mod_time`, `t2_reg_user_id`, `t2_mod_user_id`, `t2_valid`, `t2_c1`, `t2_c2`, `t2_c3`) VALUES (2,1144647224,0,1,0,1,'チェックボックス','<INPUT TYPE=\"CHECKBOX\" NAME=\"checkbox_name\" CHECKED>チェックボックスサンプル','<INPUT TYPE=\"CHECKBOX\" NAME=\"checkbox_name\" CHECKED>チェックボックスサンプル');
INSERT INTO `xoops_waffle0_data2` (`t2_id`, `t2_reg_time`, `t2_mod_time`, `t2_reg_user_id`, `t2_mod_user_id`, `t2_valid`, `t2_c1`, `t2_c2`, `t2_c3`) VALUES (3,1144647309,0,1,0,1,'ラジオボタン','<INPUT TYPE=\"radio\" NAME=\"radio_name\" VALUE=\"1\" CHECKED>ラジオ１\r\n<INPUT TYPE=\"radio\" NAME=\"radio_name\" VALUE=\"2\">ラジオ２','<INPUT TYPE=\"radio\" NAME=\"radio_name\" VALUE=\"1\" CHECKED>ラジオ１\r\n<INPUT TYPE=\"radio\" NAME=\"radio_name\" VALUE=\"2\">ラジオ２');
INSERT INTO `xoops_waffle0_data2` (`t2_id`, `t2_reg_time`, `t2_mod_time`, `t2_reg_user_id`, `t2_mod_user_id`, `t2_valid`, `t2_c1`, `t2_c2`, `t2_c3`) VALUES (4,1144647401,0,1,0,1,'プルダウンメニュー','<SELECT NAME=\"down\">\r\n<OPTION>メニュー１\r\n<OPTION>メニュー２\r\n</SELECT>','<SELECT NAME=\"down\">\r\n<OPTION>メニュー１\r\n<OPTION>メニュー２\r\n</SELECT>');
INSERT INTO `xoops_waffle0_data2` (`t2_id`, `t2_reg_time`, `t2_mod_time`, `t2_reg_user_id`, `t2_mod_user_id`, `t2_valid`, `t2_c1`, `t2_c2`, `t2_c3`) VALUES (5,1144647569,0,1,0,1,'リストボックス','<SELECT NAME=\"list\" multiple>\r\n<OPTION>リスト１\r\n<OPTION>リスト２\r\n</SELECT>','<SELECT NAME=\"list\" multiple>\r\n<OPTION>リスト１\r\n<OPTION>リスト２\r\n</SELECT>');
INSERT INTO `xoops_waffle0_data2` (`t2_id`, `t2_reg_time`, `t2_mod_time`, `t2_reg_user_id`, `t2_mod_user_id`, `t2_valid`, `t2_c1`, `t2_c2`, `t2_c3`) VALUES (6,1144647606,0,1,0,1,'テキスト','<INPUT TYPE=\"text\" NAME=\"text\">','<INPUT TYPE=\"text\" NAME=\"text\">');
INSERT INTO `xoops_waffle0_data2` (`t2_id`, `t2_reg_time`, `t2_mod_time`, `t2_reg_user_id`, `t2_mod_user_id`, `t2_valid`, `t2_c1`, `t2_c2`, `t2_c3`) VALUES (7,1144647639,0,1,0,1,'テキストエリア','<TEXTAREA NAME=\"textarea\"></TEXTAREA>','<TEXTAREA NAME=\"textarea\"></TEXTAREA>');

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data3`
--

CREATE TABLE `xoops_waffle0_data3` (
  `t3_id` int(11) NOT NULL auto_increment,
  `t3_reg_time` int(11) NOT NULL default '0',
  `t3_mod_time` int(11) default NULL,
  `t3_reg_user_id` int(11) NOT NULL default '0',
  `t3_mod_user_id` int(11) default NULL,
  `t3_valid` tinyint(4) default NULL,
  `t3_c1` mediumtext,
  `t3_c2` tinyint(4) default NULL,
  `t3_c3` tinyint(4) default NULL,
  `t3_c4` text,
  `t3_c5` tinyint(4) default NULL,
  `t3_c6` mediumtext,
  PRIMARY KEY  (`t3_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data3`
--

INSERT INTO `xoops_waffle0_data3` (`t3_id`, `t3_reg_time`, `t3_mod_time`, `t3_reg_user_id`, `t3_mod_user_id`, `t3_valid`, `t3_c1`, `t3_c2`, `t3_c3`, `t3_c4`, `t3_c5`, `t3_c6`) VALUES (1,1144656222,0,1,0,1,'山田一郎',2,2,'yamada@example.com',1,'とくになし');
INSERT INTO `xoops_waffle0_data3` (`t3_id`, `t3_reg_time`, `t3_mod_time`, `t3_reg_user_id`, `t3_mod_user_id`, `t3_valid`, `t3_c1`, `t3_c2`, `t3_c3`, `t3_c4`, `t3_c5`, `t3_c6`) VALUES (2,1144656254,0,1,0,1,'佐藤次郎',4,6,'sato@example.com',1,'');
INSERT INTO `xoops_waffle0_data3` (`t3_id`, `t3_reg_time`, `t3_mod_time`, `t3_reg_user_id`, `t3_mod_user_id`, `t3_valid`, `t3_c1`, `t3_c2`, `t3_c3`, `t3_c4`, `t3_c5`, `t3_c6`) VALUES (3,1144656287,0,1,0,1,'鈴木三郎',5,10,'suzuki@example.com',0,'よろしくお願いします。');

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data4`
--

CREATE TABLE `xoops_waffle0_data4` (
  `t4_id` int(11) NOT NULL auto_increment,
  `t4_reg_time` int(11) NOT NULL default '0',
  `t4_mod_time` int(11) default NULL,
  `t4_reg_user_id` int(11) NOT NULL default '0',
  `t4_mod_user_id` int(11) default NULL,
  `t4_valid` tinyint(4) default NULL,
  `t4_c1` mediumtext,
  `t4_c2` mediumtext,
  PRIMARY KEY  (`t4_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data4`
--

INSERT INTO `xoops_waffle0_data4` (`t4_id`, `t4_reg_time`, `t4_mod_time`, `t4_reg_user_id`, `t4_mod_user_id`, `t4_valid`, `t4_c1`, `t4_c2`) VALUES (1,1145434189,NULL,1,NULL,1,'関東文具','東京');
INSERT INTO `xoops_waffle0_data4` (`t4_id`, `t4_reg_time`, `t4_mod_time`, `t4_reg_user_id`, `t4_mod_user_id`, `t4_valid`, `t4_c1`, `t4_c2`) VALUES (2,1145434206,NULL,1,NULL,1,'山田定規','神奈川');
INSERT INTO `xoops_waffle0_data4` (`t4_id`, `t4_reg_time`, `t4_mod_time`, `t4_reg_user_id`, `t4_mod_user_id`, `t4_valid`, `t4_c1`, `t4_c2`) VALUES (3,1145434226,NULL,1,NULL,1,'蝦夷文房具','札幌');

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data5`
--

CREATE TABLE `xoops_waffle0_data5` (
  `t5_id` int(11) NOT NULL auto_increment,
  `t5_reg_time` int(11) NOT NULL default '0',
  `t5_mod_time` int(11) default NULL,
  `t5_reg_user_id` int(11) NOT NULL default '0',
  `t5_mod_user_id` int(11) default NULL,
  `t5_valid` tinyint(4) default NULL,
  `t5_c1` mediumtext,
  `t5_c2` int(11) default NULL,
  `t5_c3` int(11) default NULL,
  PRIMARY KEY  (`t5_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data5`
--

INSERT INTO `xoops_waffle0_data5` (`t5_id`, `t5_reg_time`, `t5_mod_time`, `t5_reg_user_id`, `t5_mod_user_id`, `t5_valid`, `t5_c1`, `t5_c2`, `t5_c3`) VALUES (1,1145434261,NULL,1,NULL,1,'鉛筆HB',1,50);
INSERT INTO `xoops_waffle0_data5` (`t5_id`, `t5_reg_time`, `t5_mod_time`, `t5_reg_user_id`, `t5_mod_user_id`, `t5_valid`, `t5_c1`, `t5_c2`, `t5_c3`) VALUES (2,1145434281,NULL,1,NULL,1,'教材用コンパス',2,1980);
INSERT INTO `xoops_waffle0_data5` (`t5_id`, `t5_reg_time`, `t5_mod_time`, `t5_reg_user_id`, `t5_mod_user_id`, `t5_valid`, `t5_c1`, `t5_c2`, `t5_c3`) VALUES (3,1145434316,NULL,1,NULL,1,'30cm定規',2,780);
INSERT INTO `xoops_waffle0_data5` (`t5_id`, `t5_reg_time`, `t5_mod_time`, `t5_reg_user_id`, `t5_mod_user_id`, `t5_valid`, `t5_c1`, `t5_c2`, `t5_c3`) VALUES (4,1145434344,NULL,1,NULL,1,'付箋紙',3,190);
INSERT INTO `xoops_waffle0_data5` (`t5_id`, `t5_reg_time`, `t5_mod_time`, `t5_reg_user_id`, `t5_mod_user_id`, `t5_valid`, `t5_c1`, `t5_c2`, `t5_c3`) VALUES (5,1145434366,NULL,1,NULL,1,'修正液',3,290);

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data6`
--

CREATE TABLE `xoops_waffle0_data6` (
  `t6_id` int(11) NOT NULL auto_increment,
  `t6_reg_time` int(11) NOT NULL default '0',
  `t6_mod_time` int(11) default NULL,
  `t6_reg_user_id` int(11) NOT NULL default '0',
  `t6_mod_user_id` int(11) default NULL,
  `t6_valid` tinyint(4) default NULL,
  PRIMARY KEY  (`t6_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data6`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data7`
--

CREATE TABLE `xoops_waffle0_data7` (
  `t7_id` int(11) NOT NULL auto_increment,
  `t7_reg_time` int(11) NOT NULL default '0',
  `t7_mod_time` int(11) default NULL,
  `t7_reg_user_id` int(11) NOT NULL default '0',
  `t7_mod_user_id` int(11) default NULL,
  `t7_valid` tinyint(4) default NULL,
  PRIMARY KEY  (`t7_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data7`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data8`
--

CREATE TABLE `xoops_waffle0_data8` (
  `t8_id` int(11) NOT NULL auto_increment,
  `t8_reg_time` int(11) NOT NULL default '0',
  `t8_mod_time` int(11) default NULL,
  `t8_reg_user_id` int(11) NOT NULL default '0',
  `t8_mod_user_id` int(11) default NULL,
  `t8_valid` tinyint(4) default NULL,
  PRIMARY KEY  (`t8_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data8`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data9`
--

CREATE TABLE `xoops_waffle0_data9` (
  `t9_id` int(11) NOT NULL auto_increment,
  `t9_reg_time` int(11) NOT NULL default '0',
  `t9_mod_time` int(11) default NULL,
  `t9_reg_user_id` int(11) NOT NULL default '0',
  `t9_mod_user_id` int(11) default NULL,
  `t9_valid` tinyint(4) default NULL,
  PRIMARY KEY  (`t9_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data9`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_data10`
--

CREATE TABLE `xoops_waffle0_data10` (
  `t10_id` int(11) NOT NULL auto_increment,
  `t10_reg_time` int(11) NOT NULL default '0',
  `t10_mod_time` int(11) default NULL,
  `t10_reg_user_id` int(11) NOT NULL default '0',
  `t10_mod_user_id` int(11) default NULL,
  `t10_valid` tinyint(4) default NULL,
  PRIMARY KEY  (`t10_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_data10`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_file`
--

CREATE TABLE `xoops_waffle0_file` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `real_name` tinytext NOT NULL,
  `file_size` int(11) default NULL,
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) NOT NULL default '0',
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_file`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_grant_group`
--

CREATE TABLE `xoops_waffle0_grant_group` (
  `id` int(11) NOT NULL auto_increment,
  `table_id` int(11) default NULL,
  `group_id` int(11) default NULL,
  `grant_no` int(11) default NULL,
  `reg_time` int(11) default NULL,
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) default NULL,
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_grant_group`
--

INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (1,1,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (2,1,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (3,1,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (4,1,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (5,1,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (6,1,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (7,1,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (8,1,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (9,2,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (10,2,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (11,2,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (12,2,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (13,2,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (14,2,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (15,2,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (16,2,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (17,3,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (18,3,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (19,3,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (20,3,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (21,3,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (22,3,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (23,3,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (24,3,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (25,4,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (26,4,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (27,4,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (28,4,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (29,4,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (30,4,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (31,4,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (32,4,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (33,5,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (34,5,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (35,5,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (36,5,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (37,5,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (38,5,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (39,5,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (40,5,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (41,6,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (42,6,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (43,6,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (44,6,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (45,6,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (46,6,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (47,6,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (48,6,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (49,7,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (50,7,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (51,7,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (52,7,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (53,7,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (54,7,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (55,7,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (56,7,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (57,8,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (58,8,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (59,8,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (60,8,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (61,8,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (62,8,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (63,8,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (64,8,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (65,9,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (66,9,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (67,9,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (68,9,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (69,9,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (70,9,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (71,9,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (72,9,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (73,10,1,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (74,10,2,1,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (75,10,1,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (76,10,2,2,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (77,10,1,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (78,10,2,3,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (79,10,1,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (80,10,2,4,1,NULL,0,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (81,1,3,1,1144656347,0,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (82,2,3,1,1144656352,0,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (83,3,3,1,1144656359,0,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (84,1,1,5,1145435027,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (85,1,2,5,1145435027,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (86,2,1,5,1145435038,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (87,2,2,5,1145435038,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (88,3,1,5,1145435042,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (89,3,2,5,1145435042,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (90,4,1,5,1145435046,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (91,4,2,5,1145435046,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (92,5,1,5,1145435051,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (93,5,2,5,1145435051,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (94,6,1,5,1145435059,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (95,6,2,5,1145435059,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (96,7,1,5,1145435064,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (97,7,2,5,1145435064,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (98,8,1,5,1145435068,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (99,8,2,5,1145435068,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (100,10,1,5,1145435073,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (101,10,2,5,1145435073,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (102,9,1,5,1145435077,NULL,1,NULL);
INSERT INTO `xoops_waffle0_grant_group` (`id`, `table_id`, `group_id`, `grant_no`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (103,9,2,5,1145435077,NULL,1,NULL);

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_grant_user`
--

CREATE TABLE `xoops_waffle0_grant_user` (
  `id` int(11) NOT NULL auto_increment,
  `table_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `grant_no` int(11) default NULL,
  `reg_time` int(11) default NULL,
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) default NULL,
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_grant_user`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_image`
--

CREATE TABLE `xoops_waffle0_image` (
  `id` int(11) NOT NULL auto_increment,
  `path` tinytext NOT NULL,
  `width` int(11) default NULL,
  `height` int(11) default NULL,
  `file_size` int(11) default NULL,
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) NOT NULL default '0',
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_image`
--


-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_option`
--

CREATE TABLE `xoops_waffle0_option` (
  `id` int(11) NOT NULL auto_increment,
  `column_id` int(11) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) NOT NULL default '0',
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_option`
--

INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (1,60,'〜10才',1144655834,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (2,60,'11才〜15才',1144655834,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (3,60,'16才〜20才',1144655834,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (4,60,'21才〜30才',1144655834,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (5,60,'31才〜50才',1144655834,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (6,60,'51才〜',1144655834,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (7,61,'北海道',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (8,61,'東北',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (9,61,'関東',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (10,61,'北陸',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (11,61,'近畿',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (12,61,'中国',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (13,61,'四国',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (14,61,'九州',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (15,61,'沖縄',1144655971,0,1,NULL);
INSERT INTO `xoops_waffle0_option` (`id`, `column_id`, `name`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (16,61,'海外',1144655971,0,1,NULL);

-- MySQL dump 9.11
--
-- Host: localhost    Database: xoopstest3
-- ------------------------------------------------------
-- Server version	4.0.25-standard

--
-- Table structure for table `xoops_waffle0_table`
--

CREATE TABLE `xoops_waffle0_table` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `summary` text NOT NULL,
  `valid` tinyint(4) NOT NULL default '0',
  `order` tinyint(4) NOT NULL default '0',
  `validable` tinyint(4) default '0',
  `rss` tinyint(4) NOT NULL default '0',
  `rss_top_url` tinytext NOT NULL,
  `rss_title` tinytext NOT NULL,
  `rss_summary` text NOT NULL,
  `rss_url_column` tinytext NOT NULL,
  `rss_title_column` tinytext NOT NULL,
  `rss_body_column` tinytext NOT NULL,
  `reg_time` int(11) NOT NULL default '0',
  `mod_time` int(11) default NULL,
  `reg_user_id` int(11) NOT NULL default '0',
  `mod_user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `xoops_waffle0_table`
--

INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (1,'アジアの国','',1,0,0,0,'','','','','','',0,1144655770,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (2,'HTMLフォーム','',1,0,0,0,'','','','','','',0,1144655770,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (3,'アンケートフォーム','',1,0,0,0,'','','','','','',0,1144655770,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (4,'文具メーカー','',1,0,0,0,'','','','','','',0,1145434072,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (5,'文房具','',1,0,0,0,'','','','','','',0,1145434072,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (6,'table6','',0,0,0,0,'','','','','','',0,1144655770,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (7,'table7','',0,0,0,0,'','','','','','',0,1144655770,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (8,'table8','',0,0,0,0,'','','','','','',0,1144655770,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (9,'table9','',0,0,0,0,'','','','','','',0,1144655770,0,1);
INSERT INTO `xoops_waffle0_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (10,'table10','',0,0,0,0,'','','','','','',0,1144655770,0,1);



DELETE FROM xoops_waffle0_config WHERE name LIKE '%.cache'
