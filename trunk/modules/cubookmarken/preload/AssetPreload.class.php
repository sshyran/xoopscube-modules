<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Cubookmarken_AssetPreload extends XCube_ActionFilter
{
	/**
	 * @public
	 */
	function preBlockFilter()
	{
		if (!$this->mRoot->mContext->hasAttribute('module.cubookmarken.HasSetAssetManager')) {
			$delegate =& new XCube_Delegate();
			$delegate->register('Module.cubookmarken.Event.GetAssetManager');
			$delegate->add(array(&$this, 'getManager'));
			$this->mRoot->mContext->setAttribute('module.cubookmarken.HasSetAssetManager', true);
		}
	}

	/**
	 * @private
	 */
	function getManager(&$obj)
	{
		require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AssetManager.class.php";
		$obj = Cubookmarken_AssetManager::getSingleton();
	}
}

?>
