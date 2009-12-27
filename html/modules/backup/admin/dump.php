<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

include_once './function.php';

//	Initialize
$NowTime = time();
$myYMD = date('Ymd_Hi', $NowTime);
$MySQLStrings = array();

//	Header
header("Content-type: text/plain; charset="._CHARSET);
header("Content-Disposition: attachment; filename=".XOOPS_DB_PREFIX."_${myYMD}.sql");

//	Database Tables and Modules List
list($table2module, $modules2version, $modulebydir) = myxbu_get_modules_info();

//	Default Strings
$res = $xoopsDB->query('SELECT VERSION()');
list($MySQLVersion) = $xoopsDB->fetchRow($res);
print MYXBU_SQLComment." XOOPS MySQL-Dump by MyX_BackUp\n";
print MYXBU_SQLComment."\n";
print MYXBU_SQLComment." Host: ".XOOPS_DB_HOST."\n";
print MYXBU_SQLComment." Generation Time: ".date('r', time())."\n";
print MYXBU_SQLComment." MySQL Version: ${MySQLVersion}\n";
print MYXBU_SQLComment." PHP Version: ".phpversion()."\n";
print MYXBU_SQLComment."\n";
print MYXBU_SQLComment." XOOPS Version: ".XOOPS_VERSION."\n";
print MYXBU_SQLComment." Database: `".XOOPS_DB_NAME."`\n";
print MYXBU_SQLComment." XOOPS DB Prefix: ".XOOPS_DB_PREFIX."\n";
print MYXBU_SQLComment."\n";
print MYXBU_SQLComment." ".MYXBU_SQLHairline."\n\n";

//	Main
$mqr = get_magic_quotes_runtime();
set_magic_quotes_runtime(0);
$res0 = $xoopsDB->queryF('SHOW TABLE STATUS FROM `'.XOOPS_DB_NAME.'`');
//	Table names loop
while ($tbldat = $xoopsDB->fetchArray($res0)) {
	$table_name = trim($tbldat['Name']);
	if (!preg_match('/^'.XOOPS_DB_PREFIX.'_/', $table_name)) { continue; }
	//	Initialize Variables
	$InsertQueries = ''; $CreateTableQuery = ''; $DropTableQuery = '';
	$fname = array(); $fmeta = array(); $fflag = array();
	//	Module Info
	if (isset($table2module[$table_name])) {
		$myModName = $table2module[$table_name]; $myModVer = $modules2version[$myModName];
	} else {
		$myModName = '_UNKNOWN_'; $myModVer = '---';
	}
	//	File Header
	if (!isset($MySQLStrings[$myModName])) {
		print $MySQLHeader1.MYXBU_SQLComment." Module: ${myModName} (${myModVer})\n".$MySQLHeader2;
	}
	print myxbu_create_sql($tbldat);
}
set_magic_quotes_runtime($mqr);
?>