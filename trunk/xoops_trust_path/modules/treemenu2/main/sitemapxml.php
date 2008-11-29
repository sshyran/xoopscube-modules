<?php
require_once XOOPS_ROOT_PATH.'/class/template.php' ;

$sitemap = sitemapMakeMenu( $mydirname , true , true );

//-----------------------------------------------------
if (function_exists('mb_http_output')) mb_http_output('pass') ;
header ('Content-Type:text/xml; charset=utf-8');

$xoopsTpl = new XoopsTpl();
$xoopsTpl->assign('lastmod', date('Y-m-d') );
$xoopsTpl->assign('sitemap', $sitemap[0] );
$xoopsTpl->display("db:{$mydirname}_xml_tm_sitemap.html");


?>