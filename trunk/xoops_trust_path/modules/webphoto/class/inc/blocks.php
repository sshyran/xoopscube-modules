<?php
// $Id: blocks.php,v 1.7 2008/08/25 19:28:05 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-08-24 K.OHWADA
// table_photo -> table_item
// 2008-08-06 K.OHWADA
// added cache_time
// 2008-08-05 K.OHWADA
// BUG: cannot select category
// 2008-07-01 K.OHWADA
// used use_pathinfo
// _assign_xoops_header() -> _get_popbox_js()
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_inc_blocks
//=========================================================
class webphoto_inc_blocks extends webphoto_inc_handler
{
	var $_multibyte_class;

	var $_cfg_use_popbox   = false;
	var $_cfg_use_pathinfo = false;
	var $_cfg_thumb_width  = 0 ;

	var $_URL_DEFUALT_ICON;
	var $_URL_PIXEL_GIF;

	var $_CHECKED  = 'checked="checked"';
	var $_SELECTED = 'selected="selected"';

	var $_CATLIMIT_OPTIONS = null;
	var $_CACHE_OPTIONS    = null;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_inc_blocks()
{
	$this->webphoto_inc_handler();

	$this->_multibyte_class =& webphoto_lib_multibyte::getInstance();

	$this->_CATLIMIT_OPTIONS = array(
		1 => _YES ,
		0 => _NO  ,
	);

	$this->_CACHE_OPTIONS = array(
		'0'       => _NOCACHE, 
		'30'      => sprintf(_SECONDS, 30), 
		'60'      => _MINUTE, 
		'300'     => sprintf(_MINUTES, 5), 
		'1800'    => sprintf(_MINUTES, 30), 
		'3600'    => _HOUR, 
		'18000'   => sprintf(_HOURS, 5), 
		'86400'   => _DAY, 
		'259200'  => sprintf(_DAYS, 3), 
		'604800'  => _WEEK, 
		'2592000' => _MONTH
	);
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_inc_blocks();
	}
	return $instance;
}

//---------------------------------------------------------
// topnews
//
// options
//   0 : dirname
//   1 : photos_num (5)
//   2 : cat_limitation (0)
//   3 : cat_limit_recursive (1)
//   4 : title_max_length (20)
//   5 : cols (1)
//   6 : cache_time (0)
//---------------------------------------------------------
function topnews_show( $options )
{
	$this->_init( $options );
	return $this->_top_show_common( 'topnews', $options );
}

function topnews_p_show( $options )
{
	$this->_init( $options );
	return $this->_top_show_common( 'topnews_p', $options );
}

function topnews_edit( $options )
{
	$this->_init( $options );
	return $this->_top_edit_common( $options ) ;
}

//---------------------------------------------------------
// tophits
//---------------------------------------------------------
function tophits_show( $options )
{
	$this->_init( $options );
	return $this->_top_show_common( 'tophits', $options );
}

function tophits_p_show( $options )
{
	$this->_init( $options );
	return $this->_top_show_common( 'tophits_p', $options );
}

function tophits_edit( $options )
{
	$this->_init( $options );
	return $this->_top_edit_common( $options ) ;
}

//---------------------------------------------------------
// rphoto
//---------------------------------------------------------
function rphoto_show( $options )
{
	$this->_init( $options );
	return $this->_top_show_common( 'rphoto', $options );
}

function rphoto_edit( $options )
{
	$this->_init( $options );
	return $this->_top_edit_common( $options ) ;
}

//---------------------------------------------------------
// common
//---------------------------------------------------------
function _init( $options )
{
	$dirname = $this->_get_option( $options, 0, null ) ;

	$this->init_handler( $dirname );
	$this->_init_xoops_config( $dirname );

	$ICONS_URL               = XOOPS_URL  .'/modules/' .$dirname .'/images/icons';
	$this->_URL_DEFUALT_ICON = $ICONS_URL .'/default.gif';
	$this->_URL_PIXEL_GIF    = $ICONS_URL .'/pixel_trans.gif';
}

