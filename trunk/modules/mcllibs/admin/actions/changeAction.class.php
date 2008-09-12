<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class changeAction extends AbstractMCLAdminClass
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function execute()
  {
    $theme = $this->root->mContext->mRequest->getRequest('theme');
    if ( !in_array($theme, getAdminTheme()) ) {
      $theme = 'default';
    }
    $ret = $this->root->mContext->mRequest->getRequest('url');
    if ( $ret == "" ) {
      $url = XOOPS_URL.'/admin.php';
    } else {
      $parsed = parse_url(XOOPS_URL);
      $url = isset($parsed['scheme']) ? $parsed['scheme'].'://' : 'http://';
      
      if (isset($parsed['host'])) {
        $url .= isset($parsed['port']) ? $parsed['host'].':'.$parsed['port'].$ret : $parsed['host'].$ret;
      } else {
        $url .= $_SERVER['HTTP_HOST'].$ret;
      }
    }
    
    if ( $this->update($theme) ) {
      $this->root->mController->executeRedirect($url, 2, 'Change Theme');
    } else {
      $this->root->mController->executeRedirect($url, 2, 'Error');
    }
  }
  
  private function update($theme)
  {
    $db = $this->root->mController->mDB;
    $sql = "UPDATE `".$db->prefix('config')."` ";
    $sql.= "SET `conf_value` = ".$db->quoteString($theme)." ";
    $sql.= "WHERE `conf_modid` = ".$this->root->mContext->mXoopsModule->get('mid')." ";
    $sql.= "AND `conf_catid` = 0 ";
    $sql.= "AND `conf_name` = 'admintheme'";
    return $db->queryF($sql);
  }
  
  public function executeView(&$render)
  {
  }
}
?>