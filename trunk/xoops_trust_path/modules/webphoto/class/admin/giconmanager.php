<?php
// $Id: giconmanager.php,v 1.4 2008/08/25 20:20:52 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-07-01 K.OHWADA
// used get_my_allowed_mimes()
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_admin_giconmanager
//=========================================================
class webphoto_admin_giconmanager extends webphoto_base_this
{
	var $_gicon_handler;
	var $_upload_class;
	var $_image_class;
	var $_mime_class;

	var $_post_gicon_id;
	var $_post_delgicon;
	var $_tmp_name;
	var $_media_name;

	var $_GICONS_PATH;

	var $_ADMIN_GICON_PHP;

	var $_INFO_Y_DEFAULT = 3;
	var $_ERR_ALLOW_EXTS = null;

	var $_IMAGE_FIELD_NAME  = 'image_file';
	var $_SHADOW_FIELD_NAME = 'shadow_file';
	var $_SHADOW_NAME_EXTRA = 's0';

	var $_TIME_SUCCESS = 1;
	var $_TIME_FAIL    = 5;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_admin_giconmanager( $dirname , $trust_dirname )
{
	$this->webphoto_base_this( $dirname , $trust_dirname );

	$this->_gicon_handler =& webphoto_gicon_handler::getInstance( $dirname );
	$this->_upload_class  =& webphoto_upload::getInstance( $dirname , $trust_dirname );
	$this->_image_class   =& webphoto_image_create::getInstance( $dirname , $trust_dirname );
	$this->_mime_class    =& webphoto_mime::getInstance( $dirname );

	$this->_GICONS_PATH = $this->_config_class->get_gicons_path();

	$this->_ERR_ALLOW_EXTS = 'allowed file type is '. implode( ',' , $this->get_normal_exts() ) ;

	$this->_ADMIN_GICON_PHP = $this->_MODULE_URL .'/admin/index.php?fct=giconmanager';
}

function &getInstance( $dirname , $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_admin_giconmanager( $dirname , $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// main
//---------------------------------------------------------
function main()
{
	$this->_check();

	switch ( $this->_get_action() )
	{
		case 'insert':
			$this->_insert();
			exit();

		case 'update':
			$this->_update();
			exit();

		case 'delete':
			$this->_delete();
			exit();

		default:
			break;
	}

	xoops_cp_header() ;

	echo $this->build_admin_menu();
	echo $this->build_admin_title( 'GICONMANAGER' );

	switch ( $this->_get_disp() )
	{
		case 'edit_form':
			$this->_print_edit_form();
			break;

		case 'new_form':
			$this->_print_new_form();
			break;

		case 'list':
		default:
			$this->_print_list();
			break;
	}

	xoops_cp_footer();
	exit();
}

function _get_action()
{
	$this->_post_gicon_id = $this->_post_class->get_post_get_int( 'gicon_id' );
	$this->_post_delgicon = $this->_post_class->get_post_int('delgicon' );
	$post_action   = $this->_post_class->get_post_text( 'action' );

	if ( $post_action == 'insert' ) {
		return 'insert';
	} elseif ( ( $post_action == 'update' ) && ( $this->_post_gicon_id > 0 ) ) {
		return 'update';
	} elseif ( $this->_post_delgicon > 0 ) {
		return 'delete';
	}

	return 'list';
}

function _get_disp()
{
	$get_disp = $this->_post_class->get_get_text( 'disp' );

	if ( ( $get_disp == 'edit' ) && ( $this->_post_gicon_id > 0 ) ) {
		return 'edit_form';
	} else if( $get_disp == 'new' ) {
		return 'new_form';
	}

	return 'list';
}

//---------------------------------------------------------
// check
//---------------------------------------------------------
function _check()
{
	$ret = $this->_exec_check();
	switch ( $ret )
	{
		case _C_WEBPHOTO_ERR_CHECK_DIR :
			redirect_header( $this->_ADMIN_INDEX_PHP, $this->_TIME_FAIL, $this->get_format_error() );
			exit();

		case 0:
		default;
			break;
	}
}

function _exec_check()
{
	$ret1 = $this->check_dir( $this->_TMP_DIR );
	if ( $ret1 < 0 ) { return $ret1; }

	$ret2 = $this->check_dir( XOOPS_ROOT_PATH . $this->_GICONS_PATH );
	if ( $ret2 < 0 ) { return $ret2; }

	return 0;
}

//---------------------------------------------------------
// insert
//---------------------------------------------------------
function _insert()
{
	if ( ! $this->check_token() ) {
		redirect_header( $this->_ADMIN_GICON_PHP, 3, $this->get_token_errors() );
		exit();
	}

	$ret = $this->_excute_insert();
	switch ( $ret )
	{
		case _C_WEBPHOTO_ERR_DB:
			$msg  = 'DB error <br />';
			$msg .= $this->get_format_error();
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, $msg );
			exit();

		case _C_WEBPHOTO_ERR_UPLOAD;
			$msg  = 'File Upload Error';
			$msg .= '<br />'.$this->get_format_error( false );
			redirect_header( $this->_ADMIN_GICON_PHP , $this->_TIME_FAIL , $msg ) ;
			exit();

		case _C_WEBPHOTO_ERR_FILEREAD:
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, _WEBPHOTO_ERR_FILEREAD ) ;
			exit();

		case _C_WEBPHOTO_ERR_NO_IMAGE;
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, _WEBPHOTO_ERR_NOIMAGESPECIFIED ) ;
			exit();

		case _C_WEBPHOTO_ERR_NOT_ALLOWED_EXT:
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, $this->_ERR_ALLOW_EXTS );
			exit();