function _top_show_common( $mode , $options )
{
	$cache_time        = $this->_get_option_int(  $options, 6 ) ;
	$disable_renderer  = $this->_get_option(      $options, 'disable_renderer', false ) ;
	$show_popbox       = $this->_get_option(      $options, 'show_popbox',      true ) ;

	$use_popbox = ( $show_popbox && $this->_cfg_use_popbox ) ? true : false ;

	list ( $show_popbox_js , $popbox_js )
		= $this->_get_popbox_js( $mode, $use_popbox );

	$template = 'db:'. $this->_DIRNAME .'_block_'. $mode .'.html';

	$tpl = new XoopsTpl();

// set cache time
	if ( $cache_time > 0 ) {
		$tpl->xoops_setCaching(2);
		$tpl->xoops_setCacheTime( $cache_time );
	}

// build block if cache time over
	if ( !$tpl->is_cached( $template ) || ($cache_time == 0) || $show_popbox_js ) {

		$block = $this->_build_block( $mode , $options );
		$block['show_popbox']    = $use_popbox ;
		$block['show_popbox_js'] = $show_popbox_js ;
		$block['popbox_js']      = $popbox_js ;

// return orinal block
		if ( $disable_renderer ) {
			return $block ;
		}

		$tpl->assign( 'block', $block );
	}

	$ret = array();
	$ret['content'] = $tpl->fetch( $template ) ;
	return $ret ;
}

function _build_block( $mode , $options )
{
	$title_max_length  = $this->_get_option_int(  $options, 4, 20 ) ;
	$cols              = $this->_get_option_cols( $options, 5 ) ;

// count begins from
	$count = 1 ;

	$block = array() ;
	$block['dirname']         = $this->_DIRNAME ;
	$block['cols']            = $cols ;
	$block['use_pathinfo']    = $this->_cfg_use_pathinfo ;
	$block['cfg_thumb_width'] = $this->_cfg_thumb_width ;

	$item_rows = $this->_get_item_rows_top_common( $mode , $options );
	if ( !is_array($item_rows) || !count($item_rows) ) {
		$block['photo']     = null ;
		$block['photo_num'] = 0 ;
		return $block ; 
	}

	foreach ( $item_rows as $item_row )
	{
		$arr = array_merge( $item_row, $this->_build_imgsrc( $item_row ) );

		$arr['photo_id']      = $item_row['item_id'] ;
		$arr['title_s']       = $this->sanitize( $item_row['item_title'] ) ;
		$arr['title_short_s'] = $this->_build_short_title( $item_row['item_title'], $title_max_length ) ;
		$arr['hits_suffix']   = $this->_build_hits_suffix( $item_row['item_hits'] ) ;

		$block['photo'][ $count ++ ] = $arr ;
	}

	$block['photo_num'] = $count - 1 ;
	return $block ;
}

function _top_edit_common( $options )
{
	$photos_num          = $this->_get_option_int(  $options, 1, 5 ) ;
	$cat_limitation      = $this->_get_option_int(  $options, 2, 0 ) ;
	$cat_limit_recursive = $this->_get_option_int(  $options, 3, 0 ) ;
	$title_max_length    = $this->_get_option_int(  $options, 4, 20 ) ;
	$cols                = $this->_get_option_cols( $options, 5 ) ;
	$cache_time          = $this->_get_option_int(  $options, 6 ) ;

	$catselbox = $this->_get_catselbox( $cat_limitation , 1 , 'options[2]' ) ;

	$ret  = '<table border="0"><tr><td>'."\n";
	$ret .= 'dirname';
	$ret .= '</td><td>'."\n";
	$ret .= $this->_DIRNAME;
	$ret .= '<input type="hidden" name="options[0]" value="'. $this->_DIRNAME .'" />'."\n";
	$ret .= '</td></tr><tr><td>'."\n";
	$ret .= $this->_constant( 'TEXT_DISP' );
	$ret .= '</td><td>'."\n";
	$ret .= '<input type="text" size="4" name="options[1]" value="'. $photos_num .'" />'."\n";
	$ret .= '</td></tr><tr><td>'."\n";
	$ret .= $this->_constant( 'TEXT_CATLIMITATION' );
	$ret .= '</td><td>'."\n";
	$ret .= $catselbox;
	$ret .= '</td></tr><tr><td>'."\n";
	$ret .= $this->_constant( 'TEXT_CATLIMITRECURSIVE' );
	$ret .= '</td><td>'."\n";
	$ret .= $this->build_form_radio( 'options[3]', $cat_limit_recursive, $this->_CATLIMIT_OPTIONS );
	$ret .= '</td></tr><tr><td>'."\n";
	$ret .= $this->_constant( 'TEXT_STRLENGTH' );
	$ret .= '</td><td>'."\n";
	$ret .= '<input type="text" size="6" name="options[4]" value="'. $title_max_length .'" />'."\n";
	$ret .= '</td></tr><tr><td>'."\n";
	$ret .= $this->_constant( 'TEXT_COLS' );
	$ret .= '</td><td>'."\n";
	$ret .= '<input type="text" size="2" name="options[5]" value="' .$cols .'" />'."\n";
	$ret .= '</td></tr><tr><td>'."\n";
	$ret .= $this->_constant( 'TEXT_CACHETIME' );
	$ret .= '</td><td>'."\n";
	$ret .= $this->build_form_select( 'options[6]', $cache_time, $this->_CACHE_OPTIONS );
	$ret .= '</td></tr></table>'."\n";

	return $ret;
}

