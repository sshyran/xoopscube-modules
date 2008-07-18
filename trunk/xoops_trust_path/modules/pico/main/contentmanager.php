<?php

include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;
require_once dirname(dirname(__FILE__)).'/include/history_functions.php' ;
require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;

// redirect with POST as SESSION when wraps mode's preview
if( $xoopsModuleConfig['use_wraps_mode'] && ! empty( $_POST['contentman_preview'] ) && empty( $_SESSION[$mydirname.'_preview'] ) && ! empty( $_GET['content_id'] ) ) {
	$link = empty( $_POST['vpath'] ) ? sprintf( _MD_PICO_AUTONAME4SPRINTF , intval( $_GET['content_id'] ) ) : preg_replace( '#[^0-9a-zA-Z_/.+-]#' , '' , $_POST['vpath'] ) ;
	$_POST['content_id'] = intval( $_GET['content_id'] ) ;
	$_SESSION[$mydirname.'_preview'] = $_POST ;
	header( 'Location: '.XOOPS_URL.'/modules/'.$mydirname.'/index.php'.$link.'?page=contentmanager&ret='.urlencode(@$_GET['ret']) ) ;
	exit ;
}
if( ! empty( $_SESSION[$mydirname.'_preview'] ) ) {
	$_POST = $_SESSION[$mydirname.'_preview'] ;
	unset( $_SESSION[$mydirname.'_preview'] ) ;
}

// deciding action
$allowed_actions = array( 'contentman_preview' , 'contentman_post' , 'contentman_copyfromwaiting' , 'contentman_delete' ) ;
$action = '' ;
foreach( $allowed_actions as $allowed_action ) {
	if( ! empty( $_POST[ $allowed_action ] ) ) {
		$action = substr( $allowed_action , 11 ) ;
		break ;
	}
}
if( empty( $action ) && ! empty( $_POST ) ) $action = 'preview' ;

$xoopsOption['template_main'] = $mydirname.'_main_content_form.html' ;
include XOOPS_ROOT_PATH."/header.php";

// get $content_id
$content_id = isset( $_POST['content_id'] ) ? intval( $_POST['content_id'] ) : intval( @$_GET['content_id'] ) ;

if( empty( $content_id ) ) {
	// parse path_info
	if( $xoopsModuleConfig['use_wraps_mode'] ) list( $content_id , $cat_id , $pico_path_info ) = pico_main_parse_path_info( $mydirname ) ;
}

// get and process $cat_id
$cat_id = pico_main_get_cat_id_from_content_id( $mydirname , $content_id ) ;

// get&check this category ($category4assign, $category_row), override options
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// get&check this content
require dirname(dirname(__FILE__)).'/include/process_this_content.inc.php' ;

// special check for contentmanager
if( ! $content4assign['can_edit'] && ! $content4assign['can_delete'] ) {
	if( $content4assign['locked'] ) die( _MD_PICO_ERR_LOCKEDCONTENT ) ;
	else die( _MD_PICO_ERR_EDITCONTENT ) ;
}

// TRANSACTION PART
require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
if( $action == 'post' && $content4assign['can_edit'] ) {
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// update the content
	pico_updatecontent( $mydirname , $content_id , $category4assign['post_auto_approved'] , $category4assign['isadminormod'] ) ;
	$content_uri4html = XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content_id , $mydirname ) ;
	// return uri
	if( ! empty( $_GET['ret'] ) && ( $ret_uri = pico_main_parse_ret2uri( $mydirname , $_GET['ret'] ) ) ) {
		$ret_uri4html = htmlspecialchars( $ret_uri , ENT_QUOTES ) ;
	} else {
		$ret_uri4html = $content_uri4html ;
	}
	// calling a delegate
	if( class_exists( 'XCube_DelegateUtils' ) ) {
		XCube_DelegateUtils::call( 'ModuleClass.Pico.Contentman.UpdateSuccess' , $mydirname , $content_id , $category4assign , $ret_uri4html ) ;
	}
	if( $category4assign['post_auto_approved'] ) {
		// message "modified"
		redirect_header( $ret_uri4html , 2 , _MD_PICO_MSG_CONTENTUPDATED ) ;
	} else {
		// Notify for new waiting content (only for admin or mod)
		$users2notify = pico_main_get_moderators( $mydirname , $cat_id ) ;
		if( empty( $users2notify ) ) $users2notify = array( 0 ) ;
		pico_main_trigger_event( 'global' , 0 , 'waitingcontent' , array( 'CONTENT_URL' => XOOPS_URL."/modules/$mydirname/index.php?page=contentmanager&content_id=$content_id" ) , $users2notify ) ;
		// message "waiting approval"
		redirect_header( $ret_uri4html , 2 , _MD_PICO_MSG_CONTENTWAITINGUPDATE ) ;
	}
	exit ;
}
if( $action == 'copyfromwaiting' && $category4assign['isadminormod'] ) {
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	// copy from waiting eg) body_waiting -> body
	pico_transact_copyfromwaitingcontent( $mydirname , $content_id ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content_id , $mydirname ) , 2 , _MD_PICO_MSG_CONTENTUPDATED ) ;
	exit ;
}
if( $action == 'delete' && $content4assign['can_delete'] ) {
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	pico_delete_content( $mydirname , $content_id ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_category_link4html( $xoopsModuleConfig , $cat_row ) , 2 , _MD_PICO_MSG_CONTENTDELETED ) ;
	exit ;
}

