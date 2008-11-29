<?php

$waffle_mydirname = basename( dirname( __FILE__ ) ) ;
if( preg_match( '/^waffle(\d*)$/' , $waffle_mydirname , $regs ) ) {
	$waffle_mydirnumber = $regs[1] ;
} else {
	echo "invalid dirname of waffle: " . htmlspecialchars( $mydirname ) ;
}

$modversion['name'] = _MI_WAFFLE_NAME . $waffle_mydirnumber;
$modversion['version'] = 0.9;
$modversion['description'] = _MI_WAFFLE_DESC;
$modversion['credits'] = "Masahiko Tokita";
$modversion['author'] = "Masahiko Tokita http://tokita.info/";
$modversion['help'] = "waffle.html";
$modversion['license'] = "MIT Lisence";
$modversion['official'] = 0;
$modversion['image'] = "images/waffle_logo.png";
$modversion['dirname'] = $waffle_mydirname;

// Sql file
$modversion['sqlfile']['mysql'] = "sql/" . $waffle_mydirname . "_mysql.sql";

// Tables 
$modversion['tables'][0] = $waffle_mydirname . "_config";
$modversion['tables'][1] = $waffle_mydirname . "_table";
$modversion['tables'][2] = $waffle_mydirname . "_column";
$modversion['tables'][3] = $waffle_mydirname . "_option";
$modversion['tables'][4] = $waffle_mydirname . "_grant_group";
$modversion['tables'][5] = $waffle_mydirname . "_grant_user";
$modversion['tables'][6] = $waffle_mydirname . "_image";
$modversion['tables'][7] = $waffle_mydirname . "_file";
$modversion['tables'][8] = $waffle_mydirname . "_data1";
$modversion['tables'][9] = $waffle_mydirname . "_data2";
$modversion['tables'][10] = $waffle_mydirname . "_data3";
$modversion['tables'][11] = $waffle_mydirname . "_data4";
$modversion['tables'][12] = $waffle_mydirname . "_data5";
$modversion['tables'][13] = $waffle_mydirname . "_data6";
$modversion['tables'][14] = $waffle_mydirname . "_data7";
$modversion['tables'][15] = $waffle_mydirname . "_data8";
$modversion['tables'][16] = $waffle_mydirname . "_data9";
$modversion['tables'][17] = $waffle_mydirname . "_data10";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
//$modversion['adminindex'] = "admin/myblocksadmin.php";
$modversion['adminmenu'] = "admin/menu.php";

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = $waffle_mydirname . "_search";

// Main contents
$modversion['hasMain'] = 1;

$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname($waffle_mydirname);
if( is_object( $module ) ) {
    $myts =& MyTextSanitizer::getInstance();
    $db =& Database::getInstance() ;
    $result = $db->query("SELECT id,name,valid FROM ".$db->prefix($waffle_mydirname)."_table ORDER BY `order`" ) ;

    $i = 1 ;
    while( list( $id , $name, $valid ) = $db->fetchRow( $result ) )
    {
	if ($valid) {
	    $modversion['sub'][$i]['name'] = $myts->makeTboxData4Show( $name ) ;
	    $modversion['sub'][$i]['url'] = 'index.php?t_m=ddcommon_list&t_dd='.$waffle_mydirname.'_data' . $id;
	    $i++;
	}
	
	// Tables
	if (10 < $id) {
	    $modversion['tables'][] = $waffle_mydirname . "_data" . intval($id);
	}
    }
}

// Templates
$modversion['templates'][1]['file'] = $waffle_mydirname . '_ddcommon_list.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = $waffle_mydirname . '_ddcommon_insert.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = $waffle_mydirname . '_ddcommon_view.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = $waffle_mydirname . '_ddcommon_view_one.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = $waffle_mydirname . '_ddcommon_delete.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = $waffle_mydirname . '_ddcommon_update.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = $waffle_mydirname . '_ddcommon_form.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = $waffle_mydirname . '_ddcommon_index.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = $waffle_mydirname . '_ddcommon_rdf.html';
$modversion['templates'][9]['description'] = '';
$modversion['templates'][10]['file'] = $waffle_mydirname . '_ddcommon_rss092.html';
$modversion['templates'][10]['description'] = '';
$modversion['templates'][11]['file'] = $waffle_mydirname . '_ddcommon_rss20.html';
$modversion['templates'][11]['description'] = '';
$modversion['templates'][12]['file'] = $waffle_mydirname . '_ddcommon_atom03.html';
$modversion['templates'][12]['description'] = '';
$modversion['templates'][13]['file'] = $waffle_mydirname . '_list_navi_bar.html';
$modversion['templates'][13]['description'] = '';


// Blocks
//$modversion['blocks'][1]['file'] = "waffle_block.php";
//$modversion['blocks'][1]['name'] = _MI_WAFFLE_BLOCK;
//$modversion['blocks'][1]['description'] = "WAFFLE BLOCK";
//$modversion['blocks'][1]['show_func'] = "b_waffle_block";
//$modversion['blocks'][1]['template'] = "waffle_block.html";

$waffle_tmpdir = dirname(__FILE__);
if (is_readable($waffle_tmpdir . '/plugin/plugin_xoops_version.php')) {
    include_once($waffle_tmpdir . '/plugin/plugin_xoops_version.php');
    if (function_exists('plugin_xoops_version')) {
	$func = 'plugin_xoops_version';
	$modversion = $func($modversion);
    }
}

?>
