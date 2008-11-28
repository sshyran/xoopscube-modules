<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */
$mydirname = basename( dirname(__FILE__) ) ;

$modversion['name'] = _MI_XCSEARCH_NAME;
$modversion['version'] = 0.95 ;
$modversion['description'] = _MI_XCSEARCH_DESCRIPTION;
$modversion['credits'] = "Tom Hayakawa [tom_g3x@users.sourceforge.jp] , nobunobu , wye";
$modversion['author'] = "Tom Hayakawa [tom_g3x@users.sourceforge.jp]";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/slogo.gif";
$modversion['dirname'] = "xcsearch";

// Database Tables
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'xcsearch_rank';
$modversion['tables'][1] = 'xcsearch_cx';

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

// Templates
$modversion['templates'][1]['file'] = 'xcsearch_index.html';
$modversion['templates'][1]['description'] = '';

$modversion['blocks'][1] = array (
    'file'      => 'b_xcsearch.php',
    'name'      => 'Search',
    'show_func' => 'b_xcsearch_show' ,
    'template'  => 'b_xcsearch.html' ,
    'func_num'  => 1
);
$modversion['blocks'][2] = array (
    'file'      => 'b_xcsearch.php',
    'name'      => 'Keywords Ranking',
    'show_func' => 'b_xcsearch_keywords_show' ,
    'edit_func' => 'b_xcsearch_keywords_edit' ,
    'template'  => 'b_xcsearch_keywords.html' ,
    'options'   => "$mydirname|10|16|0" ,
    'can_clone' => true ,
    'func_num'  => 2 ,
);

//Preferences
$modversion['config'][] = array (
    'name'        => 'xcsearch_rank',
    'title'       => '_MI_XCSEARCH_CONF_RANK_TITLE',
    'description' => '_MI_XCSEARCH_CONF_RANK_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0
);
$modversion['config'][] = array (
    'name'        => 'xcsearch_apikey',
    'title'       => '_MI_XCSEARCH_CONF_APIKEY_TITLE',
    'description' => '_MI_XCSEARCH_CONF_APIKEY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => ''
);
$modversion['config'][] = array (
    'name'        => 'xcsearch_perpage',
    'title'       => '_MI_XCSEARCH_CONF_P_NUM_TITLE',
    'description' => '_MI_XCSEARCH_CONF_P_NUM_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 5
);
$modversion['config'][] = array (
    'name'        => 'xcsearch_next_num',
    'title'       => '_MI_XCSEARCH_CONF_NEXT_TITLE',
    'description' => '_MI_XCSEARCH_CONF_NEXT_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 20
);
$modversion['config'][] = array (
    'name'        => 'xcsearch_default_search',
    'title'       => '_MI_XCSEARCH_CONF_DEF_TITLE',
    'description' => '_MI_XCSEARCH_CONF_DEF_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1 ,
    'options'     => array( _MI_XCSEARCH_CONF_XCSEARCH => 1 , _MI_XCSEARCH_CONF_AJAXSEARCH => 2 , _MI_XCSEARCH_CONF_INSIDE => 3 )
);

?>