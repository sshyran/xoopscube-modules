<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractDeleteAction.class.php";

class Xcat_GrDeleteAction extends Xcat_AbstractDeleteAction
{
	/**
	 * @protected
	 */
	function &_getId()
	{
		return xoops_getrequest('gr_id');
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "gr");
		return $handler;
	}

	/**
	 * @public
	 */
	function isAdminOnly()
	{
		return true;
	}

	/**
	 * @protected
	 */
	function &_setupActionForm()
	{
		// $this->mActionForm =& new Xcat_GrDeleteForm();
		$this->mActionForm =& $this->mAsset->create('form', "delete_gr");
		$this->mActionForm->prepare();
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName("xcat_gr_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('gr', $this->mObject);
		$render->setAttribute('object', $this->mObject);
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=GrList");
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=GrList", 1, _MD_XCAT_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=GrList");
	}
}

?>
