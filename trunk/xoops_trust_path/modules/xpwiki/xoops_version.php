<?php

$_parentdirname = dirname(__FILE__);
// language file (modinfo.php)
if( file_exists( $_parentdirname.'/language/'.@$xoopsConfig['language'].'/modinfo.php' ) ) {
	include $_parentdirname.'/language/'.@$xoopsConfig['language'].'/modinfo.php' ;
} else if( file_exists( $_parentdirname.'/language/english/modinfo.php' ) ) {
	include $_parentdirname.'/language/english/modinfo.php' ;
}
$constpref = '_MI_' . strtoupper( $mydirname ) ;

include $_parentdirname . '/version.php';

$modversion['name'] = $mydirname ;
$modversion['version'] = $xpwiki_version ;
$modversion['description'] = constant($constpref.'_MODULE_DESCRIPTION') ;
$modversion['credits'] = '&copy; 2006-2008 hypweb.net.';
$modversion['author'] = 'nao-pon' ;
$modversion['help'] = '' ;
$modversion['license'] = 'GPL' ;
$modversion['official'] = 0 ;
$modversion['image'] = 'module_icon.php' ;
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
$modversion['search']['func'] = $mydirname .'_global_search' ;

// Menu
$modversion['hasMain'] = 1 ;

// There are no submenu (use menu moudle instead of mainmenu)
$modversion['sub'] = array() ;

// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Blocks
$modversion['blocks'][1] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_MENUBAR') ,
	'description'	=> constant($constpref.'_BDESC_MENUBAR') ,
	'show_func'		=> 'b_xpwiki_menubar_show' ,
	'edit_func'		=> 'b_xpwiki_block_edit' ,
	'options'		=> $mydirname . '|100%|' ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;
$modversion['blocks'][2] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_FUSEN') ,
	'description'	=> constant($constpref.'_BDESC_FUSEN') ,
	'show_func'		=> 'b_xpwiki_fusen_show' ,
	'edit_func'		=> 'b_xpwiki_block_edit' ,
	'options'		=> $mydirname . '|100%|' ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;
$modversion['blocks'][3] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_NOTIFICATION') ,
	'description'	=> constant($constpref.'_BDESC_NOTIFICATION') ,
	'show_func'		=> 'b_xpwiki_notification_show' ,
	'edit_func'		=> 'b_xpwiki_notification_edit' ,
	'options'		=> $mydirname. '|',
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;
$modversion['blocks'][4] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_A_PAGE') ,
	'description'	=> constant($constpref.'_BDESC_A_PAGE') ,
	'show_func'		=> 'b_xpwiki_a_page_show' ,
	'edit_func'		=> 'b_xpwiki_a_page_edit' ,
	'options'		=> $mydirname . '||100%|' ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

// Comments
$modversion['hasComments'] = 0 ;

// Configs
$modversion['config'][] = array(
	'name'			=> 'comment_dirname' ,
	'title'			=> $constpref.'_COM_DIRNAME' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'comment_forum_id' ,
	'title'			=> $constpref.'_COM_FORUM_ID' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
) ;

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification'] = array(
	'lookup_file' => 'notification.php' ,
	'lookup_func' => "{$mydirname}_notify_iteminfo" ,
	'category' => array(
		array(
			'name' => 'global' ,
			'title' => constant($constpref.'_NOTCAT_GLOBAL') ,
			'description' => constant($constpref.'_NOTCAT_GLOBALDSC') ,
			'subscribe_from' => 'index.php' ,
		) ,
		array(
			'name' => 'page1' ,
			'title' => constant($constpref.'_NOTCAT_PAGE1') ,
			'description' => constant($constpref.'_NOTCAT_PAGE1DSC') ,
			'subscribe_from' => 'index.php' ,
			'item_name' => 'pgid1' ,
		) ,
		array(
			'name' => 'page2' ,
			'title' => constant($constpref.'_NOTCAT_PAGE2') ,
			'description' => constant($constpref.'_NOTCAT_PAGE2DSC') ,
			'subscribe_from' => 'index.php' ,
			'item_name' => 'pgid2' ,
		) ,
		array(
			'name' => 'page' ,
			'title' => constant($constpref.'_NOTCAT_PAGE') ,
			'description' => constant($constpref.'_NOTCAT_PAGEDSC') ,
			'subscribe_from' => 'index.php' ,
			'item_name' => 'pgid' ,
			'allow_bookmark' => 1 ,
		) ,
	) ,
	'event' => array(
		array(
			'name' => 'page_update' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_PAGE_UPDATE') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_UPDATECAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_UPDATECAP') ,
			'mail_template' => 'page_update' ,
			'mail_subject' => constant($constpref.'_NOTIFY_PAGE_UPDATESBJ') ,
		) ,
		array(
			'name' => 'page_update' ,
			'category' => 'page1' ,
			'title' => constant($constpref.'_NOTIFY_PAGE_UPDATE') ,
			'caption' => constant($constpref.'_NOTIFY_PAGE1_UPDATECAP') ,
			'description' => constant($constpref.'_NOTIFY_PAGE1_UPDATECAP') ,
			'mail_template' => 'page_update' ,
			'mail_subject' => constant($constpref.'_NOTIFY_PAGE_UPDATESBJ') ,
		) ,
		array(
			'name' => 'page_update' ,
			'category' => 'page2' ,
			'title' => constant($constpref.'_NOTIFY_PAGE_UPDATE') ,
			'caption' => constant($constpref.'_NOTIFY_PAGE2_UPDATECAP') ,
			'description' => constant($constpref.'_NOTIFY_PAGE2_UPDATECAP') ,
			'mail_template' => 'page_update' ,
			'mail_subject' => constant($constpref.'_NOTIFY_PAGE_UPDATESBJ') ,
		) ,
		array(
			'name' => 'page_update' ,
			'category' => 'page' ,
			'title' => constant($constpref.'_NOTIFY_PAGE_UPDATE') ,
			'caption' => constant($constpref.'_NOTIFY_PAGE_UPDATECAP') ,
			'description' => constant($constpref.'_NOTIFY_PAGE_UPDATECAP') ,
			'mail_template' => 'page_update' ,
			'mail_subject' => constant($constpref.'_NOTIFY_PAGE_UPDATESBJ') ,
		) ,
	) ,
) ;


$modversion['onInstall'] = 'oninstall.php' ;
$modversion['onUpdate'] = 'onupdate.php' ;
$modversion['onUninstall'] = 'onuninstall.php' ;

// Regularization of func_num
if ( defined( 'XOOPS_CUBE_LEGACY' ) && isset( $_GET['action'] ) && $_GET['action'] == 'ModuleUpdate' && isset( $_POST['dirname'] ) && $_POST['dirname'] == $modversion['dirname'] ) {
	include $_parentdirname.'/include/block_reg_funcnum.inc.php';
}

if ( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	// Regularization of func_num
	include $_parentdirname.'/include/block_reg_funcnum.inc.php';
	// keep block's options
	include $_parentdirname.'/include/x20_keepblockoptions.inc.php' ;
}

?>