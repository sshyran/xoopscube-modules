<?php

function b_waiting_d3downloads( $mydirname )
{
	$db =& Database::getInstance();
	$ret = array() ;

	// mydownloads links
	$block = array();
	$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE lid='0'");
	if ( $result ) {
		$block['adminlink'] = XOOPS_URL."/modules/".$mydirname."/admin/index.php?page=approvalmanager";
		list( $block['pendingnum'] ) = $db->fetchRow( $result);
		$block['lang_linkname'] = _PI_WAITING_WAITINGS ;
	}
	$ret[] = $block ;

	// mydownloads broken
	$block = array();
	$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_broken" ));
	if ( $result ) {
		$block['adminlink'] = XOOPS_URL."/modules/".$mydirname."/admin/index.php?page=filemanager";
		list( $block['pendingnum'] ) = $db->fetchRow( $result );
		$block['lang_linkname'] = _PI_WAITING_BROKENS ;
	}
	$ret[] = $block ;

	// mydownloads modreq
	$block = array();
	$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE lid > '0'");
	if ( $result ) {
		$block['adminlink'] = XOOPS_URL."/modules/".$mydirname."/admin/index.php?page=approvalmanager";
		list( $block['pendingnum'] ) = $db->fetchRow( $result );
		$block['lang_linkname'] = _PI_WAITING_MODREQS ;
	}
	$ret[] = $block ;

	return $ret;
}

?>