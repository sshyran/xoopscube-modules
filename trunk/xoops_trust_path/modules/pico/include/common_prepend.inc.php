<?php

require_once dirname(__FILE__).'/main_functions.php' ;
require_once dirname(__FILE__).'/common_functions.php' ;
require_once dirname(dirname(__FILE__)).'/class/pico.textsanitizer.php' ;
$myts =& PicoTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;

// for compatibility "wraps mode" and "GET" in some environment
if( substr( $_SERVER['REQUEST_URI'] , -19 ) == '?page=singlecontent' ) {
	$_GET['page'] = 'singlecontent' ;
} else if( substr( $_SERVER['REQUEST_URI'] , -11 ) == '?page=print' ) {
	$_GET['page'] = 'print' ;
} else if( substr( $_SERVER['REQUEST_URI'] , -9 ) == '?page=rss' ) {
	$_GET['page'] = 'rss' ;
}

// GET $uid
$uid = is_object( @$xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;
$isadmin = $uid > 0 ? $xoopsUser->isAdmin() : false ;

// get this user's permissions as perm array
$category_permissions = pico_main_get_category_permissions_of_current_user( $mydirname ) ;
$whr_read4cat = 'c.`cat_id` IN (' . implode( "," , array_keys( $category_permissions ) ) . ')' ;
$whr_read4content = 'o.`cat_id` IN (' . implode( "," , array_keys( $category_permissions ) ) . ')' ;

// add XOOPS_TRUST_PATH/PEAR/ into include_path
if( ! defined( 'PATH_SEPARATOR' ) ) define( 'PATH_SEPARATOR' , DIRECTORY_SEPARATOR == '/' ? ':' : ';' ) ;
ini_set( 'include_path' , ini_get('include_path') . PATH_SEPARATOR . XOOPS_TRUST_PATH . '/PEAR' ) ;

// init xoops_breadcrumbs
$xoops_breadcrumbs[0] = array( 'url' => XOOPS_URL.'/modules/'.$mydirname.'/index.php' , 'name' => $xoopsModule->getVar( 'name' ) ) ;

?>