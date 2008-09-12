<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
abstract class AbstractMcllibsAction
{
  protected $isError = false;
  protected $errMsg = "";
  protected $root;
  public $url = 'index.php';
  
  public function __construct()
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
  
  abstract public function execute();
  abstract public function executeView(&$render);
}
?>