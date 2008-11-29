
alter table xoops_waffle0_column add column rel_table tinytext;
alter table xoops_waffle0_column add column rel_column tinytext;
alter table xoops_waffle0_column add column rel_v_column tinytext;
alter table xoops_waffle0_column add column rel_where tinytext;
alter table xoops_waffle0_column add column rel_type tinytext;

create table xoops_waffle0_image (
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

delete from xoops_waffle0_config where name like '%.cache';

