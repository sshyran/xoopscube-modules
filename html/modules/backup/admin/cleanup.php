<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

include_once './function.php';

//	Get Modules Installed
$instMod = array();
$module_handler =& xoops_gethandler('module');
$installed_mods =& $module_handler->getObjects(new CriteriaCompo());
foreach ($installed_mods as $module) {
	$instMod[$module->getVar('dirname')] = $module->getVar('name');
}
$instMod['system'] = 'system';

//	Database Tables and Modules List
list($table2module, $modules2version, $modulebydir) = myxbu_get_modules_info();

//	List-up Tables to be Deleted
$res = $xoopsDB->queryF('SHOW TABLE STATUS FROM `'.XOOPS_DB_NAME.'`');
$table_list = array(); $table_count = 0; $table_names = array();
$keyseed = XOOPS_DB_PREFIX;
while ($t = $xoopsDB->fetchArray($res)) {
	$keyseed .= $t['Name'];
	if (preg_match('/^'.XOOPS_DB_PREFIX.'_(.*)$/', $t['Name'])) {
		if (isset($table2module[$t['Name']])) {
			$ModName = $table2module[$t['Name']];
			if (isset($instMod[$ModName])) { continue; }
		}
		$table_list[$table_count] = $t;
		$table_names[$t['Name']] = $t['Name'];
		$table_count++;
	}
}
$checkkey = md5($keyseed);

//	Delete Main
$message = '';
$table_deleted = array();
if (isset($_POST['op']) && ($_POST['op'] == 'delete')) {
	if ((strpos($_SERVER['HTTP_REFERER'], XOOPS_URL."/modules/$myxbu_mydirname/admin/") !== 0)) {
		redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/cleanup.php', 3, _AM_MYXBACKUP_ERROR);
	}
	if (!isset($_POST['checkkey']) || ($_POST['checkkey'] != $checkkey)) {
		redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/index.php', 3, _AM_MYXBACKUP_DBCHECKERROR);
	} else {
		if (MYXBU_DEBUG) {
			$message .= '<div class="error">DEBUG MODE</div>';
			print '<div class="error">DEBUG MODE</div>';
		}
		if ($table_count > 0) {
			foreach ($table_names as $key) {
				if (isset($_POST[$key]) && ($_POST[$key] == 1)) {
					$sql = 'DROP TABLE `'.addslashes($key).'`';
					if (MYXBU_DEBUG) { echo htmlspecialchars($sql).'<br />'; $res = true; }
					else { $res = $xoopsDB->query($sql); }
					if ($res !== false) {
						$message .= htmlspecialchars($key).' '._AM_MYXBACKUP_TABLE_DELETED.'<br />';
					} else {
						$message .= htmlspecialchars($key).' '._AM_MYXBACKUP_TABLE_NOTDELETED.'<br />';
					}
				}
			}
		}
	}
}
if ($message != '') { redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/cleanup.php', 10, $message); exit(); }

//	Display Header (Menu)
xoops_cp_header();

print '<div class="adminnavi">BackUp &raquo;&raquo; CleanUp</div>';
print '<div class="confirm">'._AM_MYXBACKUP_CAUTIONTODEL.'</div>';
if (MYXBU_DEBUG) { print '<div class="error">DEBUG MODE</div>'; }
print '<form action="./cleanup.php" method="post" style="margin:0;">';
print '<table class="outer">';
print '<tr><th colspan="5">'._AM_MYXBACKUP_CLEANUP_TITLE.'</th></tr>';
print '<tr>';
print '<td class="head">'._AM_MYXBACKUP_CHECK_TO_DELETE.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Name.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Rows.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Data_length.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Update_time.'</td>';
print '</tr>';

//	Display Main
$C = '';
if ($table_count == 0) {
	print '<tr><td align="center" colspan="5">'._AM_MYXBACKUP_NOTABLES_TO_DELETE.'</td></tr>';
} else {
	foreach ($table_list as $t) {
		$C = (($C == ' class="even"') ? ' class="odd"' : ' class="even"');
		print '<tr'.$C.'>';
		print '<td align="center"><input type="checkbox" name="'.htmlspecialchars($t['Name']).'" value="1" /></td>';
		print '<td nowrap="nowrap">'.htmlspecialchars($t['Name']).'</td>';
		print '<td nowrap="nowrap" align="right">'.number_format($t['Rows']).'</td>';
		print '<td nowrap="nowrap" align="right">'.number_format($t['Data_length']).'</td>';
		print '<td nowrap="nowrap">'.$t['Update_time'].'</td>';
		print '</tr>';
	}
	print '<tr><td colspan="5" class="foot">';
	print '<input type="hidden" name="op" value="delete" />';
	print '<input type="hidden" name="checkkey" value="'.$checkkey.'" />';
	print '<input type="submit" name="'._SUBMIT.'" value="'._AM_MYXBACKUP_TAKERISK.'" />';
	print '</td></tr>';
}

//	Display Footer
print '</table></form><br />';

xoops_cp_footer();
?>