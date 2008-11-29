<?php
$modversion['name'] = _MI_USERSEARCH_NAME;
$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['version'] = 0.20;
$modversion['description'] = _MI_USERSEARCH_DESC;
$modversion['author'] = 'Marijuana';
$modversion['image'] = 'slogo.png';
$modversion['mcl_update'] = 'usersearch';

$modversion['cube_style'] = true;
$modversion['read_any'] = false;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_favorites';

$modversion['legacy_installer']['updater']['class'] = 'myUpdater';
$modversion['legacy_installer']['updater']['filepath'] = XOOPS_MODULE_PATH.'/'.$modversion['dirname'].'/class/myUpdater.class.php';

$modversion['hasMain'] = 0;
?>