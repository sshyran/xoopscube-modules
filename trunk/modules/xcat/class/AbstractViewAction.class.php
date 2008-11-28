<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcat_AbstractViewAction extends Xcat_AbstractAction
{
	var $mObject = null;
	var $mObjectHandler = null;

	/**
	 * @protected
	 */
	function _getId()
	{
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
	}

	/**
	 * @protected
	 */
	function _setupObject()
	{
		$id = $this->_getId();
	
		$this->mObjectHandler =& $this->_getHandler();
	
		$this->mObject =& $this->mObjectHandler->get($id);
	}

	/**
	 * @public
	 */
	function prepare()
	{
		$this->_setupObject();
		return is_object($this->mObject);
	}

	/**
	 * @public
	 */
	function getDefaultView()
	{
		if ($this->mObject == null) {
			return XCAT_FRAME_VIEW_ERROR;
		}
	
		return XCAT_FRAME_VIEW_SUCCESS;
	}

	/**
	 * @public
	 */
	function execute()
	{
		return $this->getDefaultView($controller, $xoopsUser, $moduleConfig);
	}
}

?>
