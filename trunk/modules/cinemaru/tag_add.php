<?php

include 'header.php';

require_once('include/db.php');
require_once('include/groupperm_function.php');
require_once('constants.php');
require_once('include/misc.php');

$mydirname = basename( dirname( __FILE__ ) ) ;
$movie = cinemaru_movie_get_one(@$_REQUEST['id']);

if ($movie == false) {
    exit();
}

if ($movie['tag_lock']) {
    exit();
}

$list = cinemaru_tag_get($_REQUEST['id']);

$tag = $_GET['tag'];
if ($xoopsModuleConfig['tag_encoding']) {
    header('Content-type: text/html; charset=' . $xoopsModuleConfig['tag_encoding']);
    $tag = cinemaru_mb_convert_encoding($_GET['tag'], $xoopsModuleConfig['tag_encoding']);
}

if (isset($xoopsUser) && isset($_SESSION['xoopsUserId'])) {
    $uid = $xoopsUser->uid();
} else {
    $uid = 0;
}
if (count($list) < $xoopsModuleConfig['num_of_tag']) {
    cinemaru_add_tag_to_movie($_GET['id'], $tag, $uid);
}

$list = cinemaru_tag_get($_REQUEST['id']);

foreach ($list as $val) {
    print '<A HREF="index.php?tag=' . intval($val['tags_id']) . '">';
    print htmlspecialchars($val['name']) . '</A> ';
}

exit();

