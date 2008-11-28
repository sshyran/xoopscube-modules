<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcat_PermitObject extends XoopsSimpleObject
{
	var $mCat = null;
	var $_mCatLoadedFlag = false;
	
	/**
	 * @public
	 */
	function Xcat_PermitObject()
	{
		$this->initVar('permit_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('cat_id', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('groupid', XOBJ_DTYPE_INT, '0', false);
		// "1":allow, "0":not allow
		$this->initVar('permissions', XOBJ_DTYPE_TEXT, '', false);
	}

	function loadCat()
	{
		if ($this->_mCatLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('cat', 'xcat');
			$this->mCat =& $handler->get($this->get('cat_id'));
			$this->_mCatLoadedFlag = true;
		}
	}

	/**
	 * @public
	 * check permission about given action
	 */
	function checkPermit($action)
	{
		$permissions = unserialize($this->get('permissions'));
		if($permissions[$action]==1){
			return true;
		}
		else{
			return false;
		}
	}
}

class Xcat_PermitHandler extends XoopsObjectGenericHandler
{
	var $mTable = 'xcat_permit';
	var $mPrimary = 'permit_id';
	var $mClass = 'Xcat_PermitObject';

}

?>
