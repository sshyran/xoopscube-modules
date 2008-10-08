<?php
// $Id: redothumbs.php,v 1.4 2008/08/25 19:28:05 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-08-24 K.OHWADA
// photo_handler -> item_handler
// 2008-08-15 K.OHWADA
// BUG: undefined method create_thumb_from_photo()
// 2008-07-01 K.OHWADA
// used webphoto_lib_exif
// used create_thumb_from_photo()
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_admin_redothumbs
//=========================================================
class webphoto_admin_redothumbs extends webphoto_base_this
{
	var $_image_class;
	var $_delete_class;
	var $_exif_class;

	var $_post_forceredo ;
	var $_post_removerec ;
	var $_post_resize    ;
	var $_post_exif      ;

	var $_cfg_makethumb    = false ;
	var $_cfg_allownoimage = false ;
	var $_cfg_width        = 0 ;
	var $_cfg_height       = 0 ;

	var $_item_row ;

//	var $_msg_array = array();

	var $_ADMIN_REDO_PHP;

	var $_DEFAULT_SIZE = 10;
	var $_MAX_SIZE     = 1000;
	var $_GMAP_ZOOM    = _C_WEBPHOTO_GMAP_ZOOM ;
	var $_IMAGE_MEDIUM = 'image';

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_admin_redothumbs( $dirname , $trust_dirname )
{
	$this->webphoto_base_this( $dirname , $trust_dirname );

	$this->_image_class  =& webphoto_image_create::getInstance( $dirname , $trust_dirname );
	$this->_delete_class =& webphoto_photo_delete::getInstance( $dirname );
	$this->_exif_class   =& webphoto_lib_exif::getInstance();

	$this->_cfg_makethumb    = $this->get_config_by_name('makethumb');
	$this->_cfg_allownoimage = $this->get_config_by_name( 'allownoimage' );
	$this->_cfg_width        = $this->get_config_by_name('width');
	$this->_cfg_height       = $this->get_config_by_name('height');

	$this->_ADMIN_REDO_PHP = $this->_MODULE_URL .'/admin/index.php?fct=redothumbs';
}

function &getInstance( $dirname , $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_admin_redothumbs( $dirname , $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// main
//---------------------------------------------------------
function main()
{
	$post_submit = $this->_post_class->get_post_text('submit');
	$post_start  = $this->_post_class->get_post_int('start');

	$post_size = $this->_post_class->get_post_int('size') ;
	if( $post_size <= 0 ) {
		$post_size = $this->_DEFAULT_SIZE ;
	} elseif ( $post_size > $this->_MAX_SIZE ) {
		$post_size = $this->_MAX_SIZE ;
	}

	$param = array(
		'start'     => $post_start,
		'size'      => $post_size,
		'forceredo' => $this->_post_class->get_post_int('forceredo'),
		'removerec' => $this->_post_class->get_post_int('removerec'),
		'resize'    => $this->_post_class->get_post_int('resize'),
		'exif'      => $this->_post_class->get_post_int('exif'),
	);

	$result  = null;
	$start   = $post_start;
	$counter = 0;

	$this->_check();

	if( $post_submit ) {
		$this->clear_msg_array();
		$counter = $this->_submit( $param );
		if ( $counter === false ) {
			$msg = 'DB Error <br />'.$this->get_format_error();
			redirect_header( $this->_ADMIN_REDO_PHP, 5, $msg ) ;
			exit();
		}

		$result = $this->get_format_msg_array( false, false, false );
		$start  = $post_start + $post_size ;
	}

// Render forms
	xoops_cp_header() ;
	echo $this->build_admin_menu();
	echo $this->build_admin_title( 'REDOTHUMB' );

	$param['start']   = $start;
	$param['counter'] = $counter;

	$this->_print_form( $param );

	$this->_remove_tmp_files();

	if ( $result ) {
		echo "<br />\n" ;
		echo $result ;
	}

	xoops_cp_footer() ;
}

function _check()
{
// get flag of safe_mode
	$safe_mode_flag = ini_get( "safe_mode" ) ;

// check if the directories of thumbs and photos are same.
	if( $this->_THUMBS_DIR == $this->_PHOTOS_DIR ) {
		die( "The directory for thumbnails is same as for photos." ) ;
	}

// check or make thumbs_dir
	if( $this->_cfg_makethumb && ! is_dir( $this->_THUMBS_DIR ) ) {
		if( $safe_mode_flag ) {
			$msg = 'At first create & chmod 777 "'. $this->_THUMBS_DIR .'" by ftp or shell.' ;
			redirect_header( $this->_ADMIN_INDEX_PHP, 5, $msg);
			exit() ;
		}

		$ret = mkdir( $this->_THUMBS_DIR , 0777 ) ;
		if( ! $ret ) {
			$msg = $this->_THUMBS_DIR.' is not a directory' ;
			redirect_header( $this->_ADMIN_INDEX_PHP, 5, $msg );
			exit() ;
		} else {
			@chmod( $this->_THUMBS_DIR , 0777 ) ;
		}
	}

	return true;
}

function _remove_tmp_files()
{
// Clear tempolary files
	$removed_tmp_num = $this->_image_class->clear_tmp_files_in_tmp_dir();
	if( $removed_tmp_num > 0 ) {
		printf( "<br />"._AM_WEBPHOTO_FMT_NUMBEROFREMOVEDTMPS."<br />\n" , $removed_tmp_num ) ;
	}
}

function _submit( $param )
{
	$post_start            = $param['start'];
	$post_size             = $param['size'];
	$this->_post_forceredo = $param['forceredo'];
	$this->_post_removerec = $param['removerec'];
	$this->_post_resize    = $param['resize'];
	$this->_post_exif      = $param['exif'];

	$item_rows = $this->_item_handler->get_rows_all_asc( $post_size, $post_start );

	$counter = 0 ;

	foreach ( $item_rows as $item_row )
	{
		$this->_item_row = $item_row ;

		$item_id   = $item_row['item_id'] ;
		$item_ext  = $item_row['item_ext'] ;
		$item_kind = $item_row['item_kind'] ;
		$item_exif = $item_row['item_exif'] ;

		$cont_row  = $this->_get_cont_row(  false ) ;
		$thumb_row = $this->_get_thumb_row( false ) ;

		$counter ++ ;
		$this->set_msg_array( ( $counter + $post_start - 1 ) . ') ' ) ;
		$this->set_msg_array( sprintf( _AM_WEBPHOTO_FMT_CHECKING , $item_id ) ) ;

	// Check if the main image exists
		if ( $this->_check_remove_all_files( $cont_row ) ) {
			$this->_remove_all_files( $item_id );
			$this->set_msg_array( "<br />\n" ) ;
			continue ;
		}

	// Check file info
		if ( $this->_check_cont_filesize( $cont_row ) ) {
			$cont_row = $this->_update_cont_filesize( $cont_row ) ;
			if ( ! is_array($cont_row) ) {
				$this->set_msg_array( "<br />\n" ) ;
				continue ;
			}
		}

	// Check if the file is not image
		if ( ! $this->is_image_kind( $item_kind ) ) {
			$this->_update_non_image_type( $item_id, $thumb_row, $item_ext );
			$this->set_msg_array( "<br />\n" ) ;
			continue ;
		}

	// --- nomal image ---

	// get exif
		if ( $this->_check_update_exif( $item_exif ) ) {
			$ret = $this->_update_exif( $item_id );
			if ( !$ret ) {
				$this->set_msg_array( "<br />\n" ) ;
				continue ;
			}
		}

	// Size of main photo
		$image_param = $this->_get_cont_imagesize( $cont_row ) ;
		if ( ! is_array($image_param) ) {
			$this->set_msg_array( "<br />\n" ) ;
			continue ;
		}

		if ( $this->_check_cont_resize( $image_param ) ) {
			$cont_row = $this->_update_cont_resize() ;
			if ( ! is_array($cont_row) ) {
				$this->set_msg_array( "<br />\n" ) ;
				continue ;
			}
		}

	// Check and repair record of the photo if necessary
		if ( $this->_check_cont_image_size( $cont_row ) ) {
			$cont_row = $this->_update_cont_image_size();
			if ( ! is_array($cont_row) ) {
				$this->set_msg_array( "<br />\n" ) ;
				continue ;
			}
		}

	// --- thumb ---
		$this->_update_thumb( $item_id );
		$this->set_msg_array( "<br />\n" ) ;
	}

	return $counter ;
}

function _check_remove_all_files( $cont_row )
{
	if ( !is_array($cont_row) ) {
		if ( $this->_cfg_allownoimage ) {
			return false ;	// allow no image
		}
		return true ;
	}

	$cont_path = $cont_row['file_path'];
	if ( empty($cont_path) ) {
		return true ;
	}

	$cont_file = XOOPS_ROOT_PATH . $cont_path;
	if ( ! $this->check_file( $cont_file ) ) {
		return true ;
	}

	return false ;
}

function _remove_all_files( $item_id )
{
	$this->set_msg_array( _AM_WEBPHOTO_PHOTONOTEXISTS." &nbsp; " ) ;
	if ( $this->_post_removerec ) {
		$this->_delete_class->delete_photo( $item_id );
		$this->set_msg_array( _AM_WEBPHOTO_RECREMOVED ) ;
	} else {
		$this->set_msg_array( _AM_WEBPHOTO_SKIPPED ) ;
	}
}

function _check_cont_filesize( $cont_row )
{
	$cont_size = $cont_row['file_size'];
	if ( $cont_size > 0 ) {
		return false ;
	}
	return true ;
}

function _update_cont_filesize( $cont_row )
{
	$cont_path = $cont_row['file_path'];
	$cont_size = $cont_row['file_size'];
	$cont_file = XOOPS_ROOT_PATH . $cont_path;

	$row_update              = $cont_row ;
	$row_update['file_size'] = filesize( $cont_file );

	$ret = $this->_update_file( $row_update );
	if ( !$ret ) {
		return false ;
	}

	$this->set_msg_array( ' update cont size, ' ) ;
	return $row_update ;
}

function _update_non_image_type( $item_id, $thumb_row, $item_ext )
{
	$thumb_file = null;
	if ( is_array($thumb_row) ) {
		$thumb_path = $thumb_row['file_path'];
		$thumb_file = XOOPS_ROOT_PATH . $thumb_path;
	}

	$this->set_msg_array( ' non-image type ' ) ;

	if ( $thumb_file && $this->check_file( $thumb_file ) ) {
		$this->set_msg_array( _AM_WEBPHOTO_SKIPPED ) ;

	} else {
		$ret1 = $this->_image_class->create_thumb_icon( $item_id, $item_ext );
		$thumb_param = $this->_image_class->get_thumb_param();

		if ( $ret1 == _C_WEBPHOTO_IMAGE_READFAULT ) {
			$this->set_msg_array( _AM_WEBPHOTO_FAILEDREADING ) ;

		} elseif ( $ret1 == _C_WEBPHOTO_IMAGE_SKIPPED ) {
			$this->set_msg_array( _AM_WEBPHOTO_SKIPPED ) ;

		} else {
			if ( is_array($thumb_row) ) {
				$ret2 = $this->_update_file_by_param( $thumb_row, $thumb_param ) ;
				if ( !$ret2 ) {
					return false;
				}
				$this->set_msg_array( _AM_WEBPHOTO_CREATEDTHUMBS ) ;

			} else {
				$newid = $this->_insert_file_by_param( $item_id, $thumb_param );
				if ( !$newid ) {
					return false;
				}
				$ret3 = $this->_update_item_thumbid( $item_id, $newid );
				if ( !$ret3 ) {
					return false;
				}
				$this->set_msg_array( _AM_WEBPHOTO_CREATEDTHUMBS ) ;
			}
		}
	}

	return true ;
}

function _check_update_exif( $item_exif )
{
	if ( $this->_post_exif == 2 ) {
		return true;
	}
	if (( $this->_post_exif == 1 ) && empty( $item_exif ) ) {
		return true;
	}
	return false;
}

function _update_exif( $item_id )
{
	$cont_row  = $this->_get_cont_row() ;
	$cont_path = $cont_row['file_path'];
	$cont_file = XOOPS_ROOT_PATH . $cont_path;

	$exif_info = $this->_exif_class->read_file( $cont_file );
	if ( !is_array($exif_info) ) {
		return true ;	// no action
	}

	$param = array() ;

	$datetime  = $this->exif_to_mysql_datetime( $exif_info );
	$equipment = $exif_info['equipment'] ;
	$latitude  = $exif_info['latitude'] ;
	$longitude = $exif_info['longitude'] ;
	$exif      = $exif_info['all_data'] ;
	if ( $datetime ) {
		$param['item_datetime'] = $datetime ;
	}
	if ( $equipment ) {
		$param['item_equipment'] = $equipment ;
	}
	if ( ( $latitude > 0 )&&( $longitude > 0 ) ) {
		$param['item_gmap_latitude']  = $latitude ;
		$param['item_gmap_longitude'] = $longitude ;
		$param['item_gmap_zoom']      = $this->_GMAP_ZOOM ;
	}
	if ( $exif ) {
		$this->set_msg_array( ' redo exif, ' );
		$param['item_exif'] = $exif ;
	}

	$ret = $this->_update_item_by_param( $item_id, $param );
	if ( !$ret ) {
		return false;
	}

	return true ;
}

function _get_cont_imagesize( $cont_row )
{
	$cont_path = $cont_row['file_path'];
	$cont_file = XOOPS_ROOT_PATH . $cont_path;

	$image_param = $this->_get_image_param( $cont_file ) ;
	if ( !is_array($image_param) ) {
		return false ;
	}

	$width  = $image_param['width'] ;
	$height = $image_param['height'] ;

	$this->set_msg_array( $width .' x '. $height .' .. ' ) ;

	return $image_param ;
}

function _check_cont_resize( $image_param )
{
	$width  = $image_param['width'] ;
	$height = $image_param['height'] ;

	if ( !$this->_post_resize ) {
		return false ;
	}
	if  ( $width > $this->_cfg_width ) {
		return true ;
	}
	if ( $height > $this->_cfg_height ) {
		return true ;
	}
	return false ;
}

function _check_cont_image_size( $cont_row )
{
	$cont_width  = $cont_row['file_width'];
	$cont_height = $cont_row['file_height'];
	$cont_path   = $cont_row['file_path'];
	$cont_file   = XOOPS_ROOT_PATH . $cont_path;

	$image_param = $this->_get_image_param( $cont_file ) ;
	if ( !is_array($image_param) ) {
		return false ;	// no action
	}

	$image_width  = $image_param['width'] ;
	$image_height = $image_param['height'] ;

	if ( $cont_width != $image_width ) {
		return true;
	}
	if ( $cont_height != $image_height ) {
		return true;
	}
	return false;
}

function _update_cont_resize()
{
	$cont_row = $this->_get_cont_row();
	if ( !is_array($cont_row) ) {
		return false ;
	}

	$cont_path = $cont_row['file_path'];
	$cont_file = XOOPS_ROOT_PATH . $cont_path;

	$tmp_file = $this->_TMP_DIR.'/'.uniqid('tmp_') ;
	$this->unlink_file( $tmp_file ) ;

	$this->rename_file( $cont_file , $tmp_file ) ;
	$this->_image_class->cmd_modify_photo( $tmp_file , $cont_file );

	$this->unlink_file( $tmp_file ) ;

	$image_param = $this->_get_image_param( $cont_file ) ;
	if ( !is_array($image_param) ) {
		return false ;
	}

	$cont_row['file_width']  = $image_param['width'] ;
	$cont_row['file_height'] = $image_param['height'] ;
	$cont_row['file_mime']   = $image_param['mime'] ;
	$cont_row['file_size']   = $image_param['size'] ;
	$cont_row['file_medium'] = $image_param['medium'] ;

	$ret = $this->_update_file( $cont_row ) ;
	if ( !$ret ) {
		return false;
	}

	$this->set_msg_array( _AM_WEBPHOTO_PHOTORESIZED.' ' );
	return $cont_row ;
}

function _update_cont_image_size()
{
	$cont_row = $this->_get_cont_row();
	if ( !is_array($cont_row) ) {
		return false ;
	}

	$cont_path = $cont_row['file_path'];
	$cont_file = XOOPS_ROOT_PATH . $cont_path;

	$image_param = $this->_get_image_param( $cont_file ) ;
	if ( !is_array($image_param) ) {
		return false ;
	}

	$cont_row['file_width']  = $image_param['width'] ;
	$cont_row['file_height'] = $image_param['height'] ;
	$cont_row['file_mime']   = $image_param['mime'] ;
	$cont_row['file_size']   = $image_param['size'] ;
	$cont_row['file_medium'] = $image_param['medium'] ;

	$ret = $this->_update_file( $cont_row ) ;
	if ( !$ret ) {
		return false;
	}

	$this->set_msg_array( _AM_WEBPHOTO_SIZEREPAIRED.' ' );
	return $cont_row ;
}

function _update_thumb( $item_id )
{
	$retcode = $this->_exec_update_thumb( $item_id );
	switch( $retcode ) 
	{
		case _C_WEBPHOTO_ERR_DB : 
			return false;
			break ;

		case _C_WEBPHOTO_IMAGE_READFAULT : 
			$this->set_msg_array( _AM_WEBPHOTO_FAILEDREADING ) ;
			break ;

		case _C_WEBPHOTO_IMAGE_CREATED : 
			$this->set_msg_array( _AM_WEBPHOTO_CREATEDTHUMBS ) ;
			break ;

		case _C_WEBPHOTO_IMAGE_COPIED : 
			$this->set_msg_array( _AM_WEBPHOTO_BIGTHUMBS ) ;
			break ;

		case _C_WEBPHOTO_IMAGE_SKIPPED : 
			$this->set_msg_array( _AM_WEBPHOTO_SKIPPED ) ;
			break ;

		case _C_WEBPHOTO_ERR_GET_IMAGE_SIZE : 
			break ;

		default : 
			$this->set_msg_array( 'unexpect return code '. $retocde ) ;
			break ;
	}

	return true;
}

function _exec_update_thumb( $item_id )
{
	$thumb_file = null ;

	$cont_row = $this->_get_cont_row();
	if ( !is_array($cont_row) ) {
		return false ;
	}

	$cont_path = $cont_row['file_path'];
	$cont_ext  = $cont_row['file_ext'];
	$cont_file = XOOPS_ROOT_PATH . $cont_path;

	$thumb_row = $this->_get_thumb_row( false );
	if ( is_array($thumb_row) ) {
		$thumb_path = $thumb_row['file_path'];
		$thumb_file = XOOPS_ROOT_PATH . $thumb_path;
	}

// exist thumb
	if ( $thumb_file && $this->check_file( $thumb_file ) ) {
		$image_param = $this->_get_image_param( $cont_file ) ;
		if ( !is_array($image_param) ) {
			return _C_WEBPHOTO_ERR_GET_IMAGE_SIZE ;
		}

		$thumb_w = $image_param['width'] ;
		$thumb_h = $image_param['height'] ;
		$this->set_msg_array( $thumb_w .' x '. $thumb_h .' .. ' ) ;

		if ( $this->_post_forceredo ) {
			return $this->_create_update_thumb( $item_id, $cont_file, $cont_ext );
		}

// no thumb
	} else {
		if ( $this->_cfg_makethumb ) {
			return $this->_create_update_thumb( $item_id, $cont_file, $cont_ext );
		}
	}

	return _C_WEBPHOTO_IMAGE_SKIPPED ;
}

function _create_update_thumb( $item_id, $cont_file, $cont_ext )
{
	$thumb_row = $this->_get_thumb_row() ;

	$ret1 = $this->_image_class->create_thumb_from_image_file( 
		$cont_file, $item_id, $cont_ext );
	$thumb_param = $this->_image_class->get_thumb_param();

// update recoed
	if ( is_array($thumb_row) ) {
		$ret2 = $this->_update_file_by_param( $thumb_row, $thumb_param ) ;
		if ( !$ret2 ) {
			return _C_WEBPHOTO_ERR_DB ;
		}

// new recoed
	} else {
		$newid = $this->_insert_file_by_param( $item_id, $thumb_param );
		if ( !$newid ) {
			return _C_WEBPHOTO_ERR_DB ;
		}
		$ret3 = $this->_update_item_thumbid( $item_id, $newid );
		if ( !$ret3 ) {
			return _C_WEBPHOTO_ERR_DB ;
		}
	}

	return $ret1 ;
}

function check_file( $file )
{
	if ( $file && file_exists($file) && is_file($file) && !is_dir($file) ) {
		return true;
	}
	return false;
}

//---------------------------------------------------------
// image size
//---------------------------------------------------------
function _get_image_param( $file, $flag_msg=true )
{
	$image_size = GetImageSize( $file ) ;
	if ( !is_array($image_size) ) {
		if ( $flag_msg ) {
			$this->build_set_msg( _AM_WEBPHOTO_ERR_GET_IMAGE_SIZE, true ) ;
		}
		return false ;
	}

	$param = array(
		'width'   => $image_size[0] ,
		'height'  => $image_size[1] ,
		'mime'    => $image_size['mime'] ,
		'size'    => filesize( $file ) ,
		'medium'  => $this->_IMAGE_MEDIUM ,
	);

	return $param ;
}

//---------------------------------------------------------
// update item
//---------------------------------------------------------
function _update_item_thumbid( $item_id, $thumb_id )
{
	$row = $this->_item_handler->get_row_by_id( $item_id );
	$row['item_file_id_2'] = $thumb_id ;

	$ret = $this->_item_handler->update( $row );
	if ( !$ret ) {
		$errors = $this->_item_handler->get_errors() ;
		$this->build_set_msg( 'DB Error' , true , true ) ;
		$this->set_msg_array( $errors ) ;
		$this->set_error( $errors ) ;
		return false ;
	}

	return true ;
}

function _update_item_by_param( $item_id, $param )
{
	$row = $this->_item_handler->get_row_by_id( $item_id );
	$row_update = array_merge( $row, $param );

	$ret = $this->_item_handler->update( $row_update );
	if ( !$ret ) {
		$errors = $this->_item_handler->get_errors() ;
		$this->build_set_msg( 'DB Error' , true , true ) ;
		$this->set_msg_array( $errors ) ;
		$this->set_error( $errors ) ;
		return false ;
	}

	return true ;
}

//---------------------------------------------------------
// insert update file
//---------------------------------------------------------
function _get_cont_row( $flag_msg=true )
{
	$row = $this->get_file_row_by_kind( $this->_item_row, _C_WEBPHOTO_FILE_KIND_CONT );
	if ( !is_array($row) ) {
		if ( $flag_msg ) {
			$this->build_set_msg( ' cannot get cont row, ', true ) ;
		}
		return false ;
	}
	return $row;
}

function _get_thumb_row( $flag_msg=true )
{
	$row = $this->get_file_row_by_kind( $this->_item_row, _C_WEBPHOTO_FILE_KIND_THUMB );
	if ( !is_array($row) ) {
		if ( $flag_msg ) {
			$this->build_set_msg( ' cannot get thumb row, ', true ) ;
		}
		return false ;
	}
	return $row;
}

function _insert_file_by_param( $item_id, $param )
{
	$duration = isset($param['duration']) ? intval($param['duration']) : 0 ;

	$row = $this->_file_handler->create();
	$row['file_item_id']   = $item_id ;
	$row['file_url']       = $param['url'] ;
	$row['file_path']      = $param['path'] ;
	$row['file_name']      = $param['name'] ;
	$row['file_ext']       = $param['ext'] ;
	$row['file_mime']      = $param['mime'] ;
	$row['file_medium']    = $param['medium'] ;
	$row['file_size']      = $param['size'] ;
	$row['file_width']     = $param['width'] ;
	$row['file_height']    = $param['height'] ;
	$row['file_kind']      = $param['kind'] ;
	$row['file_duration']  = $duration ;

	$newid = $this->_file_handler->insert( $row );
	if ( !$newid ) {
		$errors = $this->_file_handler->get_errors() ;
		$this->build_set_msg( 'DB Error' , true , true ) ;
		$this->set_msg_array( $errors ) ;
		$this->set_error( $errors ) ;
		return false ;
	}

	return $newid;
}

function _update_file_by_param( $row, $param )
{
	$duration = isset($param['duration']) ? intval($param['duration']) : 0 ;

	$row['file_time_update'] = time() ;
	$row['file_url']         = $param['url'] ;
	$row['file_path']        = $param['path'] ;
	$row['file_name']        = $param['name'] ;
	$row['file_ext']         = $param['ext'] ;
	$row['file_mime']        = $param['mime'] ;
	$row['file_medium']      = $param['medium'] ;
	$row['file_size']        = $param['size'] ;
	$row['file_width']       = $param['width'] ;
	$row['file_height']      = $param['height'] ;
	$row['file_kind']        = $param['kind'] ;
	$row['file_duration']    = $duration ;

// update
	$ret = $this->_file_handler->update( $row );
	if ( !$ret ) {
		$errors = $this->_file_handler->get_errors() ;
		$this->build_set_msg( 'DB Error' , true , true ) ;
		$this->set_msg_array( $errors ) ;
		$this->set_error( $errors ) ;
		return false ;
	}

	return true ;
}

function _update_file( $row )
{
// update
	$ret = $this->_file_handler->update( $row );
	if ( !$ret ) {
		$errors = $this->_file_handler->get_errors() ;
		$this->build_set_msg( 'DB Error' , true , true ) ;
		$this->set_msg_array( $errors ) ;
		$this->set_error( $errors ) ;
		return false ;
	}
	return true ;
}

//---------------------------------------------------------
// form
//---------------------------------------------------------
function _print_form( $param )
{
	$form =& webphoto_admin_redo_form::getInstance(
		$this->_DIRNAME , $this->_TRUST_DIRNAME );
	$form->print_form_redothumbs( $param );
}

// --- class end ---
}

?>