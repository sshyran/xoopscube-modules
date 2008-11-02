<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;

//
// Define a basic manifesto.
//
$modversion['name'] = _MI_CUBOOKMARKEN_LANG_CUBOOKMARKEN;
$modversion['version'] = 0.75;
$modversion['description'] = _MI_CUBOOKMARKEN_DESC_CUBOOKMARKEN;
$modversion['author'] = "HIKAWA Kilica@ http://xacro.jp";
$modversion['credits'] = "";
$modversion['help'] = "help.html";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image']       = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = "cubookmarken";

$modversion['cube_style'] = true;
$modversion['disable_legacy_2nd_installer'] = false;

// TODO After you made your SQL, remove the following comment-out.
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
##[cubson:tables]
$modversion['tables'][0] = "{prefix}_cubookmarken_bm";
$modversion['tables'][1] = "{prefix}_cubookmarken_tag";
##[/cubson:tables]

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
//$modversion['templates'][]['file'] = 'cubookmarken'_xxxxx.html';
//$modversion['templates'][]['description'] = 'cubookmarken'_xxxxx.html';
##[cubson:templates]
$modversion['templates'][0]['file'] = 'cubookmarken_bm_list.html';
$modversion['templates'][1]['file'] = 'cubookmarken_bm_edit.html';
$modversion['templates'][2]['file'] = 'cubookmarken_bm_delete.html';
$modversion['templates'][3]['file'] = 'cubookmarken_bm_view.html';
$modversion['templates'][4]['file'] = 'cubookmarken_tag_list.html';
//$modversion['templates'][5]['file'] = 'cubookmarken_tag_edit.html';
//$modversion['templates'][6]['file'] = 'cubookmarken_tag_delete.html';
//$modversion['templates'][7]['file'] = 'cubookmarken_tag_view.html';
$modversion['templates'][5]['file'] = 'cubookmarken_bm_implement.html';
$modversion['templates'][6]['file'] = 'cubookmarken_bm_topics.html';
$modversion['templates'][7]['file'] = 'cubookmarken_rss.html';
$modversion['templates'][8]['file'] = 'cubookmarken_tag_replace.html';
$modversion['templates'][9]['file'] = 'cubookmarken_export.html';
$modversion['templates'][10]['file'] = 'cubookmarken_bm_cse.xml';
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
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "cubookmarken_search";

//block
$modversion['blocks'][1]['file'] = "cubookmarken_block_bm.php";
$modversion['blocks'][1]['name'] = _MI_CUBOOKMARKEN_LANG_BM;
$modversion['blocks'][1]['description'] = _MI_CUBOOKMARKEN_DESC_BM;
$modversion['blocks'][1]['show_func'] = "b_cubookmarken_block_bm";
$modversion['blocks'][1]['edit_func'] = "b_cubookmarken_block_bm_edit";
$modversion['blocks'][1]['template'] = 'cubookmarken_block_bm.html';
$modversion['blocks'][1]['options'] = "5";
$modversion['blocks'][1]['visible_any'] = false;
$modversion['blocks'][1]['show_all_module'] = true;
$modversion['blocks'][1]['can_clone'] = true;

$modversion['blocks'][2]['file'] = "cubookmarken_block_tagcloud.php";
$modversion['blocks'][2]['name'] = _MI_CUBOOKMARKEN_LANG_TAGCLOUD;
$modversion['blocks'][2]['description'] = _MI_CUBOOKMARKEN_DESC_TAGCLOUD;
$modversion['blocks'][2]['show_func'] = "b_cubookmarken_block_tagcloud";
$modversion['blocks'][2]['template'] = 'cubookmarken_block_tagcloud.html';
$modversion['blocks'][2]['options'] = "";
$modversion['blocks'][2]['visible_any'] = false;
$modversion['blocks'][2]['show_all_module'] = true;
$modversion['blocks'][2]['can_clone'] = true;

$modversion['blocks'][3]['file'] = "cubookmarken_block_singletag.php";
$modversion['blocks'][3]['name'] = _MI_CUBOOKMARKEN_LANG_SINGLETAG;
$modversion['blocks'][3]['description'] = _MI_CUBOOKMARKEN_DESC_SINGLETAG;
$modversion['blocks'][3]['show_func'] = "b_cubookmarken_block_singletag";
$modversion['blocks'][3]['edit_func'] = "b_cubookmarken_block_singletag_edit";
$modversion['blocks'][3]['template'] = 'cubookmarken_block_singletag.html';
$modversion['blocks'][3]['options'] = "5|";
$modversion['blocks'][3]['visible_any'] = false;
$modversion['blocks'][3]['show_all_module'] = true;
$modversion['blocks'][3]['can_clone'] = true;


// Configs
$modversion['config'][1] = array(
	'name'			=> 'popular_term' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_POP_TERM" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 14 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'popular_count' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_POP_CNT" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 3 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'tagcloud_min' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_TC_MIN" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 80 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'tagcloud_max' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_TC_MAX" ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 200 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'allow_useredit' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_USEREDIT" ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'mb_tag' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_MB_TAG" ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'css_file' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_CSS_FILE" ,
	'description'	=> "_MI_CUBOOKMARKEN_DESC_CSS_FILE" ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '/modules/cubookmarken/cubookmarken.css',
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'cse_replaceurl' ,
	'title'			=> "_MI_CUBOOKMARKEN_LANG_CSE_URL" ,
	'description'	=> "_MI_CUBOOKMARKEN_DESC_CSE_URL" ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1,
	'options'		=> array()
) ;

?>
