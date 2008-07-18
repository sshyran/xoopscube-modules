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

// GET CATEGORY LIST
include_once dirname(dirname(__FILE__)).'/class/mytree.php' ;
$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
$category4assin = array() ;
$category4assin = array( 0 => 'ALL' ) ;
$crs = $db->query("SELECT cid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid='0' ORDER BY cat_weight ASC");
while( list( $id, $name ) = $db->fetchRow( $crs ) ) {
	$catid = intval( $id );
	$category4assin[ $catid ] = $myts->makeTboxData4Show( $name )."&nbsp;(".d3download_small_sum_from_cat( $mydirname , $catid , "" ).")" ;
	$arr = $mytree->getChildTreeArray( $catid );
	foreach ( $arr as $child ) {
		$child_id = intval( $child['cid'] );
		$child['prefix'] = str_replace(".","--",$child['prefix']);
		$category4assin[ $child_id ] = $child['prefix']."&nbsp;".$myts->makeTboxData4Show( $child['title'] )."&nbsp;(".d3download_small_sum_from_cat( $mydirname , $child_id , "" ).")" ;
	}
}

if( ! empty( $_POST['category_select'] ) ){
	$category_select = intval( $_POST['category_select'] );
} elseif ( ! empty( $_GET['cid'] ) ){
	$category_select = intval( $_GET['cid'] );
} else {
	$category_select = 0 ;
}

$items_perpage = isset( $_POST['perpage'] ) ? intval( $_POST['perpage'] ) :  intval( $xoopsModuleConfig['perpage'] ) ;
if ( isset( $_GET['perpage'] ) ){
	$select_perpage = intval( $_GET['perpage'] );
} else {
	$select_perpage = $items_perpage;
}

$current_start = isset($_GET['start']) ? intval( $_GET['start'] ) : 0 ;
$perpage4assign = d3download_items_perpage();

include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
$mydownload = new MyDownload( $mydirname ) ;

if( ! empty( $category_select ) ){
	$total_num = $mydownload->All_Num( $category_select ) ;
	$total_num4assign = sprintf( _MD_D3DOWNLOADS_CATEGORY_FIlE_NUM , $total_num );
} else {
	$total_num = $mydownload->All_Num() ;
	$total_num4assign = sprintf( _MD_D3DOWNLOADS_TOTAL_FIlE_NUM , $total_num );
}

require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;
$pagenav = new XoopsPageNav( $total_num, $select_perpage, $current_start , 'start' , "page=filemanager&amp;perpage=$select_perpage&amp;cid=$category_select" ) ;
$pagenav4assign = $pagenav->renderNav( 5 ) ;

// GET DOWNLOAD LIST
$download = array();
$sql = "SELECT d.lid, d.cid, d.title, d.submitter, d.date, d.visible, d.cancomment, d.hits, d.rating, d.votes, d.comments, c.title FROM ".$db->prefix( $mydirname."_downloads" )." d LEFT JOIN ".$db->prefix($mydirname."_cat")." c ON d.cid=c.cid";
if( ! empty( $category_select ) ){
	$sql .= " WHERE d.cid = $category_select";
}
$sql .= " ORDER BY d.date DESC";
$result = $db->query( $sql, $select_perpage, $current_start );
while( list( $id, $c_id, $name, $submit, $dat, $vis, $com, $hits, $rating, $votes, $comments, $ctitle ) = $db->fetchRow( $result ) ) {
	$broken_sum = '';
	$lid = intval( $id );
	$submitter = intval( $submit );
	$postname = d3download_postname( $submitter );
	if ( $submitter > 0 ) {
		$user_url = XOOPS_URL."/userinfo.php?uid=$submitter";
	} else {
		$user_url = "";
	}

	$res = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_broken" )." WHERE lid='".$lid."'" ) ;
	list( $broken_sum ) = $db->fetchRow( $res ) ;
	if( $broken_sum ) {
		$broken_sum = intval( $broken_sum );
	}

	$download[] = array(
		'lid' => $lid ,
		'cid' => intval( $c_id ) ,
		'title' => $myts->makeTboxData4Edit( $name ) ,
		'date' => formatTimestamp( $myts->makeTboxData4Edit( $dat ) ) ,
		'visible' =>  intval( $vis ) ,
		'cancomment' =>  intval( $com ) ,
		'ctitle' => $myts->makeTboxData4Edit( $ctitle ) ,
		'broken' => $broken_sum ,
		'hits' =>  intval( $hits ) ,
		'rating' =>  intval( $rating ) ,
		'votes' =>  intval( $votes ) ,
		'comments' =>  intval( $comments ) ,
		'postname' =>  $postname ,
		'user_url' =>  $user_url ,

	) ;
}

