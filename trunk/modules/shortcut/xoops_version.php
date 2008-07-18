<?php
// $Id: xoops_version.php,v 1.7 2008-07-06 07:36:56 nobu Exp $
// 
$mydirpath = dirname(__FILE__);
$myicon = "images/shortcut_slogo.png";
if (!file_exists("$mydirpath/$myicon")) $myicon = "module_icon.php";

$modversion['name'] = _MI_SHORTCUT_NAME;
$modversion['version'] = "0.6";
$modversion['description'] = _MI_SHORTCUT_DESC;
$modversion['credits'] = "Nobuhiro YASUTOMI <br/>http://mysite.ddo.jp/";
$modversion['author'] = "Nobuhiro Yasutomi";
$modversion['help'] = "help.html";
$modversion['license'] = "modified BSD";
$modversion['official'] = 0;
$modversion['image'] = $myicon;
$modversion['dirname'] = "shortcut";


// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
//$modversion['sqlfile']['postgresql'] = "sql/pgsql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'] = array("shortcut");

// OnUpdate - upgrade DATABASE 
$modversion['onUpdate'] = "onupdate.php";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Templates
$modversion['templates'][]=array('file' => 'shortcut_index.html',
				 'description' => '');
$modversion['templates'][]=array('file' => 'shortcut_register.html',
				 'description' => '');
// Blocks
$modversion['blocks'][1]=
    array('file' => "shortcut_block.php",
	  'name' => _MI_SHORTCUT_BLOCK_MENU,
	  'description' => _MI_SHORTCUT_BLOCK_MENU_DESC,
	  'show_func' => "b_shortcut_show",
	  'edit_func' => "b_shortcut_edit",
	  'options' => '0',
	  'template' => 'shortcut_block_menu.html');

$modversion['blocks'][]=
    array('file' => "shortcut_block.php",
	  'name' => _MI_SHORTCUT_BLOCK_MYMENU,
	  'description' => _MI_SHORTCUT_BLOCK_MYMENU_DESC,
	  'show_func' => "b_shortcut_show",
	  'edit_func' => "b_shortcut_edit",
	  'options' => '1',
	  'template' => 'shortcut_block_menu.html');

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][] = array('name'=>_MI_SHORTCUT_REGISTER,
			     'url'=>'register.php');

?>
