<?php
// language file 
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( !file_exists( $langmanpath) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;


$constpref = '_MI_' . strtoupper( $mydirname ) ;

//--------------------------------------------------------------------
$modversion['name']        = constant($constpref."_MODULE_NAME");
$modversion['version']     = 2.11 ;	//2.11e
$modversion['description'] = constant($constpref."_MODULE_DSC");
$modversion['author']      = 'Keiichi Ishida / wye';
$modversion['credits']     = "Web Atelier seedA!! http://www.seedA.jp<br />\n http://never-ever.info/";
$modversion['license']     = 'GPL see LICENSE';
$modversion['official']    = 0;
$modversion['image']       = "module_icon.php";
$modversion['dirname']     = $mydirname;

// Database Tables
$modversion['sqlfile'] = false ;
$modversion['tables'] = array() ;

//admin
$modversion['hasAdmin']    = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

//Menu
$modversion['hasMain']     = 1;

// Templates
$modversion['templates'] = array() ;

//Blocks
$modversion['blocks'][1]['file']        = 'blocks.php';
$modversion['blocks'][1]['name']        = constant($constpref."_BLOCK_NAME");
$modversion['blocks'][1]['description'] = constant($constpref."_BLOCK_DSC");
$modversion['blocks'][1]['show_func']   = "b_treemenu_show";
$modversion['blocks'][1]['options']     = "$mydirname|";
$modversion['blocks'][1]['template']    = '';
$modversion['blocks'][1]['func_num']    = 1;
//B
$modversion['blocks'][2]['file']        = 'blocks.php';
$modversion['blocks'][2]['name']        = constant($constpref."_BLOCK2_NAME");
$modversion['blocks'][2]['description'] = constant($constpref."_BLOCK2_DSC");
$modversion['blocks'][2]['show_func']   = "b_sitemap_show";
$modversion['blocks'][2]['edit_func']   = "b_sitemap_edit";
$modversion['blocks'][2]['options']     = "$mydirname|0|";
$modversion['blocks'][2]['template']    = '';
$modversion['blocks'][2]['can_clone']   = true ;
$modversion['blocks'][2]['func_num']    = 2;

//configuration
$modversion['config'][1]['name']        = 'viewtype';
$modversion['config'][1]['title']       = $constpref.'_VIEWTYPE_TITLE';
$modversion['config'][1]['description'] = $constpref.'_VIEWTYPE_DSC';
$modversion['config'][1]['formtype']    = 'select';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = 2;
$modversion['config'][1]['options']     = array($constpref.'_VIEWTYPE_OPT1' => 1, $constpref.'_VIEWTYPE_OPT2' => 2, $constpref.'_VIEWTYPE_OPT3' => 3, $constpref.'_VIEWTYPE_OPT4' => 4 );
//C
$modversion['config'][2]['name']        = 'targetblank';
$modversion['config'][2]['title']       = $constpref.'_TARGETBLANK_TIT';
$modversion['config'][2]['description'] = $constpref.'_TARGETBLANK_DSC';
$modversion['config'][2]['formtype']    = 'yesno';
$modversion['config'][2]['valuetype']   = 'int';
$modversion['config'][2]['default']     = 1;
$modversion['config'][2]['options']     = array();
//C
$modversion['config'][3]['name']        = 'columns';
$modversion['config'][3]['title']       = $constpref.'_COLUMNS_TITLE';
$modversion['config'][3]['description'] = $constpref.'_COLUMNS_DSC';
$modversion['config'][3]['formtype']    = 'select';
$modversion['config'][3]['valuetype']   = 'int';
$modversion['config'][3]['default']     = 3;
$modversion['config'][3]['options']     = array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7 );


$modversion['onInstall']   = 'oninstall.php';
$modversion['onUpdate']    = 'onupdate.php';
$modversion['onUninstall'] = 'onuninstall.php';


// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
    include dirname(__FILE__).'/include/updateblock.inc.php' ;
}

?>
