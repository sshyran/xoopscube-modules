<?php
// $Id: show_photo.php,v 1.8 2008/08/25 23:37:20 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-08-24 K.OHWADA
// photo_handler -> item_handler
// 2008-08-01 K.OHWADA
// typo summry -> summary
// 2008-07-01 K.OHWADA
// added build_show_is_video()
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_show_photo
//=========================================================
class webphoto_show_photo extends webphoto_base_this
{
	var $_tag_class;
	var $_highlight_class;
	var $_image_class;
	var $_multibyte_class;

	var $_cfg_sort;
	var $_cfg_newdays;
	var $_cfg_popular;
	var $_cfg_nameoruname;

	var $_time_newdays;
	var $_usereal;

	var $_flag_highlight = false;
	var $_keyword_array  = null;

	var $_URL_DEFAULT_IMAGE;
	var $_URL_PIXEL_IMAGE;
	var $_URL_CATEGORY_IMAGE;

	var $_DEFAULT_IMAGE_WIDTH  = 64;
	var $_DEFAULT_IMAGE_HEIGHT = 64;

	var $_WINDOW_MERGIN = 16;
	var $_MAX_SUMMARY   = 100;
	var $_SUMMARY_TAIL  = ' ...';

	var $_MEDIUM_VIDEO    = 'video';
	var $_EXT_FLASH_VIDEO = 'flv';
	var $_EXT_MOBILE_VIDEO_ARRAY = array( '3gp', '3g2' );

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_show_photo( $dirname, $trust_dirname )
{
	$this->webphoto_base_this( $dirname, $trust_dirname );

	$this->_image_class =& webphoto_image_info::getInstance( $dirname, $trust_dirname );

	$this->_tag_class =& webphoto_tag::getInstance( $dirname );
	$this->_tag_class->set_is_japanese( $this->_is_japanese );

	$this->_highlight_class =& webphoto_lib_highlight::getInstance();
	$this->_highlight_class->set_replace_callback( 'webphoto_highlighter_by_class' );
	$this->_highlight_class->set_class( 'webphoto_highlight' );

	$this->_multibyte_class =& webphoto_lib_multibyte::getInstance();
	$this->_multibyte_class->set_ja_kuten(   _WEBPHOTO_JA_KUTEN );
	$this->_multibyte_class->set_ja_dokuten( _WEBPHOTO_JA_DOKUTEN );
	$this->_multibyte_class->set_ja_period(  _WEBPHOTO_JA_PERIOD );
	$this->_multibyte_class->set_ja_comma(   _WEBPHOTO_JA_COMMA );

	$this->_cfg_newdays     = $this->get_config_by_name('newdays');
	$this->_cfg_popular     = $this->get_config_by_name('popular');
	$this->_cfg_nameoruname = $this->get_config_by_name('nameoruname');

	$this->_time_newdays = time() - 86400 * $this->_cfg_newdays ;
	$this->_usereal = ( $this->_cfg_nameoruname == 'name' ) ? 1 : 0 ;

	$this->_URL_DEFAULT_IMAGE  = $this->_MODULE_URL .'/images/exts/default.png';
	$this->_URL_PIXEL_IMAGE    = $this->_MODULE_URL .'/images/icons/pixel_trans.png';
	$this->_URL_CATEGORY_IMAGE = $this->_MODULE_URL .'/images/icons/category.png';

}

function &getInstance( $dirname, $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_show_photo( $dirname, $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// photo show
//---------------------------------------------------------
// Get photo's array to assign into template (light version)
function build_photo_show_basic( $row, $tag_name_array=null )
{
	extract( $row ) ;

	list( $cont_size , $cont_duration )
		= $this->get_file_cont_size_duration( $row );

	list($desc_disp, $summary) = $this->build_show_desc_summary( 
		$row, $this->_flag_highlight, $this->_keyword_array ) ;

	$datetime_disp = $this->mysql_datetime_to_str( $item_datetime );

	$arr = array(
		'photo_id'       => $item_id ,
		'time_cretae'    => $item_time_create,
		'time_update'    => $item_time_update,
		'cat_id'         => $item_cat_id ,
		'uid'            => $item_uid ,
		'datetime'       => $item_datetime,
		'title'          => $item_title ,
		'place'          => $item_place ,
		'equipment'      => $item_equipment ,
		'gmap_latitude'  => $item_gmap_latitude,
		'gmap_longitude' => $item_gmap_longitude,
		'gmap_zoom'      => $item_gmap_zoom,
		'status'         => $item_status ,
		'hits'           => $item_hits ,
		'rating'         => $item_rating ,
		'votes'          => $item_votes ,
		'comments'       => $item_comments ,
		'description'    => $item_description,
		'search'         => $item_search,

		'title_s'        => $this->sanitize( $item_title ) ,
		'place_s'        => $this->sanitize( $item_place ) ,
		'equipment_s'    => $this->sanitize( $item_equipment ) ,
		'uname_s'        => $this->build_show_uname( $item_uid ),

		'time_update_m'       => formatTimestamp( $item_time_update , 'm' ) ,
		'datetime_disp'       => $datetime_disp ,
		'datetime_urlencode'  => $this->rawurlencode_uri_encode_str( $datetime_disp ) ,
		'place_urlencode'     => $this->rawurlencode_uri_encode_str( $item_place ),
		'equipment_urlencode' => $this->rawurlencode_uri_encode_str( $item_equipment ),
		'description_disp'    => $desc_disp ,
		'summary'             => $summary ,
		'cont_exif_disp'      => $this->_item_handler->build_show_exif_disp( $row ) ,

		'tags'      => $this->build_show_tags_from_tag_name_array( $tag_name_array ),
		'is_owner'  => $this->is_photo_owner( $item_uid ),
		'is_video'  => $this->is_video_kind( $row['item_kind'] ) ,

		'cont_size'           => $cont_size ,
		'cont_duration'       => $cont_duration ,
		'cont_size_disp'      => $this->_utility_class->format_filesize( $cont_size, 1 ) ,
		'cont_duration_disp'  => $this->format_time( $cont_duration ) ,
	);

	$show_desc = false;

	if ( $desc_disp ) {
		$show_desc = true;
	}

	$arr2 = array();
	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_TEXT; $i++ ) 
	{
		$name_i      = 'text_'.$i;
		$item_name_i = 'item_'.$name_i;
		$text_i      = $row[ $item_name_i ];
		$text_i_s    = $this->sanitize( $text_i );

		if ( $text_i ) {
			$show_desc = true;
		}

		$arr[ $name_i ]      = $text_i ;
		$arr[ $name_i.'_s' ] = $text_i_s ;

		$arr2[ $i ] = array(
			'lang'   => $this->get_constant( $item_name_i ) ,
			'text'   => $text_i,
			'text_s' => $text_i_s,
		);
	}

	if ( is_array($arr2) && count($arr2) ) {
		$arr['texts'] = $arr2;
	}

	$arr3 = array();
	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_FILE_ID; $i++ ) 
	{
		$name_i      = 'file_url_'.$i;
		$item_name_i = 'item_file_id_'.$i;
		$cont_name_i = 'FILE_KIND_'.$i;

		$url_i   = $this->get_file_url_by_kind( $row, $i );
		$url_i_s = $this->sanitize( $url_i );

		$arr[ $name_i ]      = $url_i ;
		$arr[ $name_i.'_s' ] = $url_i_s ;

		$arr3[ $i ] = array(
			'lang'  => $this->get_constant( $cont_name_i ) ,
			'url'   => $url_i,
			'url_s' => $url_i_s,
		);
	}

	$flash_video_url   = $arr[ 'file_url_'. _C_WEBPHOTO_FILE_KIND_VIDEO_FLASH ] ;
	$docomo_video_url  = $arr[ 'file_url_'. _C_WEBPHOTO_FILE_KIND_VIDEO_DOCOMO ] ;

	$arr['flash_video_url']     = $flash_video_url ;
	$arr['flash_video_url_s']   = $this->sanitize(     $flash_video_url ) ;
	$arr['is_flash_video']      = $this->has_file_url( $flash_video_url ) ;
	$arr['docomo_video_url']    = $docomo_video_url ;
	$arr['docomo_video_url_s']  = $this->sanitize(     $docomo_video_url ) ;
	$arr['is_mobile_video']     = $this->has_file_url( $docomo_video_url ) ;

	if ( is_array($arr3) && count($arr3) ) {
		$arr['urls'] = $arr3;
	}

	$arr['show_desc'] = $show_desc;

	return $arr;
}

// Get photo's array to assign into template (light version)
function build_photo_show_light( $row, $tag_name_array=null )
{
	$arr1 = $this->build_photo_show_basic( $row, $tag_name_array );
	$arr2 = $this->build_show_imgsrc( $row );

	return array_merge( $arr1, $arr2 );
}

// Get photo's array to assign into template (heavy version)
function build_photo_show( $row )
{
	$tag_name_array = $this->get_tag_name_array_by_photoid( $row['item_id'] );
	$arr1 = $this->build_photo_show_light( $row, $tag_name_array );

	extract( $row ) ;

	list( $is_newphoto, $is_updatedphoto )
		= $this->build_show_is_new_updated( $item_time_update, $item_status );

	$arr2 = array(
		'cat_title_s'      => $this->get_cached_cat_value_by_id( $item_cat_id, 'cat_title', true ),
		'cat_text1_s'      => $this->get_cached_cat_value_by_id( $item_cat_id, 'cat_text1', true ),
		'cat_text2_s'      => $this->get_cached_cat_value_by_id( $item_cat_id, 'cat_text2', true ),
		'cat_text3_s'      => $this->get_cached_cat_value_by_id( $item_cat_id, 'cat_text3', true ),
		'cat_text4_s'      => $this->get_cached_cat_value_by_id( $item_cat_id, 'cat_text4', true ),
		'cat_text5_s'      => $this->get_cached_cat_value_by_id( $item_cat_id, 'cat_text5', true ),

		'info_votes'       => $this->build_show_info_vote( $item_rating, $item_votes ) ,
		'rank'             => $this->build_show_rank( $item_rating ) ,
		'can_edit'         => $this->has_editable_by_uid( $item_uid ) ,

		'is_newphoto'      => $is_newphoto ,
		'is_updatedphoto'  => $is_updatedphoto ,
		'is_popularphoto'  => $this->build_show_is_popularphoto( $item_hits ),
		'taf_target_uri'   => $this->build_show_taf_target_uri( $item_id ),
		'taf_mailto'       => $this->build_show_taf_mailto( $item_id ) ,
		'info_morephotos'  => $this->build_show_info_morephotos( $item_uid ),

		'window_x'         => $arr1['photo_width']  + $this->_WINDOW_MERGIN ,
		'window_y'         => $arr1['photo_height'] + $this->_WINDOW_MERGIN ,
	) ;

	return array_merge( $arr1, $arr2 );
}

function build_show_desc_summary( $row, $flag_highlight=false, $keyword_array=null )
{
	$desc = $this->_item_handler->build_show_description_disp( $row );
	$summary= $this->_multibyte_class->build_summary( 
		$desc, $this->_MAX_SUMMARY, $this->_SUMMARY_TAIL, $this->_is_japanese );

	if ( $flag_highlight ) {
		$desc = $this->_highlight_class->build_highlight_keyword_array( $desc, $keyword_array );
	}

	return array($desc, $summary);
}

function build_show_rank( $rating )
{
	return floor( $rating - 0.001 );
}

function build_show_info_vote( $rating, $votes )
{
	if ( $rating > 0 ) {
		if( $votes == 1 ) {
			$votestring = $this->get_constant('ONEVOTE') ;
		} else {
			$votestring = sprintf( $this->get_constant('S_NUMVOTES') , $votes ) ;
		}
		$info_votes = number_format( $rating , 2 ).' ('. $votestring .')';
	} else {
		$info_votes = '0.00 ('.sprintf( $this->get_constant('S_NUMVOTES') , 0 ) . ')' ;
	}
	return $info_votes;
}

function build_show_is_new_updated( $time_update, $status )
{
	$is_newphoto     = false;
	$is_updatedphoto = false;

	if ( $this->_cfg_newdays && ( $time_update > $this->_time_newdays ) ) {
		if ( $status == 1 ) {
			$is_newphoto = true;
		}
		if ( $status == 2 ) {
			$is_updatedphoto = true;
		}
	}

	return array( $is_newphoto, $is_updatedphoto );
}

function build_show_is_popularphoto( $hits )
{
	if ( $this->_cfg_popular && ( $hits >= $this->_cfg_popular ) ) { 
		return true;
	}
	return false;
}

function build_show_info_morephotos( $uid )
{
	return sprintf( $this->get_constant('S_MOREPHOTOS') , $this->build_show_uname( $uid ) );
}

function build_show_uname( $uid )
{
	return $this->get_xoops_uname_by_uid( $uid, $this->_usereal );
}

function build_show_taf_target_uri( $photo_id )
{
	$str = $this->_INDEX_PHP.'/photo/'. $photo_id .'/subject='. $this->get_constant('SUBJECT4TAF');
	return urlencode( $str );
}

function build_show_taf_mailto( $photo_id )
{
	$subject  = $this->get_constant('SUBJECT4TAF');
	$body     = $this->get_constant('SUBJECT4TAF');
	$body    .= $this->_INDEX_PHP.'/photo/'. $photo_id.'/';

// --- effective only in Japanese environment ---
// convert EUC-JP to SJIS
//	$subject = $this->_lang->convert_telafriend_subject($subject);
//	$body    = $this->_lang->convert_telafriend_body($body);

	$subject = rawurlencode($subject);
	$body    = rawurlencode($body);

	$str = 'subject='. $subject .'&amp;body='. $body;
	return $str;
}

function build_show_is_mobile_video( $ext )
{
	if ( in_array( $ext, $this->_EXT_MOBILE_VIDEO_ARRAY ) ) {
		return true ;
	}
	return false ;
}

function format_time( $time )
{
	return $this->_utility_class->format_time( $time, 
		$this->get_constant('HOUR'), $this->get_constant('MINUTE'), $this->get_constant('SECOND') ) ;
}

//---------------------------------------------------------
// image
//---------------------------------------------------------
function build_show_imgsrc( $row )
{
	$ahref_file    = '';
	$imgsrc_photo  = '';
	$imgsrc_thumb  = '';
	$imgsrc_middle = '';
	$is_normal_image = false ;

	$is_image_kind = $this->is_image_kind( $row['item_kind'] );

	list( $cont_url, $cont_width, $cont_height )
		= $this->get_file_u_w_h_by_kind( $row, _C_WEBPHOTO_FILE_KIND_CONT );

	list( $thumb_url, $thumb_width, $thumb_height )
		= $this->get_file_u_w_h_by_kind( $row, _C_WEBPHOTO_FILE_KIND_THUMB );

	list( $middle_url, $middle_width, $middle_height )
		= $this->get_file_u_w_h_by_kind( $row, _C_WEBPHOTO_FILE_KIND_MIDDLE );

	$cont_url_s   = $this->sanitize( $cont_url );
	$thumb_url_s  = $this->sanitize( $thumb_url );
	$middle_url_s = $this->sanitize( $middle_url );

// photo image
	if ( $cont_url_s && $is_image_kind ) {
		$imgsrc_photo = $cont_url_s;

	} elseif ( $middle_url_s ) {
		$imgsrc_photo = $middle_url_s;

	} elseif ( $thumb_url_s ) {
		$imgsrc_photo = $thumb_url_s;

	} else {
		$imgsrc_photo = $this->_URL_DEFAULT_IMAGE;
	}

// thumb image
	if ( $thumb_url_s ) {
		$imgsrc_thumb = $thumb_url_s;

	} elseif ( $cont_url_s && $is_image_kind ) {
		$imgsrc_thumb = $cont_url_s;
		$thumb_width  = $cont_width;
		$thumb_height = $cont_height;

	} else {
		$imgsrc_thumb = $this->_URL_PIXEL_IMAGE;
		$thumb_width  = 1;
		$thumb_height = 1;
	}

	list( $thumb_width, $thumb_height )
		= $this->_image_class->adjust_thumb_size( $thumb_width, $thumb_height );

// middle image
	if ( $middle_url_s ) {
		$imgsrc_middle = $middle_url_s;

	} elseif ( $cont_url_s && $is_image_kind ) {
		$imgsrc_middle = $cont_url_s;
		$middle_width  = $cont_width;
		$middle_height = $cont_height;

	} elseif ( $thumb_url_s ) {
		$imgsrc_middle = $thumb_url_s;
		$middle_width  = $thumb_width;
		$middle_height = $thumb_height;

	} else {
		$imgsrc_middle = $this->_URL_DEFAULT_IMAGE;
		$middle_width  = 1;
		$middle_height = 1;
	}

	list( $middle_width, $middle_height )
		= $this->_image_class->adjust_middle_size( $middle_width, $middle_height );

	if ( $cont_url_s && $is_image_kind ) {
		$is_normal_image = true ;
	}

	$arr = array(
		'cont_url'         => $cont_url ,
		'thumb_url'        => $thumb_url ,
		'middle_url'       => $middle_url ,
		'cont_url_s'       => $cont_url_s ,
		'thumb_url_s'      => $thumb_url_s ,
		'middle_url_s'     => $middle_url_s ,
		'ahref_file'       => $cont_url_s ,
		'imgsrc_photo'     => $imgsrc_photo ,
		'imgsrc_thumb'     => $imgsrc_thumb ,
		'imgsrc_middle'    => $imgsrc_middle ,
		'photo_width'      => $cont_width ,
		'photo_height'     => $cont_height ,
		'middle_width'     => $middle_width ,
		'middle_height'    => $middle_height ,
		'thumb_width'      => $thumb_width ,
		'thumb_height'     => $thumb_height ,
		'is_normal_image'  => $is_normal_image ,
	);
	return $arr;

}

//---------------------------------------------------------
// file handler
//---------------------------------------------------------
function get_file_cont_size_duration( $item_row )
{
	$size     = 0 ;
	$duration = 0 ;

	$cont_row = $this->get_cached_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_CONT );
	if ( is_array($cont_row) ) {
		$size     = $cont_row['file_size'] ;
		$duration = $cont_row['file_duration'] ;
	}
	
