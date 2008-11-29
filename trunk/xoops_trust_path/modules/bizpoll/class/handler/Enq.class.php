<?php
/**
 * @file
 * @package bizpoll
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

/**
 * Bizpoll_EnqObject
**/
class Bizpoll_EnqObject extends XoopsSimpleObject
{
	var $mPoll = array();
	var $_mPollLoadedFlag = false;
	var $mMyPoll = array();
	var $_mMyPollLoadedFlag = false;
	var $mChoice = array();
	var $_mChoiceLoadedFlag = false;
	var $mPollCount = 0;
	var $_mPollCountFlag = false;

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->initVar('enq_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('title', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('cat_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
        //0:radio  1:checkbox
        $this->initVar('type', XOBJ_DTYPE_INT, '', false);
        $this->initVar('pub_unixtime', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('end_unixtime', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('choices', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('description', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('option', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
    }

	public function checkEnd()
	{
		if($this->get('end_unixtime')>86400 && $this->get('end_unixtime')<time()){
			return false;	//expired
		}
		return true;
	}

	public function countPoll($dirname)
	{
		if ($this->_mPollCountFlag == false) {
			$this->loadPoll($dirname);
			$this->mPollCount = count($this->mPoll);
			$this->_mPollCountFlag = true;
		}
	}

	public function allowAddChoice()
	{
		$root = XCube_Root::getSingleton();
		//if the poster is guest, anyone can add choices.
		if($this->get('uid')==0){
			return true;
		}
		//if 'allowAddChoice' option is true, anyone can add choices.
		$optionArr = unserialize($this->get('option'));
		if($optionArr['add_choice']==1){
			return true;
		}
		else{
			//otherwise, only the enq poster can add choices.
			$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;
			if($uid==$this->get('uid')){
				return true;
			}
			else{
				return false;
			}
		}
	}

	public function allowShowResult($dirname)
	{
		$root = XCube_Root::getSingleton();
		$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;
		$xcatHandler = new Bizpoll_XcatHandler($dirname);
		$optionArr = unserialize($this->get('option'));
	
		if(intval($optionArr['show_result']==0)){	//show result before poll
			return true;
		}
		elseif(intval($optionArr['show_result']==1)){	//show result after he polled or end of the poll
			if($this->checkEnd()==false){	//when the poll is end
				return true;
			}
		
			if($xcatHandler->checkPermit($this->get('cat_id'), 'poster') || $this->get('uid')==$uid){
				return true;
			}
		
			$this->loadMyPoll($dirname);
			return ($this->mMyPoll) ? true : false;
		}
		elseif(intval($optionArr['opt_show_result']==2)){	//show result only editors
			if($xcatHandler->checkPermit($this->get('cat_id'), 'poster') || $this->get('uid')==$root->mContext->mXoopsUser->get('uid')){
				return true;
			}
			return false;
		}
	}

	public function loadPoll($dirname, $criteria = null)
	{
		if ($this->_mPollLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'poll');
		
			if($criteria){
				$this->mPoll =& $handler->getObjects($criteria);
				unset($criteria);
			}else{
				$this->mPoll =& $handler->getObjects(new Criteria('enq_id', $this->get('enq_id')));
			}
			$this->_mPollLoadedFlag = true;
		}
	}

	public function loadMyPoll($dirname)
	{
		if ($this->_mMyPollLoadedFlag == false) {
			$root = XCube_Root::getSingleton();
			$handler =& $this->_getHandler($dirname, 'poll');
			if($root->mContext->mXoopsUser){
				$criteria = new CriteriaCompo('1', '1');
				$criteria->add(new Criteria('enq_id', $this->get('enq_id')));
				$criteria->add(new Criteria('uid', $root->mContext->mXoopsUser->get('uid')));
				$poll =& $handler->getObjects($criteria);
				unset($criteria);
			
				if(count($poll)>0){
					$this->mMyPoll = $poll[0];
				}
				else{
					$this->mMyPoll = $handler->create();
					$this->mMyPoll->set('enq_id', $this->get('enq_id'));
					$this->mMyPoll->set('uid', $root->mContext->mXoopsUser->get('uid'));
				}
			}
			else{
				$this->mMyPoll = $handler->create();
				$this->mMyPoll->set('enq_id', $this->get('enq_id'));
				$this->mMyPoll->set('uid', 0);
			}
			$this->_mMyPollLoadedFlag = true;
		}
	}

	public function &createPoll($dirname)
	{
		$handler =& $this->_getHandler($dirname, 'poll');
	
		$obj =& $handler->create();
		$obj->set('enq_id', $this->get('enq_id'));
		return $obj;
	}

	public function loadChoice($dirname, $criteria = null)
	{
		if ($this->_mChoiceLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'choice');
		
			if($criteria){
				$this->mChoice =& $handler->getObjects($criteria);
				unset($criteria);
			}else{
				$criteria = new CriteriaCompo('1', '1');
				$criteria->add(new Criteria('enq_id', $this->get('enq_id')));
				$criteria->setSort('weight');
				$this->mChoice =& $handler->getObjects($criteria);
			}
			$this->_mChoiceLoadedFlag = true;
		}
	}

	public function &createChoice($dirname)
	{
		$handler =& $this->_getHandler($dirname, 'choice');
	
		$obj =& $handler->create();
		$obj->set('enq_id', $this->get('enq_id'));
		return $obj;
	}

	protected function &_getHandler($dirname, $tablename)
	{
		$asset = null;
		XCube_DelegateUtils::call(
		    'Module.bizpoll.Global.Event.GetAssetManager',
		    new XCube_Ref($asset),
		    $dirname
		);
		if(is_object($asset) && is_a($asset, 'Bizpoll_AssetManager'))
		{
		    return $asset->getObject('handler',$tablename);
		}
	}

}

/**
 * Bizpoll_EnqHandler
**/
class Bizpoll_EnqHandler extends XoopsObjectGenericHandler
{
    /**
     * @brief   string
    **/
    public $mTable = '{dirname}_enq';

    /**
     * @brief   string
    **/
    public $mPrimary = 'enq_id';

    /**
     * @brief   string
    **/
    public $mClass = 'Bizpoll_EnqObject';

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
		    'Module.bizpoll.Global.Event.GetAssetManager',
		    new XCube_Ref($asset),
		    $dirname
		);
		if(is_object($asset) && is_a($asset, 'Bizpoll_AssetManager'))
		{
		    return $asset->getObject('handler',$tablename);
		}
	}

	function delete(&$obj)
	{
		$dirnameArr = explode('_', $this->mTable);
		$handler =& $this->_getHandler($dirnameArr[1], 'poll');
		$handler->deleteAll(new Criteria('enq_id', $obj->get('enq_id')));
		unset($handler);
	
		return parent::delete($obj);
	}

}

?>
