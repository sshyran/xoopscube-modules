<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require _MY_MODULE_PATH.'forms/myfriendregisterForm.class.php';
require_once XOOPS_MODULE_PATH . "/user/class/RegistMailBuilder.class.php";

class registerAction extends AbstractAction
{
  private $tplname;
  private $mNewUser = null;
  private $mConfig;
  private $myGroups = array();
  
  public function __construct()
  {
    parent::__construct();
  }
  
  public function execute()
  {
    if ( is_object($this->root->mContext->mXoopsUser) ) {
      $this->setErr(_MD_MYFRIEND_ACTERR1);
      return;
    }
    $this->myGroups = $this->root->mContext->mModuleConfig['in_group'];
    $this->root->mController->setupModuleContext('user');
    $this->root->mLanguageManager->loadModuleMessageCatalog('user');
    
    $this->_processActionForm();
    $sesArray = $this->mActionForm->get_session();
    $this->mActionForm->delete_session();
    $this->mActionForm->fetch();
    $this->mActionForm->set('uname', $sesArray['uname']);
    $this->mActionForm->set('email', $sesArray['email']);
    $this->mActionForm->set('user_viewemail', $sesArray['user_viewemail']);
    $this->mActionForm->set('timezone_offset', $sesArray['timezone_offset']);
    $this->mActionForm->set('pass', $sesArray['pass']);
    $this->mActionForm->set('vpass', $sesArray['pass']);
    $this->mActionForm->set('user_mailok', $sesArray['user_mailok']);
    $this->mActionForm->set('actkey', $sesArray['actkey']);

    $modhand = xoops_getmodulehandler('invitation');
    $mCriteria = new CriteriaCompo();
    $mCriteria->add(new Criteria('actkey', $sesArray['actkey']));
    $modObj = $modhand->getObjects($mCriteria);
    if ( count($modObj) == 1 ) {
      $this->mActionForm->validate();
      if (!$this->mActionForm->hasError()) {
        if ( $this->insertUser() ) {
          $this->isError = true;
          $this->errMsg = _MD_MYFRIEND_ACTERR2;
          $uid = $modObj[0]->get('uid');
          if ( $modhand->delete($modObj[0]) ) {
            $frihand = xoops_getmodulehandler('friend');
            $friObj = $frihand->create();
            $friObj->set('uid', $uid);
            $friObj->set('friend_uid', $this->mNewUser->get('uid'));
            $friObj->set('utime', time());
            if ( $frihand->insert($friObj) ) {
              $friObj->set('uid', $this->mNewUser->get('uid'));
              $friObj->set('friend_uid', $uid);
              if ( !$frihand->insert($friObj) ) {
                $this->errMsg = _MD_MYFRIEND_ACTERR3;
              }
            } else {
              $this->errMsg = _MD_MYFRIEND_ACTERR3;
            }
          } else {
            $this->errMsg = _MD_MYFRIEND_ACTERR4;
          }
          return;
        } else {
          return;
        }
      }
    } else {
      $this->tplname ='myfriend_invitation_none.html';
    }
  }
  
  private function insertUser()
  {
    $moduleHandler = xoops_gethandler('module');
    $usermod = $moduleHandler->getByDirname('user');
    $configHandler = xoops_gethandler('config');
    $this->mConfig = $configHandler->getConfigsByCat(0, $usermod->get('mid'));

    $memberHandler = xoops_gethandler('member');
    $this->mNewUser = $memberHandler->createUser();
    $this->mActionForm->update($this->mNewUser);
    $this->mNewUser->set('uorder', $this->root->mContext->getXoopsConfig('com_order'), true);
    $this->mNewUser->set('umode', $this->root->mContext->getXoopsConfig('com_mode'), true);
    if ($this->mConfig['activation_type'] == 1) {
      $this->mNewUser->set('level', 1, true);
    }

    if (!$memberHandler->insertUser($this->mNewUser)) {
      $this->isError = true;
      $this->errMsg = _MD_MYFRIEND_ACTERR5;
      return false;
    }
    
    foreach ($this->myGroups as $group) {
      if (!$memberHandler->addUserToGroup($group, $this->mNewUser->get('uid'))) {
        $this->isError = true;
        $this->errMsg = _MD_MYFRIEND_ACTERR6;
        return false;
      }
    }
    $this->_processMail($this->root->mController);
    $this->_eventNotifyMail($this->root->mController);
    
    XCube_DelegateUtils::call('Legacy.Event.RegistUser.Success', new XCube_Ref($this->mNewUser));
    
    return true;
  }
  
  private function _processMail(&$controller)
  {
    $activationType = $this->mConfig['activation_type'];
    if($activationType == 1) {
      return;
    }
    // Wmm..
    $builder = ($activationType == 0) ? new User_RegistUserActivateMailBuilder()
                                      : new User_RegistUserAdminActivateMailBuilder();

    $director = new User_UserRegistMailDirector($builder, $this->mNewUser, $controller->mRoot->mContext->getXoopsConfig(), $this->mConfig);
    $director->contruct();
    $mailer = $builder->getResult();
    
    if (!$mailer->send()) {
    }  // TODO CHECKS and use '_MD_USER_ERROR_YOURREGMAILNG'
  }
  
  private function _eventNotifyMail(&$controller)
  {
    if($this->mConfig['new_user_notify'] == 1 && !empty($this->mConfig['new_user_notify_group'])) {
      $builder = new User_RegistUserNotifyMailBuilder();
      $director = new User_UserRegistMailDirector($builder, $this->mNewUser, $controller->mRoot->mContext->getXoopsConfig(), $this->mConfig);
      $director->contruct();
      $mailer = $builder->getResult();
      $mailer->send();
    }
  }
  
  private function _processActionForm()
  {
    $moduleHandler = xoops_gethandler('module');
    $usermod = $moduleHandler->getByDirname('user');
    $configHandler = xoops_gethandler('config');
    $configs = $configHandler->getConfigsByCat(0, $usermod->get('mid'));
    
    $this->mActionForm = new myfreendRegisterForm($configs);
    $this->mActionForm->prepare();
  }

  public function executeView(&$render)
  {
    $render->setTemplateName($this->tplname);
  }
}
?>
