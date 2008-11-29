<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

/**
 * Bizforum_TopicObject
**/
class Bizforum_TopicObject extends XoopsSimpleObject
{
	var $mPost = array();
	var $_mPostLoadedFlag = false;
	var $mLastPost = null;
	var $_mLastPostLoadedFlag = false;
	var $_mPostCountFlag = false;
	var $mPostCount = 0;

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->initVar('topic_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('topic_title', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('cat_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('uid', XOBJ_DTYPE_INT, '', false);
        $this->initVar('guest_name', XOBJ_DTYPE_STRING, '', false, 16);
        $this->initVar('external_link', XOBJ_DTYPE_STRING, '', false, 64);
        $this->initVar('bodytext', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('option', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('last_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('last_unixtime', XOBJ_DTYPE_INT, time(), false);
    }

	function countPost($dirname)
	{
		if ($this->_mPostCountFlag == false) {
			$this->loadPost($dirname);
			$this->mPostCount = count($this->mPost);
			$this->_mPostCountFlag = true;
		}
	}

	function loadPost($dirname, $criteria = null)
	{
		if ($this->_mPostLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'post');
		
			if($criteria){
				$this->mPost =& $handler->getObjects($criteria);
			}else{
				$this->mPost =& $handler->getObjects(new Criteria('topic_id', $this->get('topic_id')));
			}
			$this->_mPostLoadedFlag = true;
		}
	}

	function &createPost($dirname)
	{
		$handler =& $this->_getHandler($dirname, 'post');
	
		$obj =& $handler->create();
		$obj->set('topic_id', $this->get('topic_id'));
		return $obj;
	}

	function loadLastPost($dirname)
	{
		if ($this->_mLastPostLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'post');
			$this->mLastPost =& $handler->get($this->get('last_id'));
			$this->_mLastPostLoadedFlag = true;
		}
	}

	function &_getHandler($dirname, $tablename)
	{
		$asset = null;
		XCube_DelegateUtils::call(
		    'Module.bizforum.Global.Event.GetAssetManager',
		    new XCube_Ref($asset),
		    $dirname
		);
		if(is_object($asset) && is_a($asset, 'Bizforum_AssetManager'))
		{
		    return $asset->getObject('handler',$tablename);
		}
	}
}

/**
 * Bizforum_TopicHandler
**/
class Bizforum_TopicHandler extends XoopsObjectGenericHandler
{
    /**
     * @brief   string
    **/
    public $mTable = '{dirname}_topic';

    /**
     * @brief   string
    **/
    public $mPrimary = 'topic_id';

    /**
     * @brief   string
    **/
    public $mClass = 'Bizforum_TopicObject';

    /**
     * __construct
     * 
     * @param   XoopsDatabase  &$db
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public function __construct(/*** XoopsDatabase ***/ &$db,/*** string ***/ $dirname)
    {
        $this->mTable = str_replace('{dirname}',$dirname,$this->mTable);
        parent::XoopsObjectGenericHandler($db);
    }

	function &_getHandler($dirname, $tablename)
	{
		$asset = null;
		XCube_DelegateUtils::call(
		    'Module.bizforum.Global.Event.GetAssetManager',
		    new XCube_Ref($asset),
		    $dirname
		);
		if(is_object($asset) && is_a($asset, 'Bizforum_AssetManager'))
		{
		    return $asset->getObject('handler',$tablename);
		}
	}

	function delete(&$obj)
	{
		$dirnameArr = explode('_', $this->mTable);
		$handler =& $this->_getHandler($dirnameArr[1], 'post');
		$handler->deleteAll(new Criteria('topic_id', $obj->get('topic_id')));
		unset($handler);
	
		return parent::delete($obj);
	}

}

?>
