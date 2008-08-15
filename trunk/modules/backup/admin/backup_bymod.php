<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

include_once './function.php';

//	Initialize
$NowTime = time();
$myYMD = date('Ymd_Hi', $NowTime);
$MySQLString = '';

//	Operation
$op = (isset($_POST['op']) ? $_POST['op'] : '');
$mod_name = (isset($_POST['mod_name']) ? $_POST['mod_name'] : '');

//	Database Tables and Modules List
list($table2module, $modules2version, $modulebydir) = myxbu_get_modules_info();
$myModName = $mod_name;
$myModVer = (isset($modules2version[$myModName]) ? $modules2version[$myModName] : '');

//
$mod_list = array();
foreach ($table2module as $tbl => $mod) {
	if (($tbl != '') && !in_array($mod, $mod_list)) {
		if ($mod != 'system') {
			$mod_list[] = $mod;
		}
	}
}


//
$tables_count = 0;
$my_tables = array();
if ($op == 'backup') {
//	if ($mod_name == 'system') {
//		foreach ($SystemDBTables as $tbl) {
//			$my_tables[$tables_count++] = XOOPS_DB_PREFIX.'_'.$tbl;
//		}
//	} else {
		foreach ($table2module as $tbl => $mod) {
			if ($mod_name == $mod) {
				$my_tables[$tables_count++] = $tbl;
			}
		}
//	}
}

if (($op == 'backup') && ($tables_count > 0)) {
	//	Default Strings
	$res = $xoopsDB->query('SELECT VERSION()');
	list($MySQLVersion) = $xoopsDB->fetchRow($res);
	$MySQLString  = ''; $MySQLHeader2  = '';
	$MySQLString .= MYXBU_SQLComment." XOOPS MySQL-Dump by MyX_BackUp\n";
	$MySQLString .= MYXBU_SQLComment."\n";
	$MySQLString .= MYXBU_SQLComment." Host: ".XOOPS_DB_HOST."\n";
	$MySQLString .= MYXBU_SQLComment." Generation Time: ".date('r', $NowTime)."\n";
	$MySQLString .= MYXBU_SQLComment." MySQL Version: ${MySQLVersion}\n";
	$MySQLString .= MYXBU_SQLComment." PHP Version: ".phpversion()."\n";
	$MySQLString .= MYXBU_SQLComment."\n";
	$MySQLString .= MYXBU_SQLComment." XOOPS Version: ".XOOPS_VERSION."\n";
	$MySQLString .= MYXBU_SQLComment." Database: `".XOOPS_DB_NAME."`\n";
	$MySQLString .= MYXBU_SQLComment." XOOPS DB Prefix: ".XOOPS_DB_PREFIX."\n";
	//	Main
	$mqr = get_magic_quotes_runtime();
	set_magic_quotes_runtime(0);
	$res0 = $xoopsDB->queryF('SHOW TABLE STATUS FROM `'.XOOPS_DB_NAME.'`');
	//	Table names loop
	while ($tbldat = $xoopsDB->fetchArray($res0)) {
		$table_name = trim($tbldat['Name']);
		if (!preg_match('/^'.XOOPS_DB_PREFIX.'_/', $table_name)) { continue; }
		if (!in_array($table_name, $my_tables)) { continue; }
		//	File Header
		$MySQLString .= MYXBU_SQLComment." Module: ${myModName} (${myModVer})\n";
		//	Main
		$MySQLString .= myxbu_create_sql($tbldat);
	}
	set_magic_quotes_runtime($mqr);

	//	Debug Mode
	if (MYXBU_DEBUG) {
		xoops_cp_header();
		
		print '<h3>BACKUP - BackUp</h3>
		<hr />
		<br />';
		print '<div class="error">DEBUG MODE</div>';
		print '<div class="outer">';
		print ' # '.htmlspecialchars(XOOPS_DB_PREFIX."_${myModName}_${myYMD}.sql").'</div>';
		print nl2br(htmlspecialchars($MySQLString)).'<br />';
		xoops_cp_footer();
		exit();
	}
	//	Create and Send Zip File
	require_once XOOPS_ROOT_PATH.'/class/zipdownloader.php';
	$myzip = new XoopsZipDownloader;
	$myzip->addFileData($MySQLString, XOOPS_DB_PREFIX."_${myModName}_${myYMD}.sql");
	$myzip->download(XOOPS_DB_PREFIX."_${myModName}_${myYMD}");
	exit();
}

//	Show list of tables
xoops_cp_header();

print '<h3>BackUp by Module</h3>
<hr />
<br />';
print '<form action="./backup_bymod.php" method="post" style="margin:0;">';
print '<table class="outer">';
print '<tr><th colspan="2">'._AM_MYXBACKUP_BACKUPMOD_TITLE.'</th></tr>';
print '<tr>
<td class="head" width="40%">Select the module you want to backup and push button "Submit"</td>
<td class="odd" style="padding-left:20px;">';
print '<select name="mod_name" size="12" style="padding:0px 15px;">';
foreach ($mod_list as $mod) {
	print '<option value="'.htmlspecialchars($mod).'">'.htmlspecialchars($mod).'</option>';
}
print '</select>
</td></tr>';
print '
<tr><td colspan="2" class="foot">
<input type="hidden" name="op" value="backup" />';
print '<input type="submit" value="'._SUBMIT.'" />';
print '</td></tr>';
print '</table></form>';
xoops_cp_footer();
?>