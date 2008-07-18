<?php
$dirname = dirname(dirname(__FILE__));
require $dirname . '/common.php';
require sprintf('%s/modules/%s/blocks.php', XOOPS_TRUST_PATH, $module_name);