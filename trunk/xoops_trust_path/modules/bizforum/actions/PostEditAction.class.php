<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZFORUM_TRUST_PATH . '/class/AbstractEditAction.class.php';
require_once BIZFORUM_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizforum_PostEditAction
**/
class Bizforum_PostEditAction extends Bizforum_AbstractEditAction
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
        return $this->mRoot->mContext->mRequest->getRequest('post_id');
    }

    /**
     * _getId
     * 
     * @param   void
     * 
     * @return  int
    **/
    protected function _getTopicId()
    {
    	if($this->mRoot->mContext->mRequest->getRequest('topic_id')){
	        return $this->mRoot->mContext->mRequest->getRequest('topic_id');
	    }
	    elseif($this->mRoot->mContext->mRequest->getRequest('p_id')){
	    	$handler =& $this->_getHandler();
	    	$post = $handler->get($this->mRoot->mContext->mRequest->getRequest('p_id'));
	    	return $post->get('topic_id');
	    }
	    else{
	    	return 0;	//invalid
	    }
    }


    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizforum_PostHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'post');
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
        // $this->mActionForm =& new Bizforum_PostEditForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'post',false,'edit');
        $this->mActionForm->prepare();
    }

	/**
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
	
		if(! $this->_getTopicId()){
			$this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_NO_TOPIC_REQUSETED);
		}
		$this->mObject->set('topic_id', $this->_getTopicId());
	
		//check post permission
		$xcatHandler = new Bizforum_Xcathandler($this->mAsset->mDirname);
		$this->mObject->loadTopic($this->mAsset->mDirname);
		if(! $xcatHandler->checkPermit($this->mObject->mTopic->get('cat_id'), $xcatHandler->getPermitTitle('poster'))){
			$this->mRoot->mController->executeRedirect('./index.php?action=PostList&topic_id='. $this->mObject->get('topic_id'), 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
		}
	
		$uid = ($this->mRoot->mContext->mXoopsUser) ? $this->mRoot->mContext->mXoopsUser->get('uid') : 0;
	
		if ($this->mObject->isNew()) {
			$this->mObject->set('uid', $uid);
			$this->mObject->set('p_id', intval($this->mRoot->mContext->mRequest->getRequest('p_id')));
		}
		else{
			//check permission to edit
			if(! $this->mRoot->mContext->mXoopsUser){
				return $this->mRoot->mController->executeRedirect('./index.php?action=TopicView&topic_id='. $this->mObject->get('topic_id'), 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
			}
			//Is this user the topic poster ?
			if($this->mObject->get('uid')!=$this->mRoot->mContext->mXoopsUser->get('uid')){
				//Is this user has editor's permission ?
				if(! $xcatHandler->checkPermit($this->mObject->get('cat_id'), $xcatHandler->getPermitTitle('editor'))){
					$this->mRoot->mController->executeRedirect('./index.php?action=TopicView&topic_id='. $this->mObject->get('topic_id'), 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
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
		$xcatHandler = new Bizforum_Xcathandler($this->mAsset->mDirname);
	
    	$this->mObject->loadTopic($this->mAsset->mDirname);
    	$this->mObject->loadParent($this->mAsset->mDirname);
    
        $render->setTemplateName($this->mAsset->mDirname . '_post_edit.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('object', $this->mObject);
        $render->setAttribute('topic', $this->mObject->mTopic);
        $render->setAttribute('parent', $this->mObject->mParent);
        $render->setAttribute('catTitle', $xcatHandler->getTitle($this->mObject->mTopic->get('cat_id')));
        $render->setAttribute('catPathArr', $xcatHandler->getCatPath($this->mObject->mTopic->get('cat_id')));
	
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
        $this->mRoot->mController->executeForward('./index.php?action=PostList&topic_id='. $this->mObject->get('topic_id'));
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
        $this->mRoot->mController->executeRedirect('./index.php?action=PostList', 1, _MD_BIZFORUM_ERROR_DBUPDATE_FAILED);
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
        $this->mRoot->mController->executeForward('./index.php?action=PostList');
    }


    /**
     * execute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    public function execute()
    {
        if ($this->mObject == null)
        {
            return BIZFORUM_FRAME_VIEW_ERROR;
        }
    
    	if($this->mObject->isNew()){
    		$newFlag = true;
    	}
    
        if ($this->mRoot->mContext->mRequest->getRequest('_form_control_cancel') != null)
        {
            return BIZFORUM_FRAME_VIEW_CANCEL;
        }
    
        $this->mActionForm->load($this->mObject);
    
        $this->mActionForm->fetch();
        $this->mActionForm->validate();
    
        if ($this->mActionForm->hasError())
        {
            return BIZFORUM_FRAME_VIEW_INPUT;
        }
    
        $this->mActionForm->update($this->mObject);
    
        if(! $this->mObjectHandler->insert($this->mObject))
        {
	        return BIZFORUM_FRAME_VIEW_ERROR;
        }
	
		//update last post user/time if this post is new.
		if($newFlag==true){
			$topicHandler = & $this->mAsset->getObject('handler', 'topic');
			$topic =& $topicHandler->get($this->mObject->get('topic_id'));
			$topic->set('last_id', $this->mObject->get('post_id'));
			$topic->set('last_unixtime', $this->mObject->get('reg_unixtime'));
			$topicHandler->insert($topic);
		}
	
        return BIZFORUM_FRAME_VIEW_SUCCESS;
    }

    /**
     * _doExecute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    protected function _doExecute()
    {
    }
}

?>
