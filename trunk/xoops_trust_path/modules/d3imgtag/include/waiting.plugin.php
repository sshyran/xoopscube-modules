<?php

function b_waiting_d3imgtag( $mydirname )
{
	$xoopsDB =& Database::getInstance();
	$block = array();

	$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix($mydirname."_photos")." WHERE status=0");
	if ( $result ) {
		list( $waiting_count ) = $xoopsDB->fetchRow($result);
		$ret = array(
			'adminlink' => XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=admission',
			'pendingnum' => intval( $waiting_count ) ,
			'lang_linkname' => _PI_WAITING_WAITINGS ,
		);
	}

	return $ret;
}

?>