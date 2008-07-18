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

// GET CATEGORYLIST
$category = array();
$result = $db->query("SELECT cid, title, cat_weight FROM ".$db->prefix( $mydirname."_cat" )." ORDER BY cat_weight");
while( list( $id, $name, $weight ) = $db->fetchRow( $result ) ) {
	$category[] = array(
		'cid' => intval( $id ) ,
		'title' => $myts->makeTboxData4Edit( $name ) ,
		'cat_weight' =>  intval( $weight ) ,
	) ;
}

// TITLE & WEIGHT UPDATE
if( ! empty( $_POST['category_update'] ) && ! empty( $_POST['weights'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	// DELETE NULLBYTE
	$_POST = $myts->Delete_Nullbyte( $_POST );

	$errors = array() ;
	foreach( $_POST['weights'] as $id => $weights ) {
		$cid = intval( $id ) ;
		$cat_weight = intval( $weights ) ;
		$title = "'".mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['title'][$id] ) )."'" ;
		$result = $db->query( "UPDATE ".$db->prefix( $mydirname."_cat" )." SET title=$title,cat_weight=$cat_weight WHERE cid=$cid" ) ;
		if( ! $result ) $errors[] = $cid ;
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_D3DOWNLOADS , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_REGSTERED ) ;
	exit();
}

// DELETE

if( ! empty( $_POST['delete'] ) && ! empty( $_POST['action_selects'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$errors = "";
	foreach( $_POST['action_selects'] as $id => $value ) {
		$cid = intval( $id ) ;
		d3download_delcat( $mydirname , $cid , $errors );
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_D3DOWNLOADS , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// display stage

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'categorymanager' ,
	'category' => $category ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_category_list.html' ) ;
xoops_cp_footer();

?>