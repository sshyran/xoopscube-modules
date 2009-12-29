<?php
$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;

// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'main.php' , $mydirname , $mytrustdirname ) ;


if( !isset($_GET['page']) ){
  if( isset($_GET['lid']) && !empty($_GET['lid']) ) $_GET['page'] = 'single';
  if( isset($_GET['cid'])  && !empty($_GET['cid']) && !isset($_GET['lid']) ) $_GET['page'] = 'viewcat';
  //if( isset($_GET['hits']) && !empty($_GET['hits']) ) $_GET['page'] = 'topten';
  //if( isset($_GET['rate']) && !empty($_GET['rate']) ) $_GET['page'] = 'topten';
}

if( isset($_GET['page']) && $_GET['page']=='past' ){
  $_GET['page'] = 'future' ;
  $_GET['past'] = 1 ;
}

$page = isset( $_GET['page'] ) ?  strtolower($_GET['page']) : "index" ;
$page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $page ) ;
//$actions = array( "index","submit","edit","single","viewcat","mobile","print","topten","rss","future" );

//if( in_array( $page , $actions ) ) {
	if( file_exists( "$mytrustdirpath/main/$page.php" ) ) {
		require_once "$mytrustdirpath/main/header.php";
		include "$mytrustdirpath/main/$page.php" ;
	} else {
		die( 'wrong request' ) ;
	}
//} else {
//	die( 'wrong request' ) ;
//}

?>