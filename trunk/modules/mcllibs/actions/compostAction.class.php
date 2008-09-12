<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once _MCL_LIBS_PATH.'MCL_Utils.class.php';

class compostAction extends AbstractMcllibsAction
{
  public function __construct()
  {
    parent::__construct();
    $this->setUrl(XOOPS_URL.'/');
  }

  public function execute()
  {
    if ( !MCL_Utils::isPostMethod() ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR1);
      return false;
    }
    
    $token = $this->root->mContext->mRequest->getRequest('com_token');
    if ( !isset($_SESSION['_MCLLIBS']['COMMENT'][$token]) ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR1);
      $_SESSION['_MCLLIBS']['COMMENT'] = array();
      unset($_SESSION['_MCLLIBS']['COMMENT']);
      return false;
    }
    
    $com = $_SESSION['_MCLLIBS']['COMMENT'][$token];
    $_SESSION['_MCLLIBS']['COMMENT'] = array();
    unset($_SESSION['_MCLLIBS']['COMMENT']);
    
    $this->setUrl($com['returl']);
    if ( is_object($this->root->mContext->mXoopsUser) ) {
      $uid = $this->root->mContext->mXoopsUser->get('uid');
      $name = $this->root->mContext->mXoopsUser->get('uname');
    } else {
      $uid = 0;
      $name = $this->root->mContext->mRequest->getRequest('com_name');
    }
    if ( $name == "" ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR2);
      return false;
    }
    $comment = $this->root->mContext->mRequest->getRequest('com_txt');
    if ( $comment == "" ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR3);
      return false;
    }
    
    $hand = MCL_Utils::get_handler('comment', array('com_modid', 'com_itemid', 'com_id'));
    $com_id = $hand->getMaxSeq('com_id', array($com['modid'], $com['itemid']));
    $obj = $hand->create();
    $obj->set('com_modid', $com['modid']);
    $obj->set('com_itemid', $com['itemid']);
    $obj->set('com_id', $com_id);
    $obj->set('com_text', $comment);
    $obj->set('com_uid', $uid);
    $obj->set('com_name', $name);
    $obj->set('com_ip', $_SERVER['REMOTE_ADDR']);
    $obj->set('com_time', time());
    $obj->set('com_status', $com['status']);
    $obj->set('com_xcode', $com['xcode']);
    if ( $hand->insert($obj) ) {
      $this->setErr(_MI_MCLLIBS_COMMENT_MSG1);
    } else {
      $this->setErr(_MI_MCLLIBS_COMMENT_ERR4);
    }
    return false;
  }
  
  public function executeView(&$render)
  {
  }
}
?>