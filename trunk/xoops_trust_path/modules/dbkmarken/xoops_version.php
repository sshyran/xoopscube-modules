<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();


if(!defined('DBKMARKEN_TRUST_PATH'))
{
    define('DBKMARKEN_TRUST_PATH', XOOPS_TRUST_PATH . '/modules/dbkmarken');
}
require_once DBKMARKEN_TRUST_PATH . '/class/DbkmarkenUtils.class.php';

//
// Define a basic manifesto.
//
$modversion['name'] = _MI_DBKMARKEN_LANG_DBKMARKEN;
$modversion['version'] = 0.34;
$modversion['description'] = _MI_DBKMARKEN_DESC_DBKMARKEN;
$modversion['author'] = "HIKAWA Kilica@ http://xacro.jp";
$modversion['credits'] = "";
$modversion['help'] = "help.html";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image'] = "images/dbkmarken.png";
$modversion['dirname'] = $myDirName;
$modversion['trust_dirname'] = 'dbkmarken';

$modversion['cube_style'] = true;
$modversion['legacy_installer'] = array(
    'installer'   => array(
        'class'     => 'Installer',
        'namespace' => 'Dbkmarken',
        'filepath'  => DBKMARKEN_TRUST_PATH . '/admin/class/installer/DbkmarkenInstaller.class.php'
    ),
    'uninstaller' => array(
        'class'     => 'Uninstaller',
        'namespace' => 'Dbkmarken',
        'filepath'  => DBKMARKEN_TRUST_PATH . '/admin/class/installer/DbkmarkenUninstaller.class.php'
    ),
    'updater' => array(
        'class'     => 'Updater',
        'namespace' => 'Dbkmarken',
        'filepath'  => DBKMARKEN_TRUST_PATH . '/admin/class/installer/DbkmarkenUpdater.class.php'
    )
);
$modversion['disable_legacy_2nd_installer'] = false;

// TODO After you made your SQL, remove the following comment-out.
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
##[cubson:tables]
$modversion['tables'][0] = "{prefix}_{dirname}_bm";
$modversion['tables'][1] = "{prefix}_{dirname}_tag";
##[/cubson:tables]

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
//$modversion['templates'][]['file'] = 'dbkmarken'_xxxxx.html';
//$modversion['templates'][]['description'] = 'dbkmarken'_xxxxx.html';
##[cubson:templates]
$modversion['templates'][0]['file'] = '{dirname}_bm_list.html';
$modversion['templates'][1]['file'] = '{dirname}_bm_edit.html';
$modversion['templates'][2]['file'] = '{dirname}_bm_delete.html';
$modversion['templates'][3]['file'] = '{dirname}_bm_view.html';
$modversion['templates'][4]['file'] = '{dirname}_tag_list.html';
$modversion['templates'][6]['file'] = '{dirname}_bm_topics.html';
$modversion['templates'][7]['file'] = '{dirname}_rss.html';
$modversion['templates'][8]['file'] = '{dirname}_tag_replace.html';
$modversion['templates'][9]['file'] = '{dirname}_export.html';
$modversion['templates'][10]['file'] = '{dirname}_bm_cse.xml';
##[/cubson:templates]

//
// Admin panel setting
//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//
// Public side control setting
//
$modversion['hasMain'] = 1;
// $modversion['sub'][]['name'] = "";
// $modversion['sub'][]['url'] = "";

//
// Search
//
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "includes/search.inc.php";
$modversion['search']['func'] = "dbkmarken_search";

//block

$modversion['blocks'][1]['func_num'] = 1;
$modversion['blocks'][1]['file'] = "BmBlock.class.php";
$modversion['blocks'][1]['class'] = "BmBlock";
$modversion['blocks'][1]['name'] = _MI_DBKMARKEN_LANG_BM;
$modversion['blocks'][1]['description'] = _MI_DBKMARKEN_DESC_BM;
$modversion['blocks'][1]['template'] = '{dirname}_block_bm.html';
$modversion['blocks'][1]['options'] = "5";
$modversion['blocks'][1]['visible_any'] = false;
$modversion['blocks'][1]['show_all_module'] = true;
$modversion['blocks'][1]['can_clone'] = true;

$modversion['blocks'][2]['func_num'] = 2;
$modversion['blocks'][2]['file'] = "TagcloudBlock.class.php";
$modversion['blocks'][2]['class'] = "TagcloudBlock";
$modversion['blocks'][2]['name'] = _MI_DBKMARKEN_LANG_TAGCLOUD;
$modversion['blocks'][2]['description'] = _MI_DBKMARKEN_DESC_TAGCLOUD;
$modversion['blocks'][2]['template'] = '{dirname}_block_tagcloud.html';
$modversion['blocks'][2]['options'] = "";
$modversion['blocks'][2]['visible_any'] = false;
$modversion['blocks'][2]['show_all_module'] = true;
$modversion['blocks'][2]['can_clone'] = true;

$modversion['blocks'][3]['func_num'] = 3;
$modversion['blocks'][3]['file'] = "SingletagBlock.class.php";
$modversion['blocks'][3]['class'] = "SingletagBlock";
$modversion['blocks'][3]['name'] = _MI_DBKMARKEN_LANG_SINGLETAG;
$modversion['blocks'][3]['description'] = _MI_DBKMARKEN_DESC_SINGLETAG;
$modversion['blocks'][3]['template'] = '{dirname}_block_singletag.html';
$modversion['blocks'][3]['options'] = "5|";
$modversion['blocks'][3]['visible_any'] = false;
$modversion['blocks'][3]['show_all_module'] = true;
$modversion['blocks'][3]['can_clone'] = true;


// Configs
$modversion['config'][1] = array(
	'name'			=> 'popular_term' ,
	'title'			=> "_MI_DBKMARKEN_LANG_POP_TERM" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 14 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'popular_count' ,
	'title'			=> "_MI_DBKMARKEN_LANG_POP_CNT" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 3 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'tagcloud_min' ,
	'title'			=> "_MI_DBKMARKEN_LANG_TC_MIN" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 80 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'tagcloud_max' ,
	'title'			=> "_MI_DBKMARKEN_LANG_TC_MAX" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 200 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'allow_useredit' ,
	'title'			=> "_MI_DBKMARKEN_LANG_USEREDIT" ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'mb_tag' ,
	'title'			=> "_MI_DBKMARKEN_LANG_MB_TAG" ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'css_file' ,
	'title'			=> "_MI_DBKMARKEN_LANG_CSS_FILE" ,
	'description'	=> "_MI_DBKMARKEN_DESC_CSS_FILE" ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '/modules/'. $myDirName. '/dbkmarken.css',
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'cse_replaceurl' ,
	'title'			=> "_MI_DBKMARKEN_LANG_CSE_URL" ,
	'description'	=> "_MI_DBKMARKEN_DESC_CSE_URL" ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1,
	'options'		=> array()
) ;

?>
