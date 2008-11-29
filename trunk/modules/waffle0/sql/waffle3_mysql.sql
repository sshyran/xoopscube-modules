#
# Table structure for table `waffle'
#

create table waffle3_config (
   id                   integer              auto_increment primary key,
   name                 tinytext             not null,
   value                mediumtext           not null,
   flag_serialize       tinyint(1)           not null,
   reg_time             integer              not null,
   mod_time             integer,
   reg_user_id          integer              not null,
   mod_user_id          integer
);

create table waffle3_table (
   id                   integer              auto_increment primary key,
   name                 tinytext             not null,
   summary		text		     not null default '',
   valid                tinyint              not null,
   `order`              tinyint              not null,
   `validable`          tinyint              not null default 0,
   `rss`                tinyint              not null default 0,
   rss_top_url		tinytext             not null default '',
   rss_title		tinytext             not null default '',
   rss_summary		text                 not null default '',
   rss_url_column	tinytext             not null default '',
   rss_title_column	tinytext             not null default '',
   rss_body_column	tinytext 	     not null default '',
   reg_time             integer              not null,
   mod_time             integer,
   reg_user_id          integer              not null,
   mod_user_id          integer
);

create table waffle3_column (
   id                   integer              auto_increment primary key,
   table_id             integer              not null,
   name                 tinytext             not null,
   `desc`               tinytext             not null,
   type                 tinyint              not null,
   valid                tinyint              not null,
   uniq                 tinyint              not null,
   `not_null`           tinyint              not null,
   `default`            mediumtext           not null,
   `order`              int                  not null,
   primary_key          integer              not null,
   fixed                tinyint              not null,
   serial               tinyint              not null,
   detailview           tinyint              not null,
   insertview           tinyint              not null,
   updateview           tinyint              not null,
   listview             tinyint              not null,
   updatable            tinyint              not null,
   search               tinyint              not null,
   maxlength            integer              not null,
   `size`               integer              not null,
   `rows`               integer              ,
   `cols`               integer              ,
   `rel_table`          tinytext             ,
   `rel_column`         tinytext             ,
   `rel_v_column`       tinytext             ,
   `rel_where`          tinytext             ,
   `rel_type`           tinytext             ,
   reg_time             integer              not null,
   mod_time             integer,
   reg_user_id          integer              not null,
   mod_user_id          integer
);

create table waffle3_option (
    id                   integer              auto_increment primary key,
    column_id            integer              not null,
    name                 tinytext             not null,
    reg_time             integer              not null,
    mod_time             integer,
    reg_user_id          integer              not null,
    mod_user_id          integer
);

create table waffle3_grant_group (
    id                   integer auto_increment primary key,
    table_id             integer,
    group_id             integer,
    grant_no             integer,
    reg_time             integer,
    mod_time             integer,
    reg_user_id          integer,
    mod_user_id          integer
);

create table waffle3_grant_user (
    id                   integer auto_increment primary key,
    table_id             integer,
    user_id              integer,
    grant_no             integer,
    reg_time             integer,
    mod_time             integer,
    reg_user_id          integer,
    mod_user_id          integer
);

create table waffle3_image (
   id                   integer              auto_increment primary key,
   path                 tinytext             not null,
   width                integer,
   height               integer,
   file_size            integer,
   reg_time             integer              not null,
   mod_time             integer,
   reg_user_id          integer              not null,
   mod_user_id          integer
);

create table waffle3_file (
   id                   integer              auto_increment primary key,
   name                 tinytext             not null,
   real_name            tinytext             not null,
   file_size            integer,
   reg_time             integer              not null,
   mod_time             integer,
   reg_user_id          integer              not null,
   mod_user_id          integer
);


create table waffle3_data1 (
   t1_id                integer              auto_increment primary key,
   t1_reg_time          integer              not null,
   t1_mod_time          integer,
   t1_reg_user_id       integer              not null,
   t1_mod_user_id       integer,
   t1_valid             tinyint
);

create table waffle3_data2 (
   t2_id                integer              auto_increment primary key,
   t2_reg_time          integer              not null,
   t2_mod_time          integer,
   t2_reg_user_id       integer              not null,
   t2_mod_user_id       integer,
   t2_valid             tinyint
);

create table waffle3_data3 (
   t3_id                integer              auto_increment primary key,
   t3_reg_time          integer              not null,
   t3_mod_time          integer,
   t3_reg_user_id       integer              not null,
   t3_mod_user_id       integer,
   t3_valid             tinyint
);

create table waffle3_data4 (
   t4_id                integer              auto_increment primary key,
   t4_reg_time          integer              not null,
   t4_mod_time          integer,
   t4_reg_user_id       integer              not null,
   t4_mod_user_id       integer,
   t4_valid             tinyint
);

create table waffle3_data5 (
   t5_id                integer              auto_increment primary key,
   t5_reg_time          integer              not null,
   t5_mod_time          integer,
   t5_reg_user_id       integer              not null,
   t5_mod_user_id       integer,
   t5_valid             tinyint
);

