<?php

include XOOPS_ROOT_PATH."/header.php";

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/class/db_download.php' ;
require_once dirname( dirname(__FILE__) ).'/class/livevalidationphp.class.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;
require_once dirname( dirname(__FILE__) ).'/class/submit_download.php' ;
require_once dirname( dirname(__FILE__) ).'/class/history_download.php' ;
require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
include_once dirname( dirname(__FILE__) ).'/include/upload_functions.php' ;

$myts =& d3downloadsTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;
global $xoopsUser , $xoopsModuleConfig;

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

// 登録は CID の指定を必要とします
if( ! empty( $_GET['cid'] ) ){
	$cid = intval( $_GET['cid'] );
} elseif( ! empty( $_POST['cid'] ) ) {
	$cid = intval( $_POST['cid'] );
} else {
	redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/index.php',3, _MD_D3DOWNLOADS_NO_CID );
	exit();
}

// 編集権限をチェック(管理者は除く)
$user_access = new user_access( $mydirname ) ;
$whr_cat4edit = "cid IN (".implode(",", $user_access->can_edit() ).")" ;
$permissions = $user_access->permissions_of_current_user( $cid ) ;
$can_edit = $permissions['can_edit'] ;
if( empty( $can_edit ) ) {
	redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/',3, _MD_D3DOWNLOADS_NOEDITTPERM );
	exit();
}

// 自動承認のチェック(管理者は除く)
$auto_approved = $permissions['edit_approved'] ;

// HTML許可のチェック(登録ユーザー以外は HTMLを無効とする)
$canhtml = $permissions['can_html'] ;

// アップロード許可のチェック
$canupload = $permissions['can_upload'] ;

// 削除権限のチェック(管理者は除く)
$candelete = $permissions['can_delete'] ;

// 管理者と管理者以外のテンプレートを分けて処理
if( $xoops_isadmin ){
	$xoopsOption['template_main'] = $mydirname.'_admin_submit.html' ;
} else {
	$xoopsOption['template_main'] = $mydirname.'_main_submit.html' ;
}

// 管理者以外の投稿フォーム説明文を取得
$message = d3download_submit_message( $mydirname, $cid ) ;
$formtitle = _MD_D3DOWNLOADS_SUBMIT_EDIT ;

// パンくず部分の処理
$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
if( ! empty( $xoopsModuleConfig['show_breadcrumbs'] ) ){
	$pathstring = d3download_pathstring( $mytree, $cid, $whr_cat );
	$xoopsTpl->assign('category_path', $pathstring);
}

// GET LID FROM $_GET
$lid = isset( $_GET['lid'] ) ? intval( $_GET['lid'] ) : 0 ;

// 編集可能なカテゴリリストのみ取得
$category = array() ;
if( $xoops_isadmin ){
	$category = d3download_categories_selbox( $mydirname, $mytree, $whr_cat4edit );
} else {
	$category = d3download_categories_selbox( $mydirname, $mytree, $whr_cat4edit, $cid );
}

// 利用可能な OS/ソフト等のリストを取得
$select_platform = array() ;
$select_platform = d3download_select_platform( $mydirname );

// スクリーンショット画像の取得
$img_ar = array();
$shots_help = '';
$canuseshots = ! empty( $xoopsModuleConfig['useshots'] ) ? 1 : 0 ;
$usealbum = d3download_can_albumselect( $mydirname ) ;
if( ! empty( $canuseshots ) ){
	$shots_dir = d3download_shots_dir( $mydirname, $cid );
	$img_ar = d3download_shots_img_ar( $mydirname, $shots_dir );
	if( empty( $usealbum ) ) $shots_help = sprintf( _MD_D3DOWNLOADS_SUBMIT_LOGOURL_DESC , $shots_dir );
}

