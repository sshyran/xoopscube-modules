<?php
require dirname(__FILE__) . '/common.php';
require 'SabaiXOOPS/cp_header.inc.php';
require 'Xigg/Admin.php';
require dirname(__FILE__) . '/class/permission_filter.php';
require_once 'Sabai/Handle/Instance.php';
$controller =& new Xigg_Admin();
$controller->prependFilterHandle(new Sabai_Handle_Instance(new xigg_xoops_permission_filter()));
SabaiXOOPS::run($xigg, $controller, 'Xigg', $module_dirname);