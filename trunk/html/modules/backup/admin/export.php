<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

//	Operation
$op = (isset($_POST['op']) ? $_POST['op'] : '');
$table_name = (isset($_POST['table_name']) ? $_POST['table_name'] : '');
if (!preg_match('/^'.XOOPS_DB_PREFIX.'_(.*)$/', $table_name)) { $op = ''; }
$table_name = addslashes($table_name);

//	Query
$res_t = $xoopsDB->queryF('SHOW TABLE STATUS FROM `'.XOOPS_DB_NAME.'`');
if ($table_name != '') {
	$res_d = $xoopsDB->queryF("SELECT * FROM `$table_name`");
	if ($xoopsDB->getRowsNum($res_d) == 0) { $op = ''; }
} else {
	$op = '';
}

//	Main
if ($op == 'export') {
	//	Export Main
	$result = '';
	$res = $xoopsDB->query("SELECT * FROM `$table_name` LIMIT 0");
	$fnum = mysql_num_fields($res);
	$comma = '';
	for ($i = 0; $i < $fnum; $i++) {
		$fname[$i] = mysql_field_name($res, $i);
		$fmeta[$i] = mysql_fetch_field($res, $i);
		$fflag[$i] = mysql_field_flags($res, $i);
		$result .= $comma.'"'.str_replace('"', '""', $fname[$i]).'"';
		$comma = ', ';
	}
	$result .= "\r\n";
	//	Table Data
	$row = array();
	while ($row = $xoopsDB->fetchRow($res_d)) {
		$comma = '';
		for ($i = 0; $i < $fnum; $i++) {
			$val = $row[$i];
			if (is_null($val) || !isset($val)) {
				$result .= $comma."''";
			} elseif ($fmeta[$i]->numeric) {
				$result .= $comma.$val;
			} else {
				$val = str_replace('"', '""', $val);
				$val = str_replace("\t", '    ', $val);
				$val = str_replace("\r", '', $val);
				$val = str_replace("\n", '\r\n', $val);
				$val = mb_convert_encoding($val, 'SJIS', _CHARSET);
				$result .= $comma.'"'.$val.'"';
			}
			$comma = ", ";
		}
		$result .= "\r\n";
	}
	//	Header
	header("Content-type: text/plain; charset=SJIS");
	header("Content-Disposition: attachment; filename=${table_name}.txt");
	header("Content-Length: ".strlen($result));
	print $result;
} else {
	//	Show list of tables
	xoops_cp_header();
	print '<div class="adminnavi">BackUp &raquo;&raquo; Export</div>';
	print '<form action="./export.php" method="post" style="margin:0;">';
	print '<table class="outer">';
	print '<tr><th colspan="2">'._AM_MYXBACKUP_EXPORT_TITLE.'</th></tr>';
	print '<tr><td class="head" width="40%">Select a table from your dababase then push button "submit".<br />This will export a ".txt" file with your table data.</td>';
	print '<td class="odd" style="padding-left:20px;"><select name="table_name" size="12" style="padding:0px 15px;">';
	while ($t = $xoopsDB->fetchArray($res_t)) {
		if (preg_match('/^'.XOOPS_DB_PREFIX.'_(.*)$/', $t['Name']) && ($t['Rows'] > 0)) {
			print '<option value="'.htmlspecialchars($t['Name']).'">'.htmlspecialchars($t['Name']).'</option>';
		}
	}
	print '</select></td></tr>';
	print '<tr><td colspan="2" class="foot"><input type="hidden" name="op" value="export" />';
	print '<input type="submit" value="'._SUBMIT.'" />';
	print '</form>';
	print '</td></tr>';
	print '</table>';
	xoops_cp_footer();
}
?>