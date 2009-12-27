<?php
//  ------------------------------------------------------------------------ //
//                      MyX_BackUp - XOOPS Module                            //
//                   Copyright (c) 2005- taquino.net                         //
//                     <http://xoops.taquino.net/>                           //
//  ------------------------------------------------------------------------ //
//                                                                           //
//               Attribution-NonCommercial-NoDerivs 2.1 Japan                //
//            http://creativecommons.org/licenses/by-nc-nd/2.1/jp/           //
//                                                                           //
// ------------------------------------------------------------------------- //

if (!defined('XOOPS_ROOT_PATH')) { exit(); }
$myxbu_mydirname = basename(dirname(__FILE__));

$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;


$modversion['name']         = _MI_MYXBACKUP_TITLE;
$modversion['version']      = "1.10";
$modversion['description']  = _MI_MYXBACKUP_DESC;
$modversion['credits']      = "Taquino";
$modversion['author']       = "http://xoops.taquino.net/";
$modversion['help']         = '';
$modversion['license']      = "Creative Commons Attribution-NonCommercial-NoDerivs 2.1 Japan<br />'.
                              'http://creativecommons.org/licenses/by-nc-nd/2.1/jp/";
$modversion['official']     = 0;
$modversion['image']       = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;

$modversion['dirname']      = $myxbu_mydirname;

$modversion['hasAdmin']     = 1;
$modversion['adminindex']   = "admin/index.php";
$modversion['adminmenu']    = "admin/menu.php";

$modversion['hasMain']      = 0;
$modversion['hasSearch']    = 0;
$modversion['hasComments']  = 0;

$modversion['config'][1]['name']        = 'DEBUG_MODE';
$modversion['config'][1]['title']       = "_MI_MYXBACKUP_CFG_DEBUG_TITLE";
$modversion['config'][1]['description'] = "_MI_MYXBACKUP_CFG_DEBUG_DESC";
$modversion['config'][1]['formtype']    = 'yesno';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = 0;

$modversion['config'][2]['name']        = 'CHECK_TYPE';
$modversion['config'][2]['title']       = "_MI_MYXBACKUP_CFG_CHECK_TITLE";
$modversion['config'][2]['description'] = "_MI_MYXBACKUP_CFG_CHECK_DESC";
$modversion['config'][2]['formtype']    = 'select';
$modversion['config'][2]['valuetype']   = 'text';
$modversion['config'][2]['options']     = array('FAST QUICK' => 'FAST QUICK', 'QUICK' => 'QUICK', 'FAST' => 'FAST', 'CHANGED' => 'CHANGED', 'MEDIUM' => 'MEDIUM', 'EXTENDED' => 'EXTENDED');
$modversion['config'][2]['default']     = 'MEDIUM';

$modversion['config'][3]['name']        = 'COMP_INS';
$modversion['config'][3]['title']       = "_MI_MYXBACKUP_CFG_COMPI_TITLE";
$modversion['config'][3]['description'] = "_MI_MYXBACKUP_CFG_COMPI_DESC";
$modversion['config'][3]['formtype']    = 'yesno';
$modversion['config'][3]['valuetype']   = 'int';
$modversion['config'][3]['default']     = 1;

$modversion['config'][4]['name']        = 'DIR_AS_MODULE_NAME';
$modversion['config'][4]['title']       = "_MI_MYXBACKUP_CFG_DIRMOD_TITLE";
$modversion['config'][4]['description'] = "_MI_MYXBACKUP_CFG_DIRMOD_DESC";
$modversion['config'][4]['formtype']    = 'yesno';
$modversion['config'][4]['valuetype']   = 'int';
$modversion['config'][4]['default']     = 1;
?>