// DOWNLOAD DATA UPDATE
if( ! empty( $_POST['filemanager_update'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	// DELETE NULLBYTE
	$_POST = $myts->Delete_Nullbyte( $_POST );

	$errors = array() ;
	foreach( $_POST['title'] as $id => $value ) {
		$lid = intval( $id ) ;
		$title = "'".mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['title'][$id] ) ) ."'" ;
		$visible = empty( $_POST['visible'][$id] ) ? 0 : 1 ;
		$cancomment = empty( $_POST['comment'][$id] ) ? 0 : 1 ;
		$result = $db->query( "UPDATE ".$db->prefix($mydirname."_downloads")." SET title=$title,visible=$visible,cancomment=$cancomment WHERE lid=$lid" ) ;
		if( ! $result ) $errors[] = $lid ;
	}
	d3download_delete_cache_of_categories( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_REGSTERED ) ;
	exit();
}

// DELETE
if( ! empty( $_POST['delete'] ) && ! empty( $_POST['action_selects'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$errors = array() ;
	foreach( $_POST['action_selects'] as $id => $value ) {
		if( empty( $value ) ) continue ;
		$lid = intval( $id ) ;
		d3download_delete_lid( $mydirname ,$lid );
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager" , 2 , _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// MOVE
$moveselect = array() ;
$moveselect = array( 0 => '----' ) ;
$mrs = $db->query("SELECT cid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid='0' ORDER BY cat_weight ASC");
while( list( $id, $nam ) = $db->fetchRow( $mrs ) ) {
	$mcatid = intval( $id );
	$moveselect[ $mcatid ] = $myts->makeTboxData4Show( $nam ) ;
	$arr = $mytree->getChildTreeArray( $mcatid );
	foreach ( $arr as $tree ) {
		$tree_id = intval( $tree['cid'] );
		$tree['prefix'] = str_replace(".","--",$tree['prefix']);
		$moveselect[ $tree_id ] = $tree['prefix']."&nbsp;".$myts->makeTboxData4Show( $tree['title'] );
	}
}

if( ! empty( $_POST['move'] ) && ! empty( $_POST['action_selects'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$mcid = intval( @$_POST['move_select'] ) ;
	if( ! empty( $mcid ) ){
		$errors = array() ;
		foreach( $_POST['action_selects'] as $id => $value ) {
			$mlid = intval( $id ) ;
			$mus = $db->query( "SELECT * FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid=$mlid AND cid=$mcid" ) ;
			$checksum = $db->getRowsNum( $mus ) ;
			if( empty( $checksum ) ){
				$mse = $db->query( "UPDATE ".$db->prefix( $mydirname."_downloads" )." SET cid=$mcid WHERE lid=$mlid" ) ;
				if( ! $result ) $errors[] = $lid ;
			}
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_MOVEED ) ;
		exit();
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager" , 2 , _MD_D3DOWNLOADS_NO_MOVEED ) ;
		exit();
	}
}

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'filemanager' ,
	'download' => $download ,
	'categoryselect' => $category4assin ,
	'moveselect' => $moveselect ,
	'perpage' => $perpage4assign ,
	'select_perpage' => $select_perpage ,
	'total_num' => $total_num4assign ,
	'pagenav' => $pagenav4assign ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_filemanager.html' ) ;
xoops_cp_footer();

?>