function build_form_radio( $name, $value, $options, $del="\n" )
{
	if ( !is_array($options) || !count($options) ) {
		return null;
	}

	$text = '';
	foreach ( $options as $k => $v )
	{
		$checked = '';
		if ( $value == $k ) {
			$checked = $this->_CHECKED;
		}
		$text .= '<input type="radio" name="'. $name .'" value="'. $k .'" '. $checked.' />'."\n";
		$text .= ' ';
		$text .= $v;
		$text .= ' ';
		$text .= $del;
	}
	return $text;
}

function build_form_select( $name, $value, $options, $size=1 )
{
	if ( !is_array($options) || !count($options) ) {
		return null;
	}

	$text = '<select id="'. $name.'" name="'. $name.'" size="'. $size .'">'."\n";
	foreach ( $options as $k => $v )
	{
		$selected = '';
		if ( $value == $k ) {
			$selected = $this->_SELECTED;
		}
		$text .= '<option value="'. $k .'" '. $selected .' >';
		$text .= $v;
		$text .= '</option >'."\n";
	}
	$text .= '</select>'."\n";
	return $text;
}

//---------------------------------------------------------
// private
//---------------------------------------------------------
function _get_option( $options, $num, $default=null )
{
	$val = isset( $options[ $num ] ) ? $options[ $num ] : $default;
	return $val;
}

function _get_option_int( $options, $num, $default=0 )
{
	$val = $this->_get_option( $options, $num, $default );
	return intval( $val );
}

function _get_option_cols( $options, $num )
{
	$val = $this->_get_option_int( $options, $num, 1 );
	if ( $val <= 0 ) {
		$val = 1;
	}
	return $val;
}

function _build_imgsrc( $item_row )
{
	$ahref_file   = '';
	$imgsrc_photo = '';
	$imgsrc_thumb = '';
	$is_normal_image = false ;

	$cont_url     = null;
	$cont_width   = 0;
	$cont_height  = 0;
	$thumb_url    = null;
	$thumb_width  = 0;
	$thumb_height = 0;

	$item_kind = $item_row['item_kind'];

	$cont_row  = $this->get_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_CONT );
	$thumb_row = $this->get_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_THUMB );

	if ( is_array($cont_row) ) {
		$cont_url    = $cont_row['file_url'];
		$cont_width  = $cont_row['file_width'];
		$cont_height = $cont_row['file_height'];
	}

	if ( is_array($thumb_row) ) {
		$thumb_url    = $thumb_row['file_url'];
		$thumb_width  = $thumb_row['file_width'];
		$thumb_height = $thumb_row['file_height'];
	}

	$cont_url_s  = $this->sanitize( $cont_url );
	$thumb_url_s = $this->sanitize( $thumb_url );

// normal exts
	if ( $cont_url_s && $thumb_url_s ) {
		$ahref_file   = $cont_url_s;
		$imgsrc_photo = $cont_url_s;
		$imgsrc_thumb = $thumb_url_s;

// no thumbnail
	} elseif ( $cont_url_s ) {
		$ahref_file   = $cont_url_s;
		$imgsrc_photo = $cont_url_s;
		$imgsrc_thumb = $cont_url_s;

	} else {
		$ahref_file   = $cont_url_s;
		$imgsrc_photo = $this->_URL_DEFUALT_ICON;
		$imgsrc_thumb = $this->_URL_PIXEL_GIF;
		$thumb_width  = 1;
		$thumb_height = 1;
	}

	if ( $cont_url_s && $this->is_image_kind( $item_kind ) ) {
		$is_normal_image = true ;
	}

	$arr = array(
		'ahref_file'       => $ahref_file ,
		'imgsrc_thumb'     => $imgsrc_thumb ,
		'imgsrc_photo'     => $imgsrc_photo ,
		'photo_width'      => $cont_width ,
		'photo_height'     => $cont_height ,
		'thumb_width'      => $thumb_width ,
		'thumb_height'     => $thumb_height ,
		'is_normal_image'  => $is_normal_image ,
	);
	return $arr;

}

function _build_short_title( $str, $max )
{
	if ( $max == 0 ) {
		$str = '';
	} elseif ( strlen( $str ) >= $max ) {
		$str = $this->_shorten_text( $str , $max - 1 );
	}
	return $this->sanitize( $str );
}

