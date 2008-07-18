<?php

require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
require_once dirname( dirname(__FILE__) ).'/include/download_functions.php' ;

$myts =& d3downloadsTextSanitizer::getInstance() ;

// DELETE NULLBYTE
$_GET = $myts->Delete_Nullbyte( $_GET );

$getturl = isset( $_GET['url'] ) ? $_GET['url'] : "";
$searches = array() ;
$replacements = array() ;
$searches = array( 'XOOPS_TRUST_PATH' , 'XOOPS_ROOT_PATH' ) ;
$replacements = array( XOOPS_TRUST_PATH , XOOPS_ROOT_PATH ) ;
$url = str_replace( $searches , $replacements , $getturl ) ;

$url = $myts->makeTboxData4URLShow( $url );
$filename = isset( $_GET['filename'] ) ? $myts->makeTboxData4Show( $_GET['filename'] ): "";
$ext = isset( $_GET['ext'] ) ? $myts->makeTboxData4Show( $_GET['ext'] ) : "";

d3download_download( $url, $filename, $ext, 1 ) ;

?>