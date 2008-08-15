<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

//	Display Header
xoops_cp_header();
print '<h3>BackUp - Optimize</h3>
<hr />
<br />';
print '<table class="outer">';
print '<tr><th colspan="5">'._AM_MYXBACKUP_OPTIMIZE_TITLE.'</th></tr>';
print '<tr>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Name.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Data_free.'</td>';
print '<td class="head">'._AM_MYXBACKUP_LIST_Status.'</td>';
print '</tr>';

//	Main
$res = $xoopsDB->queryF('SHOW TABLE STATUS FROM `'.XOOPS_DB_NAME.'`');
$C = '';
while ($t = $xoopsDB->fetchArray($res)) {
	if (preg_match('/^'.XOOPS_DB_PREFIX.'_(.*)$/', $t['Name'])) {
		$C = (($C == ' class="even"') ? ' class="odd"' : ' class="even"');
		print '<tr'.$C.'><td>'.htmlspecialchars($t['Name']).'</td><td align="right">'.intval($t['Data_free']).'</td>';
		$res2 = $xoopsDB->queryF("OPTIMIZE TABLE `".$t['Name'].'`');
		$result = $xoopsDB->fetchArray($res2);
		if ($result['Msg_type'] == 'error') { $S = ' style="color:#ff0000;"'; } else { $S = ''; }
		print '<td'.$S.'>'.htmlspecialchars($result['Msg_type'].' -- '.$result['Msg_text']).'</td>';
		print '</tr>';
	}
}

//	Display Footer
print '</table>';
xoops_cp_footer();
?>