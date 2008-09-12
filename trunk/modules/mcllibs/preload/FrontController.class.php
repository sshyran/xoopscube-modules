<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
define('_FRONTCONTROLLER', true);
class Mcllibs_FrontController extends XCube_ActionFilter
{
  private $dirname = "";
  private $mPostFilter = null;
  
  public function PreBlockFilter()
  {
    $this->mPostFilter = new XCube_Delegate();
    $this->mPostFilter->register('FrontController.PostFilter');
    $this->mPostFilter->add(array($this, 'loadModule'), XCUBE_DELEGATE_PRIORITY_FIRST);
    
    $moddir = $this->mRoot->mContext->mRequest->getRequest('moddir');
    if ( $moddir != "" && preg_match("/^\w+$/", $moddir)) {
      $module = new XoopsModule();
      $module->loadInfo($moddir);
      $conf = $module->modinfo;
      if ( isset($conf['front']) && $conf['front'] == true ) {
        $this->dirname = $moddir;
      }
    }
  }
  
  public function postFilter()
  {
    $this->mPostFilter->call();
  }
  
  public function loadModule()
  {
    if ( $this->dirname != "" ) {
      define ('_MY_DIRNAME', $this->dirname);
      $this->mRoot->mDelegateManager->add('Legacypage.Top.Access', 'MCL_RunModule::Call', XCUBE_DELEGATE_PRIORITY_4);
      $this->mRoot->mController->setupModuleContext($this->dirname);
      $this->mRoot->mController->_processModule();
    }
  }
}

class MCL_RunModule
{
  public static function Call()
  {
    define ('_MY_MODULE_PATH', XOOPS_MODULE_PATH.'/'._MY_DIRNAME.'/');
    define ('_MY_MODULE_URL', XOOPS_URL.'/index.php?moddir='._MY_DIRNAME);
    require _MY_MODULE_PATH.'kernel/ModController.class.php';
    $controller = new ModController();
    $root = XCube_Root::getSingleton();
    $root->mController->mExecute->add(array($controller, 'execute'));
    $root->mController->execute();
  }
}
?>