<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require _MY_MODULE_PATH.'forms/myfriendregisterForm.class.php';

class registAction extends AbstractAction
{
  private $tplname;
  private $rdata = false;
  
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
    $actkey = $this->root->mContext->mRequest->getRequest('actkey');
    $modhand = xoops_getmodulehandler('invitation');
    $mCriteria = new CriteriaCompo();
    $mCriteria->add(new Criteria('actkey', $actkey));
    $modObj = $modhand->getObjects($mCriteria);
    if ( count($modObj) == 1 ) {
      $this->tplname ='myfriend_invitation_regist.html';
      $this->root->mController->setupModuleContext('user');
      $this->root->mLanguageManager->loadModuleMessageCatalog('user');
      
      $this->_processActionForm();
      $this->mActionForm->set('timezone_offset', $this->root->mContext->getXoopsConfig('default_TZ'));
      $this->mActionForm->set('actkey', $actkey);
      $this->mActionForm->delete_session();
      if  (xoops_getenv("REQUEST_METHOD") == "POST") {
        $this->mActionForm->fetch();
        $this->mActionForm->validate();
        if (!$this->mActionForm->hasError()) {
          $this->tplname ='myfriend_invitation_regisconft.html';
          $this->mActionForm->save_session();
        }
      }
    } else {
      $this->tplname ='myfriend_invitation_none.html';
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
    $render->setAttribute('rdata', $this->rdata);
    $render->setAttribute('actionForm', $this->mActionForm);
    $tzoneHandler = xoops_gethandler('timezone');
    $timezones = $tzoneHandler->getObjects();
    $render->setAttribute('timezones', $timezones);
  }
}
?>
