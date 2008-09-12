<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class Mcllibs_Module extends Legacy_ModuleAdapter
{
  public function __construct(&$xoopsModule)
  {
    parent::Legacy_ModuleAdapter($xoopsModule);
  }
  
  public function hasAdminIndex()
  {
    return true;
  }
  
  public function getAdminIndex()
  {
    return XOOPS_MODULE_URL.'/'.$this->mXoopsModule->get('dirname').'/admin/index.php';
  }
  
  public function getAdminMenu()
  {
    if ($this->_mAdminMenuLoadedFlag == false) {
      $root = XCube_Root::getSingleton();
      
      $this->mAdminMenu[] = array(
        'link' => XOOPS_MODULE_URL.'/'.$this->mXoopsModule->get('dirname').'/admin/index.php?action=ModuleList',
        'title' => _AD_MCLLIBS_MODMANAGE,
        'keywords' => _AD_MCLLIBS_MODMANAGE,
        'show' => true
      );
      
      $this->mAdminMenu[] = array(
        'link' => XOOPS_MODULE_URL.'/'.$this->mXoopsModule->get('dirname').'/admin/index.php?action=grouplist',
        'title' => _AD_MCLLIBS_GROUPPERM,
        'keywords' => _AD_MCLLIBS_GROUPPERM,
        'show' => true
      );
      
      $this->mAdminMenu[] = array(
        'link' => XOOPS_MODULE_URL.'/'.$this->mXoopsModule->get('dirname').'/admin/index.php?action=comment',
        'title' => _AD_MCLLIBS_COMMENT,
        'keywords' => _AD_MCLLIBS_COMMENT,
        'show' => true
      );
      
      $this->mAdminMenu[] = array(
        'link' => $root->mController->getPreferenceEditUrl($this->mXoopsModule),
        'title' => _PREFERENCES,
        'absolute' => true
      );
      
      $this->_mAdminMenuLoadedFlag = true;
    }
    return $this->mAdminMenu;
  }
}
?>
