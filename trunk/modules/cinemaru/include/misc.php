<?php

if (defined('__CINEMARU_MISC_PHP__')) {
    return;
}
define('__CINEMARU_MISC_PHP__', 1);

require_once('groupperm_function.php');

$mydirname = basename( dirname( dirname( __FILE__ ) ) );
require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/constants.php');

function cinemaru_mkdir_p()
{
    global $mydirname;
    
    if (file_exists(XOOPS_ROOT_PATH . '/uploads/'. $mydirname) == false) {
	mkdir(XOOPS_ROOT_PATH . '/uploads/' . $mydirname);
    }
    
    if (file_exists(XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/image') == false) {
	mkdir(XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/image');
    }
    
    if (file_exists(XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/movie') == false) {
	mkdir(XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/movie');
    }
}

function cinemaru_get_randam_code()
{
    $str = '0123456789';
    $str .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str .= 'abcdefghijklmnopqrstuvwxyz';

    $ret = '';
    for ($i=0; $i<8; $i++) {
	$ret .= substr($str, mt_rand(0, strlen($str)), 1);
    }
    
    return $ret;
}

function cinemaru_is_auth_perm()
{
    global $mydirname;
    $constpref = strtoupper( $mydirname ) ;
    
    $groupperm_valid = cinemaru_checkright(constant($constpref.'_GROUPPERM_VALID'));
    
    if ($groupperm_valid) {
	return true;
    }
    
    if (cinemaru_is_module_admin()) {
	return true;
    } else {
	return false;
    }
}

function cinemaru_is_auth_delele_comment()
{
    global $mydirname;
    $constpref = strtoupper( $mydirname ) ;
    
    $groupperm_valid = cinemaru_checkright(constant($constpref.'_GROUPPERM_DELCOMMENT'));
    
    if ($groupperm_valid) {
	return true;
    }
    
    if (cinemaru_is_module_admin()) {
	return true;
    } else {
	return false;
    }
}

function cinemaru_is_module_admin()
{
    global $xoopsUser;
    global $module_handler;
    
    if (! is_object($xoopsUser)) {
	return false;
    }
    
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    
    $module =& $module_handler->getByDirname( $mydirname ) ;
    
    if( ! is_object( $module ) ) {
	die( "invalid module dirname:" . htmlspecialchars( $src_dirname ) );
    }
    $mid = $module->getvar( 'mid' ) ;
    
    return $xoopsUser->isAdmin($mid);
}

function cinemaru_mb_truncate($str, $len=16)
{
    if (function_exists('mb_substr')) {
	return mb_substr($str, 0, $len);
    } else {
	return substr($str, 0, $len);
    }
}

function cinemaru_movie_truncate($movie_list)
{
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    $constpref = strtoupper( $mydirname ) ;
    
    foreach ($movie_list as $key => $val) {
	if (20 < strlen($val['title'])) {
	    $movie_list[$key]['title_trunc'] = cinemaru_mb_truncate($val['title'], constant($constpref.'_THUMB_TITLE_LENGTH')) . '...';
	} else {
	    $movie_list[$key]['title_trunc'] = $val['title'];
	}
	if (30 < strlen($val['desc'])) {
	    $movie_list[$key]['desc_trunc'] = cinemaru_mb_truncate($val['desc'], constant($constpref.'_THUMB_DESC_LENGTH')) . '...';
	} else {
	    $movie_list[$key]['desc_trunc'] = $val['desc'];
	}
    }
    
    return $movie_list;
}

function cinemaru_mb_convert_encoding($str, $charcode)
{
    if (function_exists('mb_convert_encoding')) {
	return mb_convert_encoding($str, $charcode, 'auto');
    } else {
	return $str;
    }
}
