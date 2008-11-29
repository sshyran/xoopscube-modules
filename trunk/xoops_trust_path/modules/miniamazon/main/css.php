<?php
//再考
$cache_limit = empty( $xoopsModuleConfig['css_cache_time'] ) ? 3600 : intval( $xoopsModuleConfig['css_cache_time'] ) ;

//再考
if( empty( $xoopsModuleConfig['base_theme'] ) ) {
	$theme = $xoopsConfig['theme_set'] ;
} else {
	$theme = $xoopsModuleConfig['base_theme'] ;
}

//$template = preg_replace( '/[^0-9a-zA-Z_.-]/' , '' , @$_GET['template'] ) ;
//if( empty( $template ) ) $template = 'style.css' ;

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
	header("Expires: ".date('r',intval(time()/$cache_limit)*$cache_limit+$cache_limit));
	header("Cache-Control: public, max-age=$cache_limit");
	header("Last-Modified: ".date('r',intval(time()/$cache_limit)*$cache_limit));
	header('Content-Type: text/css') ;
}

if( is_object( $xoopsUser ) ) {
	$xoops_isuser = true ;
	$xoops_userid = $xoopsUser->getVar('uid') ;
	$xoops_uname = $xoopsUser->getVar('uname') ;
	$xoops_isadmin = $xoopsUserIsAdmin ;
} else {
	$xoops_isuser = false ;
	$xoops_userid = 0 ;
	$xoops_uname = '' ;
	$xoops_isadmin = false ;
}

require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'xoops_config' => $xoopsConfig ,
	'xoops_theme' => $theme ,
	'xoops_imageurl' => XOOPS_THEME_URL.'/'.$theme.'/' ,
	'xoops_themecss' => XOOPS_URL.'/modules/'.$mydirname.'/?act=css' , // TODO (?)
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'xoops_isadmin' => $xoops_isadmin ,
	'ua_type' => $ua_type ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_style.css' ) ;
exit ;

?>