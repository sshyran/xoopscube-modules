<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

include_once './function.php';

//	Database Tables and Modules List
list($table2module, $modules2version, $modulebydir) = myxbu_get_modules_info('color:#0000ff;');

//	Display Header
xoops_cp_header();
print '<h3>BackUp - Report</h3>
<hr />
<br />';
print '<table class="outer">';
print '<tr><th colspan="7">'._AM_MYXBACKUP_REPORT_TITLE.'</th></tr>';
print '<tr>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Name.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_ModName.'</td>';
print '<td class="head" align="right">'._AM_MYXBACKUP_LIST_Rows.'</td>';
print '<td class="head" align="right">'._AM_MYXBACKUP_LIST_Data_length.'</td>';
print '<td class="head" align="right">'._AM_MYXBACKUP_LIST_Avg_row_length.'</td>';
print '<td class="head" align="right">'._AM_MYXBACKUP_LIST_Data_free.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Update_time.'</td>';
print '</tr>';

//	Main
$res = $xoopsDB->queryF('SHOW TABLE STATUS FROM `'.XOOPS_DB_NAME.'`');
$C = '';
$Total = array('Rows' => 0, 'Data_length' => 0, 'Data_free' => 0, 'Update_time' => '1970-01-01 00:00:00');
while ($t = $xoopsDB->fetchArray($res)) {
	if (preg_match('/^'.XOOPS_DB_PREFIX.'_(.*)$/', $t['Name'])) {
		$C = (($C == ' class="even"') ? ' class="odd"' : ' class="even"');
		if (isset($table2module[$t['Name']])) {
			$ModName = $table2module[$t['Name']];
			if (isset($modulebydir[$t['Name']]) && $modulebydir[$t['Name']]) { $ModName .= ' *'; }
		} else {
			$ModName = '<span style="color:#ff0000;">[ unknown ]</span>';
		}
		print '<tr'.$C.'>';
		print '<td nowrap="nowrap">'.htmlspecialchars($t['Name']).'</td>';
		print '<td nowrap="nowrap">'.$ModName.'</td>';
		print '<td nowrap="nowrap" align="right">'.number_format($t['Rows']).'</td>';
		print '<td nowrap="nowrap" align="right">'.number_format($t['Data_length']).'</td>';
		print '<td nowrap="nowrap" align="right">'.number_format($t['Avg_row_length']).'</td>';
		print '<td nowrap="nowrap" align="right">'.number_format($t['Data_free']).'</td>';
		print '<td nowrap="nowrap">'.$t['Update_time'].'</td>';
		print '</tr>';
		$Total['Rows'] += intval($t['Rows']);
		$Total['Data_length'] += intval($t['Data_length']);
		$Total['Data_free'] += intval($t['Data_free']);
		if ($Total['Update_time'] < $t['Update_time']) { $Total['Update_time'] = $t['Update_time']; }
	}
}
print '<tr><th nowrap="nowrap" colspan="2">Total</th>';
print '<td class="head" nowrap="nowrap" align="right">'.number_format($Total['Rows']).'</td>';
print '<td class="head" nowrap="nowrap" align="right">'.number_format($Total['Data_length']).'</td>';
print '<td class="head" nowrap="nowrap" align="right">'.number_format($Total['Data_length'] / $Total['Rows']).'</td>';
print '<td class="head" nowrap="nowrap" align="right">'.number_format($Total['Data_free']).'</td>';
print '<td class="head" nowrap="nowrap">'.$Total['Update_time'].'</td>';
print '</tr>';

//	Display Footer
print '</table>';
xoops_cp_footer();
?>