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


class ModuleReinstallAction extends AbstractMCLAdminClass
{
  private $mXoopsModule = null;
  private $mUnInstaller = null;
  private $mInstaller = null;
  private $mActionForm = null;
  private $success = false;
  
  private $mUninstallSuccess = null;
  private $mUninstallFail = null;
  private $mInstallSuccess = null;
  private $mInstallFail = null;
  
  private $mLog = null;
  private $dirname = null;
  
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
    $this->dirname = $this->mXoopsModule->get('dirname');
    $this->mXoopsModule->loadInfoAsVar($this->dirname);
    
    $this->mActionForm = new Legacy_ModuleUninstallForm();
    $this->mActionForm->prepare();
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
      if ( $this->UnInstall() ) {
        $this->mXoopsModule = $handler->create();
        $this->mXoopsModule->set('weight', 1);
        $this->mXoopsModule->loadInfoAsVar($this->dirname);

        $this->Install();
      }
    }
    return true;
  }
  
  private function UnInstall($skip = false)
  {
    $this->mUnInstaller = Legacy_ModuleInstallUtils::createUninstaller($this->dirname);
    $this->mUnInstaller->setCurrentXoopsModule($this->mXoopsModule);
    $this->mUnInstaller->setForceMode($this->mActionForm->get('force'));
    $this->mUnInstaller->executeUninstall();
    
    if ( $skip == true ) {
      return true;
    }
    $this->mUninstallSuccess = new XCube_Delegate();
    $this->mUninstallSuccess->register('Legacy_ModuleUninstallAction.UninstallSuccess');
    
    $this->mUninstallFail = new XCube_Delegate();
    $this->mUninstallFail->register('Legacy_ModuleUninstallAction.UninstallFail');
    
    if (!$this->mUnInstaller->mLog->hasError()) {
      $this->mUninstallSuccess->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mUnInstaller->mLog));
      XCube_DelegateUtils::call('Legacy.Admin.Event.ModuleUninstall.' . ucfirst($this->dirname.'.Success'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
      return true;
    } else {
      $this->mUninstallFail->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mUnInstaller->mLog));
      XCube_DelegateUtils::call('Legacy.Admin.Event.ModuleUninstall.' . ucfirst($this->dirname.'.Fail'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
      return false;
    }
  }
  
  private function Install()
  {
    $this->mInstaller = Legacy_ModuleInstallUtils::createInstaller($this->dirname);
    $this->mInstaller->setCurrentXoopsModule($this->mXoopsModule);
    $this->mInstaller->setForceMode($this->mActionForm->get('force'));
    if (!$this->mInstaller->executeInstall()) {
      $this->UnInstall(true);
    }
    
    $this->mInstallSuccess = new XCube_Delegate();
    $this->mInstallSuccess->register('Legacy_ModuleInstallAction.InstallSuccess');
    
    $this->mInstallFail = new XCube_Delegate();
    $this->mInstallFail->register('Legacy_ModuleInstallAction.InstallFail');
    
    if (!$this->mInstaller->mLog->hasError()) {
      $this->mInstallSuccess->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
      XCube_DelegateUtils::call('Legacy.Admin.Event.ModuleInstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Success'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
    } else {
      $this->mInstallFail->call(new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
      XCube_DelegateUtils::call('Legacy.Admin.Event.ModuleInstall.' . ucfirst($this->mXoopsModule->get('dirname') . '.Fail'), new XCube_Ref($this->mXoopsModule), new XCube_Ref($this->mInstaller->mLog));
    }
    
    $this->mLog = array_merge($this->mUnInstaller->mLog->mMessages, $this->mInstaller->mLog->mMessages);
  }
  
  public function executeView(&$render)
  {
    if ( $this->success ) {
      $render->setTemplateName(XOOPS_LEGACY_PATH.'/admin/templates/module_uninstall_success.html');
      $render->setAttribute('module',$this->mXoopsModule);
      $render->setAttribute('log', $this->mLog);
    } else {
      $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_modulereinstall.html');
      $render->setAttribute('module', $this->mXoopsModule);
      $render->setAttribute('actionForm', $this->mActionForm);
      $render->setAttribute('currentVersion', round($this->mXoopsModule->get('version') / 100, 2));
    }
  }
}
?>