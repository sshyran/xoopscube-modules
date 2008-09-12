<?php

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

// language file (modinfo.php)
/*
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;
*/
$constpref = '_MI_' . strtoupper( $mydirname ) ;


$modversion['name'] = $mydirname ;
$modversion['version'] = 1.6;
$modversion['description'] = constant($constpref.'_MODULE_DESCRIPTION') ;
$modversion['credits'] = "Masahiko Tokita";
$modversion['author'] = "Masahiko Tokita http://tokita.net/" ;
$modversion['help'] = "cinemaru.html" ;
$modversion['license'] = "GPL see LICENSE" ;
$modversion['official'] = 0 ;
//$modversion['image'] = file_exists( 'module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['image'] = 'module_icon.php' ;
$modversion['dirname'] = $mydirname ;

// Any tables can't be touched by modulesadmin.
$modversion['sqlfile'] = false ;
$modversion['tables'] = array() ;

// Admin things
$modversion['hasAdmin'] = 1 ;
$modversion['adminindex'] = 'admin/index.php' ;
$modversion['adminmenu'] = 'admin/menu.php' ;

// Search
$modversion['hasSearch'] = 1 ;
$modversion['search']['file'] = 'include/search.inc.php' ;
$modversion['search']['func'] = $mydirname.'_global_search' ;

// Menu
$modversion['hasMain'] = 1 ;

// There are no submenu (use menu moudle instead of mainmenu)
$modversion['sub'] = array() ;

// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Blocks
$modversion['blocks'][1]['file'] = "cinemaru_block_random.php";
$modversion['blocks'][1]['name'] = constant($constpref.'_BLOCK_RANDOM');
$modversion['blocks'][1]['description'] = "CINEMARU BLOCK RANDOM";
$modversion['blocks'][1]['show_func'] = "b_cinemaru_block_random";
$modversion['blocks'][1]['template'] = $mydirname . "_block_random.html";
$modversion['blocks'][1]['options'] = "{$mydirname}";

$modversion['blocks'][2]['file'] = "cinemaru_block_thumb.php";
$modversion['blocks'][2]['name'] = constant($constpref.'_BLOCK_THUMB');
$modversion['blocks'][2]['description'] = "CINEMARU BLOCK THUMB";
$modversion['blocks'][2]['show_func'] = "b_cinemaru_block_thumb";
$modversion['blocks'][2]['edit_func'] = "b_cinemaru_block_thumb_edit";
$modversion['blocks'][2]['options'] = "{$mydirname}|counter|10|sort|1";
$modversion['blocks'][2]['template'] = $mydirname . "_block_thumb.html";


// Comments
$modversion['hasComments'] = 0 ;

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'cinemaru_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = constant($constpref.'_GLOBAL_NOTIFY');
$modversion['notification']['category'][1]['description'] = constant($constpref.'_GLOBAL_NOTIFYDSC');
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php', 'views.php', 'regist.php');

$modversion['notification']['event'][1]['name'] = 'new_post';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = constant($constpref.'_GLOBAL_NEWPOST_NOTIFY');
$modversion['notification']['event'][1]['caption'] = constant($constpref.'_GLOBAL_NEWPOST_NOTIFYCAP');
$modversion['notification']['event'][1]['description'] = constant($constpref.'_GLOBAL_NEWPOST_NOTIFYDSC');
$modversion['notification']['event'][1]['mail_template'] = 'global_newpost_notify';
$modversion['notification']['event'][1]['mail_subject'] = constant($constpref.'_GLOBAL_NEWPOST_NOTIFYSBJ');

$modversion['notification']['event'][2]['name'] = 'update';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['title'] = constant($constpref.'_GLOBAL_UPDATE_NOTIFY');
$modversion['notification']['event'][2]['caption'] = constant($constpref.'_GLOBAL_UPDATE_NOTIFYCAP');
$modversion['notification']['event'][2]['description'] = constant($constpref.'_GLOBAL_UPDATE_NOTIFYDSC');
$modversion['notification']['event'][2]['mail_template'] = 'global_update_notify';
$modversion['notification']['event'][2]['mail_subject'] = constant($constpref.'_GLOBAL_UPDATE_NOTIFYSBJ');


