<?php
$const_prefix = '_MI_' . strtoupper($module_dirname);
$adminmenu[1]['title'] = constant($const_prefix . '_ADMENU_CATEGORIES');
$adminmenu[1]['link'] = 'admin.php/category';
$adminmenu[2]['title'] = constant($const_prefix . '_ADMENU_NODES');
$adminmenu[2]['link'] = 'admin.php/node';
$adminmenu[3]['title'] = constant($const_prefix . '_ADMENU_TAGS');
$adminmenu[3]['link'] = 'admin.php/tag';
$adminmenu[4]['title'] = constant($const_prefix . '_ADMENU_PLUGINS');
$adminmenu[4]['link'] = 'admin.php/plugin';
$adminmenu[5]['title'] = constant($const_prefix . '_ADMENU_ROLES');
$adminmenu[5]['link'] = 'admin.php/role';
$adminmenu[6]['title'] = constant($const_prefix . '_ADMENU_XROLES');
$adminmenu[6]['link'] = 'admin_roles.php';
$adminmenu[7]['title'] = constant($const_prefix . '_ADMENU_USERS');
$adminmenu[7]['link'] = 'admin.php/user';