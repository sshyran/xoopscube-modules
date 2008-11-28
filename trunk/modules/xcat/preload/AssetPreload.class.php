<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcat_AssetPreload extends XCube_ActionFilter
{
	/**
	 * @public
	 */
	function preBlockFilter()
	{
		if (!$this->mRoot->mContext->hasAttribute('module.xcat.HasSetAssetManager')) {
			$delegate =& new XCube_Delegate();
			$delegate->register('Module.xcat.Event.GetAssetManager');
			$delegate->add(array(&$this, 'getManager'));
			$this->mRoot->mContext->setAttribute('module.xcat.HasSetAssetManager', true);
		}
	}

	/**
	 * @private
	 */
	function getManager(&$obj)
	{
		require_once XOOPS_MODULE_PATH . "/xcat/class/AssetManager.class.php";
		$obj = Xcat_AssetManager::getSingleton();
	}
}

?>
