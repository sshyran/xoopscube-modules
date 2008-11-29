<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

if(!defined('BIZFORUM_TRUST_PATH'))
{
    define('BIZFORUM_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/bizforum');
}

require_once BIZFORUM_TRUST_PATH . '/class/BizforumUtils.class.php';

//
// Define a basic manifesto.
//
$modversion['name'] = _MI_BIZFORUM_LANG_BIZFORUM;
$modversion['version'] = 0.16;
$modversion['description'] = _MI_BIZFORUM_DESC_BIZFORUM;
$modversion['author'] = _MI_BIZFORUM_LANG_AUTHOR;
$modversion['credits'] = _MI_BIZFORUM_LANG_CREDITS;
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = 'images/bizforum.png';
$modversion['dirname'] = $myDirName;
$modversion['trust_dirname'] = 'bizforum';

$modversion['cube_style'] = true;
$modversion['legacy_installer'] = array(
    'installer'   => array(
        'class'     => 'Installer',
        'namespace' => 'Bizforum',
        'filepath'  => BIZFORUM_TRUST_PATH . '/admin/class/installer/BizforumInstaller.class.php'
    ),
    'uninstaller' => array(
        'class'     => 'Uninstaller',
        'namespace' => 'Bizforum',
        'filepath'  => BIZFORUM_TRUST_PATH . '/admin/class/installer/BizforumUninstaller.class.php'
    ),
    'updater' => array(
        'class'     => 'Updater',
        'namespace' => 'Bizforum',
        'filepath'  => BIZFORUM_TRUST_PATH . '/admin/class/installer/BizforumUpdater.class.php'
    )
);
$modversion['disable_legacy_2nd_installer'] = false;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = array(
    '{prefix}_{dirname}_topic',
    '{prefix}_{dirname}_post',
##[cubson:tables]
##[/cubson:tables]
);

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
$modversion['templates'] = array(
/*
    array(
        'file'        => '{dirname}_xxx.html',
        'description' => _MI_BIZFORUM_TPL_XXX
    ),
*/
##[cubson:templates]
    array('file' => '{dirname}_topic_list.html','description' => _MI_BIZFORUM_TPL_TOPIC_LIST),
    array('file' => '{dirname}_topic_edit.html','description' => _MI_BIZFORUM_TPL_TOPIC_EDIT),
    array('file' => '{dirname}_topic_delete.html','description' => _MI_BIZFORUM_TPL_TOPIC_DELETE),
    array('file' => '{dirname}_topic_view.html','description' => _MI_BIZFORUM_TPL_TOPIC_VIEW),
    array('file' => '{dirname}_post_list.html','description' => _MI_BIZFORUM_TPL_POST_LIST),
    array('file' => '{dirname}_post_edit.html','description' => _MI_BIZFORUM_TPL_POST_EDIT),
    array('file' => '{dirname}_post_delete.html','description' => _MI_BIZFORUM_TPL_POST_DELETE),
    array('file' => '{dirname}_post_view.html','description' => _MI_BIZFORUM_TPL_POST_VIEW),
    array('file' => '{dirname}_post_rss.html','description' => _MI_BIZFORUM_TPL_POST_RSS),
##[/cubson:templates]
);

//
// Admin panel setting
//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = array(
/*
    array(
        'title'    => _MI_BIZFORUM_LANG_XXXX,
        'link'     => 'admin/index.php?action=xxx',
        'keywords' => _MI_BIZFORUM_KEYWORD_XXX,
        'show'     => true,
        'absolute' => false
    ),
*/
##[cubson:adminmenu]
##[/cubson:adminmenu]
);

//
// Public side control setting
//
$modversion['hasMain'] = 1;
$modversion['hasSearch'] = true;
$modversion['sub'] = array(
/*
    array(
        'name' => _MI_BIZFORUM_LANG_SUB_XXX,
        'url'  => 'index.php?action=XXX'
    ),
*/
##[cubson:submenu]
##[/cubson:submenu]
);

//
// Config setting
//
$modversion['config'] = array(
    array(
        'name'          => 'gr_id',
        'title'         => "_MI_BIZFORUM_TITLE_GR_ID",
        'description'   => "_MI_BIZFORUM_DESC_GR_ID",
        'formtype'      => 'textbox',
        'valuetype'     => 'int',
        'options'       => array(),
        'default'       => 0
    ),
    array(
        'name'          => 'css_file',
        'title'         => "_MI_BIZFORUM_TITLE_CSS_FILE",
        'description'   => "_MI_BIZFORUM_DESC_CSS_FILE",
        'formtype'      => 'textbox',
        'valuetype'     => 'text',
        'options'       => array(),
        'default'       => '/modules/'. $myDirName. '/bizforum.css'
    ),
    array(
        'name'          => 'per_page',
        'title'         => "_MI_BIZFORUM_TITLE_PER_PAGE",
        'description'   => "_MI_BIZFORUM_DESC_PER_PAGE",
        'formtype'      => 'textbox',
        'valuetype'     => 'int',
        'options'       => array(),
        'default'       => '20'
    ),
    array(
        'name'          => 'permit_title',
        'title'         => "_MI_BIZFORUM_TITLE_PERMIT",
        'description'   => "_MI_BIZFORUM_DESC_PERMIT",
        'formtype'      => 'textbox',
        'valuetype'     => 'text',
        'options'       => array(),
        'default'       => 'viewer|poster|editor'
    ),
    array(
        'name'          => 'show_rss',
        'title'         => "_MI_BIZFORUM_TITLE_SHOW_RSS",
        'description'   => "_MI_BIZFORUM_DESC_SHOW_RSS",
        'formtype'      => 'yesno',
        'valuetype'     => 'int',
        'options'       => array(),
        'default'       => '1'
    ),
##[cubson:config]
##[/cubson:config]
);

//
// Block setting
//
$modversion['blocks'] = array(
    1 => array(
        'func_num'          => 1,
        'file'              => 'TopicBlock.class.php',
        'class'             => 'TopicBlock',
        'name'              => _MI_BIZFORUM_BLOCK_NAME_TOPIC,
        'description'       => _MI_BIZFORUM_BLOCK_DESC_TOPIC,
        'options'           => '5|',
        'template'          => '{dirname}_block_topic.html',
        'show_all_module'   => true,
        'can_clone'			=> true,
        'visible_any'       => false
    ),
    2 => array(
        'func_num'          => 2,
        'file'              => 'CatBlock.class.php',
        'class'             => 'CatBlock',
        'name'              => _MI_BIZFORUM_BLOCK_NAME_CAT,
        'description'       => _MI_BIZFORUM_BLOCK_DESC_CAT,
        'options'           => '',
        'template'          => '{dirname}_block_cat.html',
        'show_all_module'   => true,
        'can_clone'			=> true,
        'visible_any'       => false
    ),
##[cubson:block]
##[/cubson:block]
);

?>
