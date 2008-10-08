<?php
// $Id: whatsnew.php,v 1.5 2008/08/25 19:28:05 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-08-24 K.OHWADA
// table_photo -> table_item
// 2008-07-01 K.OHWADA
// used use_pathinfo
// used is_video_mime()
//---------------------------------------------------------

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_inc_whatsnew
//=========================================================
class webphoto_inc_whatsnew extends webphoto_inc_handler
{
	var $_cfg_use_pathinfo = false;

	var $_cat_cached = array();

	var $_FLAG_SUBSTITUTE = false;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_inc_whatsnew()
{
	$this->webphoto_inc_handler();
	$this->set_normal_exts( _C_WEBPHOTO_IMAGE_EXTS );

}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_inc_whatsnew();
	}
	return $instance;
}

function _init( $dirname )
{
	$this->init_handler( $dirname );
	$this->_init_xoops_config( $dirname );

// preload
	$name = strtoupper( '_P_'. $dirname .'_WHATSNEW_SUBSTITUTE' );
	if ( defined( $name ) ) {
		$this->_FLAG_SUBSTITUTE = constant( $name );
	}
}

//---------------------------------------------------------
// public
//---------------------------------------------------------
function whatsnew( $dirname , $limit=0 , $offset=0 )
{
	$this->_init( $dirname );

	$item_rows = $this->_get_item_rows( $limit, $offset );
	if ( !is_array($item_rows) ) {
		return array(); 
	}

	$i   = 0;
	$ret = array();

	foreach( $item_rows as $item_row )
	{
		$cat_title    = null;
		$cont_url     = null;
		$cont_width   = 0;
		$cont_height  = 0;
		$cont_mime    = null;
		$thumb_url    = null;
		$thumb_width  = 0;
		$thumb_height = 0;

		$item_id      = $item_row['item_id'];
		$cat_id       = $item_row['item_cat_id'];
		$time_update  = $item_row['item_time_update'];
		$time_create  = $item_row['item_time_create'];
		$item_kind    = $item_row['item_kind'];

		$cat_row = $this->_get_cat_cached_row_by_id( $cat_id );
		if ( is_array($cat_row) ) {
			$cat_title = $cat_row['cat_title'];
		}

		$cont_row  = $this->get_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_CONT );
		$thumb_row = $this->get_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_THUMB );

		if ( is_array($cont_row) ) {
			$cont_url    = $cont_row['file_url'];
			$cont_width  = $cont_row['file_width'];
			$cont_height = $cont_row['file_height'];
			$cont_mime   = $cont_row['file_mime'];
		}

		if ( is_array($thumb_row) ) {
			$thumb_url    = $thumb_row['file_url'];
			$thumb_width  = $thumb_row['file_width'];
			$thumb_height = $thumb_row['file_height'];
		}

		if ( $this->_cfg_use_pathinfo ) {
			$link     = $this->_MODULE_URL.'/index.php/photo/'.    $item_id .'/' ;
			$cat_link = $this->_MODULE_URL.'/index.php/category/'. $cat_id .'/' ;
		} else {
			$link     = $this->_MODULE_URL.'/index.php?fct=photo&amp;p='.    $item_id ;
			$cat_link = $this->_MODULE_URL.'/index.php?fct=category&amp;p='. $cat_id ;
		}

		$arr = array(
			'link'     => $link ,
			'cat_link' => $cat_link ,
			'title'    => $item_row['item_title'] ,
			'cat_name' => $cat_title ,
			'uid'      => $item_row['item_uid'] ,
			'hits'     => $item_row['item_hits'] ,
			'time'     => $time_update ,

// atom
			'id'          => $item_id ,
			'modified'    => $time_update ,
			'issued'      => $time_create ,
			'created'     => $time_create ,
			'description' => $this->_build_description( $item_row ) ,
		);

		$is_image = $this->is_image_kind( $item_kind );
		$is_video = $this->is_video_kind( $item_kind );

// photo image
		if (( $is_image || $is_video || $this->_FLAG_SUBSTITUTE ) && 
		      $thumb_url ) {
			$arr['image']  = $thumb_url ;
			$arr['width']  = $thumb_width ;
			$arr['height'] = $thumb_height ;
		}

// media rss
		if ( $is_image ) {
			if ( $cont_url ) {
				$arr['content_url']      = $cont_url ;
				$arr['content_width']    = $cont_width ;
				$arr['content_height']   = $cont_height ;
				$arr['content_type']     = $cont_mime ;
			}
			if ( $thumb_url ) {
				$arr['thumbnail_url']    = $thumb_url ;
				$arr['thumbnail_width']  = $thumb_width ;
				$arr['thumbnail_height'] = $thumb_height ;
			}
		}

// geo rss
		if ( $this->_is_gmap( $item_row ) ) {
			$arr['geo_lat']  = floatval( $item_row['item_gmap_latitude'] ) ;
			$arr['geo_long'] = floatval( $item_row['item_gmap_longitude'] ) ;
		}

		$ret[ $i ] = $arr;
		$i++;
	}

	return $ret;
}

//---------------------------------------------------------
// private
//---------------------------------------------------------
function _build_description( $row )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->displayTarea( $row['item_description'] , 0 , 1 , 1 , 1 , 1 , 1 );
}

function _is_gmap( $row )
{
	if (( floatval( $row['item_gmap_latitude'] )  != 0 )||
	    ( floatval( $row['item_gmap_longitude'] ) != 0 )||
	    ( intval(   $row['item_gmap_zoom'] )      != 0 )) {
		return true;
	}
	return false;
}

//---------------------------------------------------------
// handler
//---------------------------------------------------------
function _get_item_rows( $limit=0, $offset=0 )
{
	$sql  = 'SELECT * FROM '. $this->prefix_dirname( 'item' );
	$sql .= ' WHERE item_status > 0 ';
	$sql .= ' ORDER BY item_time_update DESC, item_id DESC';
	return $this->get_rows_by_sql( $sql, $limit, $offset );
}

function _get_cat_cached_row_by_id( $id )
{
	if ( isset( $this->_cat_cached[ $id ] ) ) {
		return  $this->_cat_cached[ $id ];
	}

	$row = $this->get_cat_row_by_id( $id );
	if ( is_array($row) ) {
		$this->_cat_cached[ $id ] = $row;
		return $row;
	}

	return null;
}

//---------------------------------------------------------
// xoops_config
//---------------------------------------------------------
function _init_xoops_config( $dirname )
{
	$config_handler =& webphoto_inc_config::getInstance();
	$config_handler->init( $dirname );

	$this->_cfg_use_pathinfo = $config_handler->get_by_name('use_pathinfo');
}

// --- class end ---
}

?>