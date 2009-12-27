<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

//	Display Header
xoops_cp_header();
print '<h4>BackUp - Check &amp; Repair</h3>
<hr />
<br />';

if (MYXBU_DEBUG) { print '<div style="color:#0000ff; font-size:larger; font-weight:bold; margin:12px;">DEBUG MODE</div>'; }

print '<table class="outer">';
print '<tr><th colspan="5">'._AM_MYXBACKUP_CHECK_TITLE.'</th></tr>';
print '<tr>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Command.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Name.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Status.'</td>';
print '</tr>';

//	Main
$res = $xoopsDB->queryF('SHOW TABLES FROM `'.XOOPS_DB_NAME.'`');
$C = '';
while (list($table_name) = $xoopsDB->fetchRow($res)) {
	if (preg_match('/^'.XOOPS_DB_PREFIX.'_(.*)$/', $table_name)) {
		//	Check tables
		$check = $xoopsDB->fetchArray($xoopsDB->queryF('CHECK TABLE `'.$table_name.'` '.MYXBU_CHECK_TYPE));
		if ($check['Msg_type'] != 'status') { $Color = '#ff0000'; } else { $Color = '#0000ff'; }
		$C = (($C == ' class="even"') ? ' class="odd"' : ' class="even"');
		print '<tr'.$C.'>';
		print '<td nowrap="nowrap">CHECK '.MYXBU_CHECK_TYPE.'</td>';
		print '<td nowrap="nowrap">'.htmlspecialchars($table_name).'</td>';
		print '<td nowrap="nowrap" style="color:'.$Color.';"><img src="'.XOOPS_URL.'/images/accept.png" alt="'.htmlspecialchars($check['Msg_text']).'" title="'.htmlspecialchars($check['Msg_text']).'" /></td>';
		print '</tr>';
		//	Repair table
		if (($check['Msg_type'] != 'status') && (!MYXBU_DEBUG)) {
			$repair = $xoopsDB->fetchArray($xoopsDB->queryF('REPAIR TABLE `'.$table_name.'`'));
			if ($repair['Msg_type'] != 'status') { $S = 'color:#ff0000'; } else { $S = 'color:#0000ff'; }
			print '<tr'.$C.'>';
			print '<td nowrap="nowrap" style="color:#00ff00;">REPAIR</td>';
			print '<td nowrap="nowrap">'.htmlspecialchars($table_name).'</td>';
			print '<td nowrap="nowrap" style="'.$S.';">'.htmlspecialchars($repair['Msg_text']).'</td>';
			print '</tr>';
		}
	}
}

//	Display Footer
print '</table>';
xoops_cp_footer();
?>