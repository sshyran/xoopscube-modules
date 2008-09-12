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

$xoopsOption['template_main'] = $mydirname . '_comment_list.html';

$groupperm_showcomment = cinemaru_checkright(constant($constpref.'_GROUPPERM_SHOWCOMMENT'));
if ($groupperm_showcomment == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_COMMENT_READ);
    exit();
}

$total = cinemaru_comment_get_count(@$_REQUEST['id']);

$pn = new PageNavi($total, intval(@$_GET['offset']), 50);

$list = cinemaru_comment_get_custom($pn->offset, $pn->limit, @$_REQUEST['id']);

if ($xoopsModuleConfig['show_name_comment_list']) {
    $member_handler =& xoops_gethandler('member');

    foreach ($list as $key => $val) {
	$user = $member_handler->getUser($val['reg_user']);
	
	if ($val['reg_user'] == 0 || $user == false) {
	    $name = $xoopsModuleConfig['guest_user_name'];
	} else {
	    $name = $user->getVar('uname');
	}
	$val['uname'] = $name;
	$list[$key] = $val;
    }
}


$delcomment_admin = cinemaru_is_auth_delele_comment();

$xoopsTpl->assign('show_name_comment_list', $xoopsModuleConfig['show_name_comment_list']);
$xoopsTpl->assign('delcomment_admin', $delcomment_admin);
$xoopsTpl->assign('need_prev_link', $pn->need_prev_link());
$xoopsTpl->assign('need_next_link', $pn->need_next_link());
$xoopsTpl->assign('prev', $pn->get_prev());
$xoopsTpl->assign('next', $pn->get_next());
$xoopsTpl->assign('top', $pn->get_top());
$xoopsTpl->assign('last', $pn->get_last());
$xoopsTpl->assign('total', $total);
$xoopsTpl->assign('list', $list);

$l = $pn->get_page_list();
$xoopsTpl->assign('page_list', $l);

include XOOPS_ROOT_PATH.'/footer.php';
