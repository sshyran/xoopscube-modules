<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class XCube_Root
{
  public $mController = null;
  public $mDelegateManager = null;
  
  private static $instance;
  
  private function __construct()
  {
  }
  
  public static function getSingleton()
  {
    if ( !isset(self::$instance) ) {
      self::$instance = new XCube_Root();
    }
    return self::$instance;
  }
  
  public function LoadController()
  {
    $this->mController = new Session_Controller();
  }
}

class Session_Controller
{
  public $mDB;
  public $mXoopsConfig;
  public $mSession;
  
  public function __construct()
  {
    $this->_setupDB();
    $this->_setupConfig();
    $this->_setupSession();
    $this->_loadlang();
    $this->mDB->Dbcharset();
  }
  
  private function _loadlang()
  {
    $LangManager = new MCL_LanguageManager();
    $LangManager->setLanguage($this->mXoopsConfig['language']);
    $LangManager->prepare();
  }
  
  private function _setupDB()
  {
    $this->mDB = MCL_MySQL::getInstance();
  }
  
  private function _setupConfig()
  {
    $sql = 'SELECT * FROM `'.$this->mDB->prefix('config').'` ';
    $sql.= 'WHERE `conf_modid` = 0 ';
    $sql.= 'AND `conf_catid` = 1 ';
    $sql.= 'ORDER BY `conf_order` ASC';
    $result = $this->mDB->select_query($sql);
    while ($myrow = $this->mDB->fetchArray($result)) {
      switch ($myrow['conf_valuetype']) {
        case 'int':
          $ret = intval($myrow['conf_value']);
          break;
        case 'array':
          $ret = unserialize($myrow['conf_value']);
          break;
        case 'float':
          $ret = floatval($myrow['conf_value']);
          break;
        case 'textarea':
          $ret = $myrow['conf_value'];
          break;
        default:
          $ret = htmlspecialchars($myrow['conf_value'], ENT_QUOTES);
          break;
      }
      $this->mXoopsConfig[$myrow['conf_name']] = $ret;
    }
  }
  
  private function _setupSession()
  {
    $this->mSession = new XCube_Session();
    $this->mSession->mSetupSessionHandler->add('Session_Controller::setupSessionHandler');
    $this->mSession->mGetSessionCookiePath->add('Session_Controller::getSessionCookiePath');
    
    if ($this->mXoopsConfig['use_mysession']) {
      $this->mSession->setParam($this->mXoopsConfig['session_name'], $this->mXoopsConfig['session_expire']);
    }
    $this->mSession->start();
  }
  
  public static function setupSessionHandler()
  {
    $sessionHandler = new DbSession();
    session_set_save_handler(
      array($sessionHandler, 'open'),
      array($sessionHandler, 'close'),
      array($sessionHandler, 'read'),
      array($sessionHandler, 'write'),
      array($sessionHandler, 'destroy'),
      array($sessionHandler, 'gc'));
  }

  public static function getSessionCookiePath(&$cookiePath)
  {
    $pathArray = explode($_SERVER['HTTP_HOST'], XOOPS_URL);
    $cookiePath = $pathArray[1].'/';
  }
}

class DbSession
{
  private $mDB;
  
  public function __construct()
  {
    $this->mDB = MCL_MySQL::getInstance();
  }
  
  public function open($save_path, $session_name)
  {
    return true;
  }

  public function close()
  {
    return true;
  }
  
  public function read($sess_id)
  {
    $sess_data = "";
    $sql = "SELECT `sess_data` FROM `".$this->mDB->prefix('session')."` WHERE `sess_id` = '".$this->mDB->escape_string($sess_id)."'";
    $result = $this->mDB->select_query($sql);
    list($sess_data) = $this->mDB->fetchRow($result);
    return $sess_data;
  }
  
  public function write($sess_id, $sess_data)
  {
    $sql = "INSERT INTO `".$this->mDB->prefix('session')."` (`sess_id`, `sess_updated`, `sess_ip`, `sess_data`) ";
    $sql.= "VALUES ('".$this->mDB->escape_string($sess_id)."',".time().",'".$this->mDB->escape_string($_SERVER['REMOTE_ADDR'])."','".$this->mDB->escape_string($sess_data)."')";
    if ( !$this->mDB->insert_query($sql) ) {
      $sql = "UPDATE `".$this->mDB->prefix('session')."` ";
      $sql.= "SET `sess_updated` = ".time().", ";
      $sql.= "`sess_data` = '".$this->mDB->escape_string($sess_data)."', ";
      $sql.= "WHERE `sess_id` = '".$this->mDB->escape_string($sess_id)."'";
      if ( !$this->mDB->update_query($sql) ) {
        return false;
      }
    }
    return true;
  }
  
  public function destroy($sess_id)
  {
    $sql = "DELETE FROM `".$this->mDB->prefix('session')."` WHERE `sess_id` = '".$this->mDB->escape_string($sess_id)."'";
    return $this->mDB->delete_query($sql);
  }
  
  public function gc($expire)
  {
    $sql = "DELETE FROM `".$this->mDB->prefix('session')."` WHERE `sess_updated` < ". time() - intval($expire);
    return $this->mDB->delete_query($sql);
  }
}

class MCL_LanguageManager extends XCube_LanguageManager
{
  public function prepare()
  {
    parent::prepare();
    $this->loadGlobalMessageCatalog();
  }
  
  public function loadGlobalMessageCatalog()
  {
    $file = XOOPS_ROOT_PATH.'/modules/'._MCLBASE_DIRNAME.'/language/'.$this->mLanguageName.'/global.php';
    if ( is_file($file) ) {
      require_once $file;
    } else {
      require_once XOOPS_ROOT_PATH.'/modules/'._MCLBASE_DIRNAME.'/language/ja_utf8/global.php';
    }
  }
}
?>
