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

require_once BIZPOLL_TRUST_PATH . '/class/AbstractListAction.class.php';
require_once BIZPOLL_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizpoll_PollListAction
**/
class Bizpoll_PollDetailAction extends Bizpoll_AbstractListAction
{
	var $mEnq = null;

    /**
     * _getId
     * @param   void
     * @return  int
    **/
    protected function _getId()
    {
    	if($this->mRoot->mContext->mRequest->getRequest('enq_id')){
	        return $this->mRoot->mContext->mRequest->getRequest('enq_id');
	    }
	    else{
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_ENQ_ID_REQUIRED);
	    }
    }

    /**
     * &_getHandler
     * @param   void
     * @return  Bizpoll_PollHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'poll');
        return $handler;
    }

    /**
     * &_getFilterForm
     * 
     * @param   void
     * 
     * @return  Bizpoll_PollFilterForm
    **/
    protected function &_getFilterForm()
    {
        // $filter =& new Bizpoll_PollFilterForm();
        $filter =& $this->mAsset->getObject('filter', 'poll',false);
        $filter->prepare($this->_getPageNavi(), $this->_getHandler());
        return $filter;
    }

    /**
     * _getBaseUrl
     * @param   void
     * @return  string
    **/
    protected function _getBaseUrl()
    {
        return './index.php?action=PollList';
    }

	/**
	 * @public
	 */
	function getDefaultView()
	{
		$this->mUseCat = ($this->mModule->getModuleConfig('gr_id')>0) ? true : false;
	
		//get Enq object
		$enqHandler =& $this->mAsset->getObject('handler', 'enq');
		$this->mEnq =& $enqHandler->get($this->_getId());
		if(! $this->mEnq->allowShowResult($this->mAsset->mDirname)){
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_MESSAGE_HIDE_RESULT);
		}
	
		//check permissions
		if($this->mUseCat){
			$xcatHandler = new Bizpoll_XcatHandler($this->mAsset->mDirname);
		
			if(! $xcatHandler->checkPermit($this->mEnq->get('cat_id'), 'viewer')){
				$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
			}
		}
	
		//getDefaultView
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
		$this->mEnqId = intval($this->mRoot->mContext->mRequest->getRequest('enq_id'));
	
		$handler =& $this->_getHandler();
		$criteria=$this->mFilter->getCriteria();
	
		//set enq_id request
		$criteria->add(new Criteria('enq_id', $this->_getId()));
	
		$criteria->addSort('reg_unixtime', 'DESC');
		$this->mObjects =& $handler->getObjects($criteria);
	
		//loadChoice
		foreach(array_keys($this->mObjects) as $key){
			$this->mObjects[$key]->loadChoice($this->mAsset->mDirname);
		}
	
		return BIZPOLL_FRAME_VIEW_INDEX;
	}

    /**
     * executeViewIndex
     * @param   XCube_RenderTarget  &$render
     * @return  void
    **/
    public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
    {
        $render->setTemplateName($this->mAsset->mDirname . '_poll_detail.html');
        $render->setAttribute('objects', $this->mObjects);
        $render->setAttribute('enq', $this->mEnq);
        $render->setAttribute('pageNavi', $this->mFilter->mNavi);
    }
}

?>
