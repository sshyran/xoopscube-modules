<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractEditAction.class.php";

class Xcat_ModEditAction extends Xcat_AbstractEditAction
{
	/**
	 * @protected
	 */
	function _getId()
	{
		return xoops_getrequest('mod_id');
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "mod");
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
	function _setupActionForm()
	{
		// $this->mActionForm =& new Xcat_ModEditForm();
		$this->mActionForm =& $this->mAsset->create('form', "edit_mod");
		$this->mActionForm->prepare();
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$modHandler =& xoops_gethandler('module');
		$modArr =& $modHandler->getObjects();
	
		$grHandler =& xoops_getmodulehandler('gr');
		$grArr =& $grHandler->getObjects();
	
		$render->setTemplateName("xcat_mod_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('mod', $this->mObject);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('modArr', $modArr);
		$render->setAttribute('grArr', $grArr);
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=ModList");
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=ModList", 1, _MD_XCAT_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=ModList");
	}
}

?>
