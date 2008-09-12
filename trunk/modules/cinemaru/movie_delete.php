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

$movie = cinemaru_movie_get_one($_REQUEST['id']);

if (isset($movie['id']) == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NOT_FOUND);
    exit();
}

if ($movie['valid'] == 0 && cinemaru_is_auth_perm() == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NO_VALID);
    exit();
}

if (isset($xoopsUser)) {
    $uid = $xoopsUser->uid();
} else {
    $uid = 0;
}

$groupperm_touchothers = cinemaru_checkright(constant($constpref. '_GROUPPERM_TOUCHOTHERS'));

if ($groupperm_touchothers == 0 && $movie['id'] != $uid) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_DEL_AUTH);
    exit();
}

$xoopsTpl->assign('movie', $movie);

$xoopsOption['template_main'] = $mydirname . '_movie_delete.html';

include XOOPS_ROOT_PATH.'/footer.php';


