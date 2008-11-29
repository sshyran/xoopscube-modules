<?php

function b_sitemap_d3imgtag($mydirname){
	$xoopsDB =& Database::getInstance();
    $ret = sitemap_get_categoires_map($xoopsDB->prefix($mydirname."_cat"), "cid", "pid", "title", "index.php?page=viewcat&cid=", "title");
	return $ret;
}

?>