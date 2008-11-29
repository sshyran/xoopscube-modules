<?php

include 'header.php';

include XOOPS_ROOT_PATH.'/header.php';
$xoopsTpl->assign('lang_title', _XD_TITLE);

require_once 'include/WaffleMAP.php';
require_once 'include/WaffleGrant.php';
require_once 'include/misc.php';

define("DEFINE_DD", $GLOBALS['waffle_mydirname'] . '_table');

$xoopsTpl->assign('index_php', WAFFLE_DEFAULT_INDEX_PHP);
$xoopsTpl->assign('mydirname', $GLOBALS['waffle_mydirname']);

if (isset($_POST['t_dd'])) {
    $dd = $_POST['t_dd'];
} else if (isset($_GET['t_dd'])) {
    $dd = $_GET['t_dd'];
} else {
    $dd = DEFINE_DD;
}

$dd = preg_replace('/[^0-9A-Za-z\._]/', '', $dd);

$xoopsTpl->assign('table_name', $dd);
$map = WaffleMAP::new_with_cache($dd . '.yml');

// page dispatch
if (isset($_POST['t_m'])) {
    $mod = $_POST['t_m'];
} else if (isset($_GET['t_m'])) {
    $mod = $_GET['t_m'];
} else {
    $mod = '';
}

$mod = preg_replace('/[^0-9A-Za-z_]/', '', $mod);
$custom_phpfile = 'custom/' . $mod . '.php';
$phpfile = 'php/' . $mod . '.php';

if (is_readable($custom_phpfile)) {
    require($custom_phpfile);

    if (function_exists($mod)) {
	$mod();
    } else {
	echo 'Function not found';
    }
} else if (is_readable($phpfile)) {
    require($phpfile);

    if (function_exists($mod)) {
	$mod();
    } else {
	echo 'Function not found';
    }
} else {
    require('php/ddcommon_index.php');
    ddcommon_index();
}

include XOOPS_ROOT_PATH.'/footer.php';

?>
