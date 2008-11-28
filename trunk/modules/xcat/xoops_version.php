<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

//
// Define a basic manifesto.
//
$modversion['name'] = _MI_XCAT_LANG_XCAT;
$modversion['version'] = 0.43;
$modversion['description'] = _MI_XCAT_DESC_XCAT;
$modversion['author'] = "HIKAWA Kilica";
$modversion['credits'] = "";
$modversion['help'] = "help.html";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image'] = "images/xcat.png";
$modversion['dirname'] = "xcat";

$modversion['cube_style'] = true;
$modversion['disable_legacy_2nd_installer'] = false;

// TODO After you made your SQL, remove the following comment-out.
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
##[cubson:tables]
$modversion['tables'][0] = "{prefix}_xcat_cat";
$modversion['tables'][1] = "{prefix}_xcat_gr";
$modversion['tables'][2] = "{prefix}_xcat_permit";
$modversion['tables'][3] = "{prefix}_xcat_mod";
##[/cubson:tables]

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
//$modversion['templates'][]['file'] = 'xcat'_xxxxx.html';
//$modversion['templates'][]['description'] = 'xcat'_xxxxx.html';
##[cubson:templates]
$modversion['templates'][0]['file'] = 'xcat_gr_list.html';
$modversion['templates'][1]['file'] = 'xcat_gr_edit.html';
$modversion['templates'][2]['file'] = 'xcat_gr_delete.html';
$modversion['templates'][3]['file'] = 'xcat_gr_view.html';
$modversion['templates'][4]['file'] = 'xcat_cat_list.html';
$modversion['templates'][5]['file'] = 'xcat_cat_edit.html';
$modversion['templates'][6]['file'] = 'xcat_cat_delete.html';
$modversion['templates'][7]['file'] = 'xcat_cat_view.html';
$modversion['templates'][8]['file'] = 'xcat_permit_list.html';
$modversion['templates'][9]['file'] = 'xcat_permit_edit.html';
$modversion['templates'][10]['file'] = 'xcat_permit_delete.html';
$modversion['templates'][11]['file'] = 'xcat_permit_view.html';
$modversion['templates'][12]['file'] = 'xcat_mod_list.html';
$modversion['templates'][13]['file'] = 'xcat_mod_edit.html';
$modversion['templates'][14]['file'] = 'xcat_mod_delete.html';
$modversion['templates'][15]['file'] = 'xcat_mod_view.html';
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

?>
