<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Dbkmarken_TagObject extends XoopsSimpleObject
{

	var $mBm = null;
	var $_mBmLoadedFlag = false;

	/**
	 * @public
	 */
	function Dbkmarken_TagObject()
	{
		$this->initVar('tag_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('tag_name', XOBJ_DTYPE_STRING, '', false, 64);
		$this->initVar('bm_id', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
	}

	function loadBm($dirname)
	{
		if ($this->_mBmLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'bm');
		
			$this->mBm =& $handler->get($this->get('bm_id'));
			$this->_mBmLoadedFlag = true;
		}
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

class Dbkmarken_TagHandler extends XoopsObjectGenericHandler
{
	var $mTable = '{dirname}_tag';
	var $mPrimary = 'tag_id';
	var $mClass = 'Dbkmarken_TagObject';

    var $_mRootName = '';

    function Dbkmarken_TagHandler(&$db, $dirname)
    {
        $this->mTable = str_replace('{dirname}', $dirname, $this->mTable);
        parent::XoopsObjectGenericHandler($db);
    }

    function setRootName($rootName)
    {
        $this->_mRootName = $rootName;
    }

}

?>
