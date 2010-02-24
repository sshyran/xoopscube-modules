<?php

$dirname = basename(dirname(dirname(__FILE__)));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

$adminmenu[0]['title'] = constant('_MI_' . $affix . '_ITEM_MANAGE_MENU');
$adminmenu[0]['link'] = 'admin/index.php';

?>