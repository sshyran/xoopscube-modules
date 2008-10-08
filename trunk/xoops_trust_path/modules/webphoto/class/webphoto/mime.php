<?php
// $Id: mime.php,v 1.5 2008/08/25 19:28:05 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-08-24 K.OHWADA
// added ext_to_kind()
// 2008-08-01 K.OHWADA
// added get_allowed_mimes_by_groups() is_my_allow_mime()
// 2008-07-01 K.OHWADA
// added is_video_ext()
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_mime
//=========================================================
class webphoto_mime
{
	var $_mime_handler ;
	var $_utility_class ;
	var $_xoops_class ;

	var $_cached_my_allowed_mimes = null;
	var $_cached_mime_array = array();

	var $_IMAGE_MEDIUM = 'image' ;
	var $_VIDEO_MEDIUM = 'video' ;

// asx is meta file (text)
	var $_EXT_ASX = 'asx';

	var $_NORMAL_EXTS ;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_mime( $dirname )
{
	$this->_mime_handler  =& webphoto_mime_handler::getInstance( $dirname );
	$this->_utility_class =& webphoto_lib_utility::getInstance();
	$this->_xoops_class   =& webphoto_xoops_base::getInstance();

	$this->_NORMAL_EXTS = explode( '|', _C_WEBPHOTO_IMAGE_EXTS );
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_mime( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// get mime type
//---------------------------------------------------------
function get_cached_my_allowed_mimes()
{
	if ( is_array( $this->_cached_my_allowed_mimes ) ) {
		    return $this->_cached_my_allowed_mimes;
	}

	$ret = $this->get_my_allowed_mimes();
	$this->_cached_my_allowed_mimes = $ret;

	return $ret;
}

function get_my_allowed_mimes( $limit=0, $offset=0 )
{
	return $this->get_allowed_mimes_by_groups(
		$this->_xoops_class->get_my_user_groups(), $limit, $offset );
}

function get_allowed_mimes_by_groups( $groups, $limit=0, $offset=0 )
{
	$type_arr = array();
	$ext_arr  = array();

	$rows = $this->_mime_handler->get_rows_by_mygroups(
		$groups, $limit, $offset );

	if ( !is_array($rows) || !count($rows) ) {
		return false;
	}

	foreach ( $rows as $row )
	{
		$mime_ext  = $row['mime_ext'];
		$mime_type = $row['mime_type'];

		$ext_arr[] = $mime_ext;

		$temp_arr = $this->str_to_array( $mime_type , ' ' );
		if ( !is_array($temp_arr) || !count($temp_arr) ) { continue; }

		foreach ( $temp_arr as $type ) {
			$type_arr[] = $type;
		}

		$this->_cached_mime_array[ $mime_ext ] = $temp_arr[0];
	}

	$type_arr = array_unique( $type_arr );
	$ext_arr  = array_unique( $ext_arr );

	return array( $type_arr, $ext_arr );
}

function get_cached_mime_type_by_ext( $ext )
{
	if ( isset( $this->_cached_mime_array[ $ext ] ) ) {
		return  $this->_cached_mime_array[ $ext ];
	}

	$row = $this->_mime_handler->get_cached_row_by_ext( $ext );
	if ( !is_array($row) ) {
		return false;
	}

	$mime_arr = $this->str_to_array( $row['mime_type'] , ' ' );
	if ( isset( $mime_arr[0] ) ) {
		$mime = $mime_arr[0];
		$this->_cached_mime_array[ $ext ] = $mime;
		return  $mime ;
	}

	return false;
}

//---------------------------------------------------------
// judge mime type
//---------------------------------------------------------
function ext_to_kind( $ext )
{
	$kind = 0 ;
	if ( $this->is_image_ext( $ext ) ) {
		$kind = _C_WEBPHOTO_ITEM_KIND_IMAGE ;
	} elseif ( $this->is_video_ext( $ext ) ) {
		$kind = _C_WEBPHOTO_ITEM_KIND_VIDEO ;
	}
	return $kind ;
}

function ext_to_mime( $ext )
{
	return $this->get_cached_mime_type_by_ext( $ext );
}

function mime_to_medium( $mime )
{
	$medium = '' ;
	if ( $this->is_image_mime( $mime ) ) {
		$medium = $this->_IMAGE_MEDIUM ;
	} elseif ( $this->is_video_mime( $mime ) ) {
		$medium = $this->_VIDEO_MEDIUM ;
	}
	return $medium ;
}

function is_image_ext( $ext )
{
	return $this->is_normal_ext( $ext );
}

function is_video_ext( $ext )
{
	if ( $ext == $this->_EXT_ASX ) {
		return false;
	}
	return $this->is_video_mime( 
		$this->ext_to_mime( $ext ) );
}

function is_image_mime( $mime )
{
	if ( preg_match('/^image/', $mime ) ) {
		return true;
	}
	return false;
}

function is_video_mime( $mime )
{
	if ( preg_match('/^video/', $mime ) ) {
		return true;
	}
	return false;
}

function get_image_medium()
{
	return $this->_IMAGE_MEDIUM ;
}

function get_video_medium()
{
	return $this->_VIDEO_MEDIUM ;
}

//---------------------------------------------------------
// is my allow mime
//---------------------------------------------------------
function is_my_allow_mime( $mime )
{
	list ( $allowed_mimes, $allowed_exts ) 
		= $this->get_cached_my_allowed_mimes();

	if ( $mime && in_array( strtolower($mime), $allowed_mimes ) ) {
		return true;
	}
	return false;
}

function is_my_allow_ext( $ext )
{
	list ( $allowed_mimes, $allowed_exts ) 
		= $this->get_cached_my_allowed_mimes();

	if ( $ext && in_array( strtolower($ext), $allowed_exts ) ) {
		return true;
	}
	return false;
}

//---------------------------------------------------------
// utility
//---------------------------------------------------------
function is_normal_ext( $ext )
{
	if ( in_array( strtolower( $ext ) , $this->_NORMAL_EXTS ) ) {
		return true;
	}
	return false;
}

function str_to_array( $str, $pattern )
{
	return $this->_utility_class->str_to_array( $str, $pattern );
}

// --- class end ---
}

?>