<?php
if ( !isset($root) ) {
  $root = XCube_Root::getSingleton();
}
$modversion['name'] = _MI_MESSAGE_NAME;
$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['version'] = 0.83;
$modversion['author'] = 'Marijuana';
$modversion['image'] = 'slogo.png';
$modversion['mcl_update'] = 'message';
$modversion['front'] = true;

$modversion['cube_style'] = true;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_inbox';
$modversion['tables'][] = '{prefix}_{dirname}_outbox';
$modversion['tables'][] = '{prefix}_{dirname}_users';

$modversion['legacy_installer']['installer']['class'] = 'myInstaller';
$modversion['legacy_installer']['updater']['class'] = 'myUpdater';

$modversion['templates'][] = array('file' => 'message_inboxlist.html');
$modversion['templates'][] = array('file' => 'message_inboxview.html');
$modversion['templates'][] = array('file' => 'message_outboxlist.html');
$modversion['templates'][] = array('file' => 'message_outboxview.html');
$modversion['templates'][] = array('file' => 'message_new.html');
$modversion['templates'][] = array('file' => 'message_usersearch.html');
$modversion['templates'][] = array('file' => 'message_favorites.html');
$modversion['templates'][] = array('file' => 'message_settings.html');
$modversion['templates'][] = array('file' => 'message_userinfo.html');
$modversion['templates'][] = array('file' => 'message_blaclist.html');

$modversion['hasMain'] = 1;
$modversion['sub'][] = array('name' => _MI_MESSAGE_SUB_SEND, 'url' => 'index.php?action=send');
$modversion['sub'][] = array('name' => _MI_MESSAGE_SUB_NEW, 'url' => 'index.php?action=new');
if ($root->mServiceManager->getService('UserSearch') != null ) {
  $modversion['sub'][] = array('name' => _MI_MESSAGE_SUB_SEARCH, 'url' => 'index.php?action=search');
  $modversion['sub'][] = array('name' => _MI_MESSAGE_SUB_FAVORITES, 'url' => 'index.php?action=favorites');
}
$modversion['sub'][] = array('name' => _MI_MESSAGE_SUB_SETTINGS, 'url' => 'index.php?action=settings');


$modversion['hasAdmin'] = 1;

$modversion['config'][0]['name']        = 'pagenum';
$modversion['config'][0]['title']       = '_MI_MESSAGE_PAGENUM';
$modversion['config'][0]['description'] = '_MI_MESSAGE_PAGENUM_DESC';
$modversion['config'][0]['formtype']    = 'textbox';
$modversion['config'][0]['valuetype']   = 'int';
$modversion['config'][0]['default']     = '15';

$modversion['blocks'][0]['file']        = 'message_block.class.php';
$modversion['blocks'][0]['name']        = _MI_MESSAGE_BLOCK_NAME;
$modversion['blocks'][0]['description'] = '';
$modversion['blocks'][0]['show_func']   = '';
$modversion['blocks'][0]['class']       = 'Block';
$modversion['blocks'][0]['template']    = 'message_block_template.html';
$modversion['blocks'][0]['visible']     = '1';
$modversion['blocks'][0]['func_num']    = 1;
?>
