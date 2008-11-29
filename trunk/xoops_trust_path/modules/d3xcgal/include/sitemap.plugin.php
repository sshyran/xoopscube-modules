<?php

function b_sitemap_d3xcgal($mydirname){
	$xoopsDB =& Database::getInstance();
    $ret = sitemap_get_categoires_map($xoopsDB->prefix($mydirname."_categories"), "cid", "parent", "name", "index.php?cat=", "pos");
	return $ret;
}

?>