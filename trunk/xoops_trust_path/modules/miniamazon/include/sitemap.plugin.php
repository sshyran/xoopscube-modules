<?php


eval( '

function b_sitemap_'.$mydirname.'(){
	$xoopsDB =& Database::getInstance();

    $block = sitemap_get_categoires_map($xoopsDB->prefix("'.$mydirname.'_cat"), "cid", "pid", "ctitle", "index.php?cid=", "corder");

	return $block;
}

' ) ;

//[9]act=viewcat&amp;
?>