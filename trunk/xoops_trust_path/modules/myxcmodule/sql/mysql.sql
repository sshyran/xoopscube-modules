# CREATE TABLE `tablename` will be queried as
# CREATE TABLE `prefix_dirname_tablename`

CREATE TABLE `indexes` (
	`filename` varchar(255) NOT NULL default '',
	`title` varchar(255) NOT NULL default '',
	`mtime` int(11) NOT NULL default 0,
	`body` text,
	PRIMARY KEY (filename)
) TYPE=MyISAM;

