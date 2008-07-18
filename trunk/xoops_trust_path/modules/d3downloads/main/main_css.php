<?php

$cache_limit = 3600 ;

$theme = $xoopsConfig['theme_set'] ;

// UA
if( stristr( $_SERVER['HTTP_USER_AGENT'] , 'Opera' ) ) {
	$ua_type = 'Opera' ;
} else if( stristr( $_SERVER['HTTP_USER_AGENT'] , 'MSIE' ) ) {
	$ua_type = 'IE' ;
} else {
	$ua_type = 'NN' ;
}

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
	'xoops_config' => $xoopsConfig ,
	'xoops_theme' => $theme ,
	'xoops_imageurl' => XOOPS_THEME_URL.'/'.$theme.'/' ,
	'xoops_themecss' => xoops_getcss($theme) ,
	'ua_type' => $ua_type ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_main.css' ) ;
exit ;

?>