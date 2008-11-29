<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class viewAction extends AbstractAction
{
  private $inout = 'inbox';
  private $msgdata = null;
  
  public function __construct()
  {
    parent::__construct();
  }
  
  public function execute()
  {
    if ( $this->root->mContext->mRequest->getRequest('inout') == 'in' ) {
      $this->inout = 'inbox';
    } else {
      $this->inout = 'outbox';
    }
    
    $boxid = intval($this->root->mContext->mRequest->getRequest($this->inout));
    $modHand = xoops_getmodulehandler($this->inout);
    $modObj = $modHand->get($boxid);
    if ( !is_object($modObj) ) {
      $this->setErr(_MD_MESSAGE_ACTIONMSG1);
      return;
    }
    
    if ( $modObj->get('uid') != $this->root->mContext->mXoopsUser->get('uid') ) {
      $this->setErr(_MD_MESSAGE_ACTIONMSG8);
      return;
    }
    
    foreach ( array_keys($modObj->gets()) as $var_name ) {
      $this->msgdata[$var_name] = $modObj->getShow($var_name);
    }
    if ( $this->inout == 'inbox' ) {
      $this->msgdata['fromname'] = $this->getLinkUnameFromId($this->msgdata['from_uid'], $this->msgdata['uname']);
    } else {
      $this->msgdata['toname'] = $this->getLinkUnameFromId($this->msgdata['to_uid'], $this->root->mContext->mXoopsConfig['anonymous']);
    }
    $modObj->set('is_read', 1);
    $modHand->insert($modObj, true);
  }
  
  public function executeView(&$render)
  {
    if ( $this->inout == 'inbox' ) {
      $render->setTemplateName('message_inboxview.html');
    } else {
      $render->setTemplateName('message_outboxview.html');
    }
    $render->setAttribute('msgdata', $this->msgdata);
    //FRONT
    if (defined('_FRONTCONTROLLER')) {
      $render->setAttribute('message_url', XOOPS_URL.'/index.php?moddir='._MY_DIRNAME);
    } else {
      $render->setAttribute('message_url', 'index.php?moddir='._MY_DIRNAME);
    }
  }
}
?>