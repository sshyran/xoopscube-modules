<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

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

$cid = isset( $_GET['cid'] ) ? intval( $_GET['cid'] ) : "";

// GET CATEGORY DATA
$category_edit = new MyCategory( $mydirname,'Edit' ) ;
$categorydata = array();
$iserror = false ;
$error_message = array();
if( empty( $iserror ) ) $categorydata = $category_edit->MyCategory_for_Edit( $cid ) ;

$useshots = ! empty( $xoopsModuleConfig['useshots'] ) ? 1 : 0 ;
$usealbum = d3download_can_albumselect( $mydirname ) ;
if( ! empty( $useshots ) ){
	if( empty( $usealbum ) ){
		$can_selectshotsdir = 1;
	} else {
		$can_selectshotsdir = 0;
	}
} else {
	$can_selectshotsdir = 0;
}

$shots_dir = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/images/shots/';
$shotsdirhelp = sprintf( _MD_D3DOWNLOADS_CATEGORYSHOTSDIRHELP , $shots_dir );

// MAIN CATEGORY LIST
$maincategory = d3download_categories_for_edit( $mydirname, $cid ) ;

// GROUP FORM
$group_handler =& xoops_gethandler( 'group' ) ;
$groups =& $group_handler->getObjects() ;
$group_trs = '' ;
foreach( $groups as $group ) {
	$gid = $group->getVar('groupid') ;
	$fars = $db->query( "SELECT can_read, can_post, can_edit, can_delete, post_auto_approved, edit_auto_approved, html, upload FROM ".$db->prefix( $mydirname."_user_access" )." WHERE groupid=".$group->getVar('groupid')." AND cid='".$cid."'" ) ;
	if( $db->getRowsNum( $fars ) > 0 ) {
		list( $can_read, $can_post, $can_edit, $can_delete, $post_auto_approved, $edit_auto_approved, $html, $upload ) = $db->fetchRow( $fars ) ;
	} else {
		if( $gid == intval( XOOPS_GROUP_ADMIN ) ){
			$can_read = $can_post = $can_edit = $can_delete = $post_auto_approved = $edit_auto_approved = $upload = true ;
			$html = false ;
		} elseif( $gid == intval( XOOPS_GROUP_USERS ) ){
			$can_read = true ;
			$can_post = $can_edit = $can_delete = $post_auto_approved = $edit_auto_approved = $html = $upload= false ;
		} else {
			$can_read = $can_post = $can_edit = $can_delete = $post_auto_approved = $edit_auto_approved = $html = $upload = false ;
		}
	}
	$can_read_checked = $can_read ? "checked='checked'" : "" ;
	$can_post_checked = $can_post ? "checked='checked'" : "" ;
	$can_edit_checked = $can_edit ? "checked='checked'" : "" ;
	$can_delete_checked = $can_delete ? "checked='checked'" : "" ;
	$post_auto_approved_checked = $post_auto_approved ? "checked='checked'" : "" ;
	$edit_auto_approved_checked = $edit_auto_approved ? "checked='checked'" : "" ;
	$html_checked = $html ? "checked='checked'" : "" ;
	$upload_checked = $upload ? "checked='checked'" : "" ;
	$group_trs .= "
		<tr>
			<td class='even'>".$group->getVar('name')."</td>
			<td class='even'><input type='checkbox' name='can_read[$gid]' id='gcol_1_{$gid}' value='1' $can_read_checked /></td>
			<td class='even'><input type='checkbox' name='can_posts[$gid]' id='gcol_2_{$gid}' value='1' $can_post_checked /></td>
			<td class='even'><input type='checkbox' name='can_edits[$gid]' id='gcol_3_{$gid}' value='1' $can_edit_checked /></td>
			<td class='even'><input type='checkbox' name='can_deletes[$gid]' id='gcol_4_{$gid}' value='1' $can_delete_checked /></td>
			<td class='even'><input type='checkbox' name='post_auto_approveds[$gid]' id='gcol_5_{$gid}' value='1' $post_auto_approved_checked /></td>
			<td class='even'><input type='checkbox' name='edit_auto_approved[$gid]' id='gcol_6_{$gid}' value='1' $edit_auto_approved_checked /></td>
			<td class='even'><input type='checkbox' name='html[$gid]' id='gcol_7_{$gid}' value='1' $html_checked /></td>
			<td class='even'><input type='checkbox' name='upload[$gid]' id='gcol_8_{$gid}' value='1' $upload_checked /></td>
		</tr>\n" ;
}

