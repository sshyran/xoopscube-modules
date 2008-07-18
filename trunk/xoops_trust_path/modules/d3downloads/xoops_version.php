<?php

// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$modversion['name'] = $mydirname ;
$modversion['version'] = 0.97 ;
$modversion['description'] = constant($constpref.'_DESC') ;
$modversion['credits'] = "photosite";
$modversion['author'] = "photosite(http://www.photositelinks.com/)" ;
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

// Submenu (just for mainmenu)
require_once dirname(__FILE__).'/include/common_functions.php' ;
$i= 1 ;
if( is_object( @$GLOBALS['xoopsModule'] ) && $GLOBALS['xoopsModule']->getVar('dirname') == $mydirname ) {
	$submenu = d3download_submenu( $mydirname );
	if( ! empty( $submenu ) ) {
		foreach( $submenu as $categories ) {
			$modversion['sub'][$i]['name'] = $categories['name'];
			$modversion['sub'][$i]['url']  = $categories['url'];
			$i++;
		}
	}
}

$modversion['sub'][$i]['name'] = constant($constpref.'_SMNAME1');
$modversion['sub'][$i]['url']  = 'index.php?page=topten&amp;hit=1';
$i++;
$modversion['sub'][$i]['name'] = constant($constpref.'_SMNAME2');
$modversion['sub'][$i]['url']  = 'index.php?page=topten&amp;rate=1';

// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Blocks
$modversion['blocks'] = array() ;
$modversion['blocks'][1] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_RECENT') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_recent_show' ,
	'edit_func'		=> 'b_d3downloads_recent_edit' ,
	'options'		=> "$mydirname|10|25|Y/m/d|1|" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][2] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_TOPRANK') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_toprank_show' ,
	'edit_func'		=> 'b_d3downloads_toprank_edit' ,
	'options'		=> "$mydirname||d.hits DESC|10|25|Y/m/d|1|" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][3] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_DOWNLOAD') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_download_show' ,
	'edit_func'		=> 'b_d3downloads_download_edit' ,
	'options'		=> "$mydirname||" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][4] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_LIST') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_list_show' ,
	'edit_func'		=> 'b_d3downloads_list_edit' ,
	'options'		=> "$mydirname||d.date DESC|10|Y/m/d|0|" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

// Comments
$modversion['hasComments'] = 0 ;

