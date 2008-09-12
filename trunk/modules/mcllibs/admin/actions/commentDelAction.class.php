<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once _MCL_LIBS_PATH.'MCL_Utils.class.php';

class commentDelAction extends AbstractMCLAdminClass
{
  private $comm = false;
  
  public function __construct()
  {
    parent::__construct();
    $this->url = 'index.php?action=comment';
  }
  
  public function execute()
  {
    $com_modid = intval($this->root->mContext->mRequest->getRequest('com_modid'));
    $com_itemid = intval($this->root->mContext->mRequest->getRequest('com_itemid'));
    $com_id = intval($this->root->mContext->mRequest->getRequest('com_id'));
    
    $hand = MCL_Utils::get_handler('comment', array('com_modid', 'com_itemid', 'com_id'));
    $this->comm = $hand->get(array($com_modid, $com_itemid, $com_id));
    if ( !is_object($this->comm) ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR5);
      return false;
    }
    
    if ( MCL_Utils::isPostMethod() ) {
      if ( $hand->delete($this->comm) ) {
        $this->setErr(_AD_MCLLIBS_COMMENT_MSG3);
      } else {
        $this->setErr(_AD_MCLLIBS_COMMENT_MSG4);
      }
      return true;
    }
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_comment_del.html');
    $render->setAttribute('comm', $this->comm);
  }
}
?>