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

$groupperm_touchothers = cinemaru_checkright(constant($constpref.'_GROUPPERM_TOUCHOTHERS'));

if ($groupperm_touchothers == 0 && $movie['owner'] != $uid) {
    redirect_header('index.php', 2, _MD_CINEAMRU_NO_EDIT_AUTH);
    exit();
}

// richtext check
if ($xoopsModuleConfig['richtext']) {
    require_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    $f = new XoopsFormDhtmlTextArea("", 'desc', @$movie['desc'], 15, 50);
    $xoopsTpl->assign('rich_form', $f->render());
}

$groupperm_superedit = cinemaru_checkright(constant($constpref.'_GROUPPERM_SUPEREDIT'));

$xoopsTpl->assign('superedit', $groupperm_superedit);
$xoopsTpl->assign('cinemaru_module_config', $xoopsModuleConfig);
$xoopsTpl->assign('max_file_size', intval($xoopsModuleConfig['cinemaru_movie_max_size'] / 1024 / 1024));

$xoopsTpl->assign('movie', $movie);
$xoopsTpl->assign('edit', 1);

$xoopsOption['template_main'] = 'cinemaru_movie_form.html';

include XOOPS_ROOT_PATH.'/footer.php';



