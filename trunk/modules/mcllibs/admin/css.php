<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
session_cache_limiter('private_no_expire');
define('_LEGACY_ALLOW_ACCESS_FROM_ANY_ADMINS_', true);

require_once '../../../mainfile.php';
require_once XOOPS_ROOT_PATH.'/settings/definition.inc.php';
require_once XOOPS_MODULE_PATH.'/mcllibs/admin/kernel/CssRender.class.php';
$root = XCube_Root::getSingleton();
unset($root->mContext->mXoopsModule);

$theme = isset($_GET['theme']) ? trim($_GET['theme']) : null;
$dirname = isset($_GET['dirname']) ? trim($_GET['dirname']) : null;
$file = isset($_GET['file']) ? trim($_GET['file']) : null;
if ( $file == "" ) {
  exit;
}
$file = 'stylesheets/'.$file;

if (strstr($theme, '..') !== false || strstr($dirname, '..') !== false || strstr($file, '..') !== false) {
  exit();
}

$smarty = new AdminCssSmarty($theme);

if ($theme != null && $dirname != null) {
  $path = XOOPS_THEME_PATH . '/'.$theme.'/modules/'.$dirname;
} elseif ($theme != null) {
  $path = XOOPS_ROOT_PATH.'/modules/mcllibs/theme/' .$theme;
} elseif ($dirname != null) {
  $path = XOOPS_MODULE_PATH . '/'.$dirname.'/admin/templates';
} else {
  $path = XOOPS_MODULE_PATH.'/legacy/admin/theme';
}
$smarty->template_dir = $path;

$result = "";
if (is_file($path.'/'.$file)) {
  $result = $smarty->fetch('file:'.$file);
}

header('Content-Type:text/css;');
echo $result;
?>