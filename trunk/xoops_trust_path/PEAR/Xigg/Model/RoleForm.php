<?php
class Xigg_Model_RoleForm extends Xigg_Model_RoleFormBase
{
    function _onInit($params)
    {
        // things that should be applied to all forms should come here (e.g., add validators)
        $this->removeElements(array('permissions', 'system'));
        $this->validatesPresenceOf('name', _('You must enter the name'), _(' '));
        require_once 'Sabai/Form/Element/SelectCheckbox.php';
        $perm_checkbox =& new Sabai_Form_Element_SelectCheckbox('_permissions');
        foreach (array_keys($params['permissions']) as $perm_group) {
            foreach ($params['permissions'][$perm_group] as $perm_value => $perm_label) {
                $perm_checkbox->addOption($perm_value, $perm_label, $perm_group);
            }
        }
        $this->addElement($perm_checkbox, _('Permissions'));
    }

    function _onEntity(&$entity)
    {
        $this->setValueFor('_permissions', $entity->getPermissions());
    }

    function _onFillEntity(&$entity)
    {
        $entity->setPermissions($this->getValueFor('_permissions'));
    }

    /**
     * Values of the _permissions element are not set when none selected, so we override
     * the parent and set an empty array in that case here.
     */
    function validateValues($values)
    {
        if (empty($values['_permissions'])) {
            $values['_permissions'] = array();
        }
        return parent::validateValues($values);
    }
}