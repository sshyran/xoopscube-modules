<?php
require_once '../../../include/cp_header.php';
require_once './header.php';

//	Database Tables and Modules List
$sqlfiles = array();
$filescount = 0;
$keyseed = XOOPS_DB_PREFIX;
$dir = dir(MYXBU_SQL_DIR);
while (($fname = $dir->read()) !== false) {
	$keyseed .= $fname;
	if (is_dir(XOOPS_ROOT_PATH.'/modules/'.$myxbu_mydirname.'/sql/'.$fname)) { continue; }
	if (!preg_match('/(.+)\.sql$/i', $fname)) { continue; }
	$sqlfiles[$filescount++] = $fname;
}
$checkkey = md5($keyseed);

//	No SQL Files
if ($filescount == 0) {
	redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/index.php', 4, _AM_MYXBACKUP_NOSQLFILES);
}

//	Display Header
xoops_cp_header();
print '<h4>MyX_BackUp - Restore  <a href="./index.php" title="'._AM_MYXBACKUP_GOBACK_TO_MENU.'" style="margin-left:24px;">-&gt;MENU</a></h4>';
if (MYXBU_DEBUG) { print '<div style="color:#0000ff; font-size:larger; font-weight:bold; margin:12px;">DEBUG MODE</div>'; }

