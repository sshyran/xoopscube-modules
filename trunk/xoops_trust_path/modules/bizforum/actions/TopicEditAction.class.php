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
 * Bizforum_TopicEditAction
**/
class Bizforum_TopicEditAction extends Bizforum_AbstractEditAction
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
        return $this->mRoot->mContext->mRequest->getRequest('topic_id');
    }

	/**
	 * @protected
	 */
	function _getCatId()
	{
		if(! $this->mRoot->mContext->mRequest->getRequest('cat_id')){
			return 0;
		}
	
		$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
		if($xcatHandler->checkPermit($this->mRoot->mContext->mRequest->getRequest('cat_id'), $xcatHandler->getPermitTitle('poster'))){
			return intval($this->mRoot->mContext->mRequest->getRequest('cat_id'));
		}
		else{	//unpermitted category request
			$this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
		}
	}

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizforum_TopicHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'topic');
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
        // $this->mActionForm =& new Bizforum_TopicEditForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'topic',false,'edit');
        $this->mActionForm->prepare();
    }

	/**
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
		if ($this->mObject->isNew()) {
			if($this->mRoot->mContext->mXoopsUser){
				$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			}
			$this->mObject->set('cat_id', $this->_getCatId());
		}
		else{
			//check permission to edit
			if(!$this->mRoot->mContext->mXoopsUser){
				return $this->mRoot->mController->executeRedirect('./index.php?action=TopicView&topic_id='. $this->mObject->get('topic_id'), 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
			}
			//Is this user the topic poster ?
			if($this->mObject->get('uid')!=$this->mRoot->mContext->mXoopsUser->get('uid')){
				$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
				//Is this user has editor's permission ?
				if(! $xcatHandler->checkPermit($this->mObject->get('cat_id'), $xcatHandler->getPermitTitle('editor'))){
					$this->mRoot->mController->executeRedirect('./index.php?action=StoryList', 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
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
    	//get category trees
    	$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
    	$cat = $xcatHandler->getCatList($xcatHandler->getPermitTitle('poster'));

        $render->setTemplateName($this->mAsset->mDirname . '_topic_edit.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('object', $this->mObject);

        $render->setAttribute('cat', $cat);
	
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
        $this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_DBUPDATE_FAILED);
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
        $this->mRoot->mController->executeForward('./index.php?action=TopicList');
    }
}

?>
