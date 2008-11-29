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
 * Bizpoll_PollObject
**/
class Bizpoll_PollObject extends XoopsSimpleObject
{
	var $mEnq = null;
	var $_mEnqLoadedFlag = false;
	var $mChoice = array();
	var $_mChoiceLoadedFlag = false;

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->initVar('poll_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('enq_id', XOBJ_DTYPE_INT, '', false);
        $this->initVar('uid', XOBJ_DTYPE_INT, '', false);
        $this->initVar('name', XOBJ_DTYPE_STRING, '', false, 32);
        $this->initVar('choice_id', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('ip', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('comment', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('reg_unixtime', XOBJ_DTYPE_INT, time(), false);
    }

	public function loadEnq($dirname)
	{
		
		if ($this->_mEnqLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'enq');
		
			$this->mEnq =& $handler->get($this->get('enq_id'));
			$this->_mEnqLoadedFlag = true;
		}
	}

	public function loadChoice($dirname)
	{
		if ($this->_mChoiceLoadedFlag == false) {
			$handler =& $this->_getHandler($dirname, 'choice');
		
			$choiceIdArr = explode(',', $this->get('choice_id'));
			foreach(array_keys($choiceIdArr) as $key){
				$this->mChoice[] =& $handler->get($choiceIdArr[$key]);
			}
			$this->_mChoiceLoadedFlag = true;
		}
	}

	public function &_getHandler($dirname, $tablename)
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
 * Bizpoll_PollHandler
**/
class Bizpoll_PollHandler extends XoopsObjectGenericHandler
{
    /**
     * @brief   string
    **/
    public $mTable = '{dirname}_poll';

    /**
     * @brief   string
    **/
    public $mPrimary = 'poll_id';

    /**
     * @brief   string
    **/
    public $mClass = 'Bizpoll_PollObject';

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
