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

cinemaru_movie_report_add($_POST['id'], $_POST['category'], $_POST['comment']);

redirect_header('index.php', 2, _MD_CINEMARU_REPORTED);
exit();

