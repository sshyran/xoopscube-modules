<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) die();
if (!defined('_ADMIN_THME_PATH')) die();

function getAdminTheme()
{
  $results = array();
  if ($handler = opendir(_ADMIN_THME_PATH)) {
    while (($dirname = readdir($handler)) !== false) {
      if ($dirname == '.' || $dirname == '..') {
        continue;
      }
      $themeDir = _ADMIN_THME_PATH.'/'.$dirname;
      if (is_file($themeDir.'/admin_theme.html')) {
        $results[] = $dirname;
      }
    }
    closedir($handler);
  }
  return $results;
}
?>