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
 * Bizpoll_ChoiceDeleteForm
**/
class Bizpoll_ChoiceDeleteForm extends XCube_ActionForm
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
        return "module.bizpoll.ChoiceDeleteForm.TOKEN";
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
    
        //
        // Set field properties
        //
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
        $this->set('choice_id', $obj->get('choice_id'));
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
        $obj->set('choice_id', $this->get('choice_id'));
    }
}

?>
