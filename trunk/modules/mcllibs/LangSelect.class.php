<?php
/*
 * MultiLanguage Select Preload
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */

define('_CHARSET', 'UTF-8');
define('_DEF_LANG', 'ja');
define('_MB_LANG', 'Japanese');
ini_set('memory_limit', '64M');

class LangSelect extends XCube_ActionFilter
{
  public function preFilter()
  {
    $this->mRoot->mDelegateManager->add('Legacy_Controller.GetLanguageName', 'LangSelect::setLanguage');
    $this->mRoot->mDelegateManager->add('Legacy_Controller.CreateLanguageManager', 'LangSelect::CreateLanguageManager');
  }
  
  public static function get_LangArray()
  {
    $langs_array = array(
      'en'    => array('english', 'en'),
      'en-gb' => array('english', 'en'),
      'en-us' => array('english', 'en'),
      'en-au' => array('english', 'en'),
      'en-ca' => array('english', 'en'),
      'en-nz' => array('english', 'en'),
      'en-ie' => array('english', 'en'),
      'en-za' => array('english', 'en'),
      'en-jm' => array('english', 'en'),
      'en-bz' => array('english', 'en'),
      'en-tt' => array('english', 'en'),
      'ja'    => array('ja_utf8', 'ja'),
      'ja-jp' => array('ja_utf8', 'ja'),
      'ko'    => array('ko_utf8', 'ko'),
      'fr'    => array('fr_utf8', 'fr'),
      'fr-fr' => array('fr_utf8', 'fr'),
      'fr-be' => array('fr_utf8', 'fr'),
      'fr-ca' => array('fr_utf8', 'fr'),
      'fr-ch' => array('fr_utf8', 'fr'),
      'el'    => array('greek',   'el'),
      'pt'    => array('pt_utf8', 'pt'),
      'tw'    => array('tw_utf8', 'tw'),
    );
    return $langs_array;
  }
  
  public static function setLanguage(&$language)
  {
    $lang = LangSelect::getLangRequest();
    $langs_array = LangSelect::get_LangArray();
    if ( isset($langs_array[$lang]) ) {
      $sellang = $langs_array[$lang];
    } else {
      $sellang = $langs_array[_DEF_LANG];
    }
    $language = $sellang[0];
    
    $parse_array = parse_url(XOOPS_URL);
    $cookiePath = @$parse_array['path'].'/';
    setcookie('_MCLLANG', $sellang[1], time() + (86400 * 30), $cookiePath); 
  }
  
  private static function getLangRequest()
  {
    if ( isset($_GET['_MCLLANG']) ) {
      $templang = $_GET['_MCLLANG'];
    } elseif ( isset($_COOKIE['_MCLLANG']) ) {
      $templang = $_COOKIE['_MCLLANG'];
    } else {
      $templang = LangSelect::getLangAccept();
    }
    return $templang;
  }
  
  private static function getLangAccept()
  {
    $lang = _DEF_LANG;
    if ( !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) {
      $langs = split(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
      $pos = strpos($langs[0], ';');
      if ($pos > 0) {
        $lang = substr($langs[0], 0, $pos);
      } else {
        $lang = $langs[0];
      }
    }
    return $lang;
  }
  
  public static function CreateLanguageManager(&$languageManager, $language)
  {
    require XOOPS_ROOT_PATH.'/modules/mcllibs/kernel/MCL_LanguageManager.class.php';
    $languageManager = new MCL_LanguageManager();
  }
}
?>
