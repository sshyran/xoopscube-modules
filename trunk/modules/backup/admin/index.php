<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

//	Display Header
xoops_cp_header();
print '<h3>Backup Menu</h3>
<hr />
<br />';

if (MYXBU_DEBUG) { print '<div class="error">DEBUG MODE</div>'; }

//	SQL files exsit
$filescount = 0;
$dir = dir(MYXBU_SQL_DIR);
while (($fname = $dir->read()) !== false) {
	if (is_dir(XOOPS_ROOT_PATH.'/modules/'.$myxbu_mydirname.'/sql/'.$fname)) { continue; }
	if ($fname == 'index.html') { continue; }
	if ($fname == '.htaccess') { continue; }
	$filescount++;
}
if ($filescount > 0) {
	print '<br /><div class="confirm"">'._AM_MYXBACKUP_SQLFILE_EXSITS.'</div>';
}

//	Main
print '<table class="outer">';
print '
<tr><th colspan="2">BackUp</th></tr>
<tr>
<td class="head" width="40%">'._AM_MYXBACKUP_REPORT_DESC.'</td>
<td class="odd"><a href="./report.php">'._AM_MYXBACKUP_REPORT_TITLE.'</a></td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_OPTIMIZE_DESC.'</td>
<td class="even"><a href="./optimize.php">'._AM_MYXBACKUP_OPTIMIZE_TITLE.'</a></td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_CHECK_DESC.'</td>
<td class="odd"><a href="./check.php">'._AM_MYXBACKUP_CHECK_TITLE.'</a></td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_CLEANUP_DESC.'</td>
<td class="even"><a href="./cleanup.php">'._AM_MYXBACKUP_CLEANUP_TITLE.'</a>...</td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_BACKUP_DESC.'</td>
<td class="odd"><a href="./backup.php"'.(MYXBU_DEBUG ? '' : ' target="_blank"').'>'._AM_MYXBACKUP_BACKUP_TITLE.'</a></td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_BACKUPMOD_DESC.'</td>
<td class="even"><a href="./backup_bymod.php"'.(MYXBU_DEBUG ? '' : ' target="_blank"').'>'._AM_MYXBACKUP_BACKUPMOD_TITLE.'</a>...</td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_DUMP_DESC.'</td>
<td class="odd"><a href="./dump.php">'._AM_MYXBACKUP_DUMP_TITLE.'</a></td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_EXPORT_DESC.'</td>
<td class="even"><a href="./export.php">'._AM_MYXBACKUP_EXPORT_TITLE.'</a>...</td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_RESTORE_DESC.'</td>
<td class="odd"><a href="./restore.php">'._AM_MYXBACKUP_RESTORE_TITLE.'</a>...</td>
</tr>';
print '<tr>
<td class="head">'._AM_MYXBACKUP_CONFIG_DESC.'</td>
<td class="even"><a href="'.XOOPS_URL.'/modules/legacy/admin/index.php?action=PreferenceEdit&confmod_id='.$xoopsModule->getVar('mid').'">'._AM_MYXBACKUP_CONFIG_TITLE.'</a>...</td>
</tr>';
print '</table>';

//	PHP / MySQL Information
$res = $xoopsDB->query('SELECT VERSION()');
list($MySQLVersion) = $xoopsDB->fetchRow($res);
print '<div class="resultMsg">';
// print '<tr><td nowrap="nowrap">XOOPS Version</td><td nowrap="nowrap">'.XOOPS_VERSION.'</td></tr>';
print '<ul><li>MySQL Version : '.$MySQLVersion.'</li>';
print '<li>PHP Version : '.phpversion().'</li>';
if (function_exists('memory_get_usage')) {
	print '<li>PHP Memory Limit : '.memory_get_usage().' Bytes</li>';
}
print '<li>PHP Max Excecution Time : '.ini_get('max_execution_time').' sec.</li>';
print '</ul>';
print '<br /><p>'._AM_MYXBACKUP_NOTICEONINDEX.'</p></div>';
xoops_cp_footer();
?>