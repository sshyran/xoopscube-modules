<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once XOOPS_ROOT_PATH.'/core/XCube_LanguageManager.class.php';

class MCL_LanguageManager extends XCube_LanguageManager
{
  public $lang_array = array();
  
  public function __construct()
  {
    $this->lang_array = LangSelect::get_LangArray();
    $this->mLanguageName = $this->lang_array[_DEF_LANG][0];
    $this->mLocaleName = $this->getFallbackLocale();
  }
  
  public function prepare()
  {
    parent::prepare();
    
    $this->_setupDatabase();
    $this->loadGlobalMessageCatalog();
    $this->_setupMbstring();
  }
  
  public function _setupDatabase()
  {
    if ( function_exists('mysql_set_charset') ) {
      mysql_set_charset('utf8');
    } else {
      $root = XCube_Root::getSingleton();
      $root->mController->mDB->queryF('/*!40101 SET NAMES utf8 */');
    }
  }
  
  public function _setupMbstring()
  {
    if (function_exists('mb_language')) {
      define('MBSTRING', true);
      ini_set('mbstring.language', _MB_LANG);
      ini_set('mbstring.internal_encoding', _CHARSET);
      ini_set('default_charset', _CHARSET);
      ini_set('mbstring.encoding_translation', '0');
      if (function_exists('mb_regex_encoding')) {
        mb_regex_encoding(_CHARSET);
      }
    } else {
      define('MBSTRING', FALSE);
    }
    ini_set('mbstring.http_input', 'pass');
    ini_set('mbstring.http_output', 'pass');
    ini_set('mbstring.substitute_character', 'none');
  }
  
  public function loadGlobalMessageCatalog()
  {
    $this->_loadLanguage('legacy', 'global');
    if (!defined('XOOPS_USE_MULTIBYTES')) {
      define('XOOPS_USE_MULTIBYTES', 0);
    }
  }
  
  public function loadPageTypeMessageCatalog($type)
  {
    if (preg_match("/^\w+$/", $type)) {
      if (!$this->_loadFile(XOOPS_ROOT_PATH.'/language/'.$this->mLanguageName.'/'.$type.'.php')) {
        $this->_loadFile(XOOPS_ROOT_PATH.'/language/'.$this->lang_array[_DEF_LANG][0].'/'.$type.'.php');
      }
    }
  }

  public function loadModuleMessageCatalog($moduleName)
  {
    $this->_loadLanguage($moduleName, 'main');
  }
  
  public function loadModuleAdminMessageCatalog($dirname)
  {
    $this->_loadLanguage($dirname, 'admin');
  }
  
  public function loadBlockMessageCatalog($dirname)
  {
    $this->_loadLanguage($dirname, 'blocks');
  }
  
  public function loadModinfoMessageCatalog($dirname)
  {
    $this->_loadLanguage($dirname, 'modinfo');
  }
  
  public function loadExtraMessageCatalog($dirname, $fileBodyName)
  {
    if (preg_match("/^[0-9a-zA-Z-_\.]+$/", $type)) {
      $this->_loadLanguage($dirname, $fileBodyName);
    }
  }
  
  private function _loadLanguage($dirname, $fileBodyName)
  {
    if (!$this->_loadFile(XOOPS_MODULE_PATH.'/'.$dirname.'/language/'.$this->mLanguageName.'/'.$fileBodyName.'.php')) {
      $this->_loadFile(XOOPS_MODULE_PATH.'/'.$dirname.'/language/'.$this->lang_array[_DEF_LANG][0].'/'.$fileBodyName.'.php');
    }
  }
  
  private function _loadFile($filename)
  {
    if (is_file($filename)) {
      require_once $filename;
      return true;
    }
    return false;
  }
}
?>