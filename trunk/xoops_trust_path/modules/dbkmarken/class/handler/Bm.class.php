<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Dbkmarken_BmObject extends XoopsSimpleObject
{
	var $mTag = array();
	var $_mTagLoadedFlag = false;
	var $bm_count = 0;

	/**
	 * @public
	 */
	function Dbkmarken_BmObject()
	{
		$this->initVar('bm_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('bm_title', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('url', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('memo', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
	}

	function loadTag($dirname, $criteria = null)
	{
		if ($this->_mTagLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'tag');
		
			if($criteria){
				$this->mTag =& $handler->getObjects($criteria);
			}else{
				$this->mTag =& $handler->getObjects(new Criteria('bm_id', $this->get('bm_id')));
			}
			$this->_mTagLoadedFlag = true;
		}
	}

	function &createTag($dirname)
	{
		$handler =& $this->_getHandler($dirname, 'tag');
	
		$obj =& $handler->create();
		$obj->set('bm_id', $this->get('bm_id'));
		return $obj;
	}

	function &_getHandler($dirname, $tablename)
	{
		$asset = null;
		XCube_DelegateUtils::call(
		    'Module.dbkmarken.Global.Event.GetAssetManager',
		    new XCube_Ref($asset),
		    $dirname
		);
		if(is_object($asset) && is_a($asset, 'Dbkmarken_AssetManager'))
		{
		    return $asset->getObject('handler',$tablename);
		}
	}
}

class Dbkmarken_BmHandler extends XoopsObjectGenericHandler
{
	var $mTable = '{dirname}_bm';
	var $mPrimary = 'bm_id';
	var $mClass = 'Dbkmarken_BmObject';

    function Dbkmarken_BmHandler(&$db, $dirname)
    {
        $this->mTable = str_replace('{dirname}', $dirname, $this->mTable);
        parent::XoopsObjectGenericHandler($db);
    }

	function &_getHandler($dirname, $tablename)
	{
		$asset = null;
		XCube_DelegateUtils::call(
		    'Module.dbkmarken.Global.Event.GetAssetManager',
		    new XCube_Ref($asset),
		    $dirname
		);
		if(is_object($asset) && is_a($asset, 'Dbkmarken_AssetManager'))
		{
		    return $asset->getObject('handler',$tablename);
		}
	}

	function delete(&$obj)
	{
		$dirnameArr = explode('_', $this->mTable);
		$handler =& $this->_getHandler($dirnameArr[1], 'tag');
		$handler->deleteAll(new Criteria('bm_id', $obj->get('bm_id')));
		unset($handler);

		return parent::delete($obj);
	}
}


?>