// Configs
$modversion['hasconfig'] = 1;

$modversion['config'][1] = array( 
		'name'                  => 'cinemaru_movie_max_size' ,
		'title'                 => $constpref.'_MOVIE_MAX_SIZE' ,
		'description'   => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_MOVIE_MAX_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][2] = array(
		'name'                  => 'tag_size' ,
		'title'                 => $constpref.'_TAG_MAX_SIZE' ,
		'description'   => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_TAG_MAX_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][3] = array( 
		'name'                  => 'num_of_tag' ,
		'title'                 => $constpref.'_NUM_OF_TAG' ,
		'description'   => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_NUM_OF_TAG_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][4] = array( 
		'name'                  => 'tag_encoding' ,
		'title'                 => $constpref.'_TAG_ENCODING' ,
		'description'   => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_TAG_ENCODING_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][5] = array(
		'name'                  => 'num_of_sumb' ,
		'title'                 => $constpref.'_NUM_OF_THUMB' ,
		'description'   => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_NUM_OF_THUMB_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][6] = array(
		'name'                  => 'thumb_bgcolor' ,
		'title'                 => $constpref.'_THUMB_BGCOLOR' ,
		'description'           => constant($constpref.'_THUMB_BGCOLOR_DESC') ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_THUMB_BGCOLOR_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][7] = array(
		'name'                  => 'show_user_id' ,
		'title'                 => $constpref.'_SHOW_USER_ID' ,
		'description'           => constant($constpref.'_SHOW_USER_ID_DESC') ,
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SHOW_USER_ID_DEFAULT'),
		'options'               => array( $constpref.'_SHOW_USER_ID_OK'=>1,
						  $constpref.'_SHOW_USER_ID_NG'=>0,
						  )
) ;
$modversion['config'][8] = array(
		'name'                  => 'name_setting' ,
		'title'                 => $constpref.'_NAME_SETTING' ,
		'description'   => '' ,
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => '0' ,
		'options'               => array( $constpref.'_SET_NAME'=>0 ,
						  $constpref.'_SET_UNAME'=>1,
						  $constpref.'_SET_NAME_AND_UNAME'=>2,
 						  $constpref.'_SET_UNAME_OR_NAME'=>3
                                                )
) ;
$modversion['config'][9] = array(
		'name'                  => 'show_avatar' ,
		'title'                 => $constpref.'_SHOW_AVATAR' ,
		'description'           => '',
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SHOW_AVATAR_DEFAULT'),
		'options'               => array( $constpref.'_SHOW_AVATAR_OK'=>1,
						  $constpref.'_SHOW_AVATAR_NG'=>0,
						  )
) ;
$modversion['config'][10] = array(
		'name'                  => 'show_name_comment_list' ,
		'title'                 => $constpref.'_SHOW_NAME_CLIST' ,
		'description'           => '',
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SHOW_NAME_CLIST_DEFAULT'),
		'options'               => array( $constpref.'_SHOW_NAME_CLIST_OK'=>1,
						  $constpref.'_SHOW_NAME_CLIST_NG'=>0,
						  )
) ;
$modversion['config'][11] = array(
		'name'                  => 'guest_user_name' ,
		'title'                 => $constpref.'_GUEST_USER_NAME' ,
		'description'           => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_GUEST_USER_NAME_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][12] = array(
		'name'                  => 'show_name_movie' ,
		'title'                 => $constpref.'_SHOW_NAME_MOVIE' ,
		'description'           => '',
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SHOW_NAME_MOVIE_DEFAULT'),
		'options'               => array( $constpref.'_SHOW_NAME_MOVIE_OK'=>1,
						  $constpref.'_SHOW_NAME_MOVIE_NG'=>0,
						  )
) ;
$modversion['config'][13] = array(
		'name'                  => 'show_report_link' ,
		'title'                 => $constpref.'_SHOW_REPORT_LINK' ,
		'description'           => '',
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SHOW_REPORT_LINK_DEFAULT'),
		'options'               => array( $constpref.'_SHOW_REPORT_LINK_OK'=>1,
						  $constpref.'_SHOW_REPORT_LINK_NG'=>0,
						  )
) ;
$modversion['config'][14] = array(
		'name'                  => 'sp_command1' ,
		'title'                 => $constpref.'_SP_COMMAND1' ,
		'description'           => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_SP_COMMAND1_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][15] = array(
		'name'                  => 'sp_command1_url' ,
		'title'                 => $constpref.'_SP_COMMAND1_URL' ,
		'description'           => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_SP_COMMAND1_URL_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][16] = array(
		'name'                  => 'sp_command1_random' ,
		'title'                 => $constpref.'_SP_COMMAND1_RAND' ,
		'description'           => '' ,
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SP_COMMAND1_RANDOM_DEFAULT'),
		'options'               => array( $constpref.'_SP_RANDOM_OK'=>1,
						  $constpref.'_SP_RANDOM_NG'=>0,
						  )
) ;
$modversion['config'][17] = array(
		'name'                  => 'sp_command2' ,
		'title'                 => $constpref.'_SP_COMMAND2' ,
		'description'           => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_SP_COMMAND2_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][18] = array(
		'name'                  => 'sp_command2_url' ,
		'title'                 => $constpref.'_SP_COMMAND2_URL' ,
		'description'           => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_SP_COMMAND2_URL_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][19] = array(
		'name'                  => 'sp_command2_random' ,
		'title'                 => $constpref.'_SP_COMMAND2_RAND' ,
		'description'           => '' ,
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SP_COMMAND2_RANDOM_DEFAULT'),
		'options'               => array( $constpref.'_SP_RANDOM_OK'=>1,
						  $constpref.'_SP_RANDOM_NG'=>0,
						  )
) ;
$modversion['config'][20] = array(
		'name'                  => 'sp_command3' ,
		'title'                 => $constpref.'_SP_COMMAND3' ,
		'description'           => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_SP_COMMAND3_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][21] = array(
		'name'                  => 'sp_command3_url' ,
		'title'                 => $constpref.'_SP_COMMAND3_URL' ,
		'description'           => '' ,
		'formtype'              => 'textbox' ,
		'valuetype'             => 'text' ,
		'default'               => constant($constpref.'_SP_COMMAND3_URL_DEFAULT'),
		'options'               => array()
) ;
$modversion['config'][22] = array(
		'name'                  => 'sp_command3_random' ,
		'title'                 => $constpref.'_SP_COMMAND3_RAND' ,
		'description'           => '' ,
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => constant($constpref.'_SP_COMMAND3_RANDOM_DEFAULT'),
		'options'               => array( $constpref.'_SP_RANDOM_OK'=>1,
						  $constpref.'_SP_RANDOM_NG'=>0,
						  )
) ;
$modversion['config'][23] = array( 
                'name'                  => 'richtext' ,
                'title'                 => $constpref.'_RICHTEXT' ,
                'description'   => '' ,
                'formtype'              => 'select' ,
                'valuetype'             => 'int' ,
                'default'               => 1 ,
                'options'               => array( 
		    $constpref.'_USE_RICHTEXT'=> 1,
		    $constpref.'_USE_PLAINTEXT'=> 0
	       )
) ;
$modversion['config'][24] = array(
		'name'                  => 'blog_paste' ,
		'title'                 => $constpref.'_BLOG_PASTE' ,
		'description'           => '' ,
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => 1,
		'options'               => array( $constpref.'_BLOG_PASTE_OK'=>1,
						  $constpref.'_BLOG_PASTE_NG'=>0,
						  )
) ;
$modversion['config'][25] = array(
		'name'                  => 'top_movie' ,
		'title'                 => $constpref.'_TOP_MOVIE' ,
		'description'           => $constpref.'_TOP_MOVIE_DESC' ,
		'formtype'              => 'select' ,
		'valuetype'             => 'int' ,
		'default'               => 1,
		'options'               => array( $constpref.'_TOP_MOVIE_LIST'=>1,
						  $constpref.'_TOP_MOVIE_THUMB'=>2,
						  )
) ;


$modversion['onInstall'] = 'oninstall.php' ;
$modversion['onUpdate'] = 'onupdate.php' ;
$modversion['onUninstall'] = 'onuninstall.php' ;



