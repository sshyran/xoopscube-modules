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
 * Bizforum_PostViewAction
**/
class Bizforum_PostViewAction extends Bizforum_AbstractViewAction
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
     * executeViewSuccess
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
    {
		$tpl = new XoopsTpl();
		$tpl->assign('object', $this->mObject);
		$tpl->display("db:". $this->mAsset->mDirname . "_post_view.html");
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
        $this->mRoot->mController->executeRedirect('./index.php?action=PostList', 1, _MD_BIZFORUM_ERROR_CONTENT_IS_NOT_FOUND);
    }
}

?>