//	Main
if (isset($_POST['op']) && ($_POST['op'] == 'restore')) {
	if ((strpos($_SERVER['HTTP_REFERER'], XOOPS_URL."/modules/$myxbu_mydirname/admin/") !== 0)) {
		redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/restore.php', 3, _AM_MYXBACKUP_ERROR);
	}
	//	Check
	if (!isset($_POST['checkkey']) || ($_POST['checkkey'] != $checkkey)) {
		redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/restore.php', 10, _AM_MYXBACKUP_FILECHECKERROR);
	}
	if (!isset($_POST['prefix']) || ($_POST['prefix'] == '')) {
		redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/restore.php', 10, _AM_MYXBACKUP_PARAMETERERROR);
	}
	//	Get Posted
	$prefix = $_POST['prefix'];
	if (preg_match("/[`';\/\.\s]/", $prefix)) {
		redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/restore.php', 10, _AM_MYXBACKUP_PARAMETERERROR);
	}
	//	Match Patterns
	//	- End Pointer 'END_OF_SQL_FILE'
	//	- Ignore 'DROP' Command
	$mqr = get_magic_quotes_runtime();
	set_magic_quotes_runtime(0);
	$pattern1 = '/^(INSERT[\s]+INTO|CREATE[\s]+TABLE|DROP[\s]+|END_OF_SQL_FILE)/siU';
	$pattern2 = '/^(INSERT[\s]+INTO|CREATE[\s]+TABLE)([\s]+)([`]?)('.$prefix.')(.+)$/siU';
	$replace2 = "\\1 \\3".XOOPS_DB_PREFIX."\\5";
	$pattern3 = '/^(DROP TABLE)/siU';
	$jobstat = true;
	$currenttable = '';
	$tabledatacount = 0;
	foreach ($sqlfiles as $fname) {
		print '<div style="color:#00ff00; font-size:larger; font-weight:bold; background-color:#333333; padding:4px; margin-top:2px;">SQL File : '.htmlspecialchars($fname).'</div>';
		$sql_queries = file(XOOPS_ROOT_PATH.'/modules/'.$myxbu_mydirname.'/sql/'.$fname);
		$sql_queries[] = 'END_OF_SQL_FILE';
		$sql = ''; $delsql = ''; $resstat = true;
		foreach ($sql_queries as $fline) {
			$fline = trim($fline);
			if (($fline == '') || (strpos($fline, '#') === 0) || (strpos($fline, '--') === 0)) { continue; }
			//	SQL Command ?
			if (preg_match($pattern1, $fline) ) {
				if (($sql != '') && preg_match($pattern2, $sql)) {
					$sql = preg_replace($pattern2, $replace2, $sql);
					$sql = trim(preg_replace('/;$/', '', $sql));
					//	Drop Before Create
					if (preg_match('/^CREATE TABLE[\s]+([\S]+)/i', $sql, $matches)) {
						if ($currenttable != '') {
							print '<div style="color:#00aa00; margin-left:32px;">---- '.$tabledatacount.' DATA INSERTED : '.htmlspecialchars($currenttable).'</div>';
							$tabledatacount = 0;
							$currenttable = $matches[1];
						}
						$currenttable = $matches[1];
						$delsql = 'DROP TABLE IF EXISTS '.$matches[1];
						print '<div style="color:#003300; margin-left:16px;">TABLE CREATED : '.htmlspecialchars($matches[1]).'</div>';
					} else { $delsql = ''; }
					if (preg_match('/^INSERT INTO[\s]+([\S]+)/i', $sql, $matches)) {
						if ($currenttable == $matches[1]) {
							$tabledatacount++;
						} else {
							print '<div style="color:#00aa00; margin-left:32px;">---- '.$tabledatacount.' DATA INSERTED : '.htmlspecialchars($currenttable).'</div>';
							$tabledatacount = 0;
							$currenttable = $matches[1];
						}
					}
					if (MYXBU_DEBUG) {
						echo nl2br(htmlspecialchars($delsql."\n".$sql)).'<br />----<br />';
					} else {
						if ($delsql != '') { $xoopsDB->query($delsql); }
						$resstat &= $xoopsDB->query($sql);
					}
				}
				$sql = $fline;
			} elseif (!preg_match($pattern3, $fline)) {
				$sql .= "\n".$fline;
			}
			if (!$resstat) { print _AM_MYXBACKUP_RESTOREERROR; break; }
		}
		if ($currenttable != '') {
			print '<div style="color:#00aa00; margin-left:32px;">---- '.$tabledatacount.' DATA INSERTED : '.htmlspecialchars($currenttable).'</div>';
			$tabledatacount = 0;
			$currenttable = '';
		}
		unset ($sql_queries);
		$jobstat &= $resstat;
		// @unlink (XOOPS_ROOT_PATH.'/modules/'.$myxbu_mydirname.'/sql/'.$fname);
	}
	set_magic_quotes_runtime($mqr);
	if ($jobstat) {
		print '<div style="color:#0000ff; font-size:large; font-weight:bold; margin-top:12px;">';
	} else {
		print '<div style="color:#ff0000; font-size:large; font-weight:bold; margin-top:12px;">';
	}
	print _AM_MYXBACKUP_RESTORE_DONE.'</div>';
} else {
	//	Confirmation
	print '<table width="100%">';
	print '<tr><th colspan="3">'._AM_MYXBACKUP_RESTORE_TITLE.'</th></tr>';
	print '<tr class="head">';
	print '<td>'._AM_MYXBACKUP_SQL_NAME.'</td>';
	print '<td>'._AM_MYXBACKUP_LIST_Name.'</td>';
	print '<td>'._AM_MYXBACKUP_SQL_DATE.'</td>';
	print '</tr>';
	$C = '';
	foreach ($sqlfiles as $fname) {
		$C = (($C == ' class="even"') ? ' class="odd"' : ' class="even"');
		$fpath = XOOPS_ROOT_PATH.'/modules/'.$myxbu_mydirname.'/sql/'.$fname;
		$ftime = (date('Y/m/d H:i:s', filectime($fpath)));
		$table_names = array();
		$fp = fopen($fpath, 'r');
		while (!feof($fp)) {
			$line = fgets($fp, 1024);
			if (preg_match('/^(INSERT INTO|CREATE TABLE)([\s`]+)([^\s`;]+)/i', $line, $matches)) {
				$myname = htmlspecialchars($matches[3]);
				if (!in_array($myname, $table_names)) { $table_names[] = $myname; }
			}
		}
		print '<tr'.$C.'>';
		print '<td>'.htmlspecialchars($fname).'</td>';
		print '<td>'.implode('<br />', $table_names).'</td>';
		print '<td>'.htmlspecialchars($ftime).'</td></tr>';
	}
	print '</table><br />';
	print '<form action="./restore.php" method="post" style="margin:0;">';
	print '<table width="100%"><tr class="head"><td colspan="2">'._AM_MYXBACKUP_GO_RESTORE_NOTE.'</td></tr>';
	print '<tr><td class="even">'._AM_MYXBACKUP_MYPREFIX.'</td>';
	print '<td class="odd">'.XOOPS_DB_PREFIX.'</td></tr>';
	print '<tr><td class="even">'._AM_MYXBACKUP_SQL_PREFIX.'</td>';
	print '<td class="odd"><input type="text" name="prefix" size="24" value="'.XOOPS_DB_PREFIX.'" /><br />'._AM_MYXBACKUP_SQLPREFIX.'</td></tr>';
	print '<tr><td class="even">'._AM_MYXBACKUP_GO_RESTORE.'</td>';
	print '<td class="odd"><input type="hidden" name="op" value="restore" />';
	print '<input type="hidden" name="checkkey" value="'.$checkkey.'" />';
	print '<input type="submit" name="submit" value="'._AM_MYXBACKUP_GO_RESTORE.'" />  '._AM_MYXBACKUP_GO_RESTORE_NOTE.'</td></tr>';
	print '</table></form>';
}

//	Display Footer
xoops_cp_footer();
?>