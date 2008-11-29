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

require_once BIZFORUM_TRUST_PATH . '/class/AbstractDeleteAction.class.php';
require_once BIZFORUM_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizforum_PostDeleteAction
**/
class Bizforum_PostDeleteAction extends Bizforum_AbstractDeleteAction
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
        // $this->mActionForm =& new Bizforum_PostDeleteForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'post',false,'delete');
        $this->mActionForm->prepare();
    }

	function prepare()
	{
		parent::prepare();
	
		$this->mObject->loadTopic($this->mAsset->mDirname);
		//check permission to delete
		$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
		if($this->mObject->get('uid')!=$this->mRoot->mContext->mXoopsUser->get('uid') && ! $xcatHandler->checkPermit($this->mObject->mTopic->get('cat_id'), 'editor')){
			$this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
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
        $render->setTemplateName($this->mAsset->mDirname . '_post_delete.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        #cubson::lazy_load('post', $this->mObject);
        $render->setAttribute('object', $this->mObject);
	
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
        $this->mRoot->mController->executeForward('./index.php?action=PostList');
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
}

?>
