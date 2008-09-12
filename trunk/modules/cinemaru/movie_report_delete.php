<?php

include 'header.php';
require_once('include/db.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$mydirname = basename( dirname( __FILE__ ) ) ;
$xoopsTpl->assign('mydirname', $mydirname);
$constpref = strtoupper( $mydirname ) ;

$groupperm_report_list = cinemaru_checkright(constant($constpref.'_GROUPPERM_REPORT_LIST'));
if ($groupperm_report_list == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_REPORT_LIST_AUTH);
    exit();
}

cinemaru_report_delete($_REQUEST['report_id']);

redirect_header('movie_report_list.php', 2, _MD_CINEMARU_DELETED_REPORT);

exit();

