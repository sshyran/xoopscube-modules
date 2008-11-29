<?php
// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

include dirname(__FILE__).'/include/version.php';

$constpref = '_MI_' . strtoupper( $mydirname ) ;

//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
$modversion['name']        = constant($constpref."_NAME") ;
$modversion['version']     = floatval($flatdata_version) ;
$modversion['description'] = constant($constpref."_DESC") ;
$modversion['author']      = "wye , http://never-ever.info/" ;
$modversion['credits']     = "FlatData / Never Ever" ;
$modversion['help']        = "" ;
$modversion['license']     = "GPL see LICENSE" ;
$modversion['official']    = 0 ;
$modversion['image']       = "module_icon.php" ;
$modversion['dirname']     = $mydirname ;


// Database Tables
$modversion['sqlfile'] = false ;
$modversion['tables']  = array() ;


// Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";


// Blocks
	$bb=1;
$modversion['blocks'][$bb]['file']        = "blocks.php";
$modversion['blocks'][$bb]['name']        = constant($constpref."_BNAME1");
$modversion['blocks'][$bb]['description'] = "";
$modversion['blocks'][$bb]['show_func']   = "b_flatdata_top_show";
$modversion['blocks'][$bb]['edit_func']   = "b_flatdata_top_edit";
$modversion['blocks'][$bb]['options']     = "$mydirname|0|10|||";//dir|order|num|field|cat|tpl
$modversion['blocks'][$bb]['template']    = "";
$modversion['blocks'][$bb]['can_clone']   = true ;
$modversion['blocks'][$bb]['func_num']    = $bb;
if( defined('XOOPS_CUBE_LEGACY') ){
		$bb++;
	$modversion['blocks'][$bb]['file']        = "blocks.php";
	$modversion['blocks'][$bb]['name']        = constant($constpref."_BNAME2");
	$modversion['blocks'][$bb]['description'] = "";
	$modversion['blocks'][$bb]['show_func']   = "b_flatdata_categ_show";
	$modversion['blocks'][$bb]['edit_func']   = "b_flatdata_categ_edit";
	$modversion['blocks'][$bb]['options']     = "$mydirname|0|" ;//dir|count|tpl
	$modversion['blocks'][$bb]['template']    = "" ;
	$modversion['blocks'][$bb]['can_clone']   = true ;
	$modversion['blocks'][$bb]['func_num']    = $bb;
}

// Menu
$modversion['hasMain'] = 1;


// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = $mydirname."_search";


// Templates
$modversion['templates'] = array() ;


// Configs
	$cc=1;
$modversion['config'][$cc]['name']        = 'number_of_list';
$modversion['config'][$cc]['title']       = $constpref.'_NUM_OF_LIST';
$modversion['config'][$cc]['description'] = $constpref.'_NUM_OF_LIST_D';
$modversion['config'][$cc]['formtype']    = 'textbox';
$modversion['config'][$cc]['valuetype']   = 'int';
$modversion['config'][$cc]['default']     = 20 ;
	$cc++ ;
$modversion['config'][$cc]['name']        = 'embed_disp_perm';
$modversion['config'][$cc]['title']       = $constpref.'_EMBED_DISPPERM';
$modversion['config'][$cc]['description'] = $constpref.'_EMBED_DISPPERM_D';
$modversion['config'][$cc]['formtype']    = 'yesno';
$modversion['config'][$cc]['valuetype']   = 'int';
$modversion['config'][$cc]['default']     = 0;
	$cc++ ;
$modversion['config'][$cc]['name']        = 'use_bbcode';
$modversion['config'][$cc]['title']       = $constpref.'_USE_BBCODE';
$modversion['config'][$cc]['description'] = $constpref.'_USE_BBCODE_D';
$modversion['config'][$cc]['formtype']    = 'yesno';
$modversion['config'][$cc]['valuetype']   = 'int';
$modversion['config'][$cc]['default']     = 0;
/*	$cc++ ;
$modversion['config'][$cc]['name']        = 'use_xcat';
$modversion['config'][$cc]['title']       = $constpref.'_USE_XCAT';
$modversion['config'][$cc]['description'] = $constpref.'_USE_XCAT_D';
$modversion['config'][$cc]['formtype']    = 'yesno';
$modversion['config'][$cc]['valuetype']   = 'int';
$modversion['config'][$cc]['default']     = 0;*/
	$cc++ ;
$modversion['config'][$cc]['name']        = 'xcat_cat_gr';
$modversion['config'][$cc]['title']       = $constpref.'_CAT_GROUP';
$modversion['config'][$cc]['description'] = $constpref.'_CAT_GROUP_D';
$modversion['config'][$cc]['formtype']    = 'textbox';
$modversion['config'][$cc]['valuetype']   = 'int';
$modversion['config'][$cc]['default']     = 0;




$modversion['onInstall']   = 'include/oninstall.php';
$modversion['onUpdate']    = 'include/onupdate.php';
$modversion['onUninstall'] = 'include/onuninstall.php';


// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
    include dirname(__FILE__).'/include/updateblock.inc.php' ;
}

?>