	return array( $size, $duration );
}

function get_file_u_w_h_by_kind( $item_row, $kind )
{
	$url    = null ;
	$width  = 0 ;
	$height = 0 ;

	$file_row = $this->get_cached_file_row_by_kind( $item_row, $kind );
	if ( is_array($file_row) ) {
		$url    = $file_row['file_url'] ;
		$width  = $file_row['file_width'] ;
		$height = $file_row['file_height'] ;
	}

	return array( $url, $width, $height );
}

function get_file_url_by_kind( $item_row, $kind )
{
	$file_row = $this->get_cached_file_row_by_kind( $item_row, $kind );
	if ( is_array($file_row) ) {
		return $file_row['file_url'] ;
	}
	return null ;
}

function has_file_url( $url )
{
	if ( $url ) {
		return true ;
	}
	return false ;
}

//---------------------------------------------------------
// tag class
//---------------------------------------------------------
function build_show_tags_from_tag_name_array( $tag_name_array )
{
	return $this->_tag_class->build_show_tags_from_tag_name_array( $tag_name_array );
}

function get_tag_name_array_by_photoid( $photo_id )
{
	return $this->_tag_class->get_tag_name_array_by_photoid( $photo_id );
}

//---------------------------------------------------------
// set
//---------------------------------------------------------
function set_flag_highlight( $val )
{
	$this->_flag_highlight = (bool)$val;
}

function set_keyword_array( $arr )
{
	if ( is_array($arr) ) {
		$this->_keyword_array = $arr;
	}
}

function set_keyword_array_by_get()
{
	$get_keywords = $this->_pathinfo_class->get_text( 'keywords' );
	$this->set_keyword_array( $this->str_to_array( $get_keywords, ' ' ) );
}

// --- class end ---
}

?>