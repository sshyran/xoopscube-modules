<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractViewAction.class.php";

class Xcat_PermViewAction extends Xcat_AbstractViewAction
{
	/**
	 * @public
	 */
	function _getId()
	{
		return xoops_getrequest('perm_id');
	}

	/**
	 * @public
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "perm");
		return $handler;
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$render->setTemplateName("xcat_perm_view.html");
		#cubson::lazy_load('perm', $this->mObject);
		$render->setAttribute('object', $this->mObject);
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=PermList", 1, _MD_XCAT_ERROR_CONTENT_IS_NOT_FOUND);
	}
}

?>