create table waffle3_data6 (
   t6_id                integer              auto_increment primary key,
   t6_reg_time          integer              not null,
   t6_mod_time          integer,
   t6_reg_user_id       integer              not null,
   t6_mod_user_id       integer,
   t6_valid             tinyint
);

create table waffle3_data7 (
   t7_id                integer              auto_increment primary key,
   t7_reg_time          integer              not null,
   t7_mod_time          integer,
   t7_reg_user_id       integer              not null,
   t7_mod_user_id       integer,
   t7_valid             tinyint
);

create table waffle3_data8 (
   t8_id                integer              auto_increment primary key,
   t8_reg_time          integer              not null,
   t8_mod_time          integer,
   t8_reg_user_id       integer              not null,
   t8_mod_user_id       integer,
   t8_valid             tinyint
);

create table waffle3_data9 (
   t9_id                integer              auto_increment primary key,
   t9_reg_time          integer              not null,
   t9_mod_time          integer,
   t9_reg_user_id       integer              not null,
   t9_mod_user_id       integer,
   t9_valid             tinyint
);

create table waffle3_data10 (
   t10_id                integer              auto_increment primary key,
   t10_reg_time          integer              not null,
   t10_mod_time          integer,
   t10_reg_user_id       integer              not null,
   t10_mod_user_id       integer,
   t10_valid             tinyint
);

INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (1,'table1','',0,0,0,0,'','','','','','',0,1160498218,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (2,'table2','',0,0,0,0,'','','','','','',0,1160498218,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (3,'table3','',0,0,0,0,'','','','','','',0,1160498218,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (4,'table4','',0,0,0,0,'','','','','','',0,1160498218,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (5,'table5','',0,0,0,0,'','','','','','',0,1160498218,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (6,'table6','',0,0,0,0,'','','','','','',0,1160498218,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (7,'table7','',0,0,0,0,'','','','','','',0,1160498219,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (8,'table8','',0,0,0,0,'','','','','','',0,1160498219,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (9,'table9','',0,0,0,0,'','','','','','',0,1160498219,0,1);
INSERT INTO `waffle3_table` (`id`, `name`, `summary`, `valid`, `order`, `validable`, `rss`, `rss_top_url`, `rss_title`, `rss_summary`, `rss_url_column`, `rss_title_column`, `rss_body_column`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (10,'table10','',0,0,0,0,'','','','','','',0,1160498219,0,1);

INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (1,1,'t1_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1160478743,0,1);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (2,1,'t1_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1160478743,0,1);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (3,1,'t1_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1160478743,0,1);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (4,1,'t1_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1160478743,0,1);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (5,1,'t1_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1160478743,0,1);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (6,2,'t2_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (7,2,'t2_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (8,2,'t2_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (9,2,'t2_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (10,2,'t2_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (11,3,'t3_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (12,3,'t3_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (13,3,'t3_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (14,3,'t3_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (15,3,'t3_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (16,4,'t4_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (17,4,'t4_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (18,4,'t4_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (19,4,'t4_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (20,4,'t4_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (21,5,'t5_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (22,5,'t5_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (23,5,'t5_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (24,5,'t5_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (25,5,'t5_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (26,6,'t6_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (27,6,'t6_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (28,6,'t6_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (29,6,'t6_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (30,6,'t6_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (31,7,'t7_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (32,7,'t7_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (33,7,'t7_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (34,7,'t7_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (35,7,'t7_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (36,8,'t8_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (37,8,'t8_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (38,8,'t8_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (39,8,'t8_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (40,8,'t8_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (41,9,'t9_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (42,9,'t9_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (43,9,'t9_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (44,9,'t9_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (45,9,'t9_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (46,10,'t10_id','ID',1,1,1,1,'',0,1,1,1,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (47,10,'t10_reg_time','登録日時',4,1,0,1,'',1100,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (48,10,'t10_mod_time','更新日時',4,1,0,0,'',1200,0,1,0,1,0,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (49,10,'t10_reg_user_id','登録ユーザID',11,1,1,1,'',1300,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (50,10,'t10_mod_user_id','更新ユーザID',11,1,0,0,'',1400,0,1,0,1,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (55,2,'t2_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (56,3,'t3_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (54,1,'t1_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (57,4,'t4_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (58,5,'t5_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (59,6,'t6_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (60,7,'t7_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (61,8,'t8_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (62,9,'t9_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `waffle3_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES (63,10,'t10_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);


INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (1, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (2, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (3, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (4, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (5, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (6, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (7, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (8, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (9, 2, 5, 1, 0);

INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 1, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 2, 1, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 1, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 2, 2, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 1, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 2, 3, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 1, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 2, 4, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 1, 5, 1, 0);
INSERT INTO `waffle3_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (10, 2, 5, 1, 0);



