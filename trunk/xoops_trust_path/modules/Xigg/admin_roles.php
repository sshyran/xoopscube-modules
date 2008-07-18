<?php
require dirname(__FILE__) . '/common.php';
require 'SabaiXOOPS/cp_header.inc.php';
require dirname(__FILE__) . '/class/admin_roles.php';
require dirname(__FILE__) . '/class/permission_filter.php';
require_once 'Sabai/Handle/Instance.php';
$controller =& new xigg_xoops_admin_roles($xoopsModule);
$controller->prependFilterHandle(new Sabai_Handle_Instance(new xigg_xoops_permission_filter()));
SabaiXOOPS::run($xigg, $controller, $module_dirname, 'Xigg', 'admin.html');