// Configs
$modversion['config'][1] = array(
	'name'			=> 'popular' ,
	'title'			=> $constpref.'_POPULAR' ,
	'description'	=> $constpref.'_POPULARDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '100' ,
	'options'		=> array('5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000)
) ;
$modversion['config'][] = array(
	'name'			=> 'newdownloads' ,
	'title'			=> $constpref.'_NEWDLS' ,
	'description'	=> $constpref.'_NEWDLSDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'newmark' ,
	'title'			=> $constpref.'_NEWMARK' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'perpage' ,
	'title'			=> $constpref.'_PERPAGE' ,
	'description'	=> $constpref.'_PERPAGEDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'show_breadcrumbs' ,
	'title'			=> $constpref.'_BREADCRUMBS' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'useshots' ,
	'title'			=> $constpref.'_USESHOTS' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'usealbum' ,
	'title'			=> $constpref.'_USEALBUM' ,
	'description'	=> $constpref.'_USEALBUMDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'albumselect' ,
	'title'			=> $constpref.'_ALBUMSELECT' ,
	'description'	=> $constpref.'_ALBUMSELECTDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'txt' ,
	'default'		=>  '' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'shotselect' ,
	'title'			=> $constpref.'_SHOTSSELECT' ,
	'description'	=> $constpref.'_SHOTSSELECTDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'shotwidth' ,
	'title'			=> $constpref.'_SHOTWIDTH' ,
	'description'	=> $constpref.'_SHOTWIDTHDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 128 ,
	'options'		=> array('256' => 256,'128' => 128, '90' => 90, '60' => 60)
) ;
$modversion['config'][] = array(
	'name'			=> 'check_url' ,
	'title'			=> $constpref.'_CHECKURL' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'check_host' ,
	'title'			=> $constpref.'_CHECKHOST' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$xoops_url = parse_url(XOOPS_URL);
$modversion['config'][] = array(
	'name'			=> 'referers' ,
	'title'			=> $constpref.'_REFERERS' ,
	'description'	=> $constpref.'_REFERERSDSC' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'array' ,
	'default'		=> array($xoops_url['host']) ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'allow_extension' ,
	'title'			=> $constpref.'_EXTENSION' ,
	'description'	=> $constpref.'_EXTENSIONDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'zip|tgz|lzh|cab|bz2|xls|doc|pdf' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'maxfilesize' ,
	'title'			=> $constpref.'_MAXFILESIZE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1000' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'check_multiple_dot' ,
	'title'			=> $constpref.'_MULTIDOT' ,
	'description'	=> $constpref.'_MULTIDOTDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'validate_of_head' ,
	'title'			=> $constpref.'_CHECKHEAD' ,
	'description'	=> $constpref.'_CHECKHEADDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'body_editor' ,
	'title'			=> $constpref.'_EDITOR' ,
	'description'	=> $constpref.'_EDITORDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'xoopsdhtml' ,
	'options'		=> array( 'xoopsdhtml' => 'xoopsdhtml' , 'common/fckeditor' => 'common_fckeditor' )
) ;
$modversion['config'][] = array(
	'name'			=> 'use_htmlpurifier' ,
	'title'			=> $constpref.'_PURIFIER' ,
	'description'	=> $constpref.'_PURIFIERDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'select_platform' ,
	'title'			=> $constpref.'_PLATFORM' ,
	'description'	=> $constpref.'_PLATFORMDSC' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'Windows|Unix|Mac|Xoops 2.0x|XOOPS Cube Legacy 2.1x' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'use_tell_a_frined' ,
	'title'			=> $constpref.'_TELLAFRINED' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'per_rss' ,
	'title'			=> $constpref.'_PER_RSS' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 10 ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'history' ,
	'title'			=> $constpref.'_PER_HISTORY' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 10 ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20)
) ;
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
$modversion['config'][] = array(
	'name'			=> 'comment_view' ,
	'title'			=> $constpref.'_COM_VIEW' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'listposts_flat' ,
	'options'		=> array( '_FLAT' => 'listposts_flat' , '_THREADED' => 'listtopics' )
) ;


// Notification
$modversion['hasNotification'] = 1;
$modversion['notification'] = array(
	'lookup_file' => 'notification.php' ,
	'lookup_func' => "{$mydirname}_notify_iteminfo" ,
	'category' => array(
		array(
			'name' => 'category' ,
			'title' => constant($constpref.'_NOTCAT_CAT') ,
			'description' => constant($constpref.'_NOTCAT_CATDSC') ,
			'subscribe_from' => 'index.php' ,
			'item_name' => 'cid' ,
			'allow_bookmark' => 1 ,
		) ,
		array(
			'name' => 'global' ,
			'title' => constant($constpref.'_NOTCAT_GLOBAL') ,
			'description' => constant($constpref.'_NOTCAT_GLOBALDSC') ,
			'subscribe_from' => 'index.php' ,
		) ,
	) ,
	'event' => array(
		array(
			'name' => 'newpost' ,
			'category' => 'category' ,
			'title' => constant($constpref.'_NOTIFY_CAT_NEWPOST') ,
			'caption' => constant($constpref.'_NOTIFY_CAT_NEWPOSTCAP') ,
			'description' => constant($constpref.'_NOTIFY_CAT_NEWPOSTCAP') ,
			'mail_template' => 'category_newpost' ,
			'mail_subject' => constant($constpref.'_NOTIFY_CAT_NEWPOSTSBJ') ,
		) ,
		array(
			'name' => 'newpostfull' ,
			'category' => 'category' ,
			'title' => constant($constpref.'_NOTIFY_CAT_NEWPOSTFULL') ,
			'caption' => constant($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP') ,
			'description' => constant($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP') ,
			'mail_template' => 'category_newpostfull' ,
			'mail_subject' => constant($constpref.'_NOTIFY_CATL_NEWPOSTFULLSBJ') ,
		) ,
		array(
			'name' => 'newpost' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOST') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP') ,
			'mail_template' => 'global_newpost' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ') ,
		) ,
		array(
			'name' => 'newcategory' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORY') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP') ,
			'mail_template' => 'global_newcategory' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYSBJ') ,
		) ,
		array(
			'name' => 'waiting' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_WAITING') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_WAITINGCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_WAITINGCAP') ,
			'mail_template' => 'global_waiting' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ') ,
			'admin_only' => 1 ,
		) ,
		array(
			'name' => 'broken' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_BROKEN') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_BROKENCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_BROKENCAP') ,
			'mail_template' => 'global_broken' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_BROKENSBJ') ,
			'admin_only' => 1 ,
		) ,
		array(
			'name' => 'approve' ,
			'category' => 'global' ,
			'invisible' => '1' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_APPROVE') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_APPROVECAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_APPROVECAP') ,
			'mail_template' => 'global_approve' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_APPROVECAPSBJ') ,
		) ,
	) ,
) ;

$modversion['onInstall'] = 'oninstall.php' ;
$modversion['onUpdate'] = 'onupdate.php' ;
$modversion['onUninstall'] = 'onuninstall.php' ;

// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	include dirname(__FILE__).'/include/x20_keepblockoptions.inc.php' ;
}

?>