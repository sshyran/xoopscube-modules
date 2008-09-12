<?php

if (defined('__CINEMARU_BLOCK_RANDOM_PHP__')) {
    return;
}
define('__CINEMARU_BLOCK_RANDOM_PHP__', 1);

function b_cinemaru_block_random( $options )
{
    
    global $xoopsTpl;
    global $xoopsConfig;
    
    if (empty($options[0])) {
	$mydirname_cinemaru = 'cinemaru';
    } else {
	$mydirname_cinemaru = $options[0];
    }
    $GLOBALS['mydirname'] = $mydirname_cinemaru;

    require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname_cinemaru . '/include/db.php');
    require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname_cinemaru . '/include/misc.php');
    require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname_cinemaru . '/constants.php');
    
    
    $constpref = strtoupper( $mydirname_cinemaru ) ;

    $xoopsTpl->assign('mydirname', $mydirname_cinemaru);
    
    require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname_cinemaru . '/language/' . $xoopsConfig['language']. '/main.php');
    
    $arr = cinemaru_movie_get_min_max();

    for ($i=0; $i < 20; $i++) {
	$id = rand($arr['min'], $arr['max']);

	$movie = cinemaru_movie_get_one($id);
	if ($movie && $movie['valid']) {

	    if (constant($constpref.'_THUMB_TITLE_LENGTH') < strlen($movie['title'])) {
		$movie['title_trunc'] = cinemaru_mb_truncate($movie['title'], constant($constpref.'_THUMB_TITLE_LENGTH')) . '...';
	    } else {
		$movie['title_trunc'] = $movie['title'];
	    }
	    if (constant($constpref.'_THUMB_DESC_LENGTH') < strlen($movie['desc'])) {
		$movie['desc_trunc'] = cinemaru_mb_truncate($movie['desc'], constant($constpref.'_THUMB_DESC_LENGTH')) . '...';
	    } else {
		$movie['desc_trunc'] = $movie['desc'];
	    }
	    
	    $xoopsTpl->assign('cinemaru_block_randam', $movie);
	    return $movie;
	}
    }
   
    return array();
}


