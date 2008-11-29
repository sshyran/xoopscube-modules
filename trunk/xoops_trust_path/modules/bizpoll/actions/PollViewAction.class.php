<?php
/**
 * @file
 * @package bizpoll
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZPOLL_TRUST_PATH . '/class/AbstractViewAction.class.php';

/**
 * Bizpoll_PollViewAction
**/
class Bizpoll_PollViewAction extends Bizpoll_AbstractViewAction
{
    /**
     * _getId
     * 
     * @param   void
     * 
     * @return  int
    **/
    protected function _getId()
    {
        return $this->mRoot->mContext->mRequest->getRequest('poll_id');
    }

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizpoll_PollHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'poll');
        return $handler;
    }

    /**
     * executeViewSuccess
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
    {
        $render->setTemplateName($this->mAsset->mDirname . '_poll_view.html');
        #cubson::lazy_load('poll', $this->mObject);
        $render->setAttribute('object', $this->mObject);
    }

    /**
     * executeViewError
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewError(/*** XCube_RenderTarget ***/ &$render)
    {
        $this->mRoot->mController->executeRedirect('./index.php?action=PollList', 1, _MD_BIZPOLL_ERROR_CONTENT_IS_NOT_FOUND);
    }
}

?>
