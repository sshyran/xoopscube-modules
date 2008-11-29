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
 * Bizpoll_ChoiceEditForm
**/
class Bizpoll_ChoiceEditForm extends XCube_ActionForm
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
        return "module.bizpoll.ChoiceEditForm.TOKEN";
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
        $this->mFormProperties['choice_id'] =& new XCube_IntProperty('choice_id');
        $this->mFormProperties['title'] =& new XCube_StringProperty('title');
        $this->mFormProperties['enq_id'] =& new XCube_IntProperty('enq_id');
        $this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
        $this->mFormProperties['weight'] =& new XCube_IntProperty('weight');
        $this->mFormProperties['description'] =& new XCube_TextProperty('description');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['choice_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['choice_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['choice_id']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_CHOICE_ID);
    
        $this->mFieldProperties['title'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['title']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['title']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_TITLE, '255');
        $this->mFieldProperties['title']->addMessage('maxlength', _MD_BIZPOLL_ERROR_MAXLENGTH, _MD_BIZPOLL_LANG_TITLE, '255');
        $this->mFieldProperties['title']->addVar('maxlength', '255');
    
        $this->mFieldProperties['enq_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['enq_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['enq_id']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_ENQ_ID);
    
        $this->mFieldProperties['weight'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['weight']->setDependsByArray(array('required'));
        $this->mFieldProperties['weight']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_WEIGHT);
    
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
        $this->set('choice_id', $obj->get('choice_id'));
        $this->set('title', $obj->get('title'));
        $this->set('enq_id', $obj->get('enq_id'));
        $this->set('uid', $obj->get('uid'));
        $this->set('weight', $obj->get('weight'));
        $this->set('description', $obj->get('description'));
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
        //$obj->set('choice_id', $this->get('choice_id'));
        $obj->set('title', $this->get('title'));
        $obj->set('enq_id', $this->get('enq_id'));
        //$obj->set('uid', $this->get('uid'));
        $obj->set('weight', $this->get('weight'));
        $obj->set('description', $this->get('description'));
    }
}

?>
