<?php
// $Id: cat_selbox.php,v 1.1.1.1 2008/06/21 12:22:23 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_cat_selbox
//=========================================================
class webphoto_cat_selbox
{
	var $_cat_handler;
	var $_photo_handler;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_cat_selbox()
{
	// dummy
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_cat_selbox();
	}
	return $instance;
}

function init( $dirname )
{
	$this->_photo_handler = new webphoto_photo_handler( $dirname );
	$this->_cat_handler   = new webphoto_cat_handler(   $dirname );
}

//---------------------------------------------------------
// selbox
//---------------------------------------------------------
function build_selbox( $order='cat_title', $preset_id=0, $none_title='--', $sel_name='cat_id', $onchange='' )
{
	$order = 'cat_title';

	$tree = $this->_cat_handler->get_all_tree_array( $order );
	if ( !is_array($tree) || !count($tree) ) {
		return null;	// no action
	}

	$str = '<select name="'. $sel_name .'" ';
	if ( $onchange != "" ) {
		$str .= ' onchange="'. $onchange .'" ';
	}
	$str .= ">\n";

	if ( $none_title ) {
		$str .= '<option value="0">'. $none_title . "</option>\n";
	}

	foreach ( $tree as $row )
	{
		$catid  = $row['cat_id'];
		$title  = $row['cat_title'];
		$prefix = $row['prefix'];

		$num = $this->_photo_handler->get_count_by_catid( $catid );

		if ( $prefix ) {
			$prefix = str_replace(".", '--', $prefix ).' ';
		}

		$sel = '';
		if ( $catid == $preset_id ) {
			$sel = ' selected="selected" ';
		}

		$str .= '<option value="'. $catid .'" '. $sel .'>';
		$str .= $prefix . $this->sanitize($title) .'('. $num .')';
		$str .= "</option>\n";
	}

	$str .=  "</select>\n";
	return $str;
}

function sanitize( $str )
{
	return htmlspecialchars( $str, ENT_QUOTES );
}

// --- class end ---
}

?>