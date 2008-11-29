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
require_once BIZPOLL_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizpoll_EnqViewAction
**/
class Bizpoll_EnqViewAction extends Bizpoll_AbstractViewAction
{
	var $mCatTitle = "";
	var $mCatPath = array();
	var $mUseCat = false;

    /**
     * _getId
     * 
     * @param   void
     * 
     * @return  int
    **/
    protected function _getId()
    {
        return $this->mRoot->mContext->mRequest->getRequest('enq_id');
    }

    /**
     * &_getHandler
     * @param   void
     * @return  Bizpoll_EnqHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'enq');
        return $handler;
    }

    /**
     * _setupActionForm
     * @param   void
     * @return  void
    **/
    protected function _setupPollActionForm()
    {
        // $this->mActionForm =& new Bizpoll_PollEditForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'poll', false, 'edit');
        $this->mActionForm->prepare();
    }

    /**
     * getDefaultView
     * @param   void
     * @return  Enum
    **/
    public function getDefaultView()
    {
        if($this->mObject == null)
        {
            return BIZPOLL_FRAME_VIEW_ERROR;
        }
    
        $this->mActionForm->load($this->mObject->mMyPoll);
        return BIZPOLL_FRAME_VIEW_SUCCESS;
    }

	/**
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
		$this->_setupPollActionForm();
		//TODO? $this->mObjectPoll = 
	
		$this->mUseCat = ($this->mModule->getModuleConfig('gr_id')>0) ? true : false;
	
		$xcatHandler = new Bizpoll_XcatHandler($this->mAsset->mDirname);
		//don't show the View before published date
		if(! $xcatHandler->checkPermit($this->mObject->get('cat_id'), 'editor', $this->mObject->get('uid'))){
			//check publish date
			if($this->mObject->get('pub_unixtime')>time()){
				$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PUBLISHED);
			}
		}
	
		//check view permission
		if(! $xcatHandler->checkPermit($this->mObject->get('cat_id'), 'viewer')){
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
		}
	
		//get category path
		if($this->mUseCat){
			$this->mCatTitle = $xcatHandler->getTitle($this->mObject->get('cat_id'));
			$this->mCatPath = $xcatHandler->getCatPath($this->mObject->get('cat_id'));
		}
	
		//load Choices
		$this->mObject->loadChoice($this->mAsset->mDirname);
		foreach(array_keys($this->mObject->mChoice) as $key){
			$this->mObject->mChoice[$key]->loadPolled($this->mAsset->mDirname);
			$this->mObject->mChoice[$key]->countPoll($this->mAsset->mDirname);
		}
	
		//load Poll of this User
		$this->mObject->loadMyPoll($this->mAsset->mDirname);
	}

    /**
     * executeViewSuccess
     * @param   XCube_RenderTarget  &$render
     * @return  void
    **/
    public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
    {
        $render->setTemplateName($this->mAsset->mDirname . '_enq_view.html');
        $render->setAttribute('object', $this->mObject);
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('catTitle', $this->mCatTitle);
        $render->setAttribute('catPathArr', $this->mCatPath);
		$render->setAttribute('useEditor', $this->mModule->getModuleConfig('editor'));
		$render->setAttribute('useCat', $this->mUseCat);
		$render->setAttribute('allowShowResult', $this->mObject->allowShowResult($this->mAsset->mDirname));
		$render->setAttribute('dirname', $this->mAsset->mDirname);
	
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);
    }

    /**
     * executeViewError
     * @param   XCube_RenderTarget  &$render
     * @return  void
    **/
    public function executeViewError(/*** XCube_RenderTarget ***/ &$render)
    {
        $this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_CONTENT_IS_NOT_FOUND);
    }
}

?>
