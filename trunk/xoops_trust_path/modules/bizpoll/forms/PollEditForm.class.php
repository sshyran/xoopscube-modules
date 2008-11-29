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
 * Bizpoll_PollEditForm
**/
class Bizpoll_PollEditForm extends XCube_ActionForm
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
        return "module.bizpoll.PollEditForm.TOKEN";
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
    	$root = XCube_Root::getSingleton();
        //
        // Set form properties
        //
        $this->mFormProperties['poll_id'] =& new XCube_IntProperty('poll_id');
        $this->mFormProperties['enq_id'] =& new XCube_IntProperty('enq_id');
        $this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
        $this->mFormProperties['name'] =& new XCube_StringProperty('name');
        $this->mFormProperties['choice_id'] =& new XCube_IntProperty('choice_id');
        $this->mFormProperties['ip'] =& new XCube_StringProperty('ip');
        $this->mFormProperties['comment'] =& new XCube_TextProperty('comment');
        $this->mFormProperties['reg_unixtime'] =& new XCube_IntProperty('reg_unixtime');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['poll_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['poll_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['poll_id']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_POLL_ID);
    
        $this->mFieldProperties['enq_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['enq_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['enq_id']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_ENQ_ID);
	
		if(! $root->mContext->mXoopsUser){
	        $this->mFieldProperties['name'] =& new XCube_FieldProperty($this);
	        $this->mFieldProperties['name']->setDependsByArray(array('required'));
	        $this->mFieldProperties['name']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_NAME);
	    }
    
        $this->mFieldProperties['choice_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['choice_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['choice_id']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_CHOICE_ID);
    
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
        $this->set('poll_id', $obj->get('poll_id'));
        $this->set('enq_id', $obj->get('enq_id'));
        $this->set('uid', $obj->get('uid'));
        $this->set('name', $obj->get('name'));
        $this->set('choice_id', $obj->get('choice_id'));
        $this->set('ip', $obj->get('ip'));
        $this->set('comment', $obj->get('comment'));
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
        //$obj->set('poll_id', $this->get('poll_id'));
        $obj->set('enq_id', $this->get('enq_id'));
        //$obj->set('uid', $this->get('uid'));
        $obj->set('name', $this->get('name'));
        $choice = $root->mContext->mRequest->getRequest('choice_id');
        if(is_array($choice)){
	        $obj->set('choice_id', implode(',', $choice));
	    }
	    else{
	    	$obj->set('choice_id', $choice);
	    }
        $obj->set('ip', addslashes(@$_SERVER['REMOTE_ADDR']));
        $obj->set('comment', $this->get('comment'));
        //$obj->set('reg_unixtime', $this->get('reg_unixtime'));
    }
}

?>
