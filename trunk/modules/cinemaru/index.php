<?php

include 'header.php';
require_once('include/db.php');
require_once('include/pagenavi.class.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';


$mydirname = basename( dirname( __FILE__ ) ) ;
$xoopsTpl->assign('mydirname', $mydirname);
$constpref = strtoupper( $mydirname ) ;

$xoopsOption['template_main'] = $mydirname . '_index.html';

$auth_admin = cinemaru_is_auth_perm();
$delcomment_admin = cinemaru_is_auth_delele_comment();

if ($auth_admin) {
    if (cinemaru_movie_get_count(1, 1)) {
	$xoopsTpl->assign('novalid_exists', 1);
    }
}

if (isset($_REQUEST['tag'])) {
    $total = cinemaru_movie_get_count_with_tag($_REQUEST['tag'], $auth_admin, @$_REQUEST['vv']);
} else {
    $total = cinemaru_movie_get_count($auth_admin, @$_REQUEST['vv']);
}

$pn = new PageNavi($total, intval(@$_GET['offset']), $xoopsModuleConfig['num_of_sumb']);

if (isset($_REQUEST['tag'])) {
    $movie_list = cinemaru_movie_get_list_custom_with_tag($pn->offset, $pn->limit, $_REQUEST['tag'], @$auth_admin, @$_REQUEST['vv'], @$_REQUEST['sort']);
} else {
    $movie_list = cinemaru_movie_get_list_custom($pn->offset, $pn->limit, $auth_admin, @$_REQUEST['vv'], @$_REQUEST['sort']);
}
$movie_list = cinemaru_movie_truncate($movie_list);

if (isset($_GET['thumb'])) {
    $xoopsTpl->assign('thumb', '1');
    setcookie('thumb', 1, 0);
} else if (isset($_GET['list'])) {
    setcookie('thumb', 0, '0');
} else if (@$_COOKIE['thumb'] == 1) {
    $xoopsTpl->assign('thumb', '1');
} else if ($xoopsModuleConfig['top_movie'] == 2) {
    $xoopsTpl->assign('thumb', '1');
}

$groupperm_showcomment = cinemaru_checkright(constant($constpref.'_GROUPPERM_SHOWCOMMENT'));
$groupperm_insertable = cinemaru_checkright(constant($constpref.'_GROUPPERM_INSERTABLE'));
$groupperm_report_list = cinemaru_checkright(constant($constpref.'_GROUPPERM_REPORT_LIST'));

if ($groupperm_report_list) {
    $check_report_list = cinemaru_report_get_count();
}

$xoopsTpl->assign('groupperm_insertable', $groupperm_insertable);
$xoopsTpl->assign('check_report_list', @$check_report_list);
$xoopsTpl->assign('auth_admin', $auth_admin);
$xoopsTpl->assign('groupperm_showcomment', $groupperm_showcomment);
$xoopsTpl->assign('need_prev_link', $pn->need_prev_link());
$xoopsTpl->assign('need_next_link', $pn->need_next_link());
$xoopsTpl->assign('prev', $pn->get_prev());
$xoopsTpl->assign('next', $pn->get_next());
$xoopsTpl->assign('top', $pn->get_top());
$xoopsTpl->assign('last', $pn->get_last());
$xoopsTpl->assign('total', $total);
$xoopsTpl->assign('cinemaru_module_config', $xoopsModuleConfig);

$l = $pn->get_page_list();

$xoopsTpl->assign('page_list', $l);
$xoopsTpl->assign('movie_list', $movie_list);

include XOOPS_ROOT_PATH.'/footer.php';

