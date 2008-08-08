<?php
// $Id: admin_menu.php,v 1.1.1.1 2008/06/21 12:22:27 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_lib_admin_menu
// base on myalbum's mymenu.php
//=========================================================
class webphoto_lib_admin_menu
{
	var $_DIRNAME;
	var $_MODULE_URL;
	var $_MODULE_DIR;
	var $_TRUST_DIRNAME;
	var $_TRUST_DIR;
	var $_MODULE_ID = 0;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_lib_admin_menu( $dirname , $trust_dirname )
{
	$this->_DIRNAME    = $dirname ;
	$this->_MODULE_URL = XOOPS_URL       .'/modules/'. $dirname;
	$this->_MODULE_DIR = XOOPS_ROOT_PATH .'/modules/'. $dirname;

	$this->_TRUST_DIRNAME = $trust_dirname;
	$this->_TRUST_DIR     = XOOPS_TRUST_PATH .'/modules/'. $trust_dirname;

	$this->_init_xoops_param();
}

function &getInstance( $dirname , $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_lib_admin_menu( $dirname , $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// main
//---------------------------------------------------------
function build_menu()
{

	$admin_menu_class =& webphoto_inc_admin_menu::getInstance();
	$admin_menu = $admin_menu_class->build_menu( $this->_DIRNAME );

	$add_menu = $this->_build_additinal_menu();

	$menu_array = null;
	if ( is_array($admin_menu) && count($admin_menu) &&
	     is_array($add_menu)  && count($add_menu) ) {
		$menu_array = array_merge( $admin_menu, $add_menu );
	} elseif ( is_array($admin_menu) && count($admin_menu) ) {
		$menu_array = $admin_menu;
	} elseif ( is_array($add_menu) && count($add_menu) ) {
		$menu_array = $add_menu ;
	}

	if ( is_array($menu_array) && count($menu_array) ) {
		return $this->_build_highlight( $menu_array );
	}

	return null;
}

function _build_additinal_menu()
{
	// with XOOPS_TRUST_PATH and altsys

	$flag_preferences = false;

	$menu_array = array();

	if ( $this->is_installed_altsys() ) {

// mytplsadmin (TODO check if this module has tplfile)
		if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/mytplsadmin.php' ) ) {
			array_push( $menu_array , array(
				'title' => $this->get_title( 'tplsadmin' ) , 
				'link'  => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin'
			) ) ;
		}

	// myblocksadmin
		if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/myblocksadmin.php' ) ) {
				array_push( $menu_array , array( 
				'title' => $this->get_title( 'blocksadmin' ) ,
				'link'  => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin'
			) ) ;
		}

	// mypreferences
		if( $this->has_xoops_config_this_module() ) {
			if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/mypreferences.php' ) ) {
				$flag_preferences = true;
				array_push( $menu_array , array( 
					'title' => _PREFERENCES ,
					'link'  => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences'
				) ) ;
			}
		}
	}

	// preferences
	if( !$flag_preferences && $this->has_xoops_config_this_module() ) {

	// XOOPS Cube 2.1
		if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
			$link = XOOPS_URL.'/modules/legacy/admin/index.php?action=PreferenceEdit&confmod_id='.$this->_MODULE_ID;

		}

		array_push( $menu_array , array( 
			'title' => _PREFERENCES ,
			'link'  => $link 
		) ) ;
	}

	array_push( $menu_array , array( 
		'title' => $this->get_title( 'goto_module' ) , 
		'link'  => 'index.php',
	) ) ;

	return $menu_array;
}

function _build_highlight( $menu_array )
{
$mymenu_uri = empty( $mymenu_fake_uri ) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri ;
$mymenu_link = substr( strstr( $mymenu_uri , '/admin/' ) , 1 ) ;

	$flag_highlight = false ;

// set gray all
	foreach( array_keys( $menu_array ) as $i )  {
		$menu_array[$i]['color'] = '#DDDDDD' ;
	}

	$post_fct = isset($_POST['fct']) ? $_POST['fct'] : null;
	$fct = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $post_fct ) ;

