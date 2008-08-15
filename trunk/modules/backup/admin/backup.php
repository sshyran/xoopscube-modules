<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

include_once './function.php';

//	Initialize
$NowTime = time();
$myYMD = date('Ymd_Hi', $NowTime);
$MySQLStrings = array();

//	Database Tables and Modules List
list($table2module, $modules2version, $modulebydir) = myxbu_get_modules_info();

//	Default Strings
$res = $xoopsDB->query('SELECT VERSION()');
list($MySQLVersion) = $xoopsDB->fetchRow($res);
$MySQLHeader1  = ''; $MySQLHeader2  = '';
$MySQLHeader1 .= MYXBU_SQLComment." XOOPS MySQL-Dump by MyX_BackUp\n";
$MySQLHeader1 .= MYXBU_SQLComment."\n";
$MySQLHeader1 .= MYXBU_SQLComment." Host: ".XOOPS_DB_HOST."\n";
$MySQLHeader1 .= MYXBU_SQLComment." Generation Time: ".date('r', $NowTime)."\n";
$MySQLHeader1 .= MYXBU_SQLComment." MySQL Version: ${MySQLVersion}\n";
$MySQLHeader1 .= MYXBU_SQLComment." PHP Version: ".phpversion()."\n";
$MySQLHeader1 .= MYXBU_SQLComment."\n";
$MySQLHeader1 .= MYXBU_SQLComment." XOOPS Version: ".XOOPS_VERSION."\n";
$MySQLHeader1 .= MYXBU_SQLComment." Database: `".XOOPS_DB_NAME."`\n";
$MySQLHeader1 .= MYXBU_SQLComment." XOOPS DB Prefix: ".XOOPS_DB_PREFIX."\n";
$MySQLHeader2 .= MYXBU_SQLComment."\n";
$MySQLHeader2 .= MYXBU_SQLComment." ".MYXBU_SQLHairline."\n\n";

//	Main
$mqr = get_magic_quotes_runtime();
set_magic_quotes_runtime(0);
$res0 = $xoopsDB->queryF('SHOW TABLE STATUS FROM `'.XOOPS_DB_NAME.'`');
//	Table names loop
while ($tbldat = $xoopsDB->fetchArray($res0)) {
	$table_name = trim($tbldat['Name']);
	if (!preg_match('/^'.XOOPS_DB_PREFIX.'_/', $table_name)) { continue; }
	//	Module Info
	if (isset($table2module[$table_name])) {
		$myModName = $table2module[$table_name]; $myModVer = $modules2version[$myModName];
	} else {
		$myModName = '_UNKNOWN_'; $myModVer = '---';
	}
	//	File Header
	if (!isset($MySQLStrings[$myModName])) {
		$MySQLStrings[$myModName] = $MySQLHeader1.MYXBU_SQLComment." Module: ${myModName} (${myModVer})\n".$MySQLHeader2;
	}
	//	Main
	$MySQLStrings[$myModName] .= myxbu_create_sql($tbldat);
}
set_magic_quotes_runtime($mqr);

//	Debug Mode
if (MYXBU_DEBUG) {
	xoops_cp_header();
	print '<h3>BACKUP - Debug Mode</h3>
	<hr />
	<br />';
	print '<div class="error">DEBUG MODE</div>
	<br />
	<div class="outer" style="display:block; width:98%; height:300px; overflow:auto; border:1px solid #ccc;"';
	foreach ($MySQLStrings as $key => $val) {
		print '<div >';
		print ' # '.htmlspecialchars(XOOPS_DB_PREFIX."_${key}_${myYMD}.sql").'</div>';
		print nl2br(htmlspecialchars($val)).'<br />';
	}
	print '</div>';
	xoops_cp_footer();
	exit();
}

//	Create and Send Zip File
require_once XOOPS_ROOT_PATH.'/class/zipdownloader.php';
$myzip = new XoopsZipDownloader;
foreach ($MySQLStrings as $key => $val) {
	$myzip->addFileData($val, XOOPS_DB_PREFIX."_${key}_${myYMD}.sql");
}
$myzip->download(XOOPS_DB_PREFIX."_$myYMD");
?>