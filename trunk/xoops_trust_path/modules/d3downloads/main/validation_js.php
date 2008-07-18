<?php

$cache_limit = 3600 ;

// send header

$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;
$js_path = $mytrustdirpath.'/include/livevalidation.js' ;
if( ! headers_sent() ) {
	session_cache_limiter('public');
	header( 'Expires: '.date('r',intval( time()/$cache_limit )*$cache_limit+$cache_limit ) );
	header( 'Cache-Control: public, max-age=$cache_limit');
	header( 'Last-Modified: '.date( 'r',intval( time()/$cache_limit )*$cache_limit ) );
	header( 'Content-length: '.filesize( $js_path ) );
	header( 'Vary: Accept-Encoding' );
	header( 'Content-Type: application/x-javascript' ) ;
}

require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
) ) ;
$tpl->display( 'file:'.$js_path ) ;
exit ;

?>