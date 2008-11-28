<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractDeleteAction.class.php";

class Xcat_CatDeleteAction extends Xcat_AbstractDeleteAction
{
	/**
	 * @protected
	 */
	function &_getId()
	{
		return xoops_getrequest('cat_id');
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "cat");
		return $handler;
	}

	/**
	 * @protected
	 */
	function &_setupActionForm()
	{
		// $this->mActionForm =& new Xcat_CatDeleteForm();
		$this->mActionForm =& $this->mAsset->create('form', "delete_cat");
		$this->mActionForm->prepare();
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName("xcat_cat_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('cat', $this->mObject);
		$render->setAttribute('object', $this->mObject);
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=CatList");
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=CatList", 1, _MD_XCAT_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=CatList");
	}
}

?>