// USER FORM
$fars = $db->query( "SELECT u.uid, u.uname, ua.can_read, ua.can_post, ua.can_edit, ua.can_delete, ua.post_auto_approved, ua.edit_auto_approved, ua.html, ua.upload FROM ".$db->prefix($mydirname."_user_access")." ua LEFT JOIN ".$db->prefix("users")." u ON ua.uid=u.uid WHERE ua.cid='".$cid."' AND ua.groupid IS NULL ORDER BY u.uid ASC" ) ;
$user_trs = '' ;
while( list( $uid , $uname , $can_read_user, $can_post_user, $can_edit_user, $can_delete_user, $post_auto_approved_user, $edit_auto_approved_user, $html_user, $upload_user ) = $db->fetchRow( $fars ) ) {
	$uid = intval( $uid ) ;
	$uname4disp = htmlspecialchars( $uname , ENT_QUOTES ) ;

	$can_read_checked_user = $can_read_user ? "checked='checked'" : "" ;
	$can_post_checked_user = $can_post_user ? "checked='checked'" : "" ;
	$can_edit_checked_user = $can_edit_user ? "checked='checked'" : "" ;
	$can_delete_checked_user = $can_delete_user ? "checked='checked'" : "" ;
	$post_auto_approved_checked_user = $post_auto_approved_user ? "checked='checked'" : "" ;
	$edit_auto_approved_checked_user = $edit_auto_approved_user ? "checked='checked'" : "" ;
	$html_checked_user = $html_user ? "checked='checked'" : "" ;
	$upload_checked_user = $upload_user ? "checked='checked'" : "" ;
	$user_trs .= "
		<tr>
			<td class='even'>$uid</td>
			<td class='even'>$uname4disp</td>
			<td class='even'><input type='checkbox' name='can_read_user[$uid]' id='ucol_1_{$uid}' value='1' $can_read_checked_user /></td>
			<td class='even'><input type='checkbox' name='can_posts_user[$uid]' id='ucol_2_{$uid}' value='1' $can_post_checked_user /></td>
			<td class='even'><input type='checkbox' name='can_edits_user[$uid]' id='ucol_3_{$uid}' value='1' $can_edit_checked_user /></td>
			<td class='even'><input type='checkbox' name='can_deletes_user[$uid]' id='ucol_4_{$uid}' value='1' $can_delete_checked_user /></td>
			<td class='even'><input type='checkbox' name='post_auto_approveds_user[$uid]' id='ucol_5_{$uid}' value='1' $post_auto_approved_checked_user /></td>
			<td class='even'><input type='checkbox' name='edit_auto_approved_user[$uid]' id='ucol_6_{$uid}' value='1' $edit_auto_approved_checked_user /></td>
			<td class='even'><input type='checkbox' name='html_user[$uid]' id='ucol_7_{$uid}' value='1' $html_checked_user /></td>
			<td class='even'><input type='checkbox' name='upload_user[$uid]' id='ucol_8_{$uid}' value='1' $upload_checked_user /></td>
		</tr>\n" ;
}

// NEW USER FORM
$newuser_trs = '' ;
for( $i = 0 ; $i < 5 ; $i ++ ) {
	$newuser_trs .= "
		<tr>
			<td class='head'><input type='text' size='4' name='new_uids[$i]' value='' /></th>
			<td class='head'><input type='text' size='12' name='new_unames[$i]' value='' /></th>
			<td class='head'><input type='checkbox' name='new_can_read[$i]' id='ncol_1_{$i}' checked='checked' disabled='disabled' /></th>
			<td class='head'><input type='checkbox' name='new_can_posts[$i]' id='ncol_2_{$i}' value='1' /></th>
			<td class='head'><input type='checkbox' name='new_can_edits[$i]' id='ncol_3_{$i}' value='1' /></td>
			<td class='head'><input type='checkbox' name='new_can_deletes[$i]' id='ncol_4_{$i}' value='1' /></td>
			<td class='head'><input type='checkbox' name='new_post_auto_approveds[$i]' id='ncol_5_{$i}' value='1' /></td>
			<td class='head'><input type='checkbox' name='new_edit_auto_approved[$i]' id='ncol_6_{$i}' value='1' /></td>
			<td class='head'><input type='checkbox' name='new_html[$i]' id='ncol_7_{$i}' value='1' /></td>
			<td class='head'><input type='checkbox' name='new_upload[$i]' id='ncol_8_{$i}' value='1' /></td>
		</tr>
	\n" ;
}

