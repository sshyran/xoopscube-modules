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
 * Bizpoll_PollDeleteForm
**/
class Bizpoll_PollDeleteForm extends XCube_ActionForm
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
        return "module.bizpoll.PollDeleteForm.TOKEN";
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
        $this->mFormProperties['poll_id'] =& new XCube_IntProperty('poll_id');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['poll_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['poll_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['poll_id']->addMessage('required', _MD_BIZPOLL_ERROR_REQUIRED, _MD_BIZPOLL_LANG_POLL_ID);
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
        $obj->set('poll_id', $this->get('poll_id'));
    }
}

?>
