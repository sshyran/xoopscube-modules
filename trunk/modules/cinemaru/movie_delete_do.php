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

$xoopsTpl->assign('cinemaru_module_config', $xoopsModuleConfig);
$xoopsTpl->assign('max_file_size', intval($xoopsModuleConfig['cinemaru_movie_max_size'] / 1024 / 1024));

$xoopsOption['template_main'] = $mydirname . '_movie_form.html';

$movie = cinemaru_movie_get_one($_REQUEST['id']);

if ($movie == false) {
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

$groupperm_touchothers = cinemaru_checkright(constant($constpref.'_GROUPPERM_TOUCHOTHERS'));

if ($groupperm_touchothers == 0 && $movie['id'] != $uid) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_DEL_AUTH);
    exit();
}

$randam_code = $movie['randam_code'];
$id = $movie['id'];
    
$d = XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/';
$f = $id . '_' . $randam_code;
$movie = $d . 'movie/' . $movie['file'];
$image = $d . 'image/' . $movie['image_file'];

@unlink($movie);
if ($movie['image_file']) {
    @unlink($image);
}
    
cinemaru_movie_delete(@$_REQUEST['id']);

redirect_header('index.php', 2, _MD_CINEMARU_DELETED);
exit();

