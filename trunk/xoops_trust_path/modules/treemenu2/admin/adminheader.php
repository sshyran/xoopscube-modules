<?php

//include XOOPS_ROOT_PATH .'/include/cp_header.php';


if( ! empty( $_GET['lib'] ) ) {
	// common libs (eg. altsys)
	$lib = preg_replace( '[^a-zA-Z0-9_-]' , '' , $_GET['lib'] ) ;
	$page = preg_replace( '[^a-zA-Z0-9_-]' , '' , @$_GET['page'] ) ;

	if( file_exists( XOOPS_TRUST_PATH .'/libs/'.$lib.'/'.$page.'.php' ) ) {
		include XOOPS_TRUST_PATH .'/libs/'.$lib.'/'.$page.'.php' ;
	} else if( file_exists( XOOPS_TRUST_PATH .'/libs/'.$lib.'/index.php' ) ) {
		include XOOPS_TRUST_PATH .'/libs/'.$lib.'/index.php' ;
	} else {
		die( 'wrong request' ) ;
	}
	exit ;
} else {
	if( isset( $langman ) ){
		$langman->read( 'admin.php' , $mydirname , $mytrustdirname ) ;
	}
}



//DB table
$table_menu = $xoopsDB->prefix( $mydirname."_menu" ) ;
$table_addurl = $xoopsDB->prefix( $mydirname."_addurl" ) ;
$table_access = $xoopsDB->prefix( $mydirname."_access" ) ;

$myts =& MyTextSanitizer::getInstance();

include_once $mytrustdirpath .'/include/gtickets.php';

?>