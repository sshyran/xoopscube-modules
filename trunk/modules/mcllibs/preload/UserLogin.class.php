<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class Mcllibs_UserLogin extends XCube_ActionFilter
{
  public function preBlockFilter()
  {
    $this->mRoot->mDelegateManager->delete('Site.CheckLogin', 'User_LegacypageFunctions::checkLogin');
    $this->mRoot->mDelegateManager->add('Site.CheckLogin', 'Mcllibs_UserLogin::checkLogin', XCUBE_DELEGATE_PRIORITY_1);
    $this->mRoot->mDelegateManager->add('Legacy_Controller.SetupUser', 'Mcllibs_UserLogin::autologin', XCUBE_DELEGATE_PRIORITY_1);
    $this->mRoot->mDelegateManager->add('Site.Logout', 'Mcllibs_UserLogin::logout', XCUBE_DELEGATE_PRIORITY_1);
  }
  
  public static function logout(&$successFlag, $xoopsUser)
  {
    if (is_object($xoopsUser)) {
      if ( isset($_COOKIE['_MCLAUTOLOGIN']) ) {
        Mcllibs_UserLogin::del_autologin_cookie($xoopsUser->get('uid'));
      }
    }
  }

  public static function autologin(&$principal, &$controller, &$context)
  {
    $dirname = basename(dirname(dirname(__FILE__)));
    $configHandler = xoops_gethandler('config');
    $configs = $configHandler->getConfigsByDirname($dirname);
    
    if ( $configs['autologin'] == 1 ) {
      $root = XCube_Root::getSingleton();
      $db = $root->mController->getDB();
      if ( isset($_COOKIE['_MCLAUTOLOGIN']) && empty($_SESSION['xoopsUserId']) ) {
        $sql = "SELECT `uid` FROM `".$db->prefix('users')."` ";
        $sql.= "WHERE `loginkey` = '".mysql_real_escape_string($_COOKIE['_MCLAUTOLOGIN'])."' ";
        $result = $db->query($sql);
        list($uid) = $db->fetchRow($result);
        if ( !empty($uid) ) {
          $handler = xoops_gethandler('user');
          $user = $handler->get($uid);
          
          $root->mSession->regenerate();
          $_SESSION['xoopsUserId'] = $user->get('uid');
          $_SESSION['xoopsUserGroups'] = $user->getGroups();
          
          Mcllibs_UserLogin::make_autologin_cookie($user->get('uid'));
        } else {
          Mcllibs_UserLogin::set_cookie('_MCLAUTOLOGIN', '', time() - (86400 * 7));
        }
      }
    } elseif ( isset($_COOKIE['_MCLAUTOLOGIN']) ) {
      Mcllibs_UserLogin::set_cookie('_MCLAUTOLOGIN', '', time() - (86400 * 7));
    }
  }
  
  public static function set_cookie($key, $value, $time = 0, $path = null)
  {
    if ( $path == "" ) {
      $parse_array = parse_url(XOOPS_URL);
      $path = @$parse_array['path'].'/';
    }
    setcookie($key, $value, $time, $path); 
  }
  
  public static function make_autologin_cookie($uid)
  {
    $root = XCube_Root::getSingleton();
    $db = $root->mController->getDB();
    $key = sha1(uniqid(XOOPS_DB_PREFIX.mt_rand(), true));
    $sql = "UPDATE `".$db->prefix('users')."` ";
    $sql.= "SET `loginkey` = '".mysql_real_escape_string($key)."' ";
    $sql.= "WHERE `uid` = ".$uid;
    if ( $db->query($sql) ) {
      Mcllibs_UserLogin::set_cookie('_MCLAUTOLOGIN', $key, time() + (86400 * 7));
    }
  }
  
  public static function del_autologin_cookie($uid)
  {
    $root = XCube_Root::getSingleton();
    $db = $root->mController->getDB();
    $sql = "UPDATE `".$db->prefix('users')."` ";
    $sql.= "SET `loginkey` = '' ";
    $sql.= "WHERE `uid` = ".$uid;
    $db->query($sql);
    if ( isset($_COOKIE['_MCLAUTOLOGIN']) ) {
      Mcllibs_UserLogin::set_cookie('_MCLAUTOLOGIN', '', time() - (86400 * 7));
    }
  }
  
  public static function checkLogin(&$xoopsUser)
  {
    if (is_object($xoopsUser)) {
      return;
    }
    
    $root = XCube_Root::getSingleton();
    $root->mLanguageManager->loadModuleMessageCatalog('user');
    
    $dirname = basename(dirname(dirname(__FILE__)));
    $configHandler = xoops_gethandler('config');
    $configs = $configHandler->getConfigsByDirname($dirname);
    
    $uname = $root->mContext->mRequest->getRequest('uname');
    $criteria = new CriteriaCompo();
    switch ($configs['allowloginid']) {
      case 1:
        $ufield = 'email';
        break;
      case 2:
        $ufield = 'uname';
        break;
      case 0:
      default:
        if ( $uname != "" && strpos($uname, '@') !== false ) {
          $ufield = 'email';
        } else {
          $ufield = 'uname';
        }
    }
    $criteria->add(new Criteria($ufield, $uname));
    $criteria->add(new Criteria('pass', md5($root->mContext->mRequest->getRequest('pass'))));
    
    $userHandler = xoops_getmodulehandler('users', 'user');
    $userArr = $userHandler->getObjects($criteria);
    
    if (count($userArr) != 1) {
      return;
    }
    
    if ($userArr[0]->get('level') == 0) {
      return;
    }
    
    $xoopsConfig = $root->mContext->mXoopsConfig;
    if ($xoopsConfig['closesite'] == 1) {
      $allowed = false;
      foreach ($userArr[0]->getGroups() as $group) {
        if (in_array($group, $xoopsConfig['closesite_okgrp']) || XOOPS_GROUP_ADMIN == $group) {
          $allowed = true;
          break;
        }
      }
      if (!$allowed) {
        $root->mController->executeRedirect(XOOPS_URL . '/', 1, _NOPERM);
        exit;
      }
    }
    
    $handler = xoops_gethandler('user');
    $user = $handler->get($userArr[0]->get('uid'));
    $xoopsUser = $user;
  
    $root->mSession->regenerate();
    $_SESSION['xoopsUserId'] = $xoopsUser->get('uid');
    $_SESSION['xoopsUserGroups'] = $xoopsUser->getGroups();

    if ( $configs['autologin'] == 1 && isset($_POST['autologin']) && $_POST['autologin'] == 1 ) {
      Mcllibs_UserLogin::make_autologin_cookie($xoopsUser->get('uid'));
    } elseif ( $configs['autologin'] == 1 && empty($_POST['autologin']) ) {
      Mcllibs_UserLogin::del_autologin_cookie($xoopsUser->get('uid'));
    }
  }
}
?>