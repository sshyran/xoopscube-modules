<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class Mcllibs_Postcheck extends XCube_ActionFilter
{
  public function postFilter()
  {
    $_GET = isset($_GET) ? $this->chkcharcode($_GET) : array();
    $_POST = isset($_POST) ? $this->chkcharcode($_POST) : array();
    $_COOKIE = isset($_COOKIE) ? $this->chkcharcode($_COOKIE) : array();
    
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
      //captcha check
      if ( isset($_SESSION['_MCLLIBS']['CAPTCHA']['AUTO_CAP']) && (isset($_SESSION['_MCLLIBS']['CAPTCHA']['POSTURL']) && strpos($_SERVER['PHP_SELF'], $_SESSION['_MCLLIBS']['CAPTCHA']['POSTURL']) !== false) || isset($_POST['MCLLIBS_USE_CAPTCHA']) ) {
        if ( !isset($_SESSION['_MCLLIBS']['CAPTCHA']['TOKEN']) || !isset($_POST['MCLLIBS_CAPTCHA']) || $_SESSION['_MCLLIBS']['CAPTCHA']['TOKEN'] != $_POST['MCLLIBS_CAPTCHA'] ) {
          $this->mRoot->mLanguageManager->loadModuleMessageCatalog('mcllibs');
          $url = isset($_SESSION['_MCLLIBS']['CAPTCHA']['RETURL']) ? $_SESSION['_MCLLIBS']['CAPTCHA']['RETURL'] : XOOPS_URL.'/';
          $this->delsession('CAPTCHA');
          $this->mRoot->mController->executeRedirect($url, 3, _MI_MCLLIBS_CAPTCHA_ERR);
          exit;
        }
      }
      
      //postjs check
      if ( isset($_POST['MCL_stoken']) ) {
        if ( !isset($_SESSION['_MCLLIBS']['POSTJS']['TOKEN']) || !isset($_POST['MCL_stoken']) || $_SESSION['_MCLLIBS']['POSTJS']['TOKEN'] != $_POST['MCL_stoken'] ) {
          $this->mRoot->mLanguageManager->loadModuleMessageCatalog('mcllibs');
          $url = isset($_SESSION['_MCLLIBS']['POSTJS']['RETURL']) ? $_SESSION['_MCLLIBS']['POSTJS']['RETURL'] : XOOPS_URL.'/';
          $this->delsession('POSTJS');
          $this->mRoot->mController->executeRedirect($url, 3, _MI_MCLLIBS_POSTJS_ERR);
          exit;
        }
      }
    }
    
    $this->delsession('CAPTCHA');
    $this->delsession('POSTJS');
  }
  
  private function delsession($key)
  {
    if ( isset($_SESSION['_MCLLIBS'][$key]) ) {
      $_SESSION['_MCLLIBS'][$key] = array();
      unset($_SESSION['_MCLLIBS'][$key]);
    }
  }
  
  private function chkcharcode($vals)
  {
    foreach (array_keys($vals) as $key) { 
      if (is_array($vals[$key])) {
        $vals[$key] = $this->chkcharcode($vals[$key]);
      } elseif ( !mb_check_encoding($vals[$key], _CHARSET) ) {
        $vals[$key] = "";
      }
    }
    return $vals;
  }
}
?>