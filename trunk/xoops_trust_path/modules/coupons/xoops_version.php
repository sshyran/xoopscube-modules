<?php
// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

require_once dirname(__FILE__).'/include/version.php';

$constpref = '_MI_' . strtoupper( $mydirname ) ;

//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
$modversion['name']        = constant($constpref."_NAME") ;
$modversion['version']     = floatval(_COUPONS_VERSION) ;
$modversion['description'] = constant($constpref."_DESC") ;
$modversion['credits']     = "wye , http://never-ever.info/" ;
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
$modversion['blocks'][1]['file']        = "blocks.php";
$modversion['blocks'][1]['name']        = constant($constpref."_BNAME1");
$modversion['blocks'][1]['description'] = "";
$modversion['blocks'][1]['show_func']   = "b_coupons_top_show";
$modversion['blocks'][1]['edit_func']   = "b_coupons_top_edit";
$modversion['blocks'][1]['options']     = "$mydirname|0|10||";//dir,order,num,categ,tpl
$modversion['blocks'][1]['template']    = "";
$modversion['blocks'][1]['can_clone']   = true ;
$modversion['blocks'][1]['func_num']    = 1;


// Menu
$modversion['hasMain'] = 1;


// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = $mydirname."_search";


// Templates
$modversion['templates'] = array() ;


// Configs
$c = 1 ;
$modversion['config'][$c]['name']        = 'datetype';
$modversion['config'][$c]['title']       = $constpref.'_DATE_TYPE';
$modversion['config'][$c]['description'] = $constpref.'_DATE_TYPE_DSC';
$modversion['config'][$c]['formtype']    = 'select';
$modversion['config'][$c]['valuetype']   = 'int';
$modversion['config'][$c]['default']     = 1;
$modversion['config'][$c]['options']     = array( 'YYYY/MM/DD'=>'1' , 'MM/DD/YYYY'=>'2' , 'DD/MM/YYYY'=>'3' );
$c++ ;
$modversion['config'][$c]['name']        = 'addfield';
$modversion['config'][$c]['title']       = $constpref.'_ADDFIELD';
$modversion['config'][$c]['description'] = $constpref.'_ADDFIELDDSC';
$modversion['config'][$c]['formtype']    = 'yesno';
$modversion['config'][$c]['valuetype']   = 'int';
$modversion['config'][$c]['default']     = 0;
$c++ ;
$modversion['config'][$c]['name']        = 'perpage';
$modversion['config'][$c]['title']       = $constpref.'_PERPAGE';
$modversion['config'][$c]['description'] = $constpref.'_PERPAGEDSC';
$modversion['config'][$c]['formtype']    = 'select';
$modversion['config'][$c]['valuetype']   = 'int';
$modversion['config'][$c]['default']     = 10;
$modversion['config'][$c]['options']     = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50);
$c++ ;
$modversion['config'][$c]['name']        = 'qrcode_size' ;
$modversion['config'][$c]['title']       = $constpref.'_QRCODE' ;
$modversion['config'][$c]['description'] = $constpref.'_QRCODEDSC' ;
$modversion['config'][$c]['formtype']    = 'text' ;
$modversion['config'][$c]['valuetype']   = 'int' ;
$modversion['config'][$c]['default']     = 120 ;
$c++ ;
$modversion['config'][$c]['name']        = 'categoryicon_path';
$modversion['config'][$c]['title']       = $constpref.'_CATICON_PATH';
$modversion['config'][$c]['description'] = $constpref.'_CATICON_PATHDESC';
$modversion['config'][$c]['formtype']    = 'textbox';
$modversion['config'][$c]['valuetype']   = 'text';
$modversion['config'][$c]['default']     = "uploads/categories/$mydirname";
$c++ ;
$modversion['config'][$c]['name']        = 'comment_dirname';
$modversion['config'][$c]['title']       = $constpref.'_COM_DIRNAME';
$modversion['config'][$c]['description'] = '';
$modversion['config'][$c]['formtype']    = 'textbox';
$modversion['config'][$c]['valuetype']   = 'text';
$modversion['config'][$c]['default']     = '' ;
$c++ ;
$modversion['config'][$c]['name']        = 'comment_forum_id';
$modversion['config'][$c]['title']       = $constpref.'_COM_FORUM_ID';
$modversion['config'][$c]['description'] = '';
$modversion['config'][$c]['formtype']    = 'text';
$modversion['config'][$c]['valuetype']   = 'int';
$modversion['config'][$c]['default']     = '' ;


// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = $mydirname.'_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = constant($constpref.'_GLOBAL_NOTIFY');
$modversion['notification']['category'][1]['description'] = constant($constpref.'_GLOBAL_NOTIFYDSC');
$modversion['notification']['category'][1]['subscribe_from'] = 'index.php' ;

$modversion['notification']['event'][1]['name'] = 'new_coupon';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = constant($constpref.'_GLOBAL_NEWCOUPON_NOTIFY');
$modversion['notification']['event'][1]['caption'] = constant($constpref.'_GLOBAL_NEWCOUPON_NOTIFYCAP');
$modversion['notification']['event'][1]['description'] = constant($constpref.'_GLOBAL_NEWCOUPON_NOTIFYDSC');
$modversion['notification']['event'][1]['mail_template'] = 'global_newcoupon_notify';
$modversion['notification']['event'][1]['mail_subject'] = constant($constpref.'_GLOBAL_NEWCOUPON_NOTIFYSBJ');

$modversion['notification']['event'][2]['name'] = 'link_coupon';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = constant($constpref.'_GLOBAL_COUPON_DELETE_NOTIFY');
$modversion['notification']['event'][2]['caption'] = constant($constpref.'_GLOBAL_COUPON_DELETE_NOTIFYCAP');
$modversion['notification']['event'][2]['description'] = constant($constpref.'_GLOBAL_COUPON_DELETE_NOTIFYDSC');
$modversion['notification']['event'][2]['mail_template'] = 'global_coupondelete_notify';
$modversion['notification']['event'][2]['mail_subject'] = constant($constpref.'_GLOBAL_COUPON_DELETE_NOTIFYSBJ');


$modversion['onInstall']   = 'include/oninstall.php';
$modversion['onUpdate']    = 'include/onupdate.php';
$modversion['onUninstall'] = 'include/onuninstall.php';


// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
    include dirname(__FILE__).'/include/updateblock.inc.php' ;
}

?>
