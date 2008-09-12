<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
define('_MCLLIBS_PATH', basename(dirname(dirname(dirname(__FILE__)))));

class mcllibs_AdminPreload extends XCube_ActionFilter
{
  public function postFilter()
  {
    $this->admin_postFilter();
    $this->mRoot->mDelegateManager->add('Legacy_ActionFrame.CreateAction', 'mcllibs_AdminPreload::_createAction', XCUBE_DELEGATE_PRIORITY_FIRST);
    $this->mRoot->mDelegateManager->add('Legacy_AdminControllerStrategy.SetupBlock', 'mcllibs_AdminPreload::_createSidemenu');
  }
  
  private function admin_postFilter()
  {
    define('_ADMIN_THME_PATH', XOOPS_MODULE_PATH.'/'._MCLLIBS_PATH.'/theme');
    define('_ADMIN_THME_URL', XOOPS_MODULE_URL.'/'._MCLLIBS_PATH.'/theme');
    require XOOPS_MODULE_PATH.'/'._MCLLIBS_PATH.'/admin/include/admintheme.function.php';

    $moduleHandler = xoops_gethandler('module');
    $admintheme = $moduleHandler->getByDirname(_MCLLIBS_PATH);
    $configHandler = xoops_gethandler('config');
    $configs = $configHandler->getConfigsByCat(0, $admintheme->get('mid'));
    
    if ( !in_array($configs['admintheme'], getAdminTheme()) ) {
      $configs['admintheme'] = 'default';
    }
    
    if ( $configs['viewblock'] != 0 ) {
      $this->mRoot->mDelegateManager->add('Legacy_AdminControllerStrategy.SetupBlock', 'mcllibs_AdminPreload::_createBlock');
    }
    
    if ( $configs['admintheme'] != 'default' ) {
      $this->mRoot->mSiteConfig['RenderSystems']['Legacy_AdminRenderSystem'] = 'AdminthemeRender';
      $this->mRoot->mSiteConfig['AdminthemeRender']['class'] = 'AdminthemeRender';
      $this->mRoot->mSiteConfig['AdminthemeRender']['path'] = '/modules/'._MCLLIBS_PATH.'/admin/kernel';
    }
  }
  
  public static function _createBlock(&$controller)
  {
    require XOOPS_MODULE_PATH.'/'._MCLLIBS_PATH.'/admin/blocks/AdminThemeSelect.class.php';
    $controller->_mBlockChain[] = new AdminThemeSelect();
  }
  
  public static function _createAction(&$actionFrame)
  {
    if (is_object($actionFrame->mAction)) {
      return;
    }
    
    switch (ucfirst($actionFrame->mActionName)) {
      case 'PreferenceEdit':
        require XOOPS_MODULE_PATH.'/'._MCLLIBS_PATH.'/admin/actions/PreferenceEditAction.class.php';
        $actionFrame->mAction = new MCLadmin_PreferenceEditAction();
        break;
    }
  }
  
  public static function _createSidemenu(&$controller)
  {
    foreach ( array_keys($controller->_mBlockChain) as $n ) {
      if ( $controller->_mBlockChain[$n] instanceof Legacy_AdminSideMenu ) {
        require XOOPS_MODULE_PATH.'/'._MCLLIBS_PATH.'/admin/blocks/MCL_AdminSideMenu.class.php';
        $controller->_mBlockChain[$n] = new MCL_AdminSideMenu();
        return;
      }
    }
  }
}
?>
