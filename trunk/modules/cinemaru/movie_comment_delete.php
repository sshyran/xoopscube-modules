<?php

include 'header.php';
require_once('include/db.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$delcomment_admin = cinemaru_is_auth_delele_comment();
if ($delcomment_admin == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_DELETE_COMMENT_ADMIN);
    exit();
}

$xoopsOption['template_main'] = 'cinemaru_index.html';

cinemaru_comment_delete($_REQUEST['comment_id']);

if (isset($_GET['id'])) {
    redirect_header('movie_comment_list.php?id=' . intval($_GET['id']), 2, _MD_CINEMARU_DELETED_COMMENT);
} else {
    redirect_header('movie_comment_list.php', 2, _MD_CINEMARU_DELETED_COMMENT);
}
exit();

