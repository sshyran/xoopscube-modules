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

require_once BIZPOLL_TRUST_PATH . '/class/AbstractDeleteAction.class.php';

/**
 * Bizpoll_PollDeleteAction
**/
class Bizpoll_PollDeleteAction extends Bizpoll_AbstractDeleteAction
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
     * _setupActionForm
     * 
     * @param   void
     * 
     * @return  void
    **/
    protected function _setupActionForm()
    {
        // $this->mActionForm =& new Bizpoll_PollDeleteForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'poll',false,'delete');
        $this->mActionForm->prepare();
    }

    /**
     * executeViewInput
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewInput(/*** XCube_RenderTarget ***/ &$render)
    {
        $render->setTemplateName($this->mAsset->mDirname . '_poll_delete.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        #cubson::lazy_load('poll', $this->mObject);
        $render->setAttribute('object', $this->mObject);
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
        $this->mRoot->mController->executeForward('./index.php?action=EnqView&enq_id='. $this->mObject->get('enq_id'));
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
        $this->mRoot->mController->executeRedirect('./index.php?action=EnqView&enq_id='. $this->mObject->get('enq_id'), 1, _MD_BIZPOLL_ERROR_DBUPDATE_FAILED);
    }

    /**
     * executeViewCancel
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewCancel(/*** XCube_RenderTarget ***/ &$render)
    {
        $this->mRoot->mController->executeForward('./index.php?action=PollList');
    }
}

?>
