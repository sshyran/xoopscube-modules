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

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

/**
 * Bizpoll_EnqEditForm
**/
class Bizpoll_EnqEditForm extends XCube_ActionForm
{
    /**
     * getTokenName
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getTokenName()
    {
        return "module.bizpoll.EnqEditForm.TOKEN";
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['enq_id'] =& new XCube_IntProperty('enq_id');
        $this->mFormProperties['title'] =& new XCube_StringProperty('title');
        $this->mFormProperties['cat_id'] =& new XCube_IntProperty('cat_id');
        $this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
        $this->mFormProperties['type'] =& new XCube_IntProperty('type');
        $this->mFormProperties['pub_unixtime'] =& new XCube_IntProperty('pub_unixtime');
        $this->mFormProperties['pub_date'] =& new XCube_StringProperty('pub_date');
		$this->mFormProperties['pub_Hour'] =& new XCube_StringProperty('pub_Hour');
		$this->mFormProperties['pub_Minute'] =& new XCube_StringProperty('pub_Minute');
        $this->mFormProperties['end_unixtime'] =& new XCube_IntProperty('end_unixtime');
        $this->mFormProperties['end_date'] =& new XCube_TextProperty('end_date');
		$this->mFormProperties['end_Hour'] =& new XCube_StringProperty('end_Hour');
		$this->mFormProperties['end_Minute'] =& new XCube_StringProperty('end_Minute');
        $this->mFormProperties['choices'] =& new XCube_TextProperty('choices');
        $this->mFormProperties['description'] =& new XCube_TextProperty('description');
        $this->mFormProperties['option'] =& new XCube_TextProperty('option');
        $this->mFormProperties['reg_unixtime'] =& new XCube_IntProperty('reg_unixtime');
        $this->mFormProperties['opt_show_result'] =& new XCube_IntProperty('opt_show_result');
        $this->mFormProperties['opt_add_choice'] =& new XCube_IntProperty('opt_add_choice');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['enq_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['enq_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['enq_id']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_ENQ_ID);
    
        $this->mFieldProperties['title'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['title']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_TITLE, '255');
        $this->mFieldProperties['title']->addMessage('maxlength', _MD_BIZPOLL_ERROR_MAXLENGTH, _MD_BIZPOLL_LANG_TITLE, '255');
        $this->mFieldProperties['title']->addVar('maxlength', '255');
    
        $this->mFieldProperties['type'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['type']->setDependsByArray(array('required'));
        $this->mFieldProperties['type']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_TYPE);
    
    }

    /**
     * load
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function load(/*** XoopsSimpleObject ***/ &$obj)
    {
        $this->set('enq_id', $obj->get('enq_id'));
        $this->set('title', $obj->get('title'));
        $this->set('cat_id', $obj->get('cat_id'));
        $this->set('uid', $obj->get('uid'));
        $this->set('type', $obj->get('type'));
        $this->set('pub_unixtime', $obj->get('pub_unixtime'));
		$this->set('pub_date', date("Y/m/d", $obj->get('pub_unixtime')));
		$this->set('pub_Hour', date("H", $obj->get('pub_unixtime')));
		$this->set('pub_Minute', date("i", $obj->get('pub_unixtime')));
        $this->set('end_unixtime', $obj->get('end_unixtime'));
		$this->set('end_date', date("Y/m/d", $obj->get('end_unixtime')));
		$this->set('end_Hour', date("H", $obj->get('end_unixtime')));
		$this->set('end_Minute', date("i", $obj->get('end_unixtime')));
        $this->set('choices', $obj->get('choices'));
        $this->set('description', $obj->get('description'));
        $optionArr = unserialize($obj->get('option'));
        $this->set('opt_add_choice', $optionArr['add_choice']);
        $this->set('opt_show_result', $optionArr['show_result']);
        $this->set('reg_unixtime', $obj->get('reg_unixtime'));
    }

    /**
     * update
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function update(/*** XoopsSimpleObject ***/ &$obj)
    {
    	$root = XCube_Root::getSingleton();
        //$obj->set('enq_id', $this->get('enq_id'));
        $obj->set('title', $this->get('title'));
        $obj->set('cat_id', $this->get('cat_id'));
        //$obj->set('uid', $this->get('uid'));
        $obj->set('type', $this->get('type'));
		$pubUnixtimeArray = explode('/', $this->get('pub_date'));
		$pub_unixtime = mktime($this->get('pub_Hour'), $this->get('pub_Minute'), 0, $pubUnixtimeArray[1], $pubUnixtimeArray[2], $pubUnixtimeArray[0]);
		$obj->set('pub_unixtime', $pub_unixtime);
		if($this->get('end_unixtime')=='1970/01/01'){
			$end_unixtime = 0;
		}
		else{
			$endUnixtimeArray = explode('/', $this->get('end_date'));
			$end_unixtime = mktime($this->get('end_Hour'), $this->get('end_Minute'), 0, $endUnixtimeArray[1], $endUnixtimeArray[2], $endUnixtimeArray[0]);
		}
		$obj->set('end_unixtime', $end_unixtime);
        $obj->set('choices', $this->get('choices'));
        $obj->set('description', $this->get('description'));
        $option['add_choice'] = $root->mContext->mRequest->getRequest('opt_add_choice');
        $option['show_result'] = $root->mContext->mRequest->getRequest('opt_show_result');
        $obj->set('option', serialize($option));
        //$obj->set('reg_unixtime', $this->get('reg_unixtime'));
    }
}

?>