		default:
			break;
	}

	redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_SUCCESS, _WEBPHOTO_DBUPDATED );
	exit();

}

function _excute_insert()
{
	$shadow_tmp_name = null;

	$ret1 = $this->_fetch_image( false );
	if ( $ret1 < 0 ) {
		return $ret1;
	} elseif ( $ret1 == 0 ) {
		return _C_WEBPHOTO_ERR_NO_IMAGE;
	}

	$image_tmp_name    = $this->_get_tmp_name();
	$this->_media_name = $this->_get_media_name();

// check image tmp name
	if ( empty($image_tmp_name) ) {
		return _C_WEBPHOTO_ERR_NO_IMAGE;
	}

	$ret2 = $this->_fetch_shadow();
	if ( $ret2 < 0 ) {
		return $ret2;
	} elseif ( $ret2 == 1 ) {
		$shadow_tmp_name = $this->_get_tmp_name();
	}

	$row   = $this->_gicon_handler->create();
	$newid = $this->_gicon_handler->insert( $row );
	if ( !$newid ) { return $newid; }

	$row['gicon_id'] = $newid;
	$row['gicon_time_create'] = time();

	$ret4 = $this->_update_common( $row, $image_tmp_name, $shadow_tmp_name );
	if ( !$ret4 ) { return $ret4; }

	return 0;
}

function _fetch_image( $allow_noimage=false )
{
	list ( $allowed_mimes, $exts ) = $this->_mime_class->get_my_allowed_mimes();

// reject if too big
	$this->_upload_class->init_media_uploader( false, $allowed_mimes, $this->get_normal_exts() );

	$ret = $this->_upload_class->fetch_for_gicon( $this->_IMAGE_FIELD_NAME, $allow_noimage );
	if ( $ret < 0 ) {
		$this->set_error( $this->_upload_class->get_errors() );
	}
	return $ret;
}

function _fetch_shadow()
{
	$ret = $this->_upload_class->fetch_for_gicon( $this->_SHADOW_FIELD_NAME, true );
	if ( $ret < 0 ) {
		$this->set_error( $this->_upload_class->get_errors() );
	}
	return $ret;
}

function _get_tmp_name()
{
	return $this->_upload_class->get_tmp_name();
}

function _get_media_name()
{
	return $this->_upload_class->get_uploader_media_name();
}

