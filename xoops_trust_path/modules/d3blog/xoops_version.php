<?php
/**
 * @version $Id: xoops_version.php 664 2010-10-20 13:56:43Z hodaka $
 * @brief dupulicatable(v3) blog module
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright Copyrighted (c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$modversion['name'] = constant($constpref.'_BASIC_MODULE_NAME');
$modversion['description'] = constant($constpref.'_BASIC_MODULE_NAME_DSC');
$modversion['version'] = 1.08;
$modversion['author'] = "T.Kuriyama <kuri@keynext.co.jp>";
$modversion['credits'] = "www.kuri3.net";
$modversion['help'] = "{$mydirname}_help.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image']       = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = $mydirname;

// Any tables can't be touched by modulesadmin.
$modversion['sqlfile'] = false ;
$modversion['tables'] = array() ;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/admin_menu.php";

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = constant($constpref.'_SUBMENU_ARCHIVES');
$modversion['sub'][1]['url'] = 'archives.php';
if (is_object(@$GLOBALS['xoopsUser'])) {
    $module_handler = & xoops_gethandler('module');
    $module =& $module_handler->getByDirname($mydirname);
    if(is_object($module) && $module->getVar('isactive')) {
        $mid = $module->getVar('mid');
        require_once dirname(__FILE__).'/lib/user.php';
        $bloggers =& myPerm::getMembersByName('blog_perm_edit', $mid);
        if (in_array($GLOBALS['xoopsUser']->getVar('uid'), array_keys($bloggers))) {
            $modversion['sub'][2]['name'] = constant($constpref.'_SUBMENU_POST');
            $modversion['sub'][2]['url'] = 'submit.php';
            if(count($bloggers) > 1) {
                $modversion['sub'][3]['name'] = constant($constpref.'_SUBMENU_MY_BLOG');
                $modversion['sub'][3]['url'] = 'myblog.php';
            }
        }
    }
}

// Template
// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = $mydirname.'_global_search';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'details.php';
$modversion['comments']['itemName'] = 'bid';

$modversion['comments']['callbackFile'] = 'comment_functions.php';
$modversion['comments']['callback']['approve'] = $mydirname.'_com_approve';
$modversion['comments']['callback']['update'] = $mydirname.'_com_update';

// Notifications
$modversion['hasNotification'] = 1;

$modversion['notification']['lookup_file'] = 'notification.php';
$modversion['notification']['lookup_func'] = $mydirname.'_notify_iteminfo';
$i=1;
$modversion['notification']['category'][$i]['name'] = 'global';
$modversion['notification']['category'][$i]['title'] = constant($constpref.'_NOTIFY_GLOBAL');
$modversion['notification']['category'][$i]['description'] = constant($constpref.'_NOTIFY_GLOBAL_DSC');
$modversion['notification']['category'][$i]['subscribe_from'] = 'index.php';
$i++;
$modversion['notification']['category'][$i]['name'] = 'entry';
$modversion['notification']['category'][$i]['title'] = constant($constpref.'_NOTIFY_ENTRY');
$modversion['notification']['category'][$i]['description'] = constant($constpref.'_NOTIFY_ENTRY_DSC');
$modversion['notification']['category'][$i]['subscribe_from'] = 'details.php';
$modversion['notification']['category'][$i]['item_name'] = 'bid';
$modversion['notification']['category'][$i]['allow_bookmark'] = 0;
$modversion['notification']['category'][$i]['allow_bookmark'] = 0;
$j=1;
$modversion['notification']['event'][$j]['name'] = 'new_entry';
$modversion['notification']['event'][$j]['category'] = 'global';
$modversion['notification']['event'][$j]['title'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED');
$modversion['notification']['event'][$j]['caption'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_CAP');
$modversion['notification']['event'][$j]['description'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_DSC');
$modversion['notification']['event'][$j]['mail_template'] = 'blog_global_entry';
$modversion['notification']['event'][$j]['mail_subject'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_SBJ');
$j++;
$modversion['notification']['event'][$j]['name'] = 'entry_submit';
$modversion['notification']['event'][$j]['category'] = 'global';
$modversion['notification']['event'][$j]['admin_only'] = 1;
$modversion['notification']['event'][$j]['title'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED');
$modversion['notification']['event'][$j]['caption'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_CAP');
$modversion['notification']['event'][$j]['description'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_DSC');
$modversion['notification']['event'][$j]['mail_template'] = 'blog_global_posted';
$modversion['notification']['event'][$j]['mail_subject'] = constant($constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_SBJ');
$j++;
$modversion['notification']['event'][$j]['name'] = 'approved';
$modversion['notification']['event'][$j]['category'] = 'entry';
$modversion['notification']['event'][$j]['invisible'] = 1;
$modversion['notification']['event'][$j]['title'] = constant($constpref.'_NOTIFY_ENTRY_APPROVED');
$modversion['notification']['event'][$j]['caption'] = constant($constpref.'_NOTIFY_ENTRY_APPROVED_CAP');
$modversion['notification']['event'][$j]['description'] = constant($constpref.'_NOTIFY_ENTRY_APPROVED_DSC');
$modversion['notification']['event'][$j]['mail_template'] = 'blog_entry_approved';
$modversion['notification']['event'][$j]['mail_subject'] = constant($constpref.'_NOTIFY_ENTRY_APPROVED_SBJ');
$j++;
$modversion['notification']['event'][$j]['name'] = 'trackback';
$modversion['notification']['event'][$j]['category'] = 'entry';
$modversion['notification']['event'][$j]['title'] = constant($constpref.'_NOTIFY_ENTRY_TRACKBACK');
$modversion['notification']['event'][$j]['caption'] = constant($constpref.'_NOTIFY_ENTRY_TRACKBACK_CAP');
$modversion['notification']['event'][$j]['description'] = constant($constpref.'_NOTIFY_ENTRY_TRACKBACK_DSC');
$modversion['notification']['event'][$j]['mail_template'] = 'blog_global_trackback';
$modversion['notification']['event'][$j]['mail_subject'] = constant($constpref.'_NOTIFY_ENTRY_TRACKBACK_SBJ');
$j++;
$modversion['notification']['event'][$j]['name'] = 'tb_received';
$modversion['notification']['event'][$j]['category'] = 'global';
$modversion['notification']['event'][$j]['admin_only'] = 1;
$modversion['notification']['event'][$j]['title'] = constant($constpref.'_NOTIFY_GLOBAL_TBRECEIVED');
$modversion['notification']['event'][$j]['caption'] = constant($constpref.'_NOTIFY_GLOBAL_TBRECEIVED_CAP');
$modversion['notification']['event'][$j]['description'] = constant($constpref.'_NOTIFY_GLOBAL_TBRECEIVED_DSC');
$modversion['notification']['event'][$j]['mail_template'] = 'blog_global_trackback_received';
$modversion['notification']['event'][$j]['mail_subject'] = constant($constpref.'_NOTIFY_GLOBAL_TBRECEIVED_SBJ');
$j++;
$modversion['notification']['event'][$j]['name'] = 'trackback';
$modversion['notification']['event'][$j]['category'] = 'global';
//$modversion['notification']['event'][$j]['invisible'] = 1;
$modversion['notification']['event'][$j]['title'] = constant($constpref.'_NOTIFY_GLOBAL_TBAPPROVED');
$modversion['notification']['event'][$j]['caption'] = constant($constpref.'_NOTIFY_GLOBAL_TBAPPROVED_CAP');
$modversion['notification']['event'][$j]['description'] = constant($constpref.'_NOTIFY_GLOBAL_TBAPPROVED_DSC');
$modversion['notification']['event'][$j]['mail_template'] = 'blog_global_trackback';
$modversion['notification']['event'][$j]['mail_subject'] = constant($constpref.'_NOTIFY_GLOBAL_TBAPPROVED_SBJ');

// Config Options
$k=1;
$modversion['config'][$k]['name'] = 'num_per_page';
$modversion['config'][$k]['title'] = $constpref.'_NUMPERPAGE';
$modversion['config'][$k]['description'] = $constpref.'_NUMPERPAGE_DSC';
$modversion['config'][$k]['formtype'] = 'select';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = 10;
$modversion['config'][$k]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50);
$k++;
$modversion['config'][$k]['name'] = 'max_rdf';
$modversion['config'][$k]['title'] = $constpref.'_MAX_FEED';
$modversion['config'][$k]['description'] = $constpref.'_MAX_FEED_DSC';
$modversion['config'][$k]['formtype'] = 'select';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = 10;
$modversion['config'][$k]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50);
$k++;
$modversion['config'][$k]['name'] = 'show_feeder_link';
$modversion['config'][$k]['title'] = $constpref.'_RSSICON';
$modversion['config'][$k]['description'] = $constpref.'_RSSICON_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '1';
$k++;
$modversion['config'][$k]['name'] = 'show_avatar';
$modversion['config'][$k]['title'] = $constpref.'_AVATAR';
$modversion['config'][$k]['description'] = $constpref.'_AVATAR_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
$k++;
$modversion['config'][$k]['name'] = 'logo_path';
$modversion['config'][$k]['title'] = $constpref.'_LOGOPATH';
$modversion['config'][$k]['description'] = $constpref.'_LOGOPATH_DSC';
$modversion['config'][$k]['formtype'] = 'textbox';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/images/logo.gif';
$k++;
$modversion['config'][$k]['name'] = 'categoryicon_path';
$modversion['config'][$k]['title'] = $constpref.'_CAT_ICON';
$modversion['config'][$k]['description'] = $constpref.'_CAT_ICON_DSC';
$modversion['config'][$k]['formtype'] = 'textbox';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/images/caticon';
$k++;
$modversion['config'][$k]['name'] = 'wysiwyg_editor';
$modversion['config'][$k]['title'] = $constpref.'_WYSIWYG';
$modversion['config'][$k]['description'] = $constpref.'_WYSIWYG_DSC';
$modversion['config'][$k]['formtype'] = 'select';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
$modversion['config'][$k]['options'] = array($constpref.'_NO_WYSIWYG' => 0, $constpref.'_WYSIWYG_FCK' => 1, $constpref.'_WYSIWYG_QUICKTAG' => 2);
$k++;
$modversion['config'][$k]['name'] = 'dynamic_css';
$modversion['config'][$k]['title'] = $constpref.'_DYNAMICCSS';
$modversion['config'][$k]['description'] = $constpref.'_DYNAMICCSS_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '1';
$k++;
$modversion['config'][$k]['name'] = 'figure_handler';
$modversion['config'][$k]['title'] = $constpref.'_FIGUREHANDLER';
$modversion['config'][$k]['description'] = $constpref.'_FIGUREHANDLER_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
$k++;
$modversion['config'][$k]['name'] = 'perm_by_entry';
$modversion['config'][$k]['title'] = $constpref.'_PERM_BY';
$modversion['config'][$k]['description'] = $constpref.'_PERM_BY_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
$k++;
$modversion['config'][$k]['name'] = 'default_groups';
$modversion['config'][$k]['title'] = $constpref.'_PERMED';
$modversion['config'][$k]['description'] = $constpref.'_PERMED_DSC';
$modversion['config'][$k]['formtype'] = 'select_multi';
$modversion['config'][$k]['valuetype'] = 'array';
// for group list
$member_handler =& xoops_gethandler('member');
$groupList = $member_handler->getGroupList();
$modversion['config'][$k]['default'] = array();
$modversion['config'][$k]['options'] = array();
foreach($groupList as $gid => $gname) {
    $modversion['config'][$k]['default'][] = $gid;
    $modversion['config'][$k]['options'][$gname] = $gid;
}
$k++;
$modversion['config'][$k]['name'] = 'can_read_excerpt';
$modversion['config'][$k]['title'] = $constpref.'_EXCERPTOK';
$modversion['config'][$k]['description'] = $constpref.'_EXCERPTOK_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
/*$k++;
$modversion['config'][$k]['name'] = 'increment_userpost';
$modversion['config'][$k]['title'] = $constpref.'_INCREMENT';
$modversion['config'][$k]['description'] = $constpref.'_INCREMENT_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = 1;*/
$k++;
$modversion['config'][$k]['name'] = 'updateping_url';
$modversion['config'][$k]['title'] = $constpref.'_UPDATEPING';
$modversion['config'][$k]['description'] = $constpref.'_UPDATEPING_DSC';
$modversion['config'][$k]['formtype'] = 'textarea';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = constant($constpref.'_UPDATEPING_SERVERS');
/*$k++;
$modversion['config'][$k]['name'] = 'url_by_entry';
$modversion['config'][$k]['title'] = $constpref.'_URL_CHOICE';
$modversion['config'][$k]['description'] = $constpref.'_URL_CHOICE_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = 0;
$k++;
$modversion['config'][$k]['name'] = 'max_urls';
$modversion['config'][$k]['title'] = $constpref.'_MAX_URLS';
$modversion['config'][$k]['description'] = $constpref.'_MAX_URLS_DSC';
$modversion['config'][$k]['formtype'] = 'textbox';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = '4';*/
$k++;
$modversion['config'][$k]['name'] = 'trackback_approval';
$modversion['config'][$k]['title'] = $constpref.'_TBAPPROVAL';
$modversion['config'][$k]['description'] = $constpref.'_TBAPPROVAL_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
$k++;
$modversion['config'][$k]['name'] = 'trackback_ticket';
$modversion['config'][$k]['title'] = $constpref.'_TBTICKET';
$modversion['config'][$k]['description'] = $constpref.'_TBTICKET_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
$k++;
$modversion['config'][$k]['name'] = 'notify_approver';
$modversion['config'][$k]['title'] = $constpref.'_NOT_ADMIN';
$modversion['config'][$k]['description'] = $constpref.'_NOT_ADMIN_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = '0';
$k++;
$k_index = $k;
$modversion['config'][$k]['name'] = 'spam_check';
$modversion['config'][$k]['title'] = $constpref.'_SPAMCHECK';
$modversion['config'][$k]['description'] = $constpref.'_SPAMCHECK_DSC';
$modversion['config'][$k]['formtype'] = 'select_multi';
$modversion['config'][$k]['valuetype'] = 'array';
$modversion['config'][$k]['default'] = array('n');
$modversion['config'][$k]['options'] = array(
                                            constant($constpref.'_REFERENCE') => 'f',
                                            constant($constpref.'_WORLDLIST') => 'w',
                                            constant($constpref.'_REGEX') => 'r',
                                            constant($constpref.'_DNSBL')=>'d',
                                            constant($constpref.'_SURBL')=>'s'
                                         );
