
alter table xoops_waffle0_table add column validable tinyint default 0 after `order`;

alter table xoops_waffle0_column add column detailview tinyint after serial;
alter table xoops_waffle0_column add column insertview tinyint after detailview;
alter table xoops_waffle0_column add column updateview tinyint after insertview;
alter table xoops_waffle0_column add column updatable tinyint after listview;

alter table xoops_waffle0_data1 add column t1_valid tinyint after t1_mod_user_id ;
alter table xoops_waffle0_data2 add column t2_valid tinyint after t2_mod_user_id ;
alter table xoops_waffle0_data3 add column t3_valid tinyint after t3_mod_user_id ;
alter table xoops_waffle0_data4 add column t4_valid tinyint after t4_mod_user_id ;
alter table xoops_waffle0_data5 add column t5_valid tinyint after t5_mod_user_id ;
alter table xoops_waffle0_data6 add column t6_valid tinyint after t6_mod_user_id ;
alter table xoops_waffle0_data7 add column t7_valid tinyint after t7_mod_user_id ;
alter table xoops_waffle0_data8 add column t8_valid tinyint after t8_mod_user_id ;
alter table xoops_waffle0_data9 add column t9_valid tinyint after t9_mod_user_id ;
alter table xoops_waffle0_data10 add column t10_valid tinyint after t10_mod_user_id ;

update xoops_waffle0_column set detailview = 1; 
update xoops_waffle0_column set insertview = 1;
update xoops_waffle0_column set updateview = 1; 
update xoops_waffle0_column set updatable = 1;

update xoops_waffle0_data1 set t1_valid = 1;
update xoops_waffle0_data2 set t2_valid = 1;
update xoops_waffle0_data3 set t3_valid = 1;
update xoops_waffle0_data4 set t4_valid = 1;
update xoops_waffle0_data5 set t5_valid = 1;
update xoops_waffle0_data6 set t6_valid = 1;
update xoops_waffle0_data7 set t7_valid = 1;
update xoops_waffle0_data8 set t8_valid = 1;
update xoops_waffle0_data9 set t9_valid = 1;
update xoops_waffle0_data10 set t10_valid = 1;

INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',2,'t2_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',3,'t3_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',1,'t1_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',4,'t4_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',5,'t5_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',6,'t6_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',7,'t7_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',8,'t8_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',9,'t9_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',10,'t10_valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);

delete from xoops_waffle0_config where name like '%.cache';

