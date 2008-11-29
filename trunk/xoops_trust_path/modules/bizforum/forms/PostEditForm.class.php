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

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

/**
 * Bizforum_PostEditForm
**/
class Bizforum_PostEditForm extends XCube_ActionForm
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
        return "module.bizforum.PostEditForm.TOKEN";
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
        $this->mFormProperties['post_id'] =& new XCube_IntProperty('post_id');
        $this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
        $this->mFormProperties['guest_name'] =& new XCube_StringProperty('guest_name');
        $this->mFormProperties['p_id'] =& new XCube_IntProperty('p_id');
        $this->mFormProperties['topic_id'] =& new XCube_IntProperty('topic_id');
        $this->mFormProperties['bodytext'] =& new XCube_TextProperty('bodytext');
        $this->mFormProperties['reg_unixtime'] =& new XCube_IntProperty('reg_unixtime');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['post_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['post_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['post_id']->addMessage('required', _MD_BIZFORUM_ERROR_REQUIRED, _MD_BIZFORUM_LANG_POST_ID);
    
        $this->mFieldProperties['topic_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['topic_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['topic_id']->addMessage('required', _MD_BIZFORUM_ERROR_REQUIRED, _MD_BIZFORUM_LANG_TOPIC_ID);
    
        $this->mFieldProperties['bodytext'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['bodytext']->setDependsByArray(array('required'));
        $this->mFieldProperties['bodytext']->addMessage('required', _MD_BIZFORUM_ERROR_REQUIRED, _MD_BIZFORUM_LANG_BODYTEXT);
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
        $this->set('post_id', $obj->get('post_id'));
        $this->set('uid', $obj->get('uid'));
        $this->set('guest_name', $obj->get('guest_name'));
        $this->set('p_id', $obj->get('p_id'));
        $this->set('topic_id', $obj->get('topic_id'));
        $this->set('bodytext', $obj->get('bodytext'));
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
        //$obj->set('post_id', $this->get('post_id'));
        //$obj->set('uid', $this->get('uid'));
        $obj->set('guest_name', $this->get('guest_name'));
        $obj->set('p_id', $this->get('p_id'));
        $obj->set('topic_id', $this->get('topic_id'));
        $obj->set('bodytext', $this->get('bodytext'));
        //$obj->set('reg_unixtime', $this->get('reg_unixtime'));
    }
}

?>
