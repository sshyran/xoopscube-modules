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
 * Bizforum_PostObject
**/
class Bizforum_PostObject extends XoopsSimpleObject
{
	var $mTopic = array();
	var $_mTopicLoadedFlag = false;
	var $mChildren = null;
	var $_mChildrenLoadedFlag = false;
	var $mParent = null;
	var $_mParentLoadedFlag = false;
	var $mReplyPath = array();
	var $_mReplyPathLoadedFlag = false;

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->initVar('post_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('uid', XOBJ_DTYPE_INT, '', false);
        $this->initVar('guest_name', XOBJ_DTYPE_STRING, '', false, 16);
        $this->initVar('p_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('topic_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('bodytext', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
    }

	function loadTopic($dirname)
	{
		
		if ($this->_mTopicLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'topic');
		
			$this->mTopic =& $handler->get($this->get('topic_id'));
			$this->_mTopicLoadedFlag = true;
		}
	}

	/**
	 * @public
	 * load parent category Object of this category.
	 */
	function loadParent($dirname)
	{
		if ($this->_mParentLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'post');
			$this->mParent =& $handler->get($this->get('p_id'));
			$this->_mParentLoadedFlag = true;
		}
	}

	/**
	 * @public
	 * load child post Objects.
	 */
	function loadChildren($dirname)
	{
		if ($this->_mChildrenLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'post');
			$criteria = new CriteriaCompo('1', '1');
			$criteria->add(new Criteria('p_id', $this->get('post_id')));
			$this->mChildren =& $handler->getObjects(new Criteria('p_id', $this->get('post_id')));
			$this->_mChildrenLoadedFlag = true;
		}
	}

	function loadReplyPath($dirname)
	{
		if($this->_mReplyPathLoadedFlag==false){
			$handler =& $this->_getHandler($dirname, 'post');
			$this->_loadReplyPath($handler, $this->get('p_id'));
			$this->_mReplyPathLoadedFlag=true;
		}
	}

	/**
	 * @private
	 * load reply path array retroactively.
	 */
	function _loadReplyPath($handler, $p_id){
		$post =& $handler->get($p_id);
		if(is_object($post)){
			array_unshift($this->mReplyPath, $post->getShow('post_id'));
			$this->_loadReplyPath($handler, $post->get('p_id'));
		}
	}

	/**
	 * @public
	 * get child post' id array.
	 */
	function getChildIdList()
	{
		$this->loadChildren();
		foreach(array_keys($this->mChildren) as $key){
			$children['post_id'][$key] = $this->mChildren[$key]->getShow('post_id');
		}
		return $children;
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
 * Bizforum_PostHandler
**/
class Bizforum_PostHandler extends XoopsObjectGenericHandler
{
    /**
     * @brief   string
    **/
    public $mTable = '{dirname}_post';

    /**
     * @brief   string
    **/
    public $mPrimary = 'post_id';

    /**
     * @brief   string
    **/
    public $mClass = 'Bizforum_PostObject';

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
}

?>
