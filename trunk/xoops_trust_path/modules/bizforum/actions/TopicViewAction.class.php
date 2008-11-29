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

require_once BIZFORUM_TRUST_PATH . '/class/AbstractViewAction.class.php';
require_once BIZFORUM_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizforum_TopicViewAction
**/
class Bizforum_TopicViewAction extends Bizforum_AbstractViewAction
{
	var $mCatTitle = "";
	var $mCatPath = array();
	var $mIsEditor = false;

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
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
	
		$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
	
		//check view permission
		if(! $xcatHandler->checkPermit($this->mObject->get('cat_id'), $xcatHandler->getPermitTitle('viewer'))){
			$this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
		}
		//check edit permission
		if($xcatHandler->checkPermit($this->mObject->get('cat_id'), $xcatHandler->getPermitTitle('editor'))){
			$this->mIsEditor = true;
		}
	
		//get category path
		$this->mCatTitle = $xcatHandler->getTitle($this->mObject->get('cat_id'));
		$this->mCatPath = $xcatHandler->getCatPath($this->mObject->get('cat_id'));
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
        $render->setTemplateName($this->mAsset->mDirname . '_topic_view.html');
        $render->setAttribute('object', $this->mObject);
        $render->setAttribute('isEditor', $this->mIsEditor);
        $render->setAttribute('catTitle', $this->mCatTitle);
        $render->setAttribute('catPathArr', $this->mCatPath);
	
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);
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
        $this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_CONTENT_IS_NOT_FOUND);
    }
}

?>
