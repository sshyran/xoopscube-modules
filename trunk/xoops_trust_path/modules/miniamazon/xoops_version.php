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


$modversion['name'] = constant($constpref."_NAME");
$modversion['version'] = floatval($miniamazon_version) ;
$modversion['description'] = constant($constpref."_DESC");
$modversion['credits'] = "NEVER EVER";
$modversion['author'] = "wye [never-ever.info]";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "module_icon.php";
$modversion['dirname'] = $mydirname;

// Database Tables
$modversion['sqlfile'] = false ;
$modversion['tables'] = array() ;


//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;


// Templates
$modversion['templates'] = array() ;


//Block
$modversion['blocks'][1]['file']        = "blocks.php";
$modversion['blocks'][1]['name']        = constant($constpref."_BNAME_NEWITEM") ;
$modversion['blocks'][1]['description'] = "Shows recently added items";
$modversion['blocks'][1]['show_func']   = "b_miniamazon_newitem_show";
$modversion['blocks'][1]['edit_func']   = "b_miniamazon_newitem_edit";
$modversion['blocks'][1]['options']     = "$mydirname|5|20|1";
$modversion['blocks'][1]['template']    = "" ;
$modversion['blocks'][1]['can_clone']   = true ;
$modversion['blocks'][1]['func_num']    = 1;

//ˆê”ÊÝ’è
$modversion['config'][] = array (
    'name' 			=> 'associate_id',
    'title' 		=> $constpref.'_CONF_ID_TITLE',
    'description' 	=> $constpref.'_CONF_ID_DESC',
    'formtype' 		=> 'text',
    'valuetype' 	=> 'text',
    'default' 		=> 'neverever-22',
	'options'		=> array()
);
$modversion['config'][] = array (
    'name' 		=> 'item_num_perpage',
    'title' 		=> $constpref.'_CONF_PP_TITLE',
    'description' 	=> $constpref.'_CONF_PP_DESC',
    'formtype' 		=> 'text',
    'valuetype' 	=> 'int',
    'default' 		=> 10,
	'options'		=> array()
);
$modversion['config'][] = array (
    'name' 			=> 'item_num_strings',
    'title' 		=> $constpref.'_CONF_NS_TITLE',
    'description' 	=> $constpref.'_CONF_NS_DESC',
    'formtype' 		=> 'text',
    'valuetype' 	=> 'int',
    'default'		=> 200,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'comment_allow' ,
	'title'			=> $constpref.'_COM_ALLOW' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'comment_dirname' ,
	'title'			=> $constpref.'_COM_DIRNAME' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '',
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'comment_forum_id' ,
	'title'			=> $constpref.'_COM_FORUM_ID' ,
	'description'	=> '' ,
	'formtype'		=> 'text' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
);


// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = $mydirname."_search";


$modversion['onInstall']   = 'oninstall.php';
$modversion['onUpdate']    = 'onupdate.php';
$modversion['onUninstall'] = 'onuninstall.php';


// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
    include dirname(__FILE__).'/include/updateblock.inc.php' ;
}


?>
