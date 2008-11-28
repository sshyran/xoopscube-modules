<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractViewAction.class.php";
require_once XOOPS_MODULE_PATH . "/xcat/class/TreeObject.class.php";

class Xcat_GrViewAction extends Xcat_AbstractViewAction
{
	/**
	 * @public
	 */
	function _getId()
	{
		return xoops_getrequest('gr_id');
	}

	/**
	 * @public
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "gr");
		return $handler;
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		//TreeObject
		$catTree = new Xcat_TreeObject($this->mObject->get('gr_id'));
		$catTree->loadTree();
	
		//render
		$this->mObject->loadCat();
		$render->setTemplateName("xcat_gr_view.html");
		#cubson::lazy_load('gr', $this->mObject);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('childrenTree', $catTree->mTree);
		//actions array
		$render->setAttribute('actionsArr', unserialize($this->mObject->get('actions')));
		//set CSS
		$render->setAttribute('xoops_module_header','<link rel="stylesheet" type="text/css" media="screen" href="xcat.css" />');
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=GrList", 1, _MD_XCAT_ERROR_CONTENT_IS_NOT_FOUND);
	}
}

?>