function _update_common( $row, $image_tmp_name, $shadow_tmp_name )
{
	$gicon_id = $row['gicon_id'];

	$title = $this->_post_class->get_post_text('gicon_title');

// create image if upload
	if ( $image_tmp_name ) {
		$image_info = $this->_rename_image( $gicon_id, $image_tmp_name, null );
		if ( is_array($image_info) && $image_info['is_image'] ) {
			$image_width  = $image_info['width'] ;
			$image_height = $image_info['height'] ;

			$row['gicon_image_path']   = $image_info['path'] ;
			$row['gicon_image_name']   = $image_info['name'] ;
			$row['gicon_image_ext']    = $image_info['ext'] ;
			$row['gicon_image_width']  = $image_width ;
			$row['gicon_image_height'] = $image_height ;
			$row['gicon_anchor_x']     = $image_width / 2;
			$row['gicon_anchor_y']     = $image_height ;
			$row['gicon_info_x']       = $image_width / 2;
			$row['gicon_info_y']       = $this->_INFO_Y_DEFAULT ;
		}

		if ( empty($title) ) {
			$title = $this->_media_name;
		}
	}

// create shadow if upload
	if ( $shadow_tmp_name ) {
		$shadow_info = $this->_rename_image( $gicon_id, $shadow_tmp_name, $this->_SHADOW_NAME_EXTRA );
		if ( is_array($shadow_info) && $shadow_info['is_image'] ) {
			$row['gicon_shadow_path']   = $shadow_info['path'] ;
			$row['gicon_shadow_name']   = $shadow_info['name'] ;
			$row['gicon_shadow_ext']    = $shadow_info['ext'] ;
			$row['gicon_shadow_width']  = $shadow_info['width'] ;
			$row['gicon_shadow_height'] = $shadow_info['height'] ;
		}
	}

	if ( $title ) {
		$row['gicon_title'] = $title;
	}

	$row['gicon_time_update'] = time();

	$ret3 = $this->_gicon_handler->update( $row );
	if ( !$ret3 ) {
		$this->set_error( $this->_gicon_handler->get_errors() );
		return _C_WEBPHOTO_ERR_DB;
	}

	return 0;
}

function _rename_image( $gicon_id , $tmp_name, $extra=null )
{
	$width    = 0;
	$height   = 0;
	$is_image = false;

	$ext       = $this->parse_ext( $tmp_name );
	$tmp_path  = $this->_TMP_DIR   .'/'. $tmp_name;

	$gicon_name = $this->_image_class->build_photo_name( $gicon_id, $ext, $extra );
	$gicon_path = $this->_GICONS_PATH.'/'. $gicon_name ;
	$gicon_file = XOOPS_ROOT_PATH . $gicon_path ;
	$gicon_url  = XOOPS_URL       . $gicon_path ;

	$this->rename_file( $tmp_path , $gicon_file ) ;

	if ( $this->is_normal_ext( $ext ) ) {
		$size = GetImageSize( $gicon_file ) ;
		if ( is_array($size) ) {
			$width    = $size[0];
			$height   = $size[1];
			$is_image = true;
		}
	}

	$arr = array(
		'url'      => $gicon_url ,
		'path'     => $gicon_path ,
		'name'     => $gicon_name ,
		'ext'      => $ext ,
		'width'    => $width ,
		'height'   => $height ,
		'is_image' => $is_image ,
	);

	return $arr;
}

//---------------------------------------------------------
// update
//---------------------------------------------------------
function _update()
{
	if ( ! $this->check_token() ) {
		redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, $this->get_token_errors() );
		exit();
	}

	$ret = $this->_excute_update();
	switch ( $ret )
	{
		case _C_WEBPHOTO_ERR_NO_RECORD:
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, _AM_WEBPHOTO_ERR_NO_RECORD );
			exit();

		case _C_WEBPHOTO_ERR_DB:
			$msg  = 'DB error <br />';
			$msg .= $this->get_format_error();
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, $msg );
			exit();

		case _C_WEBPHOTO_ERR_UPLOAD;
			$msg  = 'File Upload Error';
			$msg .= '<br />'.$this->get_format_error( false );
			redirect_header( $this->_ADMIN_GICON_PHP , $this->_TIME_FAIL , $msg ) ;
			exit();

		case _C_WEBPHOTO_ERR_FILEREAD:
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, _WEBPHOTO_ERR_FILEREAD ) ;
			exit();

		case _C_WEBPHOTO_ERR_NOT_ALLOWED_EXT:
			redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, $this->_ERR_ALLOW_EXTS );
			exit();

		default:
			break;
	}

	redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_SUCCESS, _WEBPHOTO_DBUPDATED );
	exit();

}

