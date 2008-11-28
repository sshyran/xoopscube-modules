<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractListAction.class.php";

class Xcat_GrListAction extends Xcat_AbstractListAction
{
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
	function &_getFilterForm()
	{
		// $filter =& new Xcat_GrFilterForm();
		$filter =& $this->mAsset->create('filter', "gr");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	/**
	 * @protected
	 */
	function _getBaseUrl()
	{
		return "./index.php?action=GrList";
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName("xcat_gr_list.html");
		#cubson::lazy_load_array('gr', $this->mObjects);
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
		$render->setAttribute('xoops_module_header', '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/modules/xcat/xcat.css" />');

	}
}

?>