if (XOOPS_USE_MULTIBYTES == 1) {
    $modversion['config'][$k]['options'] = array(constant($constpref.'_LANGCHECK') => 'l') + $modversion['config'][$k]['options'];
    $k++;
    $modversion['config'][$k]['name'] = 'regex_pattern';
    $modversion['config'][$k]['title'] = $constpref.'_PATTERN';
    $modversion['config'][$k]['description'] = $constpref.'_PATTERN_DSC';
    $modversion['config'][$k]['formtype'] = 'text';
    $modversion['config'][$k]['valuetype'] = 'text';
    $modversion['config'][$k]['default'] = constant($constpref.'_REGEX_PATTERN');
    $k++;
    $modversion['config'][$k]['name'] = 'letters';
    $modversion['config'][$k]['title'] = $constpref.'_LETTERS';
    $modversion['config'][$k]['description'] = $constpref.'_LETTERS_DSC';
    $modversion['config'][$k]['formtype'] = 'textbox';
    $modversion['config'][$k]['valuetype'] = 'text';
    $modversion['config'][$k]['default'] = '5';
}
$modversion['config'][$k_index]['options'] = array(constant($constpref.'_NOSPAMCHECK') => 'n') + $modversion['config'][$k_index]['options'];
$k++;
$modversion['config'][$k]['name'] = 'wordlist';
$modversion['config'][$k]['title'] = $constpref.'_BANNEDWORD';
$modversion['config'][$k]['description'] = $constpref.'_BANNEDWORD_DSC';
$modversion['config'][$k]['formtype'] = 'textarea';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = constant($constpref.'_BANNEDWORDS');
$k++;
$modversion['config'][$k]['name'] = 'regex';
$modversion['config'][$k]['title'] = $constpref.'_REGEXCHECK';
$modversion['config'][$k]['description'] = $constpref.'_REGEXCHECK_DSC';
$modversion['config'][$k]['formtype'] = 'textarea';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = '';
$k++;
$modversion['config'][$k]['name'] = 'dnsbl';
$modversion['config'][$k]['title'] = $constpref.'_DNSBLSRV';
$modversion['config'][$k]['description'] = $constpref.'_DNSBLSRV_DSC';
$modversion['config'][$k]['formtype'] = 'textarea';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = constant($constpref.'_DNSBL_SERVERS');
$k++;
$modversion['config'][$k]['name'] = 'surbl';
$modversion['config'][$k]['title'] = $constpref.'_SURBLSRV';
$modversion['config'][$k]['description'] = $constpref.'_SURBLSRV_DSC';
$modversion['config'][$k]['formtype'] = 'textarea';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = constant($constpref.'_SURBL_SERVERS');
/*$k++;
$modversion['config'][$k]['name'] = 'd3blog_comment_system';
$modversion['config'][$k]['title'] = $constpref.'_ORIGINAL_COM';
$modversion['config'][$k]['description'] = $constpref.'_ORIGINAL_COM_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = 1;
$k++;
$modversion['config'][$k]['name'] = 'reject_reply';
$modversion['config'][$k]['title'] = $constpref.'_REJECTREPLY';
$modversion['config'][$k]['description'] = $constpref.'_REJECTREPLY_DSC';
$modversion['config'][$k]['formtype'] = 'yesno';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = 1;*/
$k++;
$modversion['config'][$k]['name'] = 'com_agent';
$modversion['config'][$k]['title'] = $constpref.'_COM_AGENT';
$modversion['config'][$k]['description'] = $constpref.'_COM_AGENT_DSC';
$modversion['config'][$k]['formtype'] = 'textbox';
$modversion['config'][$k]['valuetype'] = 'text';
$modversion['config'][$k]['default'] = '';
$k++;
$modversion['config'][$k]['name'] = 'com_agent_forumid';
$modversion['config'][$k]['title'] = $constpref.'_COM_AGENTID';
$modversion['config'][$k]['description'] = $constpref.'_COM_AGENTID_DSC';
$modversion['config'][$k]['formtype'] = 'textbox';
$modversion['config'][$k]['valuetype'] = 'int';
$modversion['config'][$k]['default'] = 0;

