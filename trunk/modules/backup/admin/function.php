<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }
if (!defined('MYXBU_SQLComment')) { exit(); }

function myxbu_create_sql ($tbldat = array('Name' => '')) {
	global $xoopsDB, $xoopsConfig, $xoopsModuleConfig;
	$table_name = addslashes(trim($tbldat['Name']));
	if ($table_name == '') { return ''; }
	$search  = array("\x00", "\x0a", "\x0d", "\x1a");
	$replace = array('\0', '\n', '\r', '\Z');
	$resSQL = '';
	$InsertQueries = ''; $CreateTableQuery = ''; $DropTableQuery = '';
	$fname = array(); $fmeta = array(); $fflag = array();
	//	Create Table SQL
	$res1 = $xoopsDB->queryF("SHOW CREATE TABLE `$table_name`");
	list($TableName, $CreateTableQuery) = $xoopsDB->fetchRow($res1);
	$CreateTableQuery = preg_replace('/;$/', '', trim($CreateTableQuery));
	if (!is_null($tbldat['Auto_increment']) && (intval($tbldat['Auto_increment']) > 0)) {
		$CreateTableQuery .= ' AUTO_INCREMENT='.intval($tbldat['Auto_increment']);
	}
	$CreateTableQuery .= ';';
	//	Drop Table SQL
	$DropTableQuery = "DROP TABLE IF EXISTS `$table_name`;";
	//	Field Info
	$res3 = $xoopsDB->query("SELECT * FROM `$table_name` LIMIT 0");
	for ($i = 0; $i < mysql_num_fields($res3); $i++) {
		$fname = mysql_field_name($res3, $i);
		$fmeta[$fname] = mysql_fetch_field($res3, $i);
		$fflag[$fname] = mysql_field_flags($res3, $i);
	}
	//	Insert Table SQL
	$res2 = $xoopsDB->query("SELECT * FROM `$table_name`");
	while ($row = $xoopsDB->fetchArray($res2)) {
		//	Fields & Values
		$fields = ''; $values = ''; $comma = '';
		foreach ($row as $key => $val) {
			if (is_null($val) || !isset($val)) {
				$values .= $comma."NULL";
			} elseif ($fmeta[$key]->numeric && ($fmeta[$key]->type != 'timestamp') && !($fmeta[$key]->blob)) {
				$values .= $comma.$val;
			} elseif (stristr($fflag[$key], 'BINARY') && ($fmeta[$key]->type != 'datetime') && ($fmeta[$key]->type != 'date') && ($fmeta[$key]->type != 'time') && ($fmeta[$key]->type != 'timestamp')) {
				if (empty($val) && ($val != '0')) {
					$values .= $comma."''";
				} else {
					$values .= $comma.'0x'.bin2hex($val);
				}
			} else {
				$values .= $comma."'".str_replace($search, $replace, addslashes($val))."'";
			}
			$fields .= $comma."`".addslashes($key)."`";
			$comma = ", ";
		}
		if (MYXBU_COMPINS) {
			$InsertQuery = "INSERT INTO `$table_name` (${fields}) VALUES (${values});";
		} else {
			$InsertQuery = "INSERT INTO `$table_name` VALUES (${values});";
		}
		$InsertQueries .= $InsertQuery."\n";
	}
	unset ($res2);
	$resSQL .= MYXBU_SQLComment."\n";
	$resSQL .= MYXBU_SQLComment." Table structure for table `$table_name`\n";
	$resSQL .= MYXBU_SQLComment." Table Created Time: ${tbldat['Create_time']}\n";
	$resSQL .= MYXBU_SQLComment."\n\n".$DropTableQuery."\n".$CreateTableQuery."\n\n";
	$resSQL .= MYXBU_SQLComment." ".MYXBU_SQLHairline."\n\n";
	$resSQL .= MYXBU_SQLComment."\n";
	$resSQL .= MYXBU_SQLComment." Dumping data for table `$table_name`\n";
	$resSQL .= MYXBU_SQLComment." Table Updated Time: ${tbldat['Update_time']}\n";
	$resSQL .= MYXBU_SQLComment."\n\n".$InsertQueries."\n";
	$resSQL .= MYXBU_SQLComment." ".MYXBU_SQLHairline."\n\n";
	
	return $resSQL;
}

//	Table List for Each Module
function myxbu_get_modules_info ($style = '') {
	global $xoopsDB, $SystemDBTables, $xoopsConfig, $xoopsModuleConfig;
	$ModuleTables = array();
	$ModuleVersion = array();
	$ModuleByDir = array();
	foreach ($SystemDBTables as $table) {
		if ($style != '') {
			$ModuleTables[$xoopsDB->prefix($table)] = '<span style="'.$style.'">system</span>';
		} else {
			$ModuleTables[$xoopsDB->prefix($table)] = 'system';
		}
	}
	$dir = dir(XOOPS_ROOT_PATH.'/modules/');
	while (($dname = $dir->read()) !== false) {
		if (!is_dir(XOOPS_ROOT_PATH.'/modules/'.$dname) || (strpos($dname, '.') === 0) || ($dname == '')) { continue; }
		if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$dname.'/xoops_version.php')) {
			unset ($modversion);
			if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$dname.'/language/'.$xoopsConfig['language'].'/modinfo.php')) {
				include_once XOOPS_ROOT_PATH.'/modules/'.$dname.'/language/'.$xoopsConfig['language'].'/modinfo.php';
			} elseif (file_exists(XOOPS_ROOT_PATH.'/modules/'.$dname.'/language/english/modinfo.php')) {
				include_once XOOPS_ROOT_PATH.'/modules/'.$dname.'/language/english/modinfo.php';
			}
			if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$dname.'/xoops_version.php')) {
				include_once (XOOPS_ROOT_PATH.'/modules/'.$dname.'/xoops_version.php');
				if (isset($modversion['tables'])) {
					foreach ($modversion['tables'] as $table) {
						if ($table != '') {
							$ModuleTables[$xoopsDB->prefix($table)] = htmlspecialchars($dname);
							$ModuleByDir[$xoopsDB->prefix($table)] = false;
						}
					}
				}
				if (isset($modversion['version'])) {
					$ModuleVersion[$dname] = htmlspecialchars($modversion['version']);
				}
			} else {
				$ModuleVersion[$dname] = 'unknown';
			}
		}
		if (MYXBU_USEDIR && (!in_array(htmlspecialchars($dname), $ModuleTables))) {
			$twild = str_replace('_', '\_', $xoopsDB->prefix(addslashes($dname).'_%'));
			$sql = "SHOW TABLE STATUS FROM `".XOOPS_DB_NAME."` LIKE '".$twild."'";
			$res = $xoopsDB->queryF($sql);
			while ($t = $xoopsDB->fetchArray($res)) {
				if (!isset($ModuleTables[$t['Name']]) && !in_array($t['Name'], $SystemDBTables)) {
					$ModuleTables[$t['Name']] = htmlspecialchars($dname);
					$ModuleByDir[$t['Name']] = true;
				}
			}
		}
	}
	return array($ModuleTables, $ModuleVersion, $ModuleByDir);
}
?>