// highlight
	if ( $fct ) {
		$uri_fct = $mymenu_link.'?fct='.$fct;
		foreach( array_keys( $menu_array ) as $i ) 
		{
			if ( $uri_fct == $menu_array[$i]['link'] ) {
				$menu_array[$i]['selected'] = true ;
				$flag_highlight = true ;
				break ;
			}
		}
	}

	if ( $fct && !$flag_highlight ) {
		$uri_fct = $mymenu_uri.'?fct='.$fct;
		foreach( array_keys( $menu_array ) as $i ) 
		{
			if ( stristr( $uri_fct , $menu_array[$i]['link'] ) ) {
				$menu_array[$i]['selected'] = true ;
				$flag_highlight = true ;
				break ;
			}
		}
	}

	if ( !$flag_highlight ) {
		foreach( array_keys( $menu_array ) as $i ) 
		{
			if ( $mymenu_link == $menu_array[$i]['link'] ) {
				$menu_array[$i]['selected'] = true ;
				$flag_highlight = true ;
				break ;
			}
		}
	}

	if ( !$flag_highlight ) {
		foreach( array_keys( $menu_array ) as $i ) 
		{
			$link = $menu_array[$i]['link'];
			if ( $link != 'admin/index.php' && 
			     strpos( $mymenu_link , $link ) === 0 ) {

				$menu_array[$i]['selected'] = true ;
				$flag_highlight = true ;
				break ;
			}
		}
	}

	if ( !$flag_highlight ) {
		foreach( array_keys( $menu_array ) as $i ) 
		{
			if ( stristr( $mymenu_uri , $menu_array[$i]['link'] ) ) {
				$menu_array[$i]['selected'] = true ;
				break ;
			}
		}
	}

	// link conversion from relative to absolute
	foreach( array_keys( $menu_array ) as $i ) 
	{
		if( stristr( $menu_array[$i]['link'] , XOOPS_URL ) === false ) {
			$menu_array[$i]['link'] = $this->_MODULE_URL .'/'. $menu_array[$i]['link'] ;
		}
	}

	// display
	/*$text = "<div style='text-align:left;width:98%;'>" ;

	foreach( $menu_array as $menuitem ) 
	{
		$text .= "<div style='float:left;height:1.5em;'><nobr>";
		$text .= "<a href='". $this->sanitize( $menuitem['link'] ) ."' style='background-color:". $menuitem['color'] .";font:normal normal bold 9pt/12pt;'>";
		$text .= $this->sanitize( $menuitem['title'] );
		$text .= "</a> | </nobr></div>\n" ;
	}

	$text .= "</div>\n";
	$text .= "<hr style='clear:left;display:block;' />\n" ;

	return $text;*/
	
	// display
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
    'adminmenu' => $menu_array ,
) ) ;
$tpl->display( 'db:altsys_inc_mymenu.html' ) ;
}

//---------------------------------------------------------
// utility
//---------------------------------------------------------
function sanitize( $str )
{
	return htmlspecialchars( $str, ENT_QUOTES );
} 

//---------------------------------------------------------
// language
//---------------------------------------------------------
function get_title( $name )
{
	$const_name = strtoupper( '_AM_'. $this->_TRUST_DIRNAME .'_MYMENU_'. $name );
	$title = defined( $const_name ) ? constant( $const_name ) : $name ;
	return $title;
}

//---------------------------------------------------------
// xoops param
//---------------------------------------------------------
function _init_xoops_param()
{
	global $xoopsModule;
	if ( is_object($xoopsModule) ) {
		$this->_MODULE_ID  = $xoopsModule->mid();
	}
}

function has_xoops_config_this_module()
{
	$config_handler =& xoops_gethandler('config');
	return count( $config_handler->getConfigs( new Criteria( 'conf_modid' , $this->_MODULE_ID ) ) );
}

function get_xoops_module_by_dirname( $dirname )
{
	$module_handler =& xoops_gethandler('module');
	return $module_handler->getByDirname( $dirname );
}

function is_installed_altsys()
{
	$module = $this->get_xoops_module_by_dirname( 'altsys' );
	if ( is_object($module) ) {
		return true;
	}
	return false;
}

// --- class end ---
}

?>