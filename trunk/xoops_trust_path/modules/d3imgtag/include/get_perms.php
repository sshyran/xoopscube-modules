<?php
if(! defined('XOOPS_ROOT_PATH')) exit();

$global_perms = 0 ;
if(is_object($xoopsDB)) {
	if(! is_object($xoopsUser)) {
		$whr_groupid = "gperm_groupid=".XOOPS_GROUP_ANONYMOUS ;
	} else {
		$groups =& $xoopsUser->getGroups();
		$whr_groupid = "gperm_groupid IN (";
		foreach($groups as $groupid) {
			$whr_groupid .= "$groupid,";
		}
		$whr_groupid = substr($whr_groupid , 0 , -1) . ")";
	}
	$rs = $xoopsDB->query("SELECT gperm_itemid FROM ".$xoopsDB->prefix("group_permission")." LEFT JOIN ".$xoopsDB->prefix("modules")." m ON gperm_modid=m.mid WHERE m.dirname='$mydirname' AND gperm_name='d3imgtag_global' AND ($whr_groupid)") ;
	while(list($itemid) = $xoopsDB->fetchRow($rs)) {
		$global_perms |= $itemid ;
	}
}
?>