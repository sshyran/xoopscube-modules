<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
require XOOPS_MODULE_PATH.'/user/forms/UserRegisterEditForm.class.php';
require XOOPS_MODULE_PATH.'/user/forms/UserConfirmForm.class.php';

class registerAction extends AbstractMcllibsAction
{
  private $mActionForm = null;
  private $mRegistForm = null;
  
  private $mConfig = array();
  private $confirm = false;
  
  public function __construct()
  {
    parent::__construct();
    $this->root->mLanguageManager->loadModuleMessageCatalog('user');
    $this->root->mLanguageManager->loadModinfoMessageCatalog('user');
    $this->url = 'index.php?moddir=mcllibs&action=register';
    
    $configHandler = xoops_gethandler('config');
    $this->mConfig = $configHandler->getConfigsByDirname('user');
    $this->_processActionForm();
  }
  
  private function _processActionForm()
  {
    if ( $this->root->mContext->mRequest->getRequest('confirm') == "ok" ) {
      $this->mActionForm = new User_UserConfirmForm();
      $this->mActionForm->prepare();
    } elseif ($this->root->mContext->mRequest->getRequest('confirm') == "no") {
      $this->mActionForm = unserialize($_SESSION['user_register_actionform']);
      $this->mActionForm->prepare();
    } else {
      if ($this->mConfig['reg_dispdsclmr'] != 0 && $this->mConfig['reg_disclaimer'] != null) {
        $this->mEnableAgreeFlag = true;
        $this->mActionForm = new User_RegisterAgreeEditForm($this->mConfig);
      } else {
        $this->mEnableAgreeFlag = false;
        $this->mActionForm = new User_RegisterEditForm($this->mConfig);
      }
      $this->mActionForm->prepare();
      $this->mActionForm->set('timezone_offset', $this->root->mContext->mXoopsConfig['default_TZ']);
    }
  }
  
  public function execute()
  {
    if ($this->root->mContext->mUser->isInRole('Site.RegisteredUser')) {
      $this->root->mController->executeForward(XOOPS_URL.'/');
    }
    if ( MCL_Utils::isPostMethod() ) {
      $this->postAction();
    }
  }
  
  private function postAction()
  {
    $this->mActionForm->fetch();
    $this->mActionForm->validate();
    
    if ($this->mActionForm->hasError()) {
      $this->setErr($this->mActionForm->getErrorMessages());
    } else {
      switch ($this->root->mContext->mRequest->getRequest('confirm')) {
        case 'ok':
          break;
        case 'no':
          $this->mActionForm = unserialize($_SESSION['user_register_actionform']);
          break;
        default:
          $_SESSION['user_register_actionform'] = serialize($this->mActionForm);
          $this->confirm = true;
      }
    }
  }
  
  public function executeView(&$render)
  {
    if ( $this->confirm ) {
      $this->executeViewConfirm($render);
    } else {
      $this->executeViewForm($render);
    }
  }
  
  private function executeViewConfirm(&$render)
  {
    $render->setTemplateName('mcllibs_register_confirm.html');
    $render->setAttribute('actionForm', $this->mActionForm);
  }
  
  private function executeViewForm(&$render)
  {
    $render->setTemplateName('user_register_form.html');
    $render->setAttribute('actionForm', $this->mActionForm);
    
    $tzoneHandler = xoops_gethandler('timezone');
    $timezones = $tzoneHandler->getObjects();
    $render->setAttribute('timezones', $timezones);
    $render->setAttribute('enableAgree', $this->mEnableAgreeFlag);
    if($this->mEnableAgreeFlag) {
      $render->setAttribute('disclaimer', $this->mConfig['reg_disclaimer']);
    }
  }
}
?>