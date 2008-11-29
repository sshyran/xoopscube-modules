<?php
$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;


// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'main.php' , $mydirname , $mytrustdirname ) ;


$page = 'index' ;
if( isset($_GET['page']) ){
	$page = strtolower($_GET['page']) ;
}elseif( isset($_GET['did']) && !empty($_GET['did']) ){
	$page = 'single' ;
}elseif( isset($_GET['cat_id']) && $_GET['cat_id']>=0 ){
	$page = 'categ' ;
}

$page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $page ) ;

if( file_exists( "$mytrustdirpath/main/$page.php" ) ) {
	require_once "$mytrustdirpath/main/header.php";
	include "$mytrustdirpath/main/$page.php" ;
} else {
	die( 'wrong request' ) ;
}

?>