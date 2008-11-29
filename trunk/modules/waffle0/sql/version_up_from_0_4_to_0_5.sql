
alter table xoops_waffle0_table add column summary text not null default '';
alter table xoops_waffle0_table add column rss tinyint not null default 0;
alter table xoops_waffle0_table add column rss_top_url tinytext not null default '';
alter table xoops_waffle0_table add column rss_title tinytext not null default '';
alter table xoops_waffle0_table add column rss_summary text not null default '';
alter table xoops_waffle0_table add column rss_url_column tinytext not null default '';
alter table xoops_waffle0_table add column rss_title_column tinytext not null default '';
alter table xoops_waffle0_table add column rss_body_column tinytext not null default '';

create table xoops_waffle0_file (
  id                   integer              auto_increment primary key,
  name                 tinytext             not null,
  real_name            tinytext             not null,
  file_size            integer,
  reg_time             integer              not null,
  mod_time             integer,
  reg_user_id          integer              not null,
  mod_user_id          integer
);

delete from xoops_waffle0_config where name like '%.cache';