// FORM PART

// get content data specified by content_id
$sql = "SELECT * FROM ".$db->prefix($mydirname."_contents")." o WHERE content_id='$content_id'" ;
if( ! $ors = $db->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
if( $db->getRowsNum( $ors ) <= 0 ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php" , 2 , _MD_PICO_ERR_READCONTENT ) ;
	exit ;
}
$content_row = $db->fetchArray( $ors ) ;
$content4assign = pico_common_get_content4assign( $mydirname , $content_id , $xoopsModuleConfig , $cat_row , false ) ;
$content4assign_base = $content4assign ;
$preview4assign = array() ;

if( $action == 'preview' ) {
	// preview (override content4assign by request4assign)
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$request = pico_get_requests4content( $mydirname , $errors = array() , $category4assign['post_auto_approved'] , $category4assign['isadminormod'] , $content_id ) ;
	$request4assign = array_map( 'htmlspecialchars_ent' , $request ) ;
	$content4assign = $request4assign + $content4assign ;
	$content4assign['id'] = $content_id ;
	$content4assign['filter_infos'] = pico_main_get_filter_infos( $request['filters'] , $category4assign['isadminormod'] ) ;
	$content4assign['body_raw'] = $request['body'] ;

	$preview4assign = array(
		'errors' => $errors ,
		'htmlheader' => $request['htmlheader'] ,
		'subject' => $myts->makeTboxData4Show( $request['subject'] ) ,
		'body' => pico_common_filter_body( $mydirname , $request + array('content_id'=>0) ) ,
	) ;
} else {
	// filter overriding for edit instead of view
	$content4edit = array(
		'vpath' => htmlspecialchars( $content_row['vpath'] , ENT_QUOTES ) ,
		'subject' => $content_row['approval'] == 0 && ! $content_row['visible'] ? htmlspecialchars( $content_row['subject_waiting'] , ENT_QUOTES ) : htmlspecialchars( $content_row['subject'] , ENT_QUOTES ) ,
		'subject_waiting' => htmlspecialchars( $content_row['subject_waiting'] , ENT_QUOTES ) ,
		'htmlheader' => htmlspecialchars( $content_row['htmlheader'] , ENT_QUOTES ) ,
		'htmlheader_waiting' => htmlspecialchars( $content_row['htmlheader_waiting'] , ENT_QUOTES ) ,
		'body' => htmlspecialchars( $content_row['body'] , ENT_QUOTES ) ,
		'body_waiting' => htmlspecialchars( $content_row['body_waiting'] , ENT_QUOTES ) ,
		'filters' => htmlspecialchars( $content_row['filters'] , ENT_QUOTES ) ,
		'filter_infos' => pico_main_get_filter_infos( $content_row['filters'] , $category4assign['isadminormod'] ) ,
		'modifier_uid' => $uid ,
	) ;
	$content4assign = $content4edit + $content4assign + $content_row ;
}

// vpath options
$content4assign['wraps_files'] = array( '' => '---' ) + pico_main_get_wraps_files_recursively( $mydirname , '/' ) ;


// WYSIWYG (some editor needs global scope ... orz)
$pico_wysiwygs = array( 'name' => 'body' , 'value' => $content4assign['body_raw'] ) ;
include dirname(dirname(__FILE__)).'/include/wysiwyg_editors.inc.php' ;

$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$xoopsModuleConfig['images_dir'] ,
	'mod_config' => $xoopsModuleConfig ,
	'category' => $category4assign ,
	'content' => $content4assign ,
	'content_base' => $content4assign_base ,
	'content_histories' => pico_get_content_histories4assign( $mydirname , $content_id ) ,
	'body_wysiwyg' => $pico_wysiwyg_body ,
	'preview' => $preview4assign ,
	'page' => 'contentmanager' ,
	'formtitle' => _MD_PICO_LINK_EDITCONTENT ,
	'cat_jumpbox_options' => pico_main_make_cat_jumpbox_options( $mydirname , $whr_read4cat , $cat_id ) ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'pico') ,
	'xoops_module_header' => pico_main_render_moduleheader( $mydirname , $xoopsModuleConfig , @$preview4assign['htmlheader'] ) . "\n" . $xoopsTpl->get_template_vars( "xoops_module_header" ) . "\n" . $pico_wysiwyg_header ,
	'xoops_pagetitle' => _MD_PICO_CONTENTMANAGER ,
	'xoops_breadcrumbs' => array_merge( $xoops_breadcrumbs , array( array( 'name' => _MD_PICO_CONTENTMANAGER ) ) ) ,
) ) ;

include XOOPS_ROOT_PATH.'/footer.php';

?>