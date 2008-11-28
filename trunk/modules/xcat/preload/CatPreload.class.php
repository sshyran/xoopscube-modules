<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/TreeObject.class.php";
require_once XOOPS_MODULE_PATH . "/xcat/class/GrList.class.php";

class Xcat_CatPreload extends XCube_ActionFilter
{
	/**
	 * @public
	 */
	function preBlockFilter()
	{
		$root =& XCube_Root::getSingleton();
	
		require_once XOOPS_MODULE_PATH . "/xcat/service/XcatService.class.php";
		$service =& new Xcat_CatService();
		$service->prepare();
	
		$this->mRoot->mServiceManager->addService('Xcat_CatService', $service);
	
		$root->mDelegateManager->add("Module.xcat.Event.GetCatManager", "Xcat_CatPreload::getCatManager");
		$root->mDelegateManager->add("Module.xcat.Event.GetCatTree", "Xcat_CatPreload::getCatTree");
		$root->mDelegateManager->add("Module.xcat.Event.GetGrList", "Xcat_CatPreload::getGrList");
	}

	/**
	 * @private
	 * get single category's object
	 */
	function getCatManager(&$obj, $catId=0)
	{
		$cat = null;
		$handler =& xoops_getmodulehandler('cat', 'xcat');
	
		if($catId>0){
			$cat =& $handler->get($catId);
			$obj = $cat;
		}
	}

	/**
	 * @private
	 * get category tree object
	 */
	function getCatTree(&$obj, $grId)
	{
		//TreeObject
		$catTree = new Xcat_TreeObject($grId);
		$catTree->loadTree();

		$obj = $catTree;
	}


	/**
	 * @private
	 * Get Gr list for category group selection
	 */
	function getGrList(&$obj)
	{
		$gr = null;

		$obj = $gr;
	}
}

?>
