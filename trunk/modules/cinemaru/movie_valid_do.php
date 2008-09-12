<?php

include 'header.php';

require_once('include/db.php');
require_once('include/groupperm_function.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$xoopsTpl->assign('cinemaru_module_config', $xoopsModuleConfig);
$xoopsTpl->assign('max_file_size', intval($xoopsModuleConfig['cinemaru_movie_max_size'] / 1024 / 1024));

$xoopsOption['template_main'] = 'cinemaru_movie_form.html';

$movie = cinemaru_movie_get_one($_REQUEST['id']);

if ($movie == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NOT_FOUND);
    exit();
}

if (isset($xoopsUser)) {
    $uid = $xoopsUser->uid();
} else {
    $uid = 0;
}

$valid = cinemaru_is_auth_perm();

if ($valid == 0) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_VALID_AUTH);
    exit();
}

if (isset($_GET['novalid'])) {
    cinemaru_movie_valid_update(@$_REQUEST['id'], 0);
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NG_VALIDED);
} else {
    cinemaru_movie_valid_update(@$_REQUEST['id'], 1);
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_VALIDED);
}

exit();