// GET DOWNLOADDATA
$ispreview = "";
$preview_title = "";
$preview_body = "";
$iserror = "";
$error_message =  "";
$mod_url = XOOPS_URL.'/modules/'.$mydirname ;
$submit_download = new submit_download( $mydirname ) ;
$downdata = array() ;
$downdata = $submit_download->get_downdata_for_submit( $lid, $category ) ;
$lid = $downdata['lid']; ;
$cid4assign = $downdata['cid'];
$submitter = $downdata['submitter'];
$user_url = $downdata['user_url'];
$title4assign = $downdata['title'];
$hits = $downdata['hits'];
$totalrating = $downdata['totalrating'];
$totalvotes =  $downdata['totalvotes'] ;
$comments = $downdata['comments'] ;
if( empty( $ispreview ) && empty( $iserror ) ) $download4assign = $downdata['downdata'] ;

// 取得した LID で投稿者本人かどうかをチェック
if( $xoops_isadmin ){
	$canedit = 1 ;
} elseif( ! empty( $can_edit ) && $submitter == $xoops_userid &&  $xoops_isuser ){
	$canedit = 1 ;
} else {
	$canedit = 0 ;
}
if( empty( $canedit ) ) {
	redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/',3, _MD_D3DOWNLOADS_NOEDITTPERM );
	exit();
}

$breadcrumbs[0] = d3download_breadcrumbs( $mydirname ) ;
$bc_arr =  $mytree->getNicePathArrayFromId( $cid4assign, "title", $whr_cat, "index.php?" );
foreach( $bc_arr as $bc ) {
	$breadcrumbs[] = array(
		'name' => $bc['name'] ,
		'url' => $bc['url'] ,
	) ;
}
$breadcrumbs[] = array( 'name' => $formtitle.':'.htmlspecialchars( $title4assign , ENT_QUOTES ) ) ;

// 管理者の投稿フォーム用に HISTORY DATA を取得
$history = new history_download( $mydirname ) ;
$history4assign = array() ;
$history4assign = $history->get_history_list( $lid );

// 同一リンクの再登録を認めるかどうか
$check_url = ! empty( $xoopsModuleConfig['check_url'] ) ? 1 : 0 ;

// HTML Purifier を利用するかどうか
$use_htmlpurifierl = d3download_use_htmlpurifierl( $mydirname ) ;

// maxfilesize(テンプレートへのアサイン用)
$upload_max_filesize = d3download_get_maxsize( $mydirname );
$max_submit_size = sprintf( _MD_D3DOWNLOADS_SUBMIT_MAXFILESIZE , number_format( $upload_max_filesize ) ) ;
$submit_extension = d3download_get_allowed_extension( $mydirname );

// 環境チェックし error の場合はアップロードフォームを選択できないようにする
$config_error = 0 ;
$config_error = d3download_upload_config_check( $mydirname );

// LiveValidationによるValidationをアサイン
require_once dirname( dirname(__FILE__) ).'/include/upload_submit_rules.inc.php' ;
$liveValidator ="";
$liveform = new LiveValidationMassValidatePHP( 'makedownloadform', $_POST );
$liveform->addRules( $formRules['makedownloadform' ] );
$liveValidator = $liveform->generateAll();
$xoopsTpl->assign('liveValidator', $liveValidator);

