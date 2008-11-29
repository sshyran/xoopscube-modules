<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

class maGroupPermission
{
	function group_perm( $perm_itemid ){

		global $xoopsUser,$xoopsModule;	
		
		if ( $xoopsUser ) {
			$groups = $xoopsUser->getGroups();
		} else {
			$groups = XOOPS_GROUP_ANONYMOUS;	//3
		}

		$module_id = $xoopsModule->getVar('mid');
		$gperm_handler =& xoops_gethandler('groupperm');
		if ($gperm_handler->checkRight( 'miniamazon_perm' , $perm_itemid , $groups , $module_id )) {
			return true;
		}
		return false;
	}
}
?>