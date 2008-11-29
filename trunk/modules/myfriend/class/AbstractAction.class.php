<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

abstract class AbstractAction
{
  protected $mActionForm;
  protected $isError = false;
  protected $errMsg = "";
  protected $root;
  protected $url = 'index.php';
  
  
  public function __construct()
  {
    $this->root = XCube_Root::getSingleton();
    //FRONT
    if (defined('_FRONTCONTROLLER')) {
      $this->url = XOOPS_URL.'/index.php?moddir='._MY_DIRNAME;
    }
  }
  
  protected function setUrl($url)
  {
    $this->url = $url;
  }
  
  public function getUrl()
  {
    return $this->url;
  }
  
  protected function setErr($msg)
  {
    $this->isError = true;
    $this->errMsg = $msg;
  }
  
  public function getisError()
  {
    return $this->isError;
  }
  
  public function geterrMsg()
  {
    return $this->errMsg;
  }
  
  abstract public function execute();
  abstract public function executeView(&$render);
}
?>