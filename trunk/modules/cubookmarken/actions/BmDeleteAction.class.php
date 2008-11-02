<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractDeleteAction.class.php";

class Cubookmarken_BmDeleteAction extends Cubookmarken_AbstractDeleteAction
{
	/**
	 * @protected
	 */
	function _getId()
	{
		return xoops_getrequest('bm_id');
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "bm");
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
		// $this->mActionForm =& new Cubookmarken_BmDeleteForm();
		$this->mActionForm =& $this->mAsset->create('form', "delete_bm");
		$this->mActionForm->prepare();
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName("cubookmarken_bm_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('bm', $this->mObject);
		$render->setAttribute('object', $this->mObject);
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
		$this->mRoot->mController->executeRedirect("./index.php?action=BmList", 1, _MD_CUBOOKMARKEN_ERROR_DBUPDATE_FAILED);
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