//Blocks
$m=1;
$modversion['blocks'][$m]['file'] = 'blocks.php';
$modversion['blocks'][$m]['name'] = constant($constpref.'_LATEST_TRACKBACKS');
$modversion['blocks'][$m]['description'] = constant($constpref.'_LATEST_TRACKBACKS_DESC');
$modversion['blocks'][$m]['show_func'] = 'b_d3blog_latest_trackbacks_show';
$modversion['blocks'][$m]['edit_func'] = 'b_d3blog_latest_trackbacks_edit';
$modversion['blocks'][$m]['template'] = '';
$modversion['blocks'][$m]['options'] = $mydirname.'|5|25|Y/m/d|1';
$modversion['blocks'][$m]['can_clone'] = true ;
$m++;
$modversion['blocks'][$m]['file'] = 'blocks.php';
$modversion['blocks'][$m]['name'] = constant($constpref.'_LATEST_COMMENTS');
$modversion['blocks'][$m]['description'] = constant($constpref.'_LATEST_COMMENTS_DESC');
$modversion['blocks'][$m]['show_func'] = 'b_d3blog_latest_comments_show';
$modversion['blocks'][$m]['edit_func'] = 'b_d3blog_latest_comments_edit';
$modversion['blocks'][$m]['template'] = '';
$modversion['blocks'][$m]['options'] = $mydirname.'|5|25|Y/m/d|1';
$modversion['blocks'][$m]['can_clone'] = true ;
$m++;
$modversion['blocks'][$m]['file'] = 'blocks.php';
$modversion['blocks'][$m]['name'] = constant($constpref.'_LATEST_ENTRIES');
$modversion['blocks'][$m]['description'] = constant($constpref.'_LATEST_ENTRIES_DESC');
$modversion['blocks'][$m]['show_func'] = 'b_d3blog_latest_entries_show';
$modversion['blocks'][$m]['edit_func'] = 'b_d3blog_latest_entries_edit';
$modversion['blocks'][$m]['template'] = '';
$modversion['blocks'][$m]['options'] = $mydirname.'|5|25|Y/m/d|1|0|0|0|||';
$modversion['blocks'][$m]['can_clone'] = true ;
$m++;
$modversion['blocks'][$m]['file'] = 'blocks.php';
$modversion['blocks'][$m]['name'] = constant($constpref.'_ARCHIVE_LIST');
$modversion['blocks'][$m]['description'] = constant($constpref.'_ARCHIVE_LIST_DESC');
$modversion['blocks'][$m]['show_func'] = 'b_d3blog_archives_show';
$modversion['blocks'][$m]['edit_func'] = 'b_d3blog_archives_edit';
$modversion['blocks'][$m]['template'] = '';
$modversion['blocks'][$m]['options'] = $mydirname.'|6';
$modversion['blocks'][$m]['can_clone'] = true ;
$m++;
$modversion['blocks'][$m]['file'] = 'blocks.php';
$modversion['blocks'][$m]['name'] = constant($constpref.'_CATEGORY_LIST');
$modversion['blocks'][$m]['description'] = constant($constpref.'_CATEGORY_LIST_DESC');
$modversion['blocks'][$m]['show_func'] = 'b_d3blog_category_list_show';
$modversion['blocks'][$m]['edit_func'] = 'b_d3blog_category_list_edit';
$modversion['blocks'][$m]['template'] = '';
$modversion['blocks'][$m]['options'] = $mydirname.'|0';
$modversion['blocks'][$m]['can_clone'] = true ;
$m++;
$modversion['blocks'][$m]['file'] = 'blocks.php';
$modversion['blocks'][$m]['name'] = constant($constpref.'_CALENDAR');
$modversion['blocks'][$m]['description'] = constant($constpref.'_CALENDAR_DESC');
$modversion['blocks'][$m]['show_func'] = 'b_d3blog_calendar_show';
$modversion['blocks'][$m]['edit_func'] = 'b_d3blog_calendar_edit';
$modversion['blocks'][$m]['template'] = '';
$modversion['blocks'][$m]['options'] = $mydirname;
$modversion['blocks'][$m]['can_clone'] = true ;
$m++;
$modversion['blocks'][$m]['file'] = 'blocks.php';
$modversion['blocks'][$m]['name'] = constant($constpref.'_BLOGGERS_LIST');
$modversion['blocks'][$m]['description'] = constant($constpref.'_BLOGGERS_LIST_DESC');
$modversion['blocks'][$m]['show_func'] = 'b_d3blog_bloggers_list_show';
$modversion['blocks'][$m]['edit_func'] = 'b_d3blog_bloggers_list_edit';
$modversion['blocks'][$m]['template'] = '';
$modversion['blocks'][$m]['options'] = $mydirname.'|5';
$modversion['blocks'][$m]['can_clone'] = true ;

$modversion['onInstall'] = 'oninstall.php';
$modversion['onUpdate'] = 'onupdate.php';
$modversion['onUninstall'] = 'onuninstall.php';

// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
    include dirname(__FILE__).'/include/x20_keepblockoptions.inc.php' ;
}
?>
