<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

//[level:category's depth limit]
// 0:no limit of category depth, 1:flat category, n:n th level of category depth

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcat_GrObject extends XoopsSimpleObject
{
	var $mCat = null;
	var $_mCatLoadedFlag = false;
	var $mAllCat = null;
	var $_mAllCatLoadedFlag = false;
	var $mMod = null;
	var $_mModLoadedFlag = false;

	/**
	 * @public
	 */
	function Xcat_GrObject()
	{
		$this->initVar('gr_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('gr_title', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('level', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('actions', XOBJ_DTYPE_TEXT, '', false);
	}

	function loadCat($criteria = null)
	{
		if ($this->_mCatLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('cat', 'xcat');
			if($criteria){
				$this->mCat =& $handler->getObjects($criteria);
			}else{
				$this->mCat =& $handler->getObjects(new Criteria('gr_id', $this->get('gr_id')));
			}
			$this->_mCatLoadedFlag = true;
		}
	}

	function &createCat()
	{
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$obj =& $handler->create();
		$obj->set('gr_id', $this->get('gr_id'));
		return $obj;
	}

	function loadMod($criteria = null)
	{
		if ($this->_mModLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('mod', 'xcat');
			if($criteria){
				$this->mMod =& $handler->getObjects($criteria);
			}else{
				$this->mMod =& $handler->getObjects(new Criteria('gr_id', $this->get('gr_id')));
			}
			$this->_mModLoadedFlag = true;
		}
	}

	function &createMod()
	{
		$handler =& xoops_getmodulehandler('mod', 'xcat');
		$obj =& $handler->create();
		$obj->set('gr_id', $this->get('gr_id'));
		return $obj;
	}

}

class Xcat_GrHandler extends XoopsObjectGenericHandler
{
	var $mTable = 'xcat_gr';
	var $mPrimary = 'gr_id';
	var $mClass = 'Xcat_GrObject';

	function delete(&$obj)
	{
		$handler =& xoops_getmodulehandler('cat');
		$handler->deleteAll(new Criteria('gr_id', $obj->get('gr_id')));
		unset($handler);

		$handler =& xoops_getmodulehandler('mod');
		$handler->deleteAll(new Criteria('gr_id', $obj->get('gr_id')));
		unset($handler);

		return parent::delete($obj);
	}
}

?>
