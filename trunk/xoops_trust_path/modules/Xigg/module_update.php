<?php
eval('
function xoops_module_update_' . $module_dirname . '(&$module, $version)
{
    return xigg_xoops_module_update("'. $module_dirname .'", $module, $version);
}
');

if (!function_exists('xigg_xoops_module_update')) {
    function xigg_xoops_module_update($module_dirname, &$module, $version)
    {
        require dirname(__FILE__) . '/common.php';
        require_once dirname(__FILE__) . '/class/module_updater.php';
        $updater =& new xigg_xoops_module_updater($xigg, $version);
        return $updater->execute($module);
    }
}