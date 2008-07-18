<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$myts =& d3downloadsTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;

// THIS PAGE CAN BE CALLED ONLY FROM D3DOWNLOADS
if( $xoopsModule->getVar('dirname') != $mydirname ) die( 'this page can be called only from '.$mydirname ) ;

// PERMISSION ERROR
$module_handler =& xoops_gethandler( 'module' ) ;
$module =& $module_handler->getByDirname( $mydirname ) ;
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
$mid = $module->getVar('mid') ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $mid , $xoopsUser->getGroups() ) ) {
	die( 'Only administrator can use this feature.' ) ;
}

// UNAPROVAL LIST
list( $unsum ) = $db->fetchRow( $db->query( "SELECT COUNT(lid) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE lid='0'" ) ) ;
$unaproval_sum = sprintf( _MD_D3DOWNLOADS_UNAPROVALNUM , intval( $unsum ) );
$unapproval = array();
$result = $db->query("SELECT m.requestid, m.cid, m.title, m.submitter, m.date, c.title FROM ".$db->prefix( $mydirname."_unapproval" )." m LEFT JOIN ".$db->prefix($mydirname."_cat")." c ON m.cid=c.cid WHERE m.lid='0' ORDER BY m.requestid");
while( list( $rid, $c_id, $name, $submit, $dat, $ctitle ) = $db->fetchRow( $result ) ) {
	$requestid = intval( $rid );
	$submitter = intval( $submit );
	$postname = d3download_postname( $submitter );
	if ( $submitter > 0 ) {
		$user_url = XOOPS_URL."/userinfo.php?uid=$submitter";
	} else {
		$user_url = "";
	}

	$unapproval[] = array(
		'requestid' => $requestid ,
		'cid' => intval( $c_id ) ,
		'title' => $myts->makeTboxData4Show( $name ) ,
		'date' => formatTimestamp( $myts->makeTboxData4Show( $dat ) ) ,
		'ctitle' => $myts->makeTboxData4Show( $ctitle ) ,
		'postname' =>  $postname ,
		'user_url' =>  $user_url ,

	) ;
}

// UNAPROVAL DELETE

if( ! empty( $_POST['unapproval_delete'] ) && ! empty( $_POST['action_selects'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$errors = array() ;
	foreach( $_POST['action_selects'] as $id => $value ) {
		if( empty( $value ) ) continue ;
		$requestid = intval( $id ) ;
		d3download_delete_unapproval_files( $mydirname , $requestid );
		$sql = "DELETE FROM ".$db->prefix($mydirname."_unapproval")." WHERE requestid = ".$requestid;
		$result = $db->query($sql);
		if( ! $result ) $errors[] = $requestid ;
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// UNAPROVAL MODFILE LIST
list( $unmsum ) = $db->fetchRow( $db->query( "SELECT COUNT(lid) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE lid > '0'" ) ) ;
$modfile_sum = sprintf( _MD_D3DOWNLOADS_UNAPROVALNUM , intval( $unmsum ) );
$modfile = array();
$result = $db->query("SELECT m.requestid, m.lid, m.cid, m.title, m.submitter, m.date, c.title FROM ".$db->prefix( $mydirname."_unapproval" )." m LEFT JOIN ".$db->prefix($mydirname."_cat")." c ON m.cid=c.cid WHERE m.lid > '0' ORDER BY m.requestid");
while( list( $rid, $id, $c_id, $name, $submit, $dat, $ctitle ) = $db->fetchRow( $result ) ) {
	$requestid = intval( $rid );
	$lid = intval( $id );
	$submitter = intval( $submit );
	$postname = d3download_postname( $submitter );
	if ( $submitter > 0 ) {
		$user_url = XOOPS_URL."/userinfo.php?uid=$submitter";
	} else {
		$user_url = "";
	}

	$modfile[] = array(
		'requestid' => $requestid ,
		'lid' => $lid ,
		'cid' => intval( $c_id ) ,
		'title' => $myts->makeTboxData4Show( $name ) ,
		'date' => formatTimestamp( $myts->makeTboxData4Show( $dat ) ) ,
		'ctitle' => $myts->makeTboxData4Show( $ctitle ) ,
		'postname' =>  $postname ,
		'user_url' =>  $user_url ,

	) ;
}

// UNAPROVAL MODFILE DELETE

if( ! empty( $_POST['modfile_delete'] ) && ! empty( $_POST['modfile_selects'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$errors = array() ;
	foreach( $_POST['modfile_selects'] as $id => $value ) {
		if( empty( $value ) ) continue ;
		$requestid = intval( $id ) ;
		d3download_delete_unapproval_files( $mydirname , $requestid );
		$sql = "DELETE FROM ".$db->prefix($mydirname."_unapproval")." WHERE requestid = ".$requestid;
		$result = $db->query($sql);
		if( ! $result ) $errors[] = $requestid ;
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'approvalmanager' ,
	'unapproval' => $unapproval ,
	'modfile' => $modfile ,
	'unaproval_sum' => $unaproval_sum ,
	'modfile_sum' => $modfile_sum ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_approvalmanager.html' ) ;
xoops_cp_footer();

?>