<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_LEGACY_PATH.'/class/ActionFrame.class.php';
require_once XOOPS_LEGACY_PATH.'/admin/actions/ModuleUpdateAction.class.php';

class ModuleUpdateAction extends AbstractMCLAdminClass
{
  private $mXoopsModule = null;
  private $mInstaller = null;
  private $mActionForm = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->url = _MY_MODULE_URL.'admin/index.php?action=ModuleList';
  }
  
  public function execute()
  {
    $mid = intval($this->root->mContext->mRequest->getRequest('mid'));
    $handler = xoops_gethandler('module');
    $this->mXoopsModule = $handler->get($mid);
    if (!is_object($this->mXoopsModule)) {
      $this->setErr('Module is nothing.');
      return false;
    }
    
    $this->mActionForm = new Legacy_ModuleUpdateForm();
    $this->mActionForm->prepare();
    
    $this->mInstaller = Legacy_ModuleInstallUtils::createUpdater($this->mXoopsModule->get('dirname'));
    $this->mInstaller->setCurrentXoopsModule($this->mXoopsModule);
    
    $this->mXoopsModule->loadInfoAsVar($this->mXoopsModule->get('dirname'));
    $this->mInstaller->setTargetXoopsModule($this->mXoopsModule);
    $this->mActionForm->load($this->mXoopsModule);
    
    return true;
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_moduleupdate.html');
    $render->setAttribute('module', $this->mXoopsModule);
    $render->setAttribute('actionForm', $this->mActionForm);
    $render->setAttribute('currentVersion', round($this->mInstaller->getCurrentVersion() / 100, 2));
    $render->setAttribute('targetVersion', round($this->mInstaller->getTargetPhase() / 100, 2));
    $render->setAttribute('isPhasedMode', $this->mInstaller->hasUpgradeMethod());
  }
}
?>