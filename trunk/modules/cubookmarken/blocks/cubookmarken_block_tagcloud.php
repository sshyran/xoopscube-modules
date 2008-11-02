<?php

require_once XOOPS_MODULE_PATH . "/cubookmarken/include/getTagCloud.php";
require_once XOOPS_MODULE_PATH . "/cubookmarken/class/Module.class.php";

function b_cubookmarken_block_tagcloud($options)
{
	$handler =& xoops_gethandler('module');
	$module =& $handler->getByDirname('cubookmarken');
	$moduleRunner = new Cubookmarken_Module($module);

	//TagCloud
	$where = "";
	$block = getTagCloud($where, $moduleRunner->getModuleConfig('tagcloud_min'), $moduleRunner->getModuleConfig('tagcloud_max'));

	return $block;
}

?>
