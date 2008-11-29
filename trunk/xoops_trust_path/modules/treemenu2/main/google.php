<?php
require_once XOOPS_ROOT_PATH.'/class/template.php' ;

$sitemap = sitemapMakeMenu( $mydirname , true , true );

//-----------------------------------------------------
if (function_exists('mb_http_output')) mb_http_output('pass') ;
header ('Content-Type:text/xml; charset=utf-8');

$xoopsTpl = new XoopsTpl();
//$xoopsTpl->assign('lastmod', gmdate( 'Y-m-d\TH:i:s\Z' ) ); // TODO
$tzd = substr(date('O'),0,3).':'.substr(date('O'),3,2);
$xoopsTpl->assign('lastmod', date('Y-m-d\TH:i:s').$tzd );
$xoopsTpl->assign('sitemap', $sitemap[0] );
$xoopsTpl->display("db:{$mydirname}_xml_tm_google.html");


?>