// TRANSACTION PART
if( isset( $_POST['categoryform_post'] ) || isset( $_POST['category_update'] ) || isset( $_POST['group_update'] ) || isset( $_POST['user_update'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$requests_int = $category_edit->requests_int_categories() ;
	$edit_id = $requests_int['cid'] ;
	$pid = $requests_int['pid'] ;
	$cat_weight = $requests_int['cat_weight'] ;
	$requests_text = $category_edit->requests_text_categories() ;
	$title = $requests_text['title'] ;
	$imgurl = $requests_text['imgurl'] ;
	$shotsdir = $requests_text['shotsdir'] ;

	$validate_result = $category_edit->Validate() ;
	if( ! empty( $validate_result ) ){
		$iserror = $validate_result['error'];
		$error_message = implode( '<br />' , $validate_result['message'] ) ;
	}

	// ERORR INITIALIZATION
	$errors = "";

	// for after iserror edit
	$categorydata = array(
		'cid' => $edit_id ,
		'pid' => $pid ,
		'title' => $requests_text['title4edit'] ,
		'imgurl' => $requests_text['imgurl4edit'] ,
		'shotsdir' => $requests_text['shotsdir4edit'] ,
		'cat_weight' =>  $requests_int['cat_weight'] ,
		'submit_message' => $requests_text['submit_message4edit'] ,
	) ;

	if( empty( $iserror ) ){
		include_once dirname( dirname(__FILE__) ).'/class/db_download.php' ;
		$post_cat = new db_download( $db->prefix( $mydirname."_cat" ) , "cid", $edit_id ) ;

		// SET4SQL
		$set4sql_int = $requests_int['set4sql'] ;
		$set4sql_text = $requests_text['set4sql'] ;
		$set4sql = $set4sql_int . $set4sql_text ;

		// MAKE LINK SQL
		if( empty( $edit_id ) ) {
			$new_cid = $post_cat->db_insert( $set4sql );
			if( empty( $new_cid ) ){
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID ) ;
				exit();
			}
			// Define tags for notification message
			$tags = array();
			$tags = array(
				'CAT_TITLE' => $title ,
				'CAT_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?cid=' . $new_cid ,
			) ;
			d3download_main_trigger_event( 'global' , 0 , 'newcategory' , $tags, 0 ) ;
		} elseif ( ! empty( $edit_id ) ) {
			// DOES THE LINK ALREADY EXIST? -- UPDATE SQL
			$sql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_cat" )." WHERE cid='".$edit_id."'";
			list( $count ) = $db->fetchRow( $db->query( $sql) );
			if( $count > 0 ){
				$result = $post_cat->db_update( $set4sql, $edit_id );
				if( ! $result ) $errors = $edit_id ;
			}
		}

		if( empty( $edit_id ) ) $edit_id = $new_cid ;
		// GROUP UPDATE
		$db->query( "DELETE FROM ".$db->prefix( $mydirname."_user_access" )." WHERE cid=$edit_id AND groupid > 0" ) ;
		$result = $db->query( "SELECT groupid FROM ".$db->prefix("groups") ) ;
		if( empty( $pid ) ){
			while( list( $gid ) = $db->fetchRow( $result ) ) {
				$can_read = empty( $_POST['can_read'][$gid] ) ? 0 : 1 ;
				$can_post = empty( $_POST['can_posts'][$gid] ) ? 0 : 1 ;
				$can_edit = empty( $_POST['can_edits'][$gid] ) ? 0 : 1 ;
				$can_delete = empty( $_POST['can_deletes'][$gid] ) ? 0 : 1 ;
				$post_auto_approved = empty( $_POST['post_auto_approveds'][$gid] ) ? 0 : 1 ;
				$edit_auto_approved = empty( $_POST['edit_auto_approved'][$gid] ) ? 0 : 1 ;
				$html = empty( $_POST['html'][$gid] ) ? 0 : 1 ;
				$upload = empty( $_POST['upload'][$gid] ) ? 0 : 1 ;
				$set4sql = "cid='".$edit_id."'" ;
				$set4sql .= ",groupid='".$gid."'" ;
				$set4sql .= ",can_read='".$can_read."'" ;
				$set4sql .= ",can_post='".$can_post."'" ;
				$set4sql .= ",can_edit='".$can_edit."'" ;
				$set4sql .= ",can_delete='".$can_delete."'" ;
				$set4sql .= ",post_auto_approved='".$post_auto_approved."'" ;
				$set4sql .= ",edit_auto_approved='".$edit_auto_approved."'" ;
				$set4sql .= ",html='".$html."'" ;
				$set4sql .= ",upload='".$upload."'" ;
				$sql="INSERT INTO ".$db->prefix( $mydirname."_user_access" )." SET $set4sql";
				$res = $db->query( $sql );
				if( ! $res ) $errors = $edit_cid ;
			}
		}

		// USER UPDATE
		$db->query( "DELETE FROM ".$db->prefix($mydirname."_user_access")." WHERE cid=$edit_id AND uid > 0" ) ;
		if( empty( $pid ) ){
			$can_read_user = is_array( @$_POST['can_read_user'] ) ? $_POST['can_read_user'] : array() ;
			foreach( $can_read_user as $uid => $can_read_user ) {
				$uid = intval( $uid ) ;
				if( $can_read_user ) {
					$can_post_user = empty( $_POST['can_posts_user'][$uid] ) ? 0 : 1 ;
					$can_edit_user = empty( $_POST['can_edits_user'][$uid] ) ? 0 : 1 ;
					$can_delete_user = empty( $_POST['can_deletes_user'][$uid] ) ? 0 : 1 ;
					$post_auto_approved_user = empty( $_POST['post_auto_approveds_user'][$uid] ) ? 0 : 1 ;
					$edit_auto_approved_user = empty( $_POST['edit_auto_approved_user'][$uid] ) ? 0 : 1 ;
					$html_user = empty( $_POST['html_user'][$uid] ) ? 0 : 1 ;
					$upload_user = empty( $_POST['upload_user'][$uid] ) ? 0 : 1 ;
					$set4sql = "cid='".$edit_id."'" ;
					$set4sql .= ",uid='".$uid."'" ;
					$set4sql .= ",can_read='".$can_read_user."'" ;
					$set4sql .= ",can_post='".$can_post_user."'" ;
					$set4sql .= ",can_edit='".$can_delete_user."'" ;
					$set4sql .= ",can_delete='".$can_delete_user."'" ;
					$set4sql .= ",post_auto_approved='".$post_auto_approved_user."'" ;
					$set4sql .= ",edit_auto_approved='".$edit_auto_approved_user."'" ;
					$set4sql .= ",html='".$html_user."'" ;
					$set4sql .= ",upload='".$upload_user."'" ;
					$res = $db->query( "INSERT INTO ".$db->prefix($mydirname."_user_access")." SET $set4sql" ) ;
					if( ! $res ) $errors = $edit_cid ;
				}
			}

			$member_hander =& xoops_gethandler( 'member' ) ;
			if( is_array( @$_POST['new_uids'] ) ) foreach( $_POST['new_uids'] as $i => $uid ) {
				$can_post_user = empty( $_POST['new_can_posts'][$i] ) ? 0 : 1 ;
				$can_edit_user = empty( $_POST['new_can_edits'][$i] ) ? 0 : 1 ;
				$can_delete_user = empty( $_POST['new_can_deletes'][$i] ) ? 0 : 1 ;
				$post_auto_approved_user = empty( $_POST['new_post_auto_approveds'][$i] ) ? 0 : 1 ;
				$edit_auto_approved_user = empty( $_POST['new_edit_auto_approved'][$i] ) ? 0 : 1 ;
				$html_user = empty( $_POST['new_html'][$i] ) ? 0 : 1 ;
				$upload_user = empty( $_POST['new_upload'][$i] ) ? 0 : 1 ;
				if( empty( $uid ) ) {
					//require_once XOOPS_ROOT_PATH.'/class/criteria.php' ;
					$criteria =& new Criteria( 'uname' , addslashes( @$_POST['new_unames'][$i] ) ) ;
					@list( $user ) = $member_handler->getUsers( $criteria ) ;
				} else {
					$user =& $member_handler->getUser( intval( $uid ) ) ;
				}
				if( is_object( $user ) ) {
					$set4sql = "cid='".$edit_id."'" ;
					$set4sql .= ",uid='".$user->getVar( 'uid' )."'" ;
					$set4sql .= ", can_read= 1" ;
					$set4sql .= ", can_post='".$can_post_user."'" ;
					$set4sql .= ", can_edit='".$can_edit_user."'" ;
					$set4sql .= ", can_delete='".$can_delete_user."'" ;
					$set4sql .= ", post_auto_approved='".$post_auto_approved_user."'" ;
					$set4sql .= ", edit_auto_approved='".$edit_auto_approved_user."'" ;
					$set4sql .= ", html='".$html_user."'" ;
					$set4sql .= ", upload='".$upload_user."'" ;
					$res = $db->query( "INSERT INTO ".$db->prefix($mydirname."_user_access")." SET $set4sql" ) ;
					if( ! $res ) $errors = $edit_cid ;
				}
			}
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
		if( ! empty( $_POST['categoryform_post'] ) ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $errors ) : _MD_D3DOWNLOADS_REGSTERED ) ;
		} else {
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categoryedit&amp;cid=$edit_id" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $errors ) : _MD_D3DOWNLOADS_REGSTERED ) ;
		}
		exit();
	}
}

// DELETE SQL
if( isset( $_POST['categoryform_delete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$errors = "";
	$cid = isset( $_POST['cid'] ) ? intval( @$_POST['cid'] ) : "" ;
	d3download_delcat( $mydirname , $cid , $errors );
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $errors ) : _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// DISPLAY STAGE

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'categoryedit' ,
	'categorydata' => $categorydata ,
	'maincategory' => $maincategory ,
	'group_trs' => $group_trs ,
	'user_trs' => $user_trs ,
	'newuser_trs' => $newuser_trs ,
	'can_selectshotsdir' => $can_selectshotsdir ,
	'shotsdirhelp' => $shotsdirhelp ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_category_edit.html' ) ;
xoops_cp_footer();

?>