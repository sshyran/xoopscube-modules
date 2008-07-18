<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/db_download.php' ;
require_once dirname( dirname(__FILE__) ).'/class/unapproval_download.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
require_once dirname( dirname(__FILE__) ).'/include/upload_functions.php' ;

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

if( is_object( $xoopsUser ) ) {
	$xoops_isuser = true ;
	$xoops_userid = $xoopsUser->getVar('uid') ;
	$xoops_uname = $xoopsUser->getVar('uname') ;
	$xoops_isadmin = $xoopsUserIsAdmin ;
} else {
	$xoops_isuser = false ;
	$xoops_userid = 0 ;
	$xoops_uname = '' ;
	$xoops_isadmin = false ;
}

// GET REQUESTID FROM $_GET
$requestid = isset( $_GET['requestid'] ) ? intval( $_GET['requestid'] ) : "";

// CATEGORY LIST
$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
$category = array() ;
$crs = $db->query("SELECT cid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid='0' ORDER BY cat_weight ASC");
while( list( $id, $name ) = $db->fetchRow( $crs ) ) {
	$catid = intval( $id );
	$category[ $catid ] = $myts->makeTboxData4Show( $name ) ;
	$arr = $mytree->getChildTreeArray( $catid );
	foreach ( $arr as $child ) {
		$child_id = intval( $child['cid'] );
		$child['prefix'] = str_replace(".","--",$child['prefix']);
		$category[ $child_id ] = $child['prefix']."&nbsp;".$myts->makeTboxData4Show( $child['title'] );
	}
}
// GET PLATFORM LIST
$select_platform = array() ;
$select_platform = d3download_select_platform( $mydirname );

$formtitle = _MD_D3DOWNLOADS_SUBMIT_APPROVAL ;

// GET UNAPROVALDATA
$mod_url = XOOPS_URL.'/modules/'.$mydirname ;
$unapproval = new unapproval_download( $mydirname ) ;
$unapprovaldata = array() ;
$unapprovaldata = $unapproval->get_unapprovaldata( $requestid, $category );
$cid4assign = $unapprovaldata['cid'];
$aprovalid = $unapprovaldata['aprovalid'];
$user_url = $unapprovaldata['user_url'];
$ispreview = "";
$preview_title = "";
$preview_body = "";
$iserror = "";
$error_message =  "";
if( empty( $ispreview ) && empty( $iserror ) ) $unapproval4assign = $unapprovaldata['unapprovaldata'] ;

// SCREEN SHOTS DATA
$img_ar = array();
$shots_help = '';
$canuseshots = ! empty( $xoopsModuleConfig['useshots'] ) ? 1 : 0 ;
$usealbum = d3download_can_albumselect( $mydirname ) ;
if( ! empty( $canuseshots ) ){
	$shots_dir = d3download_shots_dir( $mydirname, $cid4assign );
	$img_ar = d3download_shots_img_ar( $mydirname, $shots_dir );
	if( empty( $usealbum ) ){
		$shots_help = sprintf( _MD_D3DOWNLOADS_SUBMIT_LOGOURL_DESC , $shots_dir );
	}
}

// GET DOWNLOADDATA
$mydownload = new MyDownload( $mydirname );
$download4assign = $mydownload->get_downdata_for_singleview( 0, $aprovalid, 0, 1, 1 );

// USE HTML Purifier
$use_htmlpurifierl = d3download_use_htmlpurifierl( $mydirname ) ;

