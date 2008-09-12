<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once _MCL_LIBS_BASE_PATH.'forms/LostPassEditForm.class.php';

class lostpassAction extends AbstractMcllibsAction
{
  private $mActionForm = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->mActionForm = new MCL_LostPassEditForm();
    $this->mActionForm->prepare();
    $this->url = 'index.php?moddir=mcllibs&amp;action=lostpass';
  }

  public function execute()
  {
    if ($this->root->mContext->mUser->isInRole('Site.RegisteredUser')) {
      $this->root->mController->executeForward(XOOPS_URL.'/');
    }
    
    if ( MCL_Utils::isPostMethod() ) {
      $this->postAction();
    } elseif ($this->root->mContext->mRequest->getRequest('code') != "" && $this->root->mContext->mRequest->getRequest('email') != "") {
      $this->updatePassword();
    }
  }
  
  private function updatePassword()
  {
    $this->mActionForm->fetch();

    $userHandler = xoops_gethandler('user');
    $mCriteria = new CriteriaCompo(new Criteria('email', $this->mActionForm->get('email')));
    $mCriteria->add(new Criteria('pass', $this->mActionForm->get('code'), '=', '', 'LEFT(%s,5)'));
    $lostUserArr = $userHandler->getObjects($mCriteria);     
    if (is_array($lostUserArr) && count($lostUserArr) > 0) {
      $lostUser = $lostUserArr[0];
    } else {
      $this->setErr(_MD_USER_ERROR_SEND_MAIL);
      return;
    }
    
    require_once XOOPS_MODULE_PATH.'/user/class/LostPassMailBuilder.class.php';
    $newpass = xoops_makepass();
    $extraVars['newpass'] = $newpass;
    $builder = new User_LostPass2MailBuilder();
    $director = new User_LostPassMailDirector($builder, $lostUser, $this->root->mContext->getXoopsConfig(), $extraVars);
    $director->contruct();
    $xoopsMailer = $builder->getResult();
    if (!$xoopsMailer->send()) {
      $this->setErr(_MD_USER_ERROR_SEND_MAIL);
      return;
    }
    $lostUser->set('pass', md5($newpass), true);
    $userHandler->insert($lostUser, true);

    $this->setErr(_MD_USER_MESSAGE_SEND_PASSWORD);
  }
  
  private function postAction()
  {
    $this->mActionForm->fetch();
    $this->mActionForm->validate();
    if ($this->mActionForm->hasError()) {
      $this->setErr($this->mActionForm->getErrorMessages());
      return false;
    }
    
    $userHandler = xoops_gethandler('user');
    $lostUserArr = $userHandler->getObjects(new Criteria('email', $this->mActionForm->get('email')));
    if (is_array($lostUserArr) && count($lostUserArr) > 0) {
      $lostUser = $lostUserArr[0];
    } else {
      $this->setErr(_MD_USER_ERROR_SEND_MAIL);
      return false;
    }
    
    require_once XOOPS_MODULE_PATH.'/user/class/LostPassMailBuilder.class.php';
    $builder = new User_LostPass1MailBuilder();
    $director = new User_LostPassMailDirector($builder, $lostUser, $this->root->mContext->getXoopsConfig());
    $director->contruct();
    $builder->mMailer->assign('NEWPWD_LINK', XOOPS_MODULE_URL.'/mcllibs/index.php?action=lostpass&email='.$lostUser->getShow('email').'&code='.substr($lostUser->get('pass'), 0, 5));
    $xoopsMailer = $builder->getResult();

    if (!$xoopsMailer->send()) {
      $this->setErr(_MD_USER_ERROR_SEND_MAIL);
    } else {
      $this->setErr(_MD_USER_MESSAGE_SEND_PASSWORD);
    }
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName('user_lostpass.html');
    $render->setAttribute('actionForm', $this->mActionForm);
  }
}
?>