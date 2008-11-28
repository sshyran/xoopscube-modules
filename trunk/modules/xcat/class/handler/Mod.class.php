<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcat_ModObject extends XoopsSimpleObject
{
	var $mGr = null;
	var $_mGrLoadedFlag = false;

	/**
	 * @public
	 */
	function Xcat_ModObject()
	{
		$this->initVar('mod_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('gr_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('mid', XOBJ_DTYPE_INT, '', false);
		$this->initVar('dir_name', XOBJ_DTYPE_STRING, '', false, 25);
		$this->initVar('weight', XOBJ_DTYPE_INT, 10, false);
		$this->initVar('option', XOBJ_DTYPE_TEXT, '', false);
	}

	/**
	 * @public
	 * load Gr Object of this category.
	 */
	function loadGr()
	{
		if ($this->_mGrLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('gr', 'xcat');
			$this->mGr =& $handler->get($this->get('gr_id'));
			$this->_mGrLoadedFlag = true;
		}
	}

}

class Xcat_ModHandler extends XoopsObjectGenericHandler
{
	var $mTable = 'xcat_mod';
	var $mPrimary = 'mod_id';
	var $mClass = 'Xcat_ModObject';

}

?>
