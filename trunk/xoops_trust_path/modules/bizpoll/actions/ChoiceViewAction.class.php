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
 * Bizpoll_ChoiceViewAction
**/
class Bizpoll_ChoiceViewAction extends Bizpoll_AbstractViewAction
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
        return $this->mRoot->mContext->mRequest->getRequest('choice_id');
    }

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizpoll_ChoiceHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'choice');
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
        $render->setTemplateName($this->mAsset->mDirname . '_choice_view.html');
        #cubson::lazy_load('choice', $this->mObject);
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
        $this->mRoot->mController->executeRedirect('./index.php?action=ChoiceList', 1, _MD_BIZPOLL_ERROR_CONTENT_IS_NOT_FOUND);
    }
}

?>
