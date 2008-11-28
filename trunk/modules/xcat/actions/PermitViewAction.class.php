<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractViewAction.class.php";

class Xcat_PermitViewAction extends Xcat_AbstractViewAction
{
	/**
	 * @public
	 */
	function _getId()
	{
		return xoops_getrequest('permit_id');
	}

	/**
	 * @public
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "permit");
		return $handler;
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$render->setTemplateName("xcat_permit_view.html");
		#cubson::lazy_load('permit', $this->mObject);
		$render->setAttribute('object', $this->mObject);
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=PermitList", 1, _MD_XCAT_ERROR_CONTENT_IS_NOT_FOUND);
	}
}

?>
