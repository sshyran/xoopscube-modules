
INSERT INTO `xoops_waffle0_table` (id, name, valid, `order`, reg_time, mod_time, reg_user_id, mod_user_id) VALUES (_TABLE_NO_, 'table_TABLE_NO_', 0, 0, 0, NULL, 0, NULL);

INSERT INTO `xoops_waffle0_column` (table_id, name, `desc`, type, valid, uniq, `not_null`, `default`, `order`, primary_key, fixed, serial, detailview, listview, maxlength, `size`, reg_time, mod_time, reg_user_id, mod_user_id) VALUES (_TABLE_NO_, 't_TABLE_NO__id', 'ID', 1, 1, 1, 1, '', 0, 1, 1, 1, 1, 1, 0, 0, 0, NULL, 0, NULL);
INSERT INTO `xoops_waffle0_column` (table_id, name, `desc`, type, valid, uniq, `not_null`, `default`, `order`, primary_key, fixed, serial, detailview, listview, maxlength, `size`, reg_time, mod_time, reg_user_id, mod_user_id) VALUES (_TABLE_NO_, 't_TABLE_NO__reg_time', '登録日時', 4, 1, 0, 1, '', 1100, 0, 1, 0, 1, 1, 0, 0, 0, NULL, 0, NULL);
INSERT INTO `xoops_waffle0_column` (table_id, name, `desc`, type, valid, uniq, `not_null`, `default`, `order`, primary_key, fixed, serial, detailview, listview, maxlength, `size`, reg_time, mod_time, reg_user_id, mod_user_id) VALUES (_TABLE_NO_, 't_TABLE_NO__mod_time', '更新日時', 4, 1, 0, 0, '', 1200, 0, 1, 0, 1, 1, 0, 0, 0, NULL, 0, NULL);
INSERT INTO `xoops_waffle0_column` (table_id, name, `desc`, type, valid, uniq, `not_null`, `default`, `order`, primary_key, fixed, serial, detailview, listview, maxlength, `size`, reg_time, mod_time, reg_user_id, mod_user_id) VALUES (_TABLE_NO_, 't_TABLE_NO__reg_user_id', '登録ユーザID', 11, 1, 1, 1, '', 1300, 0, 1, 0, 1, 0, 0, 0, 0, NULL, 0, NULL);
INSERT INTO `xoops_waffle0_column` (table_id, name, `desc`, type, valid, uniq, `not_null`, `default`, `order`, primary_key, fixed, serial, detailview, listview, maxlength, `size`, reg_time, mod_time, reg_user_id, mod_user_id) VALUES (_TABLE_NO_, 't_TABLE_NO__mod_user_id', '更新ユーザID', 11, 1, 0, 0, '', 1400, 0, 1, 0, 1, 0, 0, 0, 0, NULL, 0, NULL);

create table xoops_waffle0_data_TABLE_NO_ (
   t_TABLE_NO__id                integer              auto_increment primary key,
   t_TABLE_NO__valid             integer              not null default 1,
   t_TABLE_NO__reg_time          integer              not null,
   t_TABLE_NO__mod_time          integer,
   t_TABLE_NO__reg_user_id       integer              not null,
   t_TABLE_NO__mod_user_id       integer
);

INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 1, 1, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 2, 1, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 1, 2, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 2, 2, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 1, 3, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 2, 3, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 1, 4, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 2, 4, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 1, 5, 1, 0);
INSERT INTO `xoops_waffle0_grant_group` (table_id, group_id, grant_no, reg_time, reg_user_id) VALUES (_TABLE_NO_, 2, 5, 1, 0);

INSERT INTO `xoops_waffle0_column` (`id`, `table_id`, `name`, `desc`, `type`, `valid`, `uniq`, `not_null`, `default`, `order`, `primary_key`, `fixed`, `serial`, `detailview`, `insertview`, `updateview`, `listview`, `updatable`, `search`, `maxlength`, `size`, `rows`, `cols`, `rel_table`, `rel_column`, `rel_v_column`, `rel_where`, `rel_type`, `reg_time`, `mod_time`, `reg_user_id`, `mod_user_id`) VALUES ('',_TABLE_NO_,'t_TABLE_NO__valid','認証フラグ',1,1,0,0,'1',0,0,1,0,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL);
