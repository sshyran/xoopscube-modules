<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_videobox($params, &$smarty)
{
  $root = XCube_Root::getSingleton();
  $root->mDelegateManager->add('MCLLIBS.ModuleHeader', 'mcllibs_videobox::_mcllibs_videobox');
}

class mcllibs_videobox
{
  private static $read = false;
  public static function _mcllibs_videobox(&$header)
  {
    if ( self::$read == false ) {
      $js = '<script type="text/javascript" src="%s"></script>';
      $f = XOOPS_MODULE_URL.'/mcllibs/common/videobox/';
      $header[] = '<!-- videobox -->';
      $header[] = sprintf($js, $f.'js/mootools.js');
      $header[] = sprintf($js, $f.'js/swfobject.js');
      $header[] = sprintf($js, $f.'js/videobox.js');
      $header[] = '<link rel="stylesheet" href="'.$f.'css/videobox.css" type="text/css" media="screen" />';
      $header[] = '<!-- /videobox -->';
      self::$read = true;
    }
  }
}
?>
