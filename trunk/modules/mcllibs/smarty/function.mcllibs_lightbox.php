<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_lightbox($params, &$smarty)
{
  $root = XCube_Root::getSingleton();
  $root->mDelegateManager->add('MCLLIBS.ModuleHeader', 'mcllibs_lightbox::_mcllibs_lightbox');
}

class mcllibs_lightbox
{
  private static $read = false;
  public static function _mcllibs_lightbox(&$header)
  {
    if ( self::$read == false ) {
      $js = '<script type="text/javascript" src="%s"></script>';
      $f = XOOPS_MODULE_URL.'/mcllibs/common/lightbox/';
      $header[] = '<!-- lightbox -->';
      $header[] = sprintf($js, $f.'js/prototype.js');
      $header[] = sprintf($js, $f.'js/scriptaculous.js?load=effects,builder');
      $header[] = sprintf($js, $f.'js/lightbox.js');
      $header[] = '<link rel="stylesheet" href="'.$f.'css/lightbox.css" type="text/css" media="screen" />';
      $header[] = '<script type="text/javascript">';
      $header[] = 'LightboxOptions.fileLoadingImage = "'.XOOPS_MODULE_URL.'/mcllibs/common/lightbox/images/loading.gif";';
      $header[] = 'LightboxOptions.fileBottomNavCloseImage = "'.XOOPS_MODULE_URL.'/mcllibs/common/lightbox/images/closelabel.gif";';
      $header[] = '</script>';
      $header[] = '<!-- /lightbox -->';
      self::$read = true;
    }
  }
}
?>
