<?php
/**
 * @author Marijuana
 */
$root = XCube_Root::getSingleton();
$root->mLanguageManager->loadModinfoMessageCatalog('legacy');
$root->mLanguageManager->loadModinfoMessageCatalog('user');

$modversion['name'] = 'MCL Librarys';
$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['version'] = 0.40;
$modversion['author'] = 'Marijuana';
$modversion['image'] = 'slogo.png';
$modversion['mcl_update'] = 'mcllibs';
$modversion['front'] = true;
$modversion['read_any'] = true;

$modversion['legacy_installer']['installer']['class'] = 'myInstaller';

$modversion['hasAdmin'] = 1;

$modversion['cube_style'] = true;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_comment';

$modversion['templates'][] = array('file' => 'mcllibs_login.html');
$modversion['templates'][] = array('file' => 'mcllibs_register_confirm.html');

$modversion['templates'][] = array('file' => 'mcllibs_comment_edit.html');
$modversion['templates'][] = array('file' => 'mcllibs_comment_delete.html');


$modversion['config'][0]['name']        = 'admintheme';
$modversion['config'][0]['title']       = '_MI_MCLLIBS_CONF';
$modversion['config'][0]['description'] = '_MI_MCLLIBS_DESC';
$modversion['config'][0]['formtype']    = 'admintheme';
$modversion['config'][0]['valuetype']   = 'text';
$modversion['config'][0]['default']     = 'default';

$modversion['config'][1]['name']        = 'viewblock';
$modversion['config'][1]['title']       = '_MI_MCLLIBS_BLOCKV';
$modversion['config'][1]['description'] = '_MI_MCLLIBS_BLOCKV_DESC';
$modversion['config'][1]['formtype']    = 'yesno';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = '1';

$modversion['config'][2]['name']        = 'allowloginid';
$modversion['config'][2]['title']       = '_MI_MCLLIBS_LOGIN_OPT';
$modversion['config'][2]['description'] = '_MI_MCLLIBS_LOGIN_OPT';
$modversion['config'][2]['formtype']    = 'select';
$modversion['config'][2]['valuetype']   = 'int';
$modversion['config'][2]['default']     = '0';
$modversion['config'][2]['options']     = array('_MI_MCLLIBS_LOGIN_ALL' => 0, '_MI_MCLLIBS_LOGIN_EMAIL' => 1, '_MI_MCLLIBS_LOGIN_UNAME' => 2);

$modversion['config'][3]['name']        = 'autologin';
$modversion['config'][3]['title']       = '_MI_MCLLIBS_LOGIN_AUTO';
$modversion['config'][3]['description'] = '_MI_MCLLIBS_LOGIN_AUTO';
$modversion['config'][3]['formtype']    = 'yesno';
$modversion['config'][3]['valuetype']   = 'int';
$modversion['config'][3]['default']     = '0';

// Blocks
$modversion['blocks'][0]['func_num'] = 1;
$modversion['blocks'][0]['file'] = 'mcllibs_main.class.php';
$modversion['blocks'][0]['name'] = _MI_LEGACY_BLOCK_MAINMENU_NAME;
$modversion['blocks'][0]['description'] = _MI_LEGACY_BLOCK_MAINMENU_DESC;
$modversion['blocks'][0]['class'] = 'Mainmenu';
$modversion['blocks'][0]['visible_any'] = true;
$modversion['blocks'][0]['show_all_module'] = true;
$modversion['blocks'][0]['template']    = 'mcllibs_block_mainmenu.html';
$modversion['blocks'][0]['options'] = '1';

$modversion['blocks'][1]['func_num'] = 2;
$modversion['blocks'][1]['file'] = 'mcllibs_usermenu.class.php';
$modversion['blocks'][1]['name'] = _MI_LEGACY_BLOCK_USERMENU_NAME;
$modversion['blocks'][1]['description'] = _MI_LEGACY_BLOCK_USERMENU_DESC;
$modversion['blocks'][1]['class'] = 'Usermenu';
$modversion['blocks'][1]['show_all_module'] = true;
$modversion['blocks'][1]['visible_any'] = true;

$modversion['blocks'][2]['func_num'] = 3;
$modversion['blocks'][2]['file'] = 'mcllibs_theme.class.php';
$modversion['blocks'][2]['name'] = _MI_LEGACY_BLOCK_THEMES_NAME;
$modversion['blocks'][2]['description'] = _MI_LEGACY_BLOCK_THEMES_DESC;
$modversion['blocks'][2]['class'] = 'Theme';
$modversion['blocks'][2]['options'] = '0|80';

$modversion['blocks'][3]['func_num'] = 4;
$modversion['blocks'][3]['file'] = 'mcllibs_search.class.php';
$modversion['blocks'][3]['name'] = _MI_LEGACY_BLOCK_SEARCH_NAME;
$modversion['blocks'][3]['description'] = _MI_LEGACY_BLOCK_SEARCH_DESC;
$modversion['blocks'][3]['class'] = 'Search';

$modversion['blocks'][4]['func_num'] = 5;
$modversion['blocks'][4]['file'] = 'mcllibs_login.class.php';
$modversion['blocks'][4]['name'] = _MI_USER_BLOCK_LOGIN_NAME;
$modversion['blocks'][4]['description'] = _MI_USER_BLOCK_LOGIN_DESC;
$modversion['blocks'][4]['class'] = 'BlockLogin';
$modversion['blocks'][4]['show_all_module'] = true;
$modversion['blocks'][4]['visible_any'] = true;
$modversion['blocks'][4]['template']    = 'mcllibs_block_login.html';

$modversion['blocks'][5]['func_num'] = 6;
$modversion['blocks'][5]['file'] = 'mcllibs_langset.class.php';
$modversion['blocks'][5]['name'] = _MI_MCLLIBS_BLOCK_LANGSET_NAME;
$modversion['blocks'][5]['description'] = _MI_MCLLIBS_BLOCK_LANGSET_DESC;
$modversion['blocks'][5]['class'] = 'Langset';
$modversion['blocks'][5]['template'] = 'mcllibs_block_lang.html';
?>
