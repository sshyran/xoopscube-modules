<?php
if (isset($xoopsUser) && is_object($xoopsUser)) {
    $url_arr = explode('/',strstr($xoopsRequestUri,'/modules/'));
    $module_handler =& xoops_gethandler('module');
    $xoopsModule =& $module_handler->getByDirname($url_arr[2]);
    unset($url_arr);
    $moduleperm_handler = & xoops_gethandler('groupperm');
    if (!$moduleperm_handler->checkRight('module_admin', $xoopsModule->getVar('mid'), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
    exit();
}
// set config values for this module
if ($xoopsModule->getVar('hasconfig') == 1 || $xoopsModule->getVar('hascomments') == 1) {
    $config_handler = & xoops_gethandler('config');
    $xoopsModuleConfig = & $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
}
require XOOPS_ROOT_PATH . '/include/cp_functions.php';