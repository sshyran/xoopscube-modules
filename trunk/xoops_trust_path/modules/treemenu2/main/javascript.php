<?php

if( ! headers_sent() ) {
    $cache_limit = 3600 ;

    session_cache_limiter('public');
    header("Expires: ".date('r', intval(time()/$cache_limit)*$cache_limit+$cache_limit));
    header("Cache-Control: public, max-age=$cache_limit");
    header("Last-Modified: ".date('r',intval(time()/$cache_limit)*$cache_limit));
    header('Content-type:application/x-javascript');
}

require_once XOOPS_ROOT_PATH.'/class/template.php' ;

$tpl =& new XoopsTpl();
$tpl->assign( 'mydirname' , $mydirname );
$tpl->display("db:{$mydirname}_block_sitemap.js");
exit;

?>