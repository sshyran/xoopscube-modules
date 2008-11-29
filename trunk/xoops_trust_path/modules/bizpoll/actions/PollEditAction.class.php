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
require_once BIZPOLL_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizpoll_PollEditAction
**/
class Bizpoll_PollEditAction extends Bizpoll_AbstractEditAction
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

    protected function _getEnqId()
    {
        return $this->mRoot->mContext->mRequest->getRequest('enq_id');
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
        // $this->mActionForm =& new Bizpoll_PollEditForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'poll', false, 'edit');
        $this->mActionForm->prepare();
    }

	/**
	 * @public
	 */
	public function prepare()
	{
		$this->mUseCat = ($this->mModule->getModuleConfig('gr_id')>0) ? true : false;
		parent::prepare();
		$this->mObject->set('enq_id', $this->_getEnqId());
		$this->mObject->loadEnq($this->mAsset->mDirname);
		//check poll permission.
		//if not use Xcat, everyone(include guest) can poll.
		if($this->mUseCat){
			$xcatHandler = new Bizpoll_XcatHandler($this->mAsset->mDirname);
			if(! $xcatHandler->checkPermit($this->mObject->mEnq->get('cat_id'), 'poller')){
				$this->mRoot->mController->executeRedirect('./index.php?action=EnqView&enq_id='. $this->mObject->get('enq_id'), 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
			}
		}
	
		if ($this->mObject->isNew()) {
			if($this->mRoot->mContext->mXoopsUser){
				$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			}
			else{
				//check multiple polls
				$criteria = new CriteriaCompo('1', '1');
				$criteria->add(new Criteria('enq_id', $this->_getEnqId()));
				$criteria->add(new Criteria('uid', 0));
				$criteria->add(new Criteria('ip', addslashes($_SERVER['REMOTE_ADDR'])));
				$handler =& $this->_getHandler();
				$poll = $handler->getObjects($criteria);
				//guest can't poll multiple from the same ip during 1 day
				$ipPeriod = $this->mModule->getModuleConfig('ip_period') * 3600;
				if(count($poll)>0 && $poll[0]->get('reg_unixtime')+$ipPeriod>time()){
					$this->mRoot->mController->executeRedirect('./index.php?action=EnqView&enq_id='. $this->_getEnqId(), 1, _MD_BIZPOLL_MESSAGE_MULTIPLE_POLL);
				}
			}
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
    	$handler =& $this->mAsset->getObject('handler', 'enq');
    	$object = $handler->get($this->mObject->get('enq_id'));
		//load Choices
		$object->loadChoice($this->mAsset->mDirname);
		foreach(array_keys($object->mChoice) as $key){
			$object->mChoice[$key]->loadPolled($this->mAsset->mDirname);
			$object->mChoice[$key]->countPoll($this->mAsset->mDirname);
		}
		$object->loadMyPoll($this->mAsset->mDirname);
	
        $render->setTemplateName($this->mAsset->mDirname . '_enq_view.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('object', $object);
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);

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
        $this->mRoot->mController->executeRedirect('./index.php?action=PollList', 1, _MD_BIZPOLL_ERROR_DBUPDATE_FAILED);
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
