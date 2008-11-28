<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcat_AbstractAction
{
	var $mRoot = null;
	var $mModule = null;
	var $mAsset = null;

	/**
	 * @public
	 */
	function Xcat_AbstractAction()
	{
		$this->mRoot =& XCube_Root::getSingleton();
		$this->mModule =& $this->mRoot->mContext->mModule;
		$this->mAsset =& $this->mModule->mAssetManager;
	}

	/**
	 * @public
	 */
	function isMemberOnly()
	{
		return false;
	}

	/**
	 * @public
	 */
	function isAdminOnly()
	{
		return false;
	}

	/**
	 * @public
	 */
	function prepare()
	{
		return true;
	}

	/**
	 * @public
	 */
	function hasPermission()
	{
		return true;
	}

	/**
	 * @public
	 */
	function getDefaultView()
	{
		return Xcat_FRAME_VIEW_NONE;
	}

	/**
	 * @public
	 */
	function execute()
	{
		return Xcat_FRAME_VIEW_NONE;
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
	}

	/**
	 * @public
	 */
	function executeViewPreview(&$render)
	{
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
	}
}

?>