function _excute_update()
{
	$image_tmp_name  = null;
	$shadow_tmp_name = null;

	$post_shadow_del = $this->_post_class->get_post_int( 'shadow_del' );

	$row = $this->_gicon_handler->get_row_by_id( $this->_post_gicon_id );
	if ( !is_array($row) ) {
		return _C_WEBPHOTO_ERR_NO_RECORD;
	}

// set by post
	$row['gicon_anchor_x'] = $this->_post_class->get_post_int('gicon_anchor_x') ;
	$row['gicon_anchor_y'] = $this->_post_class->get_post_int('gicon_anchor_y') ;
	$row['gicon_info_x']   = $this->_post_class->get_post_int('gicon_info_x') ;
	$row['gicon_info_y']   = $this->_post_class->get_post_int('gicon_info_y') ;

	$ret1 = $this->_fetch_image( true );
	if ( $ret1 < 0 ) {
		return $ret1;
	} elseif ( $ret1 == 1 ) {
		$image_tmp_name = $this->_get_tmp_name();
	}

	$ret2 = $this->_fetch_shadow();
	if ( $ret2 < 0 ) {
		return $ret2;
	} elseif ( $ret2 == 1 ) {
		$shadow_tmp_name = $this->_get_tmp_name();
	}

//delete old files
	if ( $post_shadow_del || $shadow_tmp_name ){

// default icons have no name value
		if ( $row['gicon_shadow_path'] && $row['gicon_shadow_name'] ) {
			$this->unlink_file( XOOPS_ROOT_PATH.$row['gicon_shadow_path'] );
			$row['gicon_shadow_path']   = '' ;
			$row['gicon_shadow_name']   = '' ;
			$row['gicon_shadow_ext']    = '' ;
			$row['gicon_shadow_width']  = 0 ;
			$row['gicon_shadow_height'] = 0 ;
		}
	}

	$ret4 = $this->_update_common( $row, $image_tmp_name, $shadow_tmp_name );
	if ( !$ret4 ) { return $ret4; }

	return 0;
}

//---------------------------------------------------------
// delete
//---------------------------------------------------------
function _delete()
{
	$gicon_id = $this->_post_delgicon;

	if ( ! $this->check_token() ) {
		redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, $this->get_token_errors() );
		exit();
	}

	$row = $this->_gicon_handler->get_row_by_id( $gicon_id );
	if ( !is_array($row) ) {
		redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, _AM_WEBPHOTO_ERR_NO_RECORD );
		exit();
	}

// delete image files
// default icons have no name value
	if ( $row['gicon_image_path'] && $row['gicon_image_name'] ) {
		$this->unlink_file( XOOPS_ROOT_PATH.$row['gicon_image_path'] );
	}
	if ( $row['gicon_shadow_path'] && $row['gicon_shadow_name'] ) {
		$this->unlink_file( XOOPS_ROOT_PATH.$row['gicon_shadow_path'] );
	}

	$ret1 = $this->_cat_handler->clear_gicon_id( $gicon_id );
	if ( !$ret1 ) {
		$this->set_error( $this->_cat_handler->get_errors() );
	}

	$ret2 = $this->_photo_handler->clear_gicon_id( $gicon_id );
	if ( !$ret2 ) {
		$this->set_error( $this->_photo_handler->get_errors() );
	}

	$ret3 = $this->_gicon_handler->delete_by_id(    $gicon_id );
	if ( !$ret3 ) {
		$this->set_error( $this->_gicon_handler->get_errors() );
	}

	if ( ! $this->return_code() ) {
		$msg  = 'DB error <br />';
		$msg .= $this->get_format_error();
		redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_FAIL, $msg );
		exit();
	}

	redirect_header( $this->_ADMIN_GICON_PHP, $this->_TIME_SUCCESS, _WEBPHOTO_DBUPDATED );
	exit();
}

//---------------------------------------------------------
// form
//---------------------------------------------------------
function _print_edit_form()
{
	$row = $this->_gicon_handler->get_row_by_id( $this->_post_gicon_id );
	if ( !is_array($row) ) {
		redirect_header( $this->_ADMIN_GICON_PHP , $this->_TIME_FAIL , _AM_WEBPHOTO_ERR_NO_RECORD ) ;
	}

	$this->_print_gicon_form( 'edit' , $row );
}

function _print_new_form()
{
	$row = $this->_gicon_handler->create();

	$this->_print_gicon_form( 'new' , $row );
}

//---------------------------------------------------------
// list
//---------------------------------------------------------
function _print_list()
{
	echo '<p><a href="'. $this->_ADMIN_GICON_PHP .'&amp;disp=new">';
	echo _AM_WEBPHOTO_GICON_ADD;
	echo '</a></p>'."\n" ;

	$rows = $this->_gicon_handler->get_rows_all_asc();

	$this->_print_gicon_list( $rows );

}

//---------------------------------------------------------
// admin_gicon_form
//---------------------------------------------------------
function _print_gicon_form( $mode , $row )
{
	$form =& webphoto_admin_gicon_form::getInstance( 
		$this->_DIRNAME , $this->_TRUST_DIRNAME );
	$form->print_form( $mode, $row );
}

function _print_gicon_list( $rows )
{
	$form =& webphoto_admin_gicon_form::getInstance( 
		$this->_DIRNAME , $this->_TRUST_DIRNAME );
	$form->print_list( $rows );
}

// --- class end ---
}

?>