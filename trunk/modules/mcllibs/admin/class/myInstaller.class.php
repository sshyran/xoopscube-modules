<?php
/**
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 3
 * @author Marijuana
 */
require_once XOOPS_ROOT_PATH.'/modules/legacy/admin/class/ModuleInstaller.class.php';

class Mcllibs_myInstaller extends Legacy_ModuleInstaller
{
  public function __construct()
  {
    parent::Legacy_ModuleInstaller();
  }
  
  public function executeInstall()
  {
    $root = XCube_Root::getSingleton();
    $db = $root->mController->getDB();
    
    $sql = "ALTER TABLE `".$db->prefix('users')."` ";
    $sql.= "ADD `loginkey` varchar(64) NOT NULL";
    $db->query($sql);
    
    return parent::executeInstall();
  }
  
  public function _installModule()
  {
    $moduleHandler = xoops_gethandler('module');
    if (!$moduleHandler->insert($this->_mXoopsModule)) {
      $this->mLog->addError('*Could not install module information*');
      return false;
    }
    
    $gpermHandler = xoops_gethandler('groupperm');
    
    //
    // Add a permission which administrators can manage.
    //
    if ($this->_mXoopsModule->getInfo('hasAdmin')) {
      $adminPerm = $this->_createPermission(XOOPS_GROUP_ADMIN);
      $adminPerm->setVar('gperm_name', 'module_admin');
      if (!$gpermHandler->insert($adminPerm)) {
        $this->mLog->addError(_AD_LEGACY_ERROR_COULD_NOT_SET_ADMIN_PERMISSION);
      }
    }
    
    //
    // $this->_mXoopsModule->getInfo('read_any')==trueじゃなくても強制
    //
    $memberHandler = xoops_gethandler('member');
    $groupObjects = $memberHandler->getGroups();
    foreach ($groupObjects as $group) {
      $readPerm = $this->_createPermission($group->getVar('groupid'));
      $readPerm->setVar('gperm_name', 'module_read');
      if (!$gpermHandler->insert($readPerm)) {
        $this->mLog->addError(_AD_LEGACY_ERROR_COULD_NOT_SET_READ_PERMISSION);
      }
    }
  }
}
?>
