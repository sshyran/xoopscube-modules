<?php

include 'header.php';

require_once('include/db.php');
require_once('include/groupperm_function.php');
require_once('constants.php');
require_once('include/misc.php');
require_once('include/url.php');

if (preg_match('/v=(.+)&?/', $_GET['url'], $r) || preg_match('/([A-Z]+)/i', $_GET['url'], $r)) {
    print cinemaru_get_youtube_flv_url('http://www.youtube.com/watch?v=' . addslashes($r[1]));
}
exit();

