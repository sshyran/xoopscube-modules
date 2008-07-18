<?php
eval('
function xoops_module_install_' . $module_dirname . '(&$module)
{
    return xigg_xoops_module_install("'. $module_dirname .'", $module);
}
');

if (!function_exists('xigg_xoops_module_install')) {
    function xigg_xoops_module_install($module_dirname, &$module)
    {
        require dirname(__FILE__) . '/common.php';
        require_once dirname(__FILE__) . '/class/module_installer.php';
        $installer =& new xigg_xoops_module_installer($xigg);
        return $installer->execute($module);
    }
}