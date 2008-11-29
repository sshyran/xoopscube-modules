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
 * Bizforum_TopicEditForm
**/
class Bizforum_TopicEditForm extends XCube_ActionForm
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
        return "module.bizforum.TopicEditForm.TOKEN";
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
        $this->mFormProperties['topic_id'] =& new XCube_IntProperty('topic_id');
        $this->mFormProperties['topic_title'] =& new XCube_StringProperty('topic_title');
        $this->mFormProperties['cat_id'] =& new XCube_IntProperty('cat_id');
        $this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
        $this->mFormProperties['guest_name'] =& new XCube_StringProperty('guest_name');
        $this->mFormProperties['external_link'] =& new XCube_StringProperty('external_link');
        $this->mFormProperties['bodytext'] =& new XCube_TextProperty('bodytext');
        $this->mFormProperties['option'] =& new XCube_TextProperty('option');
        $this->mFormProperties['reg_unixtime'] =& new XCube_IntProperty('reg_unixtime');
        $this->mFormProperties['last_id'] =& new XCube_IntProperty('last_id');
        $this->mFormProperties['last_unixtime'] =& new XCube_IntProperty('last_unixtime');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['topic_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['topic_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['topic_id']->addMessage('required', _MD_BIZFORUM_ERROR_REQUIRED, _MD_BIZFORUM_LANG_TOPIC_ID);
    
        $this->mFieldProperties['topic_title'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['topic_title']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['topic_title']->addMessage('required', _MD_BIZFORUM_ERROR_REQUIRED, _MD_BIZFORUM_LANG_TOPIC_TITLE, '255');
        $this->mFieldProperties['topic_title']->addMessage('maxlength', _MD_BIZFORUM_ERROR_MAXLENGTH, _MD_BIZFORUM_LANG_TOPIC_TITLE, '255');
        $this->mFieldProperties['topic_title']->addVar('maxlength', '255');
    
        $this->mFieldProperties['cat_id'] =& new XCube_FieldProperty($this);
        $this->mFieldProperties['cat_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['cat_id']->addMessage('required', _MD_BIZFORUM_ERROR_REQUIRED, _MD_BIZFORUM_LANG_CAT_ID);
    
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
        $this->set('topic_id', $obj->get('topic_id'));
        $this->set('topic_title', $obj->get('topic_title'));
        $this->set('cat_id', $obj->get('cat_id'));
        $this->set('uid', $obj->get('uid'));
        $this->set('guest_name', $obj->get('guest_name'));
        $this->set('external_link', $obj->get('external_link'));
        $this->set('bodytext', $obj->get('bodytext'));
        $this->set('option', $obj->get('option'));
        $this->set('reg_unixtime', $obj->get('reg_unixtime'));
        $this->set('last_id', $obj->get('last_id'));
        $this->set('last_unixtime', $obj->get('last_unixtime'));
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
        //$obj->set('topic_id', $this->get('topic_id'));
        $obj->set('topic_title', $this->get('topic_title'));
        $obj->set('cat_id', $this->get('cat_id'));
        //$obj->set('uid', $this->get('uid'));
        $obj->set('guest_name', $this->get('guest_name'));
        $obj->set('external_link', $this->get('external_link'));
        $obj->set('bodytext', $this->get('bodytext'));
        $obj->set('option', $this->get('option'));
        //$obj->set('reg_unixtime', $this->get('reg_unixtime'));
    }
}

?>
