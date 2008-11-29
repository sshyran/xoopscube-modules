<?php
/**
 * @file
 * @package bizpoll
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

if(!defined('BIZPOLL_TRUST_PATH'))
{
    define('BIZPOLL_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/bizpoll');
}

require_once BIZPOLL_TRUST_PATH . '/class/BizpollUtils.class.php';

//
// Define a basic manifesto.
//
$modversion['name'] = _MI_BIZPOLL_LANG_BIZPOLL;
$modversion['version'] = 0.1;
$modversion['description'] = _MI_BIZPOLL_DESC_BIZPOLL;
$modversion['author'] = _MI_BIZPOLL_LANG_AUTHOR;
$modversion['credits'] = _MI_BIZPOLL_LANG_CREDITS;
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = 'images/bizpoll.png';
$modversion['dirname'] = $myDirName;
$modversion['trust_dirname'] = 'bizpoll';

$modversion['cube_style'] = true;
$modversion['legacy_installer'] = array(
    'installer'   => array(
        'class'     => 'Installer',
        'namespace' => 'Bizpoll',
        'filepath'  => BIZPOLL_TRUST_PATH . '/admin/class/installer/BizpollInstaller.class.php'
    ),
    'uninstaller' => array(
        'class'     => 'Uninstaller',
        'namespace' => 'Bizpoll',
        'filepath'  => BIZPOLL_TRUST_PATH . '/admin/class/installer/BizpollUninstaller.class.php'
    ),
    'updater' => array(
        'class'     => 'Updater',
        'namespace' => 'Bizpoll',
        'filepath'  => BIZPOLL_TRUST_PATH . '/admin/class/installer/BizpollUpdater.class.php'
    )
);
$modversion['disable_legacy_2nd_installer'] = false;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = array(
//    '{prefix}_{dirname}_xxxx',
##[cubson:tables]
'{prefix}_{dirname}_enq',
'{prefix}_{dirname}_choice',
'{prefix}_{dirname}_poll',
##[/cubson:tables]
);

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
$modversion['templates'] = array(
/*
    array(
        'file'        => '{dirname}_xxx.html',
        'description' => _MI_BIZPOLL_TPL_XXX
    ),
*/
##[cubson:templates]
    array('file' => '{dirname}_enq_list.html','description' => _MI_BIZPOLL_TPL_ENQ_LIST),
    array('file' => '{dirname}_enq_edit.html','description' => _MI_BIZPOLL_TPL_ENQ_EDIT),
    array('file' => '{dirname}_enq_delete.html','description' => _MI_BIZPOLL_TPL_ENQ_DELETE),
    array('file' => '{dirname}_enq_view.html','description' => _MI_BIZPOLL_TPL_ENQ_VIEW),
    array('file' => '{dirname}_poll_list.html','description' => _MI_BIZPOLL_TPL_POLL_LIST),
    array('file' => '{dirname}_poll_edit.html','description' => _MI_BIZPOLL_TPL_POLL_EDIT),
    array('file' => '{dirname}_poll_delete.html','description' => _MI_BIZPOLL_TPL_POLL_DELETE),
    array('file' => '{dirname}_poll_detail.html','description' => _MI_BIZPOLL_TPL_POLL_VIEW),
    array('file' => '{dirname}_choice_list.html','description' => _MI_BIZPOLL_TPL_CHOICE_LIST),
    array('file' => '{dirname}_choice_edit.html','description' => _MI_BIZPOLL_TPL_CHOICE_EDIT),
    array('file' => '{dirname}_choice_delete.html','description' => _MI_BIZPOLL_TPL_CHOICE_DELETE),
    array('file' => '{dirname}_choice_view.html','description' => _MI_BIZPOLL_TPL_CHOICE_VIEW),
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
        'title'    => _MI_BIZPOLL_LANG_XXXX,
        'link'     => 'admin/index.php?action=xxx',
        'keywords' => _MI_BIZPOLL_KEYWORD_XXX,
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
$modversion['hasSearch'] = 0;
$modversion['sub'] = array(
/*
    array(
        'name' => _MI_BIZPOLL_LANG_SUB_XXX,
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
        'title'         => "_MI_BIZPOLL_TITLE_GR_ID",
        'description'   => "_MI_BIZPOLL_DESC_GR_ID",
        'formtype'      => 'textbox',
        'valuetype'     => 'int',
        'options'       => array(),
        'default'       => 0
    ),
    array(
        'name'          => 'css_file',
        'title'         => "_MI_BIZPOLL_TITLE_CSS_FILE",
        'description'   => "_MI_BIZPOLL_DESC_CSS_FILE",
        'formtype'      => 'textbox',
        'valuetype'     => 'text',
        'options'       => array(),
        'default'       => '/modules/'. $myDirName. '/bizpoll.css'
    ),
    array(
        'name'          => 'permit_title',
        'title'         => "_MI_BIZPOLL_TITLE_PERMIT",
        'description'   => "_MI_BIZPOLL_DESC_PERMIT",
        'formtype'      => 'textbox',
        'valuetype'     => 'text',
        'options'       => array(),
        'default'       => 'viewer|poster|editor|viewer'
    ),
    array(
        'name'          => 'show_rss',
        'title'         => "_MI_BIZPOLL_TITLE_SHOW_RSS",
        'description'   => "_MI_BIZPOLL_DESC_SHOW_RSS",
        'formtype'      => 'yesno',
        'valuetype'     => 'int',
        'options'       => array(),
        'default'       => '1'
    ),
    array(
        'name'          => 'editor',
        'title'         => "_MI_BIZPOLL_TITLE_EDITOR",
        'description'   => "_MI_BIZPOLL_DESC_EDITOR",
        'formtype'      => 'select',
        'valuetype'     => 'text',
        'options'       => array("bbcode"=>"bbcode", "fckeditor"=>"fckeditor"),
        'default'       => 'bbcode'
    ),
    array(
        'name'          => 'ip_period',
        'title'         => "_MI_BIZPOLL_TITLE_IP_PERIOD",
        'description'   => "_MI_BIZPOLL_DESC_IP_PERIOD",
        'formtype'      => 'textbox',
        'valuetype'     => 'int',
        'options'       => array(),
        'default'       => '24'
    ),
/*
    array(
        'name'          => 'xxxx',
        'title'         => '_MI_BIZPOLL_TITLE_XXXX',
        'description'   => '_MI_BIZPOLL_DESC_XXXX',
        'formtype'      => 'xxxx',
        'valuetype'     => 'xxx',
        'options'       => array(xxx => xxx,xxx => xxx),
        'default'       => 0
    ),
*/
##[cubson:config]
##[/cubson:config]
);

//
// Block setting
//
$modversion['blocks'] = array(
/*
    x => array(
        'func_num'          => x,
        'file'              => 'xxxBlock.class.php',
        'class'             => 'xxx',
        'name'              => _MI_BIZPOLL_BLOCK_NAME_xxx,
        'description'       => _MI_BIZPOLL_BLOCK_DESC_xxx,
        'options'           => '',
        'template'          => '{dirname}_block_xxx.html',
        'show_all_module'   => true,
        'visible_any'       => true
    ),
*/
##[cubson:block]
##[/cubson:block]
);

?>
