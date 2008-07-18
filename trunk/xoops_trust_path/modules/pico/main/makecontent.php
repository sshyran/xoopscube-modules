<?php

include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;
require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;

// redirect with POST as SESSION when wraps mode's preview
if( $xoopsModuleConfig['use_wraps_mode'] && ! empty( $_POST['contentman_preview'] ) && empty( $_SESSION[$mydirname.'_preview'] ) ) {
	$link = empty( $_POST['vpath'] ) ? sprintf( _MD_PICO_AUTONAME4SPRINTF , 0 ) : preg_replace( '#[^0-9a-zA-Z_/.+-]#' , '' , $_POST['vpath'] ) ;
	$_SESSION[$mydirname.'_preview'] = $_POST ;
	header( 'Location: '.XOOPS_URL.'/modules/'.$mydirname.'/index.php'.$link.'?page=makecontent&ret='.urlencode(@$_GET['ret']) ) ;
	exit ;
}
if( ! empty( $_SESSION[$mydirname.'_preview'] ) ) {
	$_POST = $_SESSION[$mydirname.'_preview'] ;
	unset( $_SESSION[$mydirname.'_preview'] ) ;
}

// deciding action
$allowed_actions = array( 'contentman_preview' , 'contentman_post' ) ;
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

$cat_id = isset( $_POST['cat_id'] ) ? intval( $_POST['cat_id'] ) : intval( @$_GET['cat_id'] ) ;

// get&check this category ($category4assign, $category_row), override options
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// special check for makecontent
if( ! $category4assign['can_post'] ) die( _MD_PICO_ERR_CREATECONTENT ) ;

// TRANSACTION PART
require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
if( $action == 'post' ) {
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	// create a content
	$content_id = pico_makecontent( $mydirname , $category4assign['post_auto_approved'] , $category4assign['isadminormod'] ) ;
	$content_uri4html = XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content_id , $mydirname ) ;
	// return uri
	if( ! empty( $_GET['ret'] ) && ( $ret_uri = pico_main_parse_ret2uri( $mydirname , $_GET['ret'] ) ) ) {
		$ret_uri4html = htmlspecialchars( $ret_uri , ENT_QUOTES ) ;
	} else {
		$ret_uri4html = $content_uri4html ;
	}
	// calling a delegate
	if( class_exists( 'XCube_DelegateUtils' ) ) {
		XCube_DelegateUtils::call( 'ModuleClass.Pico.Contentman.InsertSuccess' , $mydirname , $content_id , $category4assign , $ret_uri4html ) ;
	}
	if( $category4assign['post_auto_approved'] ) {
		// Notify for new content
		pico_main_trigger_event( 'global' , 0 , 'newcontent' , array( 'CONTENT_URL' => pico_common_unhtmlspecialchars( $content_uri4html ) ) , array() , 0 ) ;
		// message "registered"
		redirect_header( $ret_uri4html , 2 , _MD_PICO_MSG_CONTENTMADE ) ;
	} else {
		// Notify for new waiting content (only for admin or mod)
		$users2notify = pico_main_get_moderators( $mydirname , $cat_id ) ;
		if( empty( $users2notify ) ) $users2notify = array( 0 ) ;
		pico_main_trigger_event( 'global' , 0 , 'waitingcontent' , array( 'CONTENT_URL' => XOOPS_URL."/modules/$mydirname/index.php?page=contentmanager&content_id=$content_id" ) , $users2notify ) ;
		// message "waiting approval"
		redirect_header( $ret_uri4html , 2 , _MD_PICO_MSG_CONTENTWAITINGREGISTER ) ;
	}
	exit ;
}


// FORM PART

// set content4assign as initial data
$content4assign = array(
	'id' => 0 ,
	'vpath' => '' ,
	'subject' => '' ,
	'htmlheader' => '' ,
	'body' => '' ,
	'body_raw' => '' ,
	'filters' => $xoopsModuleConfig['filters'] ,
	'filter_infos' => pico_main_get_filter_infos( $xoopsModuleConfig['filters'] , $category4assign['isadminormod'] ) ,
	'weight' => 0 ,
	'use_cache' => 0 ,
	'visible' => 1 ,
	'show_in_navi' => 1 ,
	'show_in_menu' => 1 ,
	'allow_comment' => 1 ,
	'approval' => $category4assign['post_auto_approved'] ,
	'poster_uid' => $uid ,
	'modifier_uid' => $uid ,
	'created_time' => time() ,
	'modified_time' => time() ,
	'created_time_formatted' => formatTimestamp( time() ) ,
	'modified_time_formatted' => formatTimestamp( time() ) ,
) ;
$content4assign_base = $content4assign ;
$preview4assign = array() ;

if( $action == 'preview' ) {
	// preview (override content4assign by request4assign)
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$request = pico_get_requests4content( $mydirname , $errors = array() , $category4assign['post_auto_approved'] , $category4assign['isadminormod'] ) ;
	$request4assign = array_map( 'htmlspecialchars_ent' , $request ) ;
	$content4assign = $request4assign + $content4assign ;
	$content4assign['filter_infos'] = pico_main_get_filter_infos( $request['filters'] , $category4assign['isadminormod'] ) ;
	$content4assign['body_raw'] = $request['body'] ;
	$preview4assign = array(
		'errors' => $errors ,
		'htmlheader' => $request['htmlheader'] ,
		'subject' => $myts->makeTboxData4Show( $request['subject'] ) ,
		'body' => pico_common_filter_body( $mydirname , $request + array('content_id'=>0) ) ,
	) ;
}

// vpath options
$content4assign['wraps_files'] = array( '' => '---' ) + pico_main_get_wraps_files_recursively( $mydirname , '/' ) ;


// WYSIWYG (some editor needs global scope ... orz)
$pico_wysiwygs = array( 'name' => 'body' , 'value' => $content4assign['body_raw'] ) ;
include dirname(dirname(__FILE__)).'/include/wysiwyg_editors.inc.php' ;

// assign
$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$xoopsModuleConfig['images_dir'] ,
	'mod_config' => $xoopsModuleConfig ,
	'category' => $category4assign ,
	'content' => $content4assign ,
	'content_base' => $content4assign_base ,
	'body_wysiwyg' => $pico_wysiwyg_body ,
	'preview' => $preview4assign ,
	'page' => 'makecontent' ,
	'formtitle' => _MD_PICO_LINK_MAKECONTENT ,
	'cat_jumpbox_options' => pico_main_make_cat_jumpbox_options( $mydirname , $whr_read4cat , $cat_id ) ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'pico') ,
	'xoops_module_header' => pico_main_render_moduleheader( $mydirname , $xoopsModuleConfig , @$preview4assign['htmlheader'] ) . $xoopsTpl->get_template_vars( "xoops_module_header" ) . "\n" . $pico_wysiwyg_header ,
	'xoops_pagetitle' => _MD_PICO_LINK_MAKECONTENT ,
	'xoops_breadcrumbs' => array_merge( $xoops_breadcrumbs , array( array( 'name' => _MD_PICO_LINK_MAKECONTENT ) ) ) ,
) ) ;

include XOOPS_ROOT_PATH.'/footer.php';

?>