<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractDeleteAction.class.php";

class Dbkmarken_BmDeleteAction extends Dbkmarken_AbstractDeleteAction
{
	/**
	 * @protected
	 */
	function _getId()
	{
		return $this->mRoot->mContext->mRequest->getRequest('bm_id');
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', "bm");
		return $handler;
	}

	/**
	 * @public
	 */
	function isMemberOnly()
	{
		return true;
	}

	function isAdminOnly()
	{
		$id = $this->_getId();
		$handler = & $this->_getHandler();
		$this->mObject = & $handler->get($id);
		if($this->mObject->get('uid') != $this->mRoot->mContext->mXoopsUser->get('uid')){
			return true;
		}
	}

	/**
	 * @protected
	 */
	function _setupActionForm()
	{
		// $this->mActionForm =& new Dbkmarken_BmDeleteForm();
		$this->mActionForm =& $this->mAsset->getObject('form', "bm", false, "delete");
		$this->mActionForm->prepare();
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . "_bm_delete.html");
        $render->setAttribute('dirname',$this->mAsset->mDirname);
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('bm', $this->mObject);
		$render->setAttribute('object', $this->mObject);
	
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=BmList");
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=BmList", 1, _MD_DBKMARKEN_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=BmList");
	}
}

?>
