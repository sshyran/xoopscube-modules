<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractListAction.class.php";

class Xcat_CatListAction extends Xcat_AbstractListAction
{
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
	function _getBaseUrl()
	{
		return "./index.php?action=CatList";
	}

	/**
	 * @public
	 */
	function getDefaultView()
	{
		//This ListAction won't use normal cubson's List
	
		$grHandler =& xoops_getmodulehandler('gr');
		$gr =& $grHandler->getObjects();
		$treeObj = array();
		foreach(array_keys($gr) as $key){
			$treeObj[$key] = new XCat_TreeObject($gr[$key]->get('gr_id'));
			$treeObj[$key]->loadTree();
		}
		$this->mObjects = $treeObj;
	
		return XCAT_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName("xcat_cat_list.html");
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('xoops_module_header', '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/modules/xcat/xcat.css" />');
	}
}

?>
