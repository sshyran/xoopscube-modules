<?php

include 'header.php';

require_once('include/db.php');

header('Content-type: text/html; charset=' . $xoopsModuleConfig['tag_encoding']);

$mydirname = basename( dirname( __FILE__ ) ) ;
$movie = cinemaru_movie_get_one(@$_REQUEST['id']);

if ($movie == false) {
    exit();
}

$list = cinemaru_tag_get($_REQUEST['id']);

foreach ($list as $val) {
    print'<A HREF="index.php?tag=' . intval($val['tags_id']) . '">';
    print htmlspecialchars($val['name']) . '</A> ';
}

exit();

