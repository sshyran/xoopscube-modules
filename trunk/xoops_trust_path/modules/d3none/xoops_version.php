<?php
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$modversion['name'] = $mydirname ;
$modversion['version'] = '0.10';
$modversion['description'] = constant($constpref.'_DESC');
$modversion['credits'] = '';
$modversion['author']   = 'manta';
$modversion['help'] = '';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image']    = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname']  = $mydirname ;

// Admin things
$modversion['hasAdmin'] = 0;
$modversion['adminmenu'] = '';

// Menu
$modversion['hasMain'] = 1;

// onInstall, onUpdate, onUninstall
$modversion['onInstall'] = 'oninstall.php' ;~
$modversion['onUpdate'] = 'onupdate.php' ;~
$modversion['onUninstall'] = 'onuninstall.php' ;

?>