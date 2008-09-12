<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once _MCL_LIBS_BASE_PATH.'admin/class/AbstractAction.class.php';
require_once _MCL_LIBS_BASE_PATH.'libs/MCL_Utils.class.php';

class AdmController
{
  private $act;
  
  public function __construct()
  {
    $root = XCube_Root::getSingleton();
    $this->act = $root->mContext->mRequest->getRequest('action');
    if ( $this->act == "" ) {
      $this->act = 'index';
    }
    if (!preg_match("/^\w+$/", $this->act)) {
      exit('bad action name');
    }
  }
  
  public function execute($controller)
  {
    $className = $this->act.'Action';
    $fileName = _MY_MODULE_PATH.'admin/actions/'.$className.'.class.php';
    if (!is_file($fileName)) {
      exit('file not found');
    }
    require $fileName;

    $Action = new $className($controller);
    $Action->execute();
    if ( $Action->getisError() ) {
      $controller->executeRedirect($Action->getUrl(), 2, $Action->geterrMsg());
    } else {
      $Action->executeView($controller->mRoot->mContext->mModule->getRenderTarget());
    }
  }
}
?>