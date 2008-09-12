<?php

include 'header.php';
require_once('include/db.php');
require_once('include/groupperm_function.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$mydirname = basename( dirname( __FILE__ ) ) ;
$xoopsTpl->assign('mydirname', $mydirname);
$constpref = strtoupper( $mydirname ) ;

$xoopsOption['template_main'] = $mydirname . '_index.html';

$groupperm_insertcomment = cinemaru_checkright(constant($constpref.'_GROUPPERM_INSERTCOMMENT'));

if ($groupperm_insertcomment) {
    cinemaru_movie_comment_up($_REQUEST['id']);

    if (isset($xoopsUser)) {
	$uid = $xoopsUser->uid();
    } else {
	$uid = 0;
    }
    cinemaru_comment_add($_REQUEST['id'], cinemaru_mb_convert_encoding($_REQUEST['comment'], $xoopsModuleConfig['tag_encoding']), intval($_REQUEST['time'] * 1000), $uid);
}

exit();
