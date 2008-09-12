<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
abstract class AbstractMCLAdminClass
{
  private $isError = false;
  private $errMsg = "";
  protected $url;
  protected $root;
  
  abstract public function execute();
  abstract public function executeView(&$render);
  
  protected function __construct()
  {
    $this->root = XCube_Root::getSingleton();
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
}
?>