function _build_hits_suffix( $hits )
{
	$val = $hits > 1 ? 'hits' : 'hit' ;
	return $val;
}

//---------------------------------------------------------
// langauge
//---------------------------------------------------------
function _constant( $name )
{
	return constant( $this->_constant_name( $name ) );
}

function _constant_name( $name )
{
	return strtoupper( '_BL_' . $this->_DIRNAME . '_' . $name );
}

//---------------------------------------------------------
// multibyte class
//---------------------------------------------------------
function _shorten_text( $str, $max )
{
	return $this->_multibyte_class->sub_str( $str, 0, $max ) .'...';;
}

//---------------------------------------------------------
// database handler
//---------------------------------------------------------
function _get_item_rows_top_common( $mode, $options )
{
	$photos_num          = $this->_get_option_int(  $options, 1, 5 ) ;
	$cat_limitation      = $this->_get_option_int(  $options, 2, 0 ) ;
	$cat_limit_recursive = $this->_get_option_int(  $options, 3, 0 ) ;

	switch( $mode )
	{
		case 'tophits':
		case 'tophits_p':
			$orderby = 'i.item_hits DESC, i.item_id DESC';
			break;

		case 'rphoto':
			$orderby = 'rand()';
			break;

		case 'topnews':
		case 'topnews_p':
		default:
			$orderby = 'i.item_time_update DESC, i.item_id DESC';
			break;
	}

	$table_item = $this->prefix_dirname( 'item' ) ;
	$table_cat  = $this->prefix_dirname( 'cat' ) ;

	// Category limitation
	$where = '' ;
	if ( $cat_limitation ) {
		if ( $cat_limit_recursive ) {

// BUG: cannot select category
			$cattree = new XoopsTree( $table_cat , 'cat_id' , 'cat_pid' ) ;

			$children = $cattree->getAllChildId( $cat_limitation ) ;

			$where = 'i.item_cat_id IN (' ;
			foreach( $children as $child ) {
				$where .= intval($child) . ',' ;
			}
			$where .= intval($cat_limitation) .')' ;

		} else {
			$where = 'i.item_cat_id='. intval($cat_limitation) ;
		}

	}

	$sql  = 'SELECT i.* , c.* ';
	$sql .= 'FROM '. $table_item .' i ';
	$sql .= 'LEFT JOIN '. $table_cat .' c ';
	$sql .= 'ON i.item_cat_id = c.cat_id ';
	$sql .= 'WHERE i.item_status > 0 ';
	if ( $where ) {
		$sql .= 'AND '. $where;
	}
	$sql .= ' ORDER BY '.$orderby;

	return $this->get_rows_by_sql( $sql, $photos_num );
}

function _get_catselbox( $preset_id=0, $none=0, $sel_name='', $onchange='' )
{
	$table_cat = $this->prefix_dirname( 'cat' ) ;

// BUG: cannot select category
	$cattree = new XoopsTree( $table_cat , 'cat_id' , 'cat_pid' ) ;

	ob_start() ;
	$cattree->makeMySelBox( 'cat_title', 'cat_title', $preset_id, $none, $sel_name, $onchange ) ;
	$catselbox = ob_get_contents() ;
	ob_end_clean() ;

	return $catselbox;
}

//---------------------------------------------------------
// xoops header class
//---------------------------------------------------------
function _get_popbox_js( $mode, $show_popbox )
{
	$show_popbox_js = false ;
	$popbox_js      = null ;

	switch( $mode )
	{
		case 'topnews_p':
		case 'tophits_p':
		case 'rphoto':
			$header_class =& webphoto_inc_xoops_header::getInstance();
			$popbox_js = $header_class->assign_or_get_popbox_js( 
				$this->_DIRNAME, $show_popbox, $this->_constant( 'POPBOX_REVERT' ) );
			break;

		default:
			break;
	}

	if ( $popbox_js ) {
		$show_popbox_js = true;
	}

	return array( $show_popbox_js , $popbox_js );
}

//---------------------------------------------------------
// xoops_config
//---------------------------------------------------------
function _init_xoops_config( $dirname )
{
	$config_handler =& webphoto_inc_config::getInstance();
	$config_handler->init( $dirname );

	$this->_cfg_use_popbox   = $config_handler->get_by_name('use_popbox');
	$this->_cfg_use_pathinfo = $config_handler->get_by_name('use_pathinfo');
	$this->_cfg_thumb_width  = $config_handler->get_by_name('thumb_width');
}

// --- class end ---
}

?>