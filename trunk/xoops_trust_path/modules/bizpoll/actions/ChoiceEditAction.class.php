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

require_once BIZPOLL_TRUST_PATH . '/class/AbstractEditAction.class.php';

/**
 * Bizpoll_ChoiceEditAction
**/
class Bizpoll_ChoiceEditAction extends Bizpoll_AbstractEditAction
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
     * _getEnqId
     * @param   void
     * @return  int
    **/
    protected function _getEnqId()
    {
    	return ($this->mObject->get('enq_id')>0) ? $this->mObject->get('enq_id') : intval($this->mRoot->mContext->mRequest->getRequest('enq_id'));
    }

    /**
     * _getEnq
     * @param   void
     * @return  object
    **/
	protected function _getEnq()
	{
		$handler =& $this->mAsset->getObject('handler', 'enq');
		return $handler->get($this->_getEnqId());
	}

    /**
     * &_getHandler
     * @param   void
     * @return  Bizpoll_ChoiceHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'choice');
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
        // $this->mActionForm =& new Bizpoll_ChoiceEditForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'choice',false,'edit');
        $this->mActionForm->prepare();
    }

	/**
	 * @public
	 */
	public function prepare()
	{
		parent::prepare();
	
		//enq_id is necessary
		$enq = $this->_getEnq();
		if(! $enq){
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_ENQ_ID_REQUIRED);
		}
	
		//Can this user add choices ?
		if(! $enq->allowAddChoice()){
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
		}
	
		if ($this->mObject->isNew()) {
			if($this->mRoot->mContext->mXoopsUser){
				$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			}
			$this->mObject->set('enq_id', $enq->get('enq_id'));
		}
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
        $render->setTemplateName($this->mAsset->mDirname . '_choice_edit.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        #cubson::lazy_load('choice', $this->mObject);
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
        $this->mRoot->mController->executeForward('./index.php?action=ChoiceList');
    }
}

?>
