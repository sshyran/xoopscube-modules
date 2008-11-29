<?php

eval( '
	function b_waiting_'.$mydirname.'(){
		return b_waiting_miniamazon_base( "'.$mydirname.'" ) ;
	}
' ) ;

if( ! function_exists( 'b_waiting_miniamazon_base' ) ) {

	function b_waiting_miniamazon_base($mydirname) {
		$xoopsDB =& Database::getInstance();
		$block = array();

		$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix($mydirname."_items")." WHERE stats=0");
		if ( $result ) {
			$block['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/index.php?act=stats";
			list($block['pendingnum']) = $xoopsDB->fetchRow($result);
			$block['lang_linkname'] = _PI_WAITING_WAITINGS ;
		}

		return $block;
	}

}

?>