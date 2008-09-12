<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class loginAction extends AbstractMcllibsAction
{
  private $mActionForm = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->url = 'index.php?moddir=mcllibs&amp;action=login';
  }

  public function execute()
  {
    if ($this->root->mContext->mUser->isInRole('Site.RegisteredUser')) {
      $this->root->mController->executeForward(XOOPS_URL.'/');
    }
    
    if ( MCL_Utils::isPostMethod() ) {
      $this->root->mController->checkLogin();
    }
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName('mcllibs_login.html');
  }
}
?>