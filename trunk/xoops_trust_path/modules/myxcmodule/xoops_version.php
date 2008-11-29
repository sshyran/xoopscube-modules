<?php

// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;


$modversion['name'] = $mydirname ;
$modversion['version'] = 1 ;
$modversion['description'] = constant($constpref.'_MODULE_DESCRIPTION') ;
$modversion['credits'] = "";
$modversion['author'] = "" ;
$modversion['help'] = "" ;
$modversion['license'] = "GPL" ;
$modversion['official'] = 0 ;
$modversion['image'] = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = $mydirname ;

// Any tables can't be touched by modulesadmin.
$modversion['sqlfile'] = false ;
$modversion['tables'] = array() ;

// Admin things
$modversion['hasAdmin'] = 1 ;
$modversion['adminindex'] = 'admin/index.php' ;
$modversion['adminmenu'] = 'admin/admin_menu.php' ;

// Search
$modversion['hasSearch'] = 1 ;
$modversion['search']['file'] = 'search.php' ;
$modversion['search']['func'] = $mydirname.'_global_search' ;

// Menu
$modversion['hasMain'] = 1 ;

// There are no submenu (use menu moudle instead of mainmenu)
$modversion['sub'] = array() ;

// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Blocks
$i = 1;
$modversion['blocks'][$i]['file']        = "blocks.php";
$modversion['blocks'][$i]['name']        = constant($constpref.'_BNAME1');
$modversion['blocks'][$i]['description'] = constant($constpref.'_BDESC1');
$modversion['blocks'][$i]['show_func']   = "b_myxcmodule_topics_show";
$modversion['blocks'][$i]['options']     = $mydirname;
$modversion['blocks'][$i]['template']    = "{$mydirname}_block_topics.html";

// Comments
$modversion['hasComments'] = 0 ;

// Configs
$modversion['config'][1] = array(
	'name'			=> 'index_file' ,
	'title'			=> $constpref.'_INDEX_FILE' ,
	'description'	=> $constpref.'_INDEX_FILEDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'index.html' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'index_auto_updated' ,
	'title'			=> $constpref.'_INDEXAUTOUPD' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'index_last_updated' ,
	'title'			=> $constpref.'_INDEXLASTUPD' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'browser_cache' ,
	'title'			=> $constpref.'_BRCACHE' ,
	'description'	=> $constpref.'_BRCACHEDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 3600 ,
	'options'		=> array()
) ;


// Notification
$modversion['hasNotification'] = 0 ;

$modversion['onInstall'] = 'oninstall.php' ;
$modversion['onUpdate'] = 'onupdate.php' ;
$modversion['onUninstall'] = 'onuninstall.php' ;


?>
