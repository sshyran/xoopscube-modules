<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Cubookmarken_TagObject extends XoopsSimpleObject
{

	var $mBm = null;
	var $_mBmLoadedFlag = false;

	/**
	 * @public
	 */
	function Cubookmarken_TagObject()
	{
		$this->initVar('tag_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('tag_name', XOBJ_DTYPE_STRING, '', false, 64);
		$this->initVar('bm_id', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
	}

	function loadBm()
	{
		if ($this->_mBmLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('bm', 'cubookmarken');
			$this->mBm =& $handler->get($this->get('bm_id'));
			$this->_mBmLoadedFlag = true;
		}
	}

}

class Cubookmarken_TagHandler extends XoopsObjectGenericHandler
{
	var $mTable = 'cubookmarken_tag';
	var $mPrimary = 'tag_id';
	var $mClass = 'Cubookmarken_TagObject';

}

?>
