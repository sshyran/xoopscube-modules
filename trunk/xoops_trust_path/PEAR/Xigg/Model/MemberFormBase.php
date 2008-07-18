<?php
/*
This file has been generated by the Sabai scaffold script. Do not edit this file directly.
If you need to customize the class, use the following file:
Xigg/library/Xigg/Model/MemberForm.php
*/
class Xigg_Model_MemberFormBase extends Sabai_Model_EntityForm
{
    function onInit($params)
    {
        require_once 'Sabai/Form/Element/SelectEntity.php';
        $element =& new Sabai_Form_Element_SelectEntity($this->_model, 'Role', 'Role', 1);
        $this->addElement($element, _('role'));
        require_once 'Sabai/Form/Element/InputText.php';
        $this->addElement(new Sabai_Form_Element_InputText('userid', 30, 255), _('User ID'));
        $this->_onInit($params);
    }

    function onEntity(&$entity)
    {
        if ($this->hasElement('Role')) {
            $this->setValueFor('Role', $entity->getVar('role_id'));
        }
        if ($this->hasElement('userid')) {
            $this->setValueFor('userid', $entity->getVar('userid'));
        }
        $this->_onEntity($entity);
    }

    function onFillEntity(&$entity)
    {
        $vars = array();
        foreach (array('role_id' => 'Role', 'userid' => 'userid') as $var_name => $form_name) {
            if ($this->hasElement($form_name)) {
                $vars[$var_name] = $this->getValueFor($form_name);
            }
        }
        $entity->setVars($vars);
        $this->_onFillEntity($entity);
    }

    function _onInit($params){}
    function _onEntity(&$entity){}
    function _onFillEntity(&$entity){}
}