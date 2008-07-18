<?php

$cache_limit = 3600 ;

// send header

if( ! headers_sent() ) {
	session_cache_limiter('public');
	header( 'Expires: '.date( 'r',intval( time()/$cache_limit )*$cache_limit+$cache_limit ) );
	header( 'Cache-Control: public, max-age=$cache_limit' );
	header( 'Last-Modified: '.date( 'r',intval( time()/$cache_limit )*$cache_limit ) );
	header( 'Content-Type: text/css' ) ;
}

require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_livevalidation.css' ) ;
exit ;

?>