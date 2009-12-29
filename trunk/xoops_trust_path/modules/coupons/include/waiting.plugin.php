<?php
if(!function_exists('b_waiting_coupons'))
{

  function b_waiting_coupons( $mydirname ){
	$db =& Database::getInstance();
	$block = array();
	$adminlink = XOOPS_URL."/modules/$mydirname/admin/index.php";
	$approvalpage = "?page=approval";

	//NEW
	$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_coupons")." WHERE status=0" ;
	if ( $result = $db->query($sql) ) {
		list($pendingnum) = $db->fetchRow($result);
		$block[] = array(
			'adminlink'     => $adminlink . $approvalpage ,
			'pendingnum'    => $pendingnum ,
			'lang_linkname' => _WT_COUPONS_WAITING_NEW ,
		);
	}
	//EDIT
	$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_coupons")." WHERE status=-1" ;
	if ( $result = $db->query($sql) ) {
		list($pendingnum) = $db->fetchRow($result);
		$block[] = array(
			'adminlink'     => $adminlink . $approvalpage ,
			'pendingnum'    => $pendingnum ,
			'lang_linkname' => _WT_COUPONS_WAITING_MOD ,
		);
	}
	//DELETE
	$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_coupons")." WHERE status=-2" ;
	if ( $result = $db->query($sql) ) {
		list($pendingnum) = $db->fetchRow($result);
		$block[] = array(
			'adminlink'     => $adminlink . $approvalpage ,
			'pendingnum'    => $pendingnum ,
			'lang_linkname' => _WT_COUPONS_WAITING_DEL ,
		);
	}

	return $block;
  }

}
?>