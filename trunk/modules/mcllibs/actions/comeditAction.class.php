<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once _MCL_LIBS_PATH.'MCL_Utils.class.php';

class comeditAction extends AbstractMcllibsAction
{
  private $comobj = false;
  public function __construct()
  {
    parent::__construct();
    $this->setUrl(XOOPS_URL.'/');
  }

  public function execute()
  {
    $com_modid = intval($this->root->mContext->mRequest->getRequest('com_modid'));
    $com_itemid = intval($this->root->mContext->mRequest->getRequest('com_itemid'));
    $com_id = intval($this->root->mContext->mRequest->getRequest('com_id'));
    
    if ( $com_modid < 0 || $com_itemid < 0 || $com_id < 1 ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR5);
      return false;
    }
    
    $hand = MCL_Utils::get_handler('comment', array('com_modid', 'com_itemid', 'com_id'));
    $this->comobj = $hand->get(array($com_modid, $com_itemid, $com_id));
    if ( !$this->comobj ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR5);
      return false;
    }
    
    if ( $this->root->mContext->mXoopsUser->get('uid') != $this->comobj->get('com_uid') ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR6);
      return false;
    }
    
    if ( MCL_Utils::isPostMethod() ) {
      $comment = $this->root->mContext->mRequest->getRequest('com_txt');
      if ( $comment == "" ) {
        $this->setErr(_MI_MCLLIBS_COMMENT_ERR3);
        return false;
      }
      
      $this->comobj->set('com_text', $comment);
      $this->comobj->set('com_ip', $_SERVER['REMOTE_ADDR']);
      $this->comobj->set('com_time', time());
      if ( $hand->insert($this->comobj) ) {
        $this->setErr(_MI_MCLLIBS_COMMENT_MSG2);
      } else {
        $this->setErr(_MI_MCLLIBS_COMMENT_ERR7);
      }
      return true;
    }
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName('mcllibs_comment_edit.html');
    $render->setAttribute('comobj', $this->comobj);
  }
}
?>