// TRANSACTION PART
if( isset( $_POST['unapproval_post'] ) || isset( $_POST['unapproval_preview'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	// GET POST
	require_once dirname(dirname(__FILE__)).'/class/submit_validate.php' ;
	$submit_validate = new Submit_Validate( $mydirname, 'approval' ) ;

	// requests_01
	$requests_01 = $submit_validate->get_requests_01() ;
	$html = $requests_01['html'];
	$smiley = $requests_01['smiley'];
	$br = $requests_01['br'];
	$xcode = $requests_01['xcode'];

	// requests_int
	$requests_int = $submit_validate->get_requests_int() ;
	$edit_id = intval( @$_POST['requestid'] ) ;
	$cid = $requests_int['cid'];
	$submitter = $requests_int['submitter'];
	$lid = $requests_int['lid'];
	$size = $requests_int['size'];
	$date = intval( @$_POST['date'] );

	// requests_text
	$requests_text = $submit_validate->get_requests_text( $use_htmlpurifierl, $html , $smiley , $xcode , $br ) ;
	$title = $requests_text['title'];
	$homepage = $requests_text['homepage'];
	$version = $requests_text['version'];
	$platform = $requests_text['platform'];
	$url = $requests_text['url'];
	$filename = $requests_text['filename'];
	$ext = $requests_text['ext'];
	$body = $requests_text['description'];

	// requests_logourl
	$requests_logourl = $submit_validate->get_requests_logourl( $usealbum ) ;
	$logourl = $requests_logourl['logourl'];

	// requests_admin
	$requests_admin = $submit_validate->get_requests_admin() ;
	$visible = $requests_admin['visible'];
	$cancomment = $requests_admin['cancomment'];
	$notify = empty( $_POST['notify'] ) ? 0 : 1 ;
	$modify = intval( @$_POST['modify'] ) ;

	// postname
	$postname = d3download_postname( $submitter );

	// for after preview edit
	$unapproval4assign = array(
		'requestid' => $edit_id ,
		'lid' => $lid ,
		'cid' => $cid ,
		'category' => $category ,
		'title' => $requests_text['title4edit'] ,
		'url' => $requests_text['url4edit'] ,
		'filelink' => $unapprovaldata['unapprovaldata']['filelink'] ,
		'filename' => $requests_text['filename4edit'] ,
		'ext' => $requests_text['ext4edit'] ,
		'homepage' => $requests_text['homepage4edit'] ,
		'version' => $requests_text['version4edit'] ,
		'size' => $size ,
		'platform' => $requests_text['platform4edit'] ,
		'logourl' => $requests_logourl['logourl4edit'] ,
		'description' => $requests_text['description4edit'] ,
		'html' => $html ,
		'smiley' => $smiley ,
		'br' => $br ,
		'xcode' => $xcode ,
		'submitter' => $submitter ,
		'postname' => $postname ,
		'user_url' => $user_url ,
		'date' => $date ,
		'modify' => $modify ,
		'visible' => $visible ,
		'cancomment' => $cancomment ,
		'notify' => $notify ,
	) ;

	if( isset( $_POST['unapproval_preview'] ) ){
		$ispreview = true ;
		$preview_title = $requests_text['title4preview'] ;
		$preview_body = $requests_text['description4preview'] ;
	}

	// ERORR INITIALIZATION
	$errors = '';

	$validate_result = $submit_validate->Validate( $url, $filename ) ;
	if( ! empty( $validate_result ) ){
		$iserror = $validate_result['error'];
		$error_message = implode( '<br />' , $validate_result['message'] ) ;
	}
	if( isset( $_POST['unapproval_post'] ) && empty( $iserror ) ){
		// $set4sql
		$set4sql = "lid='".$lid."'" ;
		$set4sql .= $requests_01['set4sql'] ;
		$set4sql .= $requests_int['set4sql'] ;
		$set4sql .= ",date='".$date."'" ;
		$set4sql .= $requests_text['set4sql'] ;
		$set4sql .= $requests_logourl['set4sql'] ;
		$set4sql .= $requests_admin['set4sql'] ;
		// MAKE LINK SQL
		if( ! empty( $edit_id ) && empty( $modify ) && empty( $lid ) ) {
			$new_lid = $db->genId($db->prefix( $mydirname."_downloads" )."_lid_seq");
			$make_link = new db_download( $db->prefix( $mydirname."_downloads" ) , "lid", $new_lid ) ;
			$newid = $make_link->db_insert( $set4sql );
			if( empty( $newid ) ) $errors[] = $edit_id ;
			if( ! empty( $filename ) ) d3download_convert_for_newid( $mydirname, $newid, $url, $submitter );

			// Category title
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
			$ctitle = $mycategory->return_title() ;

			// Define tags for notification message
			$tags = array();
			$tags = array(
				'POSTER_UNAME' => $postname ,
				'POST_TITLE' => $title ,
				'POST_BODY' => $body ,
				'POST_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?page=singlefile&cid=' . $cid . '&lid=' . $newid,
				'CAT_TITLE' => $ctitle ,
				'CAT_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?cid=' . $cid ,
			) ;
			d3download_main_trigger_event( 'global' , 0 , 'newpost' , $tags, 0 ) ;
			d3download_main_trigger_event( 'category' , $cid , 'newpost' , $tags, 0 ) ;
			d3download_main_trigger_event( 'category' , $cid , 'newpostfull' , $tags, 0 ) ;
			if( ! empty( $notify ) ){
				d3download_main_trigger_event( 'global' , $edit_id , 'approve' , $tags, 0 ) ;
			}
		} elseif( ! empty( $edit_id ) && ! empty( $modify ) && ! empty( $lid ) ) {
			// UPDATE SQL
			$make_link = new db_download( $db->prefix( $mydirname."_downloads" ) , "lid", $lid ) ;
			$count = $make_link->db_getrowsnum( $lid );
			if( $count > 0 ){
				$result = $make_link->db_update( $set4sql, $lid );
				if( ! $result ) $errors[] = $lid ;
				$new_historyid = $db->genId($db->prefix( $mydirname."_downloads_history" )."_id_seq");
				$sql4history = "id='".$new_historyid."'" ;
				$sql4history .= ",lid='".$lid."'" ;
				$sql4history .= ",cid='".$cid."'" ;
				$sql4history .= ",title='".addslashes( $title )."'" ;
				$sql4history .= ",url='".addslashes( $url )."'" ;
				$sql4history .= ",filename='".addslashes( $filename )."'" ;
				$sql4history .= ",ext='".addslashes( $ext )."'" ;
				$sql4history .= ",description='".$requests_text['description4sql']."'" ;
				$sql4history .= ",date='".$date."'" ;
				$make_history = new db_download( $db->prefix( $mydirname."_downloads_history" ) , "id", $new_historyid ) ;
				$result = $make_history->db_insert( $sql4history );
				d3download_delete_history( $mydirname, $lid );
				if( ! empty( $notify ) ){
					// Define tags for notification message
					$tags = array();
					$tags = array(
						'POST_TITLE' => $title ,
						'POST_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?page=singlefile&cid=' . $cid . '&lid=' . $lid,
					) ;
					d3download_main_trigger_event( 'global' , $lid , 'approve' , $tags, 0 ) ;
				}
			}
		}
		$sql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE requestid='".$edit_id."'";
		list( $count ) = $db->fetchRow( $db->query( $sql ) );
		if( $count > 0 ){
			$sql = "DELETE FROM ".$db->prefix($mydirname."_unapproval")." WHERE requestid = ".$edit_id;
			$result = $db->query($sql);
			if( ! $result ) $errors[] = $edit_id ;
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_SUBMIT_APPROVED ) ;
		exit();
	}
}

// DELETE SQL
if( isset( $_POST['approvalform_delete'] )) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$errors = '';
	$delete_requestid = isset( $_POST['requestid'] ) ? intval( @$_POST['requestid'] ) : "" ;

	$sql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE requestid='".$delete_requestid."'";
	list( $count ) = $db->fetchRow( $db->query( $sql ) );
	if( $count > 0 ){
		d3download_delete_unapproval_files( $mydirname , $delete_requestid );
		$sql = "DELETE FROM ".$db->prefix($mydirname."_unapproval")." WHERE requestid = ".$delete_requestid;
		$result = $db->query( $sql );
		if( ! $result ) $errors[] = $delete_requestid ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_DELETED ) ;
		exit();
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager&amp;requestid=".$delete_requestid, 2, _MD_D3DOWNLOADS_NONDELETED);
		exit();
	}
}

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => $mod_url ,
	'page' => 'approval' ,
	'unapproval' => $unapproval4assign ,
	'down' => $download4assign ,
	'canuseshots' => $canuseshots ,
	'select_platform' => $select_platform ,
	'downimg' => $img_ar ,
	'preview_title' => $preview_title ,
	'preview_body' => $preview_body ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'shots_help' => $shots_help ,
	'formtitle' => $formtitle ,
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'xoops_isadmin' => $xoops_isadmin ,
	'xoops_config' => $xoopsConfig ,
	'mod_config' => $xoopsModuleConfig ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_approval.html' ) ;
xoops_cp_footer();

?>