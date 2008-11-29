<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class ideleteAction extends AbstractAction
{
  private $modObj = null;
  
  public function __construct()
  {
    parent::__construct();
  }
  
  public function execute()
  {
    $id = intval($this->root->mContext->mRequest->getRequest('id'));
    
    $modhand = xoops_getmodulehandler('invitation');
    $this->modObj = $modhand->get($id);
    if ( !is_object($this->modObj) ) {
      $this->setErr(_MD_MYFRIEND_NOUSER);
      return;
    }
    
    if ( $this->modObj->get('uid') != $this->root->mContext->mXoopsUser->get('uid') ) {
      $this->setErr(_MD_MYFRIEND_ACTERR13);
      return;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if ( XoopsSingleTokenHandler::quickValidate('del') == false ) {
        $this->setErr(_MD_MYFRIEND_ACTERR13);
        return;
      }
      if ( $modhand->delete($this->modObj) ) {
        $this->setErr(XCube_Utils::formatString(_MD_MYFRIEND_DELOK, $this->modObj->getVar('email')));
      } else {
        $this->setErr(XCube_Utils::formatString(_MD_MYFRIEND_DELNG, $this->modObj->getVar('email')));
      }
    }
  }
  
  public function executeView(&$render)
  {
    $tokenHandler = new XoopsSingleTokenHandler();
    $token = $tokenHandler->create('del');
    $tokenHandler->register($token);
    
    $hiddens = array('id' => $this->modObj->get('id'), 'action' => 'idelete');
    $render->setTemplateName('legacy_xoops_confirm.html');
    $render->setAttribute('legacy_module', 'legacy');
    $render->setAttribute('action', 'index.php');
    $render->setAttribute('message', XCube_Utils::formatString(_MD_MYFRIEND_DELCONF, $this->modObj->getVar('email')));
    $render->setAttribute('hiddens', $hiddens);
    $render->setAttribute('submit', _DELETE);
    $render->setAttribute('tokenName', $token->getTokenName());
    $render->setAttribute('tokenValue', $token->getTokenValue());
  }
}
?>