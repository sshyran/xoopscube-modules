<?php

$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;


// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'main.php' , $mydirname , $mytrustdirname ) ;



if( !empty($_GET['lid']) && (empty($_GET['act']) || @$_GET['act']=='item') ) $_GET['act'] = 'item';
if( empty( $_GET['lid'] ) && isset( $_GET['cid'] ) && @$_GET['act'] != 'submit' ) $_GET['act'] = 'viewcat';	//cid ONLY

$act = empty( $_GET['act'] ) ? "index" : $_GET['act'];
$act = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $act ) ;

$actions = Array( "index","viewcat","item","submit","edit","confirm","css" );	//white list

if( in_array( $act , $actions ) ) {
	if( file_exists( "$mytrustdirpath/main/$act.php" ) ) {
		include "$mytrustdirpath/main/$act.php" ;
	} else {
		die( 'wrong request' ) ;
	}
} else {
	die( 'wrong request' ) ;
}


?>