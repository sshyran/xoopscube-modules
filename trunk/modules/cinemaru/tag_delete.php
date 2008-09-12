<?php

require_once 'header.php';

require_once('include/db.php');
require_once('include/groupperm_function.php');
require_once('constants.php');
require_once('include/misc.php');

$mydirname = basename( dirname( __FILE__ ) ) ;
$movie = cinemaru_movie_get_one(@$_REQUEST['movie_id']);
$constpref = strtoupper( $mydirname ) ;

if ($movie == false) {
    exit();
}

if ($movie['tag_lock']) {
    exit();
}

header('Content-type: text/html; charset=' . $xoopsModuleConfig['tag_encoding']);

if (isset($xoopsUser) && isset($_SESSION['xoopsUserId'])) {
    $uid = $xoopsUser->uid();
} else {
    $uid = 0;
}
$groupperm_tag_deletable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGDELETABLE'));
if ($groupperm_tag_deletable || $movie['id'] == $uid) {
    cinemaru_delete_tag_to_movie($_REQUEST['id']);
}

$_REQUEST['id'] = $_REQUEST['movie_id'];
require_once('tag_edit.php');

