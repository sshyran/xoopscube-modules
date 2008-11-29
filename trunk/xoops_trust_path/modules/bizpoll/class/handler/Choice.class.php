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
 * Bizpoll_ChoiceObject
**/
class Bizpoll_ChoiceObject extends XoopsSimpleObject
{
	var $mEnq = array();
	var $_mEnqLoadedFlag = false;
	var $mPoll = array();
	var $_mPollLoadedFlag = false;
	var $mPollCount = 0;
	var $_mPollCountFlag = false;
	var $mIsPolled = false;

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->initVar('choice_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('title', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('enq_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, '10', false);
        $this->initVar('description', XOBJ_DTYPE_TEXT, '', false);
    }

	public function countPoll($dirname)
	{
		if ($this->_mPollCountFlag == false) {
			$this->loadPoll($dirname);
			$this->mPollCount = count($this->mPoll);
			$this->_mPollCountFlag = true;
		}
	}

	public function loadEnq($dirname)
	{
		
		if ($this->_mEnqLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'enq');
		
			$this->mEnq =& $handler->get($this->get('enq_id'));
			$this->_mEnqLoadedFlag = true;
		}
	}

	public function loadPoll($dirname)
	{
		if ($this->_mPollLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'poll');
		
			$this->loadEnq($dirname);
			if($this->mEnq->get('type')==0){	//radio
				$this->mPoll =& $handler->getObjects(new Criteria('choice_id', $this->get('choice_id')));
			}
			elseif($this->mEnq->get('type')==1){	//checkbox
				$pollArr = & $handler->getObjects(new Criteria('enq_id', $this->get('enq_id')));
				foreach(array_keys($choiceArr) as $key){
					$choices = explode(',', $pollArr[$key]->get('choice_id'));
					if(in_array($this->get('choice_id'), $choices)){
						$this->mPoll[] = $pollArr[$key];
					}
				}
			}
			$this->_mPollLoadedFlag = true;
		}
	}

	public function &createPoll($dirname)
	{
		$handler =& $this->_getHandler($dirname, 'poll');
	
		$obj =& $handler->create();
		$obj->set('choice_id', $this->get('choice_id'));
		return $obj;
	}

	public function loadPolled($dirname)
	{
		$root = XCube_Root::getSingleton();
		if(! $root->mContext->mXoopsUser){
			return;
		}
		$handler =& $this->_getHandler($dirname, 'poll');
		$criteria = new CriteriaCompo('1', '1');
		$criteria->add(new Criteria('enq_id', $this->get('enq_id')));
		$criteria->add(new Criteria('uid', $root->mContext->mXoopsUser->get('uid')));
		$pollArr = $handler->getObjects($criteria);
		unset($criteria);
		if(count($pollArr)>0){
			$polledArr = explode(',', ($pollArr[0]->get('choice_id')));
			if(in_array($this->get('choice_id'), $polledArr)){
				$this->mIsPolled = true;
			}
			else{
				$this->mIsPolled = false;
			}
		}
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
 * Bizpoll_ChoiceHandler
**/
class Bizpoll_ChoiceHandler extends XoopsObjectGenericHandler
{
    /**
     * @brief   string
    **/
    public $mTable = '{dirname}_choice';

    /**
     * @brief   string
    **/
    public $mPrimary = 'choice_id';

    /**
     * @brief   string
    **/
    public $mClass = 'Bizpoll_ChoiceObject';

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
