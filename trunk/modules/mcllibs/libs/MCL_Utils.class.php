<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCL_Utils
{
  private static $modhandlers = array();
  private static $handlers = array();
  
  //Legaacy
  public static function getmodulehandler($name, $module_dir = null)
  {
    $root = XCube_Root::getSingleton();
    if (empty($module_dir)) {
      if (isset($root->mContext->mXoopsModule) && is_object($root->mContext->mXoopsModule)) {
        $module_dir = $root->mContext->mXoopsModule->get('dirname');
      } else {
        trigger_error('No Module is loaded', E_USER_ERROR);
      }
    }
    
    if (!isset(parent::$modhandlers[$module_dir][$name])) {
      if (is_file($hnd_file = XOOPS_ROOT_PATH.'/modules/'.$module_dir.'/class/handler/'.ucfirst($name).'.class.php')) {
        include_once $hnd_file;
      } elseif (is_file($hnd_file = XOOPS_ROOT_PATH.'/modules/'.$module_dir.'/class/'.$name.'.php' ) ) {
        include_once $hnd_file;
      }
      $className = ucfirst(strtolower($module_dir)).'_'.ucfirst($name).'Handler';
      if (class_exists($className)) {
        self::$modhandlers[$module_dir][$name] = new $className($root->mController->mDB);
      } else {
        $className = ucfirst(strtolower($module_dir)).ucfirst($name).'Handler';
        if (class_exists($className)) {
          self::$modhandlers[$module_dir][$name] = new $className($root->mController->mDB);
        }
      }
    }
    
    if (!isset(self::$modhandlers[$module_dir][$name])) {
      trigger_error('Handler does not exist<br />Module: '.$module_dir.'<br />Name: '.$name, E_USER_ERROR);
    }
    return self::$modhandlers[$module_dir][$name];
  }
  
  //Legaacy
  public static function gethandler($name)
  {
    $name = strtolower($name);
    if (!isset(self::$handlers[$name])) {
      $handler = null;
      XCube_DelegateUtils::call('Legacy.Event.GetHandler', new XCube_Ref($handler), $name);
      if (is_object($handler)) {
        self::$handlers[$name] = $handler;
        return self::$handlers[$name];
      }
      
      if (is_file( $hnd_file = XOOPS_ROOT_PATH.'/kernel/'.$name.'.php' ) ) {
        require_once $hnd_file;
      }
      $class = 'Xoops'.ucfirst($name).'Handler';
      if (class_exists($class)) {
        $root = XCube_Root::getSingleton();
        self::$handlers[$name] = new $class($root->mController->mDB);
      }
    }
    
    if (!isset(self::$handlers[$name])) {
      trigger_error('Class <b>'.$class.'</b> does not exist<br />Handler Name: '.$name, E_USER_ERROR);
    }
    return self::$handlers[$name];
  }
  
  //Legaacy
  public static function getmodulehandlerD($namespace, $name = null, $module_dir = null)
  {
    $root = XCube_Root::getSingleton();
    if (!isset($module_dir)) {
      if (isset($root->mContext->mXoopsModule) && is_object($root->mContext->mXoopsModule)) {
        $module_dir = $root->mContext->mXoopsModule->get('dirname');
      } else {
        trigger_error('No Module is loaded', E_USER_ERROR);
      }
    }
    $className = ucfirst(strtolower($namespace)).'_'.ucfirst($name).'Handler';
    
    if ( !class_exists($className) && is_file($filepath = XOOPS_MODULE_PATH.'/'.$module_dir.'/class/handler/'.ucfirst($name).'.class.php') ) {
      require_once $filepath;
    } elseif ( !class_exists($className) && is_file($filepath = XOOPS_MODULE_PATH.'/'.$module_dir.'/class/'.$name.'.php') ) {
      require_once $filepath;
    }
    return new $className($root->mController->mDB, $module_dir);
  }
  
  //MCL
  public static function get_handler($name, $primary, $dirname = "")
  {
    if ( $dirname == "" ) {
      if ( defined('_MY_DIRNAME') ) {
        $dirname = _MY_DIRNAME;
      } else {
        return false;
      }
    }
    $file = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/class/object/'.$name.'.object.php';
    if ( is_file($file) ) {
      require_once $file;
    } else {
      return false;
    }
    $classname = ucfirst($dirname).ucfirst($name).'Object';
    $hanclass = ucfirst($dirname).ucfirst($name).'Handler';
    $tablename = $dirname.'_'.$name;
    if ( class_exists($hanclass) ) {
      return new $hanclass($tablename, $primary, $classname);
    } else {
      return new TableObjectHandler($tablename, $primary, $classname);
    }
  }
  
  public static function get_object($name, $dirname = "")
  {
    if ( $dirname == "" ) {
      if ( defined('_MY_DIRNAME') ) {
        $dirname = _MY_DIRNAME;
      } else {
        return false;
      }
    }
    $file = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/class/object/'.$name.'.object.php';
    if ( is_file($file) ) {
      require_once $file;
    } else {
      return false;
    }
    $classname = ucfirst($dirname).ucfirst($name).'Object';
    return new $classname();
  }
  
  public static function getSelectObject($sql)
  {
    $root = XCube_Root::getSingleton();
    $db = $root->mController->mDB;
    
    $char = array('STRING', 'CHAR', 'VARCHAR');
    $text = array('TEXT', 'MEDIUMTEXT', 'LONGTEXT','BLOB');
    $int = array('INT', 'INTEGER', 'TINYINT', 'SMALLINT', 'MEDIUMINT', 'BIGINT');
    $float = array('REAL', 'DOUBLE', 'FLOAT', 'DECIMAL', 'NUMERIC');
    $result = $db->query($sql);
    
    for ($i = 0; $i < $db->getFieldsNum($result); $i++) {
      $ftype = strtoupper($db->getFieldType($result, $i));
      $fname = $db->getFieldName($result, $i);
      
      if ( in_array($ftype, $char) ) {
        $type = XOBJ_DTYPE_STRING;
      } elseif ( in_array($ftype, $text) ) {
        $type = XOBJ_DTYPE_TEXT;
      } elseif ( in_array($ftype, $int) ) {
        $type = XOBJ_DTYPE_INT;
      } elseif ( in_array($ftype, $float) ) {
        $type = XOBJ_DTYPE_FLOAT;
      } else {
        $type = XOBJ_DTYPE_STRING;
      }
      $fdata[$fname] = $type;
    }
    
    $ret = array();
    $n = 0;
    while ($row = $db->fetchArray($result)) {
      $ret[$n] = new XoopsSimpleObject();
      foreach ( $fdata as $name => $type ) {
        $ret[$n]->initVar($name, $type);
      }
      $ret[$n]->assignVars($row);
      $ret[$n]->unsetNew();
      $n++;
    }
    return $ret;
  }
  
  public static function isPostMethod()
  {
    return ($_SERVER['REQUEST_METHOD'] == 'POST');
  }
}
?>