<?php

include 'header.php';

require_once('include/db.php');
require_once('constants.php');
require_once('include/groupperm_function.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$mydirname = basename( dirname( __FILE__ ) ) ;
$xoopsTpl->assign('mydirname', $mydirname);
$constpref = strtoupper( $mydirname ) ;

$movie = cinemaru_movie_get_one(@$_REQUEST['id']);

if ($movie == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NOT_FOUND);
    exit();
}

$groupperm_report = cinemaru_checkright(constant($constpref.'_GROUPPERM_REPORT'));

if ($groupperm_report == 0) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_REPORT_AUTH);
    exit();
}

if (@$xoopsModuleConfig['show_name_movie']) {
    $member_handler =& xoops_gethandler('member');
    
    if ($movie['owner'] == 0) {
	$user_name =  $xoopsModuleConfig['guest_user_name'];
    } else {
	$user = $member_handler->getUser($movie['owner']);

	if ($xoopsModuleConfig['name_setting'] == 0) {
	    $user_name =  $user->getVar('uname');
	} else if ($xoopsModuleConfig['name_setting'] == 1) {
	    $user_name =  $user->getVar('name');
	} else if ($xoopsModuleConfig['name_setting'] == 2) {
	    $user_name = $user->getVar('uname') . '(' . $user->getVar('name') . ')';
	} else if ($xoopsModuleConfig['name_setting'] == 3) {
	    if ($user->getVar('name') != '') {
		$user_name = $user->getVar('name');
	    } else {
		$user_name = $user->getVar('uname');
	    }
	}
    }
    
    $xoopsTpl->assign('user_name', $user_name);
}

$valid = cinemaru_is_auth_perm();
$groupperm_showcomment = cinemaru_checkright(constant($constpref.'_GROUPPERM_SHOWCOMMENT'));
$groupperm_comment = cinemaru_checkright(constant($constpref.'_GROUPPERM_INSERTCOMMENT'));
$groupperm_editable = cinemaru_checkright(constant($constpref.'_GROUPPERM_EDITABLE'));
$groupperm_touchothers = cinemaru_checkright(constant($constpref.'_GROUPPERM_TOUCHOTHERS'));
$groupperm_tag_insertable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGINSERTABLE'));
$groupperm_tag_deletable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGDELETABLE'));
$groupperm_tag_editable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGEDITABLE'));

$xoopsTpl->assign('show_report_link', $xoopsModuleConfig['show_report_link']);
$xoopsTpl->assign('', $xoopsModuleConfig['show_name_movie']);
$xoopsTpl->assign('auth_valid', $valid);
$xoopsTpl->assign('showcomment', $groupperm_showcomment);
$xoopsTpl->assign('commentok', $groupperm_comment);
$xoopsTpl->assign('editable', $groupperm_editable);
$xoopsTpl->assign('touchothers', $groupperm_touchothers);
$xoopsTpl->assign('tag_insertable', $groupperm_tag_insertable);
$xoopsTpl->assign('tag_deletable', $groupperm_tag_deletable);
$xoopsTpl->assign('tag_editable', $groupperm_tag_editable);

$list = cinemaru_tag_get($_REQUEST['id']);

$tag = '';
foreach ($list as $val) {
    $tag .= '<A HREF="index.php?tag=' . intval($val['tags_id']) . '">';
    $tag .= htmlspecialchars($val['name']) . '</A> ';
}
$xoopsTpl->assign('tag', $tag);

cinemaru_movie_counter_up($_REQUEST['id']);

$movie['counter']++;

if (isset($xoopsUser)) {
    $xoopsTpl->assign('user_avatar', $xoopsUser->getVar('user_avatar'));
}
$xoopsTpl->assign('movie', $movie);

$xoopsOption['template_main'] = $mydirname . '_report_form.html';

include XOOPS_ROOT_PATH.'/footer.php';


