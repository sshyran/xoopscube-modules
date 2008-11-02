<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Cubookmarken_BmObject extends XoopsSimpleObject
{
	var $mTag = array();
	var $_mTagLoadedFlag = false;
	var $bm_count = 0;

	/**
	 * @public
	 */
	function Cubookmarken_BmObject()
	{
		$this->initVar('bm_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('bm_title', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('url', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('memo', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
	}

	function loadTag($criteria = null)
	{
		if ($this->_mTagLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('Tag', 'cubookmarken');
			if($criteria){
				$this->mTag =& $handler->getObjects($criteria);
			}else{
				$this->mTag =& $handler->getObjects(new Criteria('bm_id', $this->get('bm_id')));
			}
			$this->_mTagLoadedFlag = true;
		}
	}

	function &createTag()
	{
		$handler =& xoops_getmodulehandler('Tag');
		$obj =& $handler->create();
		$obj->set('bm_id', $this->get('bm_id'));
		return $obj;
	}

}

class Cubookmarken_BmHandler extends XoopsObjectGenericHandler
{
	var $mTable = 'cubookmarken_bm';
	var $mPrimary = 'bm_id';
	var $mClass = 'Cubookmarken_BmObject';

	function delete(&$obj)
	{
		$handler =& xoops_getmodulehandler('tag');
		$handler->deleteAll(new Criteria('bm_id', $obj->get('bm_id')));
		unset($handler);

		return parent::delete($obj);
	}
}

?>
