<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

//	General
define ("_AM_MYXBACKUP_GOBACK_TO_MENU",	"Go Back to Menu");
define ("_AM_MYXBACKUP_ERROR",		"Error !");
define ("_AM_MYXBACKUP_PARAMETERERROR",	"Parameter Error !");
define ("_AM_MYXBACKUP_DBCHECKERROR",	"Error ! (Database may be changed)");
define ("_AM_MYXBACKUP_FILECHECKERROR",	"Error ! (SQL files may br changed)");
define ("_AM_MYXBACKUP_RESTOREERROR",	"<div style=\"color:#ff0000; font-size:larger; margin-left:20px;\">Error ! (SQL files may br changed)</div>");

//	Index (Menu)
define ("_AM_MYXBACKUP_NOTICEONINDEX",	"Don't click twice !");
define ("_AM_MYXBACKUP_REPORT_TITLE",	"Report");
define ("_AM_MYXBACKUP_REPORT_DESC",	"Report about database tables.");
define ("_AM_MYXBACKUP_OPTIMIZE_TITLE",	"Optimize");
define ("_AM_MYXBACKUP_OPTIMIZE_DESC",	"Optimize XOOPS Cube database tables.");
define ("_AM_MYXBACKUP_CHECK_TITLE",	"Check");
define ("_AM_MYXBACKUP_CHECK_DESC",	"Check XOOPS Cube database tables.");
define ("_AM_MYXBACKUP_CLEANUP_TITLE",	"Clean Up");
define ("_AM_MYXBACKUP_CLEANUP_DESC",	"Delete unneccesary tables.");
define ("_AM_MYXBACKUP_BACKUP_TITLE",	"Back Up Dababase");
define ("_AM_MYXBACKUP_BACKUP_DESC",	"Back up XOOPS Cube databse tables. Download SQL file zipped.");
define ("_AM_MYXBACKUP_BACKUPMOD_TITLE","Back Up Module");
define ("_AM_MYXBACKUP_BACKUPMOD_DESC",	"Back up XOOPS Cube databse tables by module. Download SQL file zipped");
define ("_AM_MYXBACKUP_DUMP_TITLE",	"Dump");
define ("_AM_MYXBACKUP_DUMP_DESC",	"Dump XOOPS Cube database tables (SQL text format)");
define ("_AM_MYXBACKUP_EXPORT_TITLE",	"Export");
define ("_AM_MYXBACKUP_EXPORT_DESC",	"Export XOOPS Cube database selected tables(CSV format)");
define ("_AM_MYXBACKUP_RESTORE_TITLE",	"Restore");
define ("_AM_MYXBACKUP_RESTORE_DESC",	"Restore backuped database tables. Place SQL files into 'sql' directory.");
define ("_AM_MYXBACKUP_CONFIG_TITLE",	"Settings");
define ("_AM_MYXBACKUP_CONFIG_DESC",	"General settings.");
define ("_AM_MYXBACKUP_SQLFILE_EXSITS",	"There are some files in SQL directory.<br />If you don't plan to restore, delete these files.");

//	Report / Check
define ("_AM_MYXBACKUP_LIST_Prefix",		"PREFIX");
define ("_AM_MYXBACKUP_LIST_Name",		"NAME");
define ("_AM_MYXBACKUP_LIST_Table",		"TABLE");
define ("_AM_MYXBACKUP_LIST_ModName",		"MODULE");
define ("_AM_MYXBACKUP_LIST_Rows",		"ROWS");
define ("_AM_MYXBACKUP_LIST_Data_length",	"LENGTH");
define ("_AM_MYXBACKUP_LIST_Avg_row_length",	"Ave. LENGTH");
define ("_AM_MYXBACKUP_LIST_Data_free",		"DATA FREE");
define ("_AM_MYXBACKUP_LIST_Update_time",	"UPDATED");
define ("_AM_MYXBACKUP_LIST_Status",		"STATUS");
define ("_AM_MYXBACKUP_LIST_Command",		"OPTION");

//	Optimize
define ("_AM_MYXBACKUP_OPTIMIZED",		"<span style=\"color:#00ff00;\"> optimized</span>");
define ("_AM_MYXBACKUP_NOTOPTIMIZED",		"<span style=\"color:#ff0000;\"> not optimized</span>");
define ("_AM_MYXBACKUP_NONEEDOPTIMIZED",	"<span style=\"color:#000000;\"> Table is already up to date</span>");
define ("_AM_MYXBACKUP_NOTABLE_OPTIMIZED",	"All table are already up to date");

//	Delete
define ("_AM_MYXBACKUP_NOTABLES_TO_DELETE",	"No tables found to be deleted");
define ("_AM_MYXBACKUP_TABLE_DELETED",		" deleted");
define ("_AM_MYXBACKUP_TABLE_NOTDELETED",	" not deleted");
define ("_AM_MYXBACKUP_CHECK_TO_DELETE",	"OPTION");

//	Restore
define ("_AM_MYXBACKUP_NOSQLFILES",		"SQL files not found");
define ("_AM_MYXBACKUP_SQL_NAME",		"SQL FILE");
define ("_AM_MYXBACKUP_SQL_PREFIX",		"PREFIX in SQL files");
define ("_AM_MYXBACKUP_SQL_DATE",		"FILE DATE");
define ("_AM_MYXBACKUP_SQLPREFIX",		"Input PREFIX in SQL files");
define ("_AM_MYXBACKUP_MYPREFIX",		"PREFIX");
define ("_AM_MYXBACKUP_GO_RESTORE",		"START");
define ("_AM_MYXBACKUP_GO_RESTORE_NOTE",	"Start to restore (unable to cancel operation)");
define ("_AM_MYXBACKUP_RESTORE_DONE",		"Restore done. Delete SQL files.");

//	Clean Up
define ("_AM_MYXBACKUP_CAUTIONTODEL",		"<span style=\"color:#ff0000;\">Necessary tables may be listed up in the case of DUPLICATABLE modules.<br />DO NOT DELETE any tables if you are not confident.<br />You should BACK-UP before this operation.</span>");
define ("_AM_MYXBACKUP_TAKERISK",		"TAKE MY OWN RISK");
?>