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

if ($movie['valid'] == 0 && cinemaru_is_auth_perm() == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NO_VALID);
    exit();
}

if (@$movie['file_url']) {
    $movie['file_url'] = urlencode($movie['file_url']);
}

if (@$movie['image_file_url']) {
    $movie['image_file_url'] = urlencode($movie['image_file_url']);
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

$myts =& MyTextSanitizer::getInstance();
$movie['desc'] = $myts->previewTarea($movie['desc'], 0, 1, 1, 1, 1);

$valid = cinemaru_is_auth_perm();
$groupperm_showcomment = cinemaru_checkright(constant($constpref.'_GROUPPERM_SHOWCOMMENT'));
$groupperm_comment = cinemaru_checkright(constant($constpref.'_GROUPPERM_INSERTCOMMENT'));
$groupperm_editable = cinemaru_checkright(constant($constpref.'_GROUPPERM_EDITABLE'));
$groupperm_touchothers = cinemaru_checkright(constant($constpref.'_GROUPPERM_TOUCHOTHERS'));
$groupperm_tag_insertable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGINSERTABLE'));
$groupperm_tag_deletable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGDELETABLE'));
$groupperm_tag_editable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGEDITABLE'));
$groupperm_report = cinemaru_checkright(constant($constpref.'_GROUPPERM_REPORT'));

$xoopsTpl->assign('show_report_link', $xoopsModuleConfig['show_report_link']);
$xoopsTpl->assign('xoops_module_config', $xoopsModuleConfig);
$xoopsTpl->assign('', $xoopsModuleConfig['show_name_movie']);
$xoopsTpl->assign('auth_valid', $valid);
$xoopsTpl->assign('showcomment', $groupperm_showcomment);
$xoopsTpl->assign('commentok', $groupperm_comment);
$xoopsTpl->assign('editable', $groupperm_editable);
$xoopsTpl->assign('touchothers', $groupperm_touchothers);
$xoopsTpl->assign('tag_insertable', $groupperm_tag_insertable);
$xoopsTpl->assign('tag_deletable', $groupperm_tag_deletable);
$xoopsTpl->assign('tag_editable', $groupperm_tag_editable);
$xoopsTpl->assign('report', $groupperm_report);
$xoopsTpl->assign('t', time());

if (preg_match('/^star1.swf$/', $xoopsModuleConfig['sp_command1_url'])) {
    $xoopsTpl->assign('spcmd1url', XOOPS_URL . '/modules/' . $mydirname . '/flash/star1.swf');
} else {
    $xoopsTpl->assign('spcmd1url', $xoopsModuleConfig['sp_command1_url']);
}
if (preg_match('/^star2.swf$/', $xoopsModuleConfig['sp_command2_url'])) {
    $xoopsTpl->assign('spcmd2url', XOOPS_URL . '/modules/' . $mydirname . '/flash/star2.swf');
} else {
    $xoopsTpl->assign('spcmd2url', $xoopsModuleConfig['sp_command2_url']);
}
if (preg_match('/^star3.swf$/', $xoopsModuleConfig['sp_command3_url'])) {
    $xoopsTpl->assign('spcmd3url', XOOPS_URL . '/modules/' . $mydirname . '/flash/star3.swf');
} else {
    $xoopsTpl->assign('spcmd3url', $xoopsModuleConfig['sp_command3_url']);
}

$list = cinemaru_tag_get($_REQUEST['id']);

$tag = '';
foreach ($list as $val) {
    $tag .= '<A HREF="index.php?tag=' . intval($val['tags_id']) . '">';
    $tag .= htmlspecialchars($val['name']) . '</A> ';
}
$xoopsTpl->assign('tag', $tag);

cinemaru_movie_counter_up($_REQUEST['id']);

$movie['counter']++;

if (isset($xoopsUser) && isset($_SESSION['xoopsUserId'])) {
    $xoopsTpl->assign('user_avatar', $xoopsUser->getVar('user_avatar'));
}
$xoopsTpl->assign('movie', $movie);

$xoopsOption['template_main'] = $mydirname . '_movie.html';

if ($xoopsModuleConfig['blog_paste']) {
    $xoopsTpl->assign('player_float', 0);
    $blog_paste = $xoopsTpl->fetch('db:' . $mydirname . '_movie_flash_player.html');
    $blog_paste .= '<BR><A HREF="' . XOOPS_URL . '">Powered by ' . $xoopsConfig['sitename'] . '</A>';
    $blog_paste = preg_replace('/[\n\r]/', '', $blog_paste);
    $xoopsTpl->assign('blog_paste', $blog_paste);
}
$xoopsTpl->assign('player_float', 1);
$xoopsTpl->assign('autoplay', 1);

include XOOPS_ROOT_PATH.'/footer.php';