// TRANSACTION PART
$liveformErrors=array();
if( isset( $_POST['makedownload_post'] ) || isset( $_POST['makedownload_preview'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	// $liveformErrors = $liveform->validate();

	// GET POST
	require_once dirname( dirname(__FILE__) ).'/class/submit_validate.php' ;
	$submit_validate = new Submit_Validate( $mydirname, 'modfile' ) ;

	// requests_01
	$requests_01 = $submit_validate->get_requests_01() ;
	$html = $requests_01['html'];
	$smiley = $requests_01['smiley'];
	$br = $requests_01['br'];
	$xcode = $requests_01['xcode'];

	// requests_int
	$requests_int = $submit_validate->get_requests_int() ;
	$cid = $requests_int['cid'];
	$submitter = $requests_int['submitter'];
	$edit_id = $requests_int['lid'];
	$post_size = $requests_int['size'];

	// requests_text
	$requests_text = $submit_validate->get_requests_text( $use_htmlpurifierl, $html , $smiley , $xcode , $br ) ;
	$title = $requests_text['title'];
	$homepage = $requests_text['homepage'];
	$version = $requests_text['version'];
	$platform = $requests_text['platform'];
	$post_url = $requests_text['url'];
	$post_filename = $requests_text['filename'];
	$post_ext = $requests_text['ext'];
	$body = $requests_text['description'];

	// requests_logourl
	$requests_logourl = $submit_validate->get_requests_logourl( $usealbum ) ;
	$logourl = $requests_logourl['logourl'];

	// requests_admin
	$requests_admin = $submit_validate->get_requests_admin() ;
	$visible = $requests_admin['visible'];
	$cancomment = $requests_admin['cancomment'];
	$dateoption = empty( $_POST['dateoption'] ) ? 0 : 1 ;
	$notify = empty( $_POST['notify'] ) ? 0 : 1 ;

	// requests_upload
	$request4upload  = isset( $_FILES['file_upload'] ) ? @$_FILES['file_upload'] : "" ;

	// postname
	$postname = d3download_postname( $submitter );

	// for after preview edit
	$download4assign = array(
		'lid' => $edit_id ,
		'cid' => $cid ,
		'category' => $category ,
		'title' => $requests_text['title4edit'] ,
		'url' => $requests_text['url4edit'] ,
		'filename' => $requests_text['filename4edit'] ,
		'ext' => $requests_text['ext4edit'] ,
		'filelink' => $downdata['downdata']['filelink'] ,
		'homepage' => $requests_text['homepage4edit'] ,
		'version' => $requests_text['version4edit'] ,
		'size' => $post_size ,
		'platform' => $requests_text['platform4edit'] ,
		'logourl' => $requests_logourl['logourl4edit'] ,
		'description' => $requests_text['description4edit'] ,
		'submitter' => $submitter ,
		'postname' => $postname ,
		'user_url' => $user_url ,
		'html' => $html ,
		'smiley' => $smiley ,
		'br' => $br ,
		'xcode' => $xcode ,
		'visible' => $visible ,
		'cancomment' => $cancomment ,
		'dateoption' => $dateoption ,
	) ;

	if( ! empty( $html ) && ! $xoops_isadmin ) $submit_validate->Validate_for_html( $cid ) ;
	if( ! empty( $request4upload['name'] ) && ! $xoops_isadmin ) $submit_validate->Validate_for_upload( $cid ) ;

	if( isset( $_POST['makedownload_preview'] ) ){
		$ispreview = true ;
		$preview_title = $requests_text['title4preview'] ;
		$preview_body = $requests_text['description4preview'] ;
	}

	// requests_upload
 	if( isset( $_POST['makedownload_post'] ) && ! empty( $request4upload['name'] ) && $canupload ){
		$upload_result = d3download_file_upload( $mydirname, $request4upload, $upload_max_filesize, $edit_id, $submitter ) ;
	}
	$url = ! empty( $upload_result['url'] ) ? $upload_result['url'] : $post_url ;
	if( preg_match( '/^(https?|ftp)?:\/\/.+\..+/i' , $url ) ) {
		$filename = "" ;
		$ext = "" ;
	} else {
		$filename = ! empty( $upload_result['file_name'] ) ? $upload_result['file_name'] : $post_filename ;
		$ext = ! empty( $upload_result['ext'] ) ? $upload_result['ext'] : $post_ext ;
	}
	$size = ! empty( $upload_result['size'] ) ? $upload_result['size'] : $post_size ;

	// LiveValidationによるValidation が有効にならない環境を考慮し、ここでも入力チェック
	$validate_result = $submit_validate->Validate( $url, $filename ) ;
	if( ! empty( $upload_result['error'] ) || ! empty( $validate_result ) ){
		if( ! empty( $upload_result['error'] ) ){
			$error_message = $upload_result['error'] . '<br />' . implode( '<br />' , $validate_result['message'] ) ;
		} else {
			$error_message = implode( '<br />' , $validate_result['message'] ) ;
		}
		if( ! empty( $error_message ) ) $iserror = true;
	}

	// 承認待ちの再登録はお断り
	$submit_validate->Validate_check_unapproval( $url ) ;

/*
	if( ! empty( $liveformErrors ) ){
		$iserror = true ;
		$error_message = implode( '<br />' , $liveformErrors ) ;
	}
*/
	if( isset( $_POST['makedownload_post'] ) && empty( $iserror ) ){
		// set4sql
		$set4sql = "lid='".$edit_id."'" ;
		$set4sql .= $requests_01['set4sql'] ;
		$set4sql .= $requests_int['set4sql'] ;
		$set4sql .= $requests_text['set4sql'] ;
		$set4sql .= ",size='".$size."'" ;
		$date = time() ;
		if( empty( $dateoption ) ){
			$set4sql .= ",date='".$date."'" ;
		}
		$set4sql .=  $requests_logourl['set4sql'] ;
		$set4sql .= ",url='".addslashes( $url )."'" ;
		$set4sql .= ",filename='".addslashes( $filename )."'" ;
		$set4sql .= ",ext='".addslashes( $ext )."'" ;
		$set4sql .= $requests_admin['set4sql'] ;

		// ERORR INITIALIZATION
		$errors ="";

		// LIDを取得できなかった場合はお断り
		if( empty( $edit_id ) ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/index.php" , 2 , _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID ) ;
			exit();
		} elseif ( ! empty( $edit_id ) && ! empty( $auto_approved ) ) {
			// DOES THE LINK ALREADY EXIST? -- UPDATE SQL
			$make_link = new db_download( $db->prefix( $mydirname."_downloads" ) , "lid", $edit_id ) ;
			$count = $make_link->db_getrowsnum( $edit_id );
			if( $count > 0 ){
				$result = $make_link->db_update( $set4sql, $edit_id );
				if( ! $result ) $errors = $edit_id ;
				$newid = $db->genId($db->prefix( $mydirname."_downloads_history" )."_id_seq");
				$sql4history = "id='".$newid."'" ;
				$sql4history .= ",lid='".$edit_id."'" ;
				$sql4history .= ",cid='".$cid."'" ;
				$sql4history .= ",title='".addslashes( $title )."'" ;
				$sql4history .= ",url='".addslashes( $url )."'" ;
				$sql4history .= ",filename='".addslashes( $filename )."'" ;
				$sql4history .= ",ext='".addslashes( $ext )."'" ;
				$sql4history .= ",description='".$requests_text['description4sql']."'" ;
				$sql4history .= ",date='".$date."'" ;
				$make_history = new db_download( $db->prefix( $mydirname."_downloads_history" ) , "id", $newid ) ;
				$result = $make_history->db_insert( $sql4history );
				d3download_delete_history( $mydirname ,$edit_id );
				d3download_delete_cache_of_categories( $mydirname ) ;
				if( ! empty( $visible ) ){
					redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=singlefile&amp;cid=$cid&amp;lid=$edit_id" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $errors ) : _MD_D3DOWNLOADS_THANKSSUBMIT ) ;
				} else {
					redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $errors ) : _MD_D3DOWNLOADS_THANKSSUBMIT ) ;
				}
				exit();
			}
		} else {
			// MAKE UNAPPROVAL LINK SQL
			$requestid = $db->genId($db->prefix( $mydirname."_unapproval" )."_requestid_seq");
			$set4sql .= ",requestid='".$requestid."'" ;
			$set4sql .= ",notify='".$notify."'" ;
			$unapproval_link = new db_download( $db->prefix( $mydirname."_unapproval" ) , "requestid", $edit_id ) ;
			$newid = $unapproval_link->db_insert( $set4sql );
			if( empty( $newid ) ) $errors = true ;
			// Define tags for notification message
			$tags = array();
			$tags = array(
				'POSTER_UNAME' => $postname ,
				'POST_TITLE' => $title ,
				'POST_BODY' => $body ,
				'WAITING_URL' => XOOPS_URL . '/modules/' . $mydirname . '/admin/index.php?page=approvalmanager' ,
			) ;
			d3download_main_trigger_event( 'global' , 0 , 'waiting' , $tags , 0 ) ;
			if ( ! empty( $notify ) ) {
				include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->subscribe('global', $edit_id, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			}
			redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=singlefile&amp;cid=$cid&amp;lid=$edit_id" , 2 , $errors ? _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID : _MD_D3DOWNLOADS_THANKSFORINFO ) ;
			exit();
		}
	}
}

// 削除権限をチェックしたうえ関連データも同時に削除
if( isset( $_POST['makedownloadform_delete'] ) && ! empty( $candelete ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$delete_lid = isset( $_POST['lid'] ) ? intval( @$_POST['lid'] ) : "" ;

	require_once dirname( dirname(__FILE__) ).'/class/submit_validate.php' ;
	$submit_validate = new Submit_Validate( $mydirname, 'delete' ) ;
	if( ! $xoops_isadmin ) $submit_validate->Validate_for_delete( $cid, $delete_lid ) ;
	d3download_delete_lid( $mydirname ,$lid );
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php" , 2 , _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// ファイル破損報告DATAの取得(管理者用)
$broken_data = d3download_get_broken_data( $mydirname, $lid ) ;
$totalbroken = $broken_data['totalbroken'] ;
$total_broken4assign = $broken_data['total_broken4assign'] ;
$broken = $broken_data['broken'] ;

// VOTE DATAの取得(管理者用)
$total_vote4assign = sprintf( _MD_D3DOWNLOADS_TOTAL_VOTE , $totalvotes );
$user_vote_data = d3download_get_user_vote( $mydirname, $lid ) ;
$user_vote4assign = $user_vote_data['user_totalvote'] ;
$user_vote = $user_vote_data['user_vote'] ;
$guest_vote_data = d3download_get_guest_vote( $mydirname, $lid ) ;
$guest_vote4assign = $guest_vote_data['guest_totalvote'] ;
$guest_vote = $guest_vote_data['guest_vote'] ;

// WYSIWYG
$wysiwygs = array( 'name' => 'desc' , 'value' => $download4assign['description'] ) ;
include dirname( dirname(__FILE__) ).'/include/wysiwyg_editors.inc.php' ;

// livevalidation.js と livevalidation.css を xoops_module_header にアサイン
$xoops_module_header = d3download_dbmoduleheader( $mydirname );
$livevalidation_header = d3download_dbmoduleheader_for_livevalidation( $mydirname );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" .$livevalidation_header. "\n" . $wysiwyg_header. "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));

// assign
$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => $mod_url ,
	'page' => 'modfile' ,
	'select_platform' => $select_platform ,
	'download' => $download4assign ,
	'canuseshots' => $canuseshots ,
	'downimg' => $img_ar ,
	'shots_help' => $shots_help ,
	'candelete' => $candelete ,
	'preview_title' => $preview_title ,
	'preview_body' => $preview_body ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'formtitle' => $formtitle ,
	'auto_approved' => $auto_approved ,
	'message' => $message ,
	'check_url' => $check_url ,
	'history' => $history4assign ,
	'hits' => $hits ,
	'rating' => $totalrating ,
	'totalbroken' => $total_broken4assign ,
	'broken' => $broken ,
	'brokensum' => $totalbroken ,
	'totalvotes' => $total_vote4assign ,
	'user_totalvote' => $user_vote4assign ,
	'guest_totalvote' => $guest_vote4assign ,
	'user_vote' => $user_vote ,
	'guest_vote' => $guest_vote ,
	'comments' => $comments ,
	'canhtml' => $canhtml ,
	'canupload' => $canupload ,
	'upload_max_filesize' => $upload_max_filesize ,
	'max_submit_size' => $max_submit_size ,
	'submit_extension' => $submit_extension ,
	'config_error' => $config_error ,
	'body_wysiwyg' => $wysiwyg_body ,
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'xoops_isadmin' => $xoops_isadmin ,
	'xoops_config' => $xoopsConfig ,
	'mod_config' => $xoopsModuleConfig ,
	'xoops_pagetitle' => $formtitle,
	'xoops_breadcrumbs' => $breadcrumbs ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;

include XOOPS_ROOT_PATH.'/footer.php';

?>