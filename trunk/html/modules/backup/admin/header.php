<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

//	Unset Global Variables ( for security )
//foreach ($_GET as $key => $val) { unset($$key); }
//foreach ($_POST as $key => $val) { unset($$key); }
//foreach ($_COOKIE as $key => $val) { unset($$key); }

//	PHP Settings
//set_time_limit(300);

//	My Directry
$myfulldirname = dirname(__FILE__);
$myxbu_mydirname = basename(dirname(dirname(__FILE__)));

//	Define
//	Directory for SQL Files
define ('MYXBU_SQL_DIR', XOOPS_ROOT_PATH.'/modules/'.$myxbu_mydirname.'/sql/');
//	SQL comment letter
define ('MYXBU_SQLComment', '#');
//	SQL comment hairline
define ('MYXBU_SQLHairline', '--------------------------------------------------------');

//	Get configulation
if ($xoopsModuleConfig['DEBUG_MODE']) { define ('MYXBU_DEBUG', true); } else { define ('MYXBU_DEBUG', false); }
if ($xoopsModuleConfig['COMP_INS']) { define ('MYXBU_COMPINS', true); } else { define ('MYXBU_COMPINS', false); }
if ($xoopsModuleConfig['DIR_AS_MODULE_NAME']) { define ('MYXBU_USEDIR', true); } else { define ('MYXBU_USEDIR', false); }
if (preg_match('/^(QUICK|FAST|MEDIUM|EXTENDED|CHANGED)$/i', $xoopsModuleConfig['CHECK_TYPE'])) {
	define ('MYXBU_CHECK_TYPE', $xoopsModuleConfig['CHECK_TYPE']);
} else { define ('MYXBU_CHECK_TYPE', 'MEDIUM'); }

//	Check Referer
if (($_SERVER['HTTP_REFERER'] != '') && (strpos($_SERVER['HTTP_REFERER'], XOOPS_URL) !== 0)) {
	redirect_header(XOOPS_URL.'/modules/'.$myxbu_mydirname.'/admin/index.php', 3, _AM_MYXBACKUP_ERROR);
}

//	System Database Tables
$SystemDBTables = array(
	'avatar', 'avatar_user_link', 'banner', 'bannerclient',
	'bannerfinish', 'block_module_link', 'xoopscomments', 'xoopsnotifications',
	'config', 'configcategory', 'configoption', 'groups',
	'group_permission', 'groups_users_link', 'image', 'imagebody',
	'imagecategory', 'imgset', 'imgset_tplset_link', 'imgsetimg',
	'modules', 'newblocks', 'online', 'priv_msgs',
	'ranks', 'session', 'smiles', 'tplset',
	'tplfile', 'tplsource', 'users', 'user_mailjob', 'user_mailjob_link',
	'legacy_contents', 'legacyrender_theme'
	);
?>