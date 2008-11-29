<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/modules/legacy/admin/class/ModuleUpdater.class.php';

class Usersearch_myUpdater extends Legacy_ModulePhasedUpgrader
{
  public function __construct()
  {
    parent::Legacy_ModulePhasedUpgrader();
    $this->_mMilestone = array(
      '020' => 'update020',
    );
  }
  
  private function updatemain()
  {
    Legacy_ModuleInstallUtils::clearAllOfModuleTemplatesForUpdate($this->_mTargetXoopsModule, $this->mLog);
    Legacy_ModuleInstallUtils::installAllOfModuleTemplates($this->_mTargetXoopsModule, $this->mLog);
    
    $this->saveXoopsModule($this->_mTargetXoopsModule);
    $this->mLog->add('Version'.($this->_mTargetVersion / 100).' for update.');
    $this->_mCurrentVersion = $this->_mTargetVersion;
  }
  
  public function update020()
  {
    $this->mLog->addReport(_AD_LEGACY_MESSAGE_UPDATE_STARTED);
    $root = XCube_Root::getSingleton();
    $db = $root->mController->getDB();
    
    $sql = "ALTER TABLE `".$db->prefix('usersearch_favorites')."` ";
    $sql.= "ADD UNIQUE `uni` ( `mid` , `uid` , `fuid` ) ";
    if (!$db->query($sql)) {
      $this->mLog->addReport($db->error());
    } else {
      $this->mLog->addReport('Add unique key');
    }
    
    $this->updatemain();
    return true;
  }
}
?>
