<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_greybox($params, &$smarty)
{
  $root = XCube_Root::getSingleton();
  $root->mDelegateManager->add('MCLLIBS.ModuleHeader', 'mcllibs_greybox::_mcllibs_greybox');
}

class mcllibs_greybox
{
  private static $read = false;
  public static function _mcllibs_greybox(&$header)
  {
    if ( self::$read == false ) {
      $js = '<script type="text/javascript" src="%s"></script>';
      $f = XOOPS_MODULE_URL.'/mcllibs/common/greybox/';
      $header[] = '<!-- greybox -->';
      $header[] = '<script type="text/javascript">';
      $header[] = 'var GB_ROOT_DIR = "'.$f.'";';
      $header[] = '</script>';
      $header[] = sprintf($js, $f.'AJS.js');
      $header[] = sprintf($js, $f.'AJS_fx.js');
      $header[] = sprintf($js, $f.'gb_scripts.js');
      $header[] = '<link rel="stylesheet" href="'.$f.'gb_styles.css" type="text/css" media="screen" />';
      $header[] = '<!-- /greybox -->';
      self::$read = true;
    }
  }
}
?>
