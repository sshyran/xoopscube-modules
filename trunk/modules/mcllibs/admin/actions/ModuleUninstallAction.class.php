<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_LEGACY_PATH.'/class/ActionFrame.class.php';
require_once XOOPS_LEGACY_PATH.'/admin/actions/AbstractModuleInstallAction.class.php';
require_once XOOPS_LEGACY_PATH.'/admin/class/ModuleInstallUtils.class.php';
require_once XOOPS_LEGACY_PATH.'/admin/forms/ModuleUninstallForm.class.php';


class ModuleUninstallAction extends AbstractMCLAdminClass
{
  private $mXoopsModule = null;
  private $mInstaller = null;
  private $mActionForm = null;
  private $success = false;
  
  private $mUninstallSuccess = null;
  private $mUninstallFail = null;
  
  
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
    $this->mXoopsModule->loadInfoAsVar($this->mXoopsModule->get('dirname'));
    
    $this->mActionForm = new Legacy_ModuleUninstallForm();
    $this->mActionForm->prepare();
    
    $this->mInstaller = Legacy_ModuleInstallUtils::createUninstaller($this->mXoopsModule->get('dirname'));
    $this->mInstaller->setCurrentXoopsModule($this->mXoopsModule);
    
    $this->mActionForm->load($this->mXoopsModule);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['_form_control_cancel'])) {
        $this->root->mController->executeForward($this->url);
        exit;
      }
      
      $this->mActionForm->fetch();
      $this->mActionForm->validate();
      if ($this->mActionForm->hasError()) {
        return;
      }
      
      $this->success = true;
      $this->mInstaller->setForceMode($this->mActionForm->get('force'));
      $this->mInstaller->executeUninstall();
      
      $this->mUninstallSuccess = new XCube_Delegate();
      $this->mUninstallSuccess->register('Legacy_ModuleUninstallAction.UninstallSuccess');
      
      $this->mUninstallFail = new XCube_Delegate();
      $this->mUninstallFail->register('Legacy_ModuleUninstallAction.UninstallFail');
    }
    return true;
  }
  
  public function executeView(&$render)
  {
    if ( $this->success ) {
      if (!$this->mInstaller->mLog->hasError()) {
        $this->mUninstallSuccess->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
        XCube_DelegateUtils::call('Legacy.Admin.Event.ModuleUninstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Success'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
      } else {
        $this->mUninstallFail->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
        XCube_DelegateUtils::call('Legacy.Admin.Event.ModuleUninstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Fail'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
      }

      $render->setTemplateName(XOOPS_LEGACY_PATH.'/admin/templates/module_uninstall_success.html');
      $render->setAttribute('module',$this->mXoopsModule);
      $render->setAttribute('log', $this->mInstaller->mLog->mMessages);
    } else {
      $render->setTemplateName(XOOPS_LEGACY_PATH.'/admin/templates/module_uninstall.html');
      $render->setAttribute('module', $this->mXoopsModule);
      $render->setAttribute('actionForm', $this->mActionForm);
      $render->setAttribute('currentVersion', round($this->mXoopsModule->get('version') / 100, 2));
    }
  }
}
?>