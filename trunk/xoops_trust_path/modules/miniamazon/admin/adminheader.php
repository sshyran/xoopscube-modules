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
		$langman->read( 'main.php' , $mydirname , $mytrustdirname ) ;
	}
}


?>