<?php
eval('
function xoops_module_uninstall_' . $module_dirname . '(&$module)
{
    return xigg_xoops_module_uninstall("'. $module_dirname .'", $module);
}
');

if (!function_exists('xigg_xoops_module_uninstall')) {
    function xigg_xoops_module_uninstall($module_dirname, &$module)
    {
        // This is a fix for XC Legacy where module data is already removed from the db at this point
        $GLOBALS['xoopsModule'] =& $module;
        require dirname(__FILE__) . '/common.php';
        require_once dirname(__FILE__) . '/class/module_uninstaller.php';
        $uninstaller =& new xigg_xoops_module_uninstaller($xigg, $module->getVar('version'));
        return $uninstaller->execute($module);
    }
}