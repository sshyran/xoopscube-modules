<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once dirname(__FILE__) . "/AbstractEditAction.class.php";

class Xcat_AbstractDeleteAction extends Xcat_AbstractEditAction
{
	/**
	 * @protected
	 */
	function _isEnableCreate()
	{
		return false;
	}

	/**
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
		return is_object($this->mObject);
	}

	/**
	 * @protected
	 */
	function _doExecute()
	{
		if ($this->mObjectHandler->delete($this->mObject)) {
			return XCAT_FRAME_VIEW_SUCCESS;
		}
	
		return XCAT_FRAME_VIEW_ERROR;
	}
}

?>
