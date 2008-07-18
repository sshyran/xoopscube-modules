<?php
require_once 'Sabai/Controller.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   SabaiXOOPS
 * @package    SabaiXOOPS
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/gpl-license.php GNU GPL
 * @link       http://sourceforge.net/projects/sabai
 * @since      Class available since Release 0.1.0
 */
class SabaiXOOPS_GroupPermissionController extends Sabai_Controller
{
    var $_xoopsModule;
    var $_options;

    function SabaiXOOPS_GroupPermissionController(&$module, $options = array())
    {
        $this->_xoopsModule =& $module;
        $default = array(
                     'formVar' => 'form',
                     'successURL' => null,
                     'successMsg' => 'Roles updated successfully',
                     'errorMsg' => 'Failed to delete roles for this module');
        $this->_options = array_merge($default, $options);
    }

    function _doExecute(&$context)
    {
        $module_id = $this->_xoopsModule->getVar('mid');
        $perm_name = $this->_xoopsModule->getVar('dirname') . '_role';
        $form =& $this->_getForm($context, $module_id, $perm_name);
        if ($context->request->isPost()) {
            if ($form->validateValues($context->request->getAll())) {
                $groupperm_h =& xoops_gethandler('groupperm');
                if ($groupperm_h->deleteByModule($module_id, $perm_name)) {
                    foreach ($context->request->getAsArray('roles') as $group_id => $role_ids) {
                        if (in_array($group_id, array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_ADMIN)) || $groupperm_h->checkRight('module_admin', $module_id, $group_id)) {
                            continue;
                        }
                        foreach ($role_ids as $role_id) {
                            $groupperm_h->addRight($perm_name, $role_id, $group_id, $module_id);
                        }
                    }
                    $context->response->setSuccess($this->_options['successMsg'], $this->_options['successURL']);
                    return;
                } else {
                    $form->addFormValidationError($this->_options['errorMsg']);
                }
            }
        }
        $form->onView();
        $context->response->pushContentName(strtolower(get_class($this)));
        $context->response->setVarRef($this->_options['formVar'], $form);
    }

    function &_getForm(&$context, $moduleId, $permName)
    {
        require_once 'Sabai/Form.php';
        require_once 'Sabai/Form/Decorator/Token.php';
        require_once 'Sabai/Form/Element/SelectDropdown.php';
        require_once 'Sabai/Validator/Inclusion.php';
        $form =& new Sabai_Form_Decorator_Token(new Sabai_Form(), 'XOOPS_RoleAdmin');
        $member_h =& xoops_gethandler('member');
        $groupperm_h =& xoops_gethandler('groupperm');
        $roles = $this->_getRoles($context);
        foreach ($member_h->getGroupList() as $group_id => $group_name) {
            if (in_array($group_id, array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_ADMIN))) {
                continue;
            }
            if ($groupperm_h->checkRight('module_admin', $moduleId, $group_id)) {
                continue;
            }
            $element =& new Sabai_Form_Element_SelectDropdown(sprintf('roles[%d]', $group_id), 5,  true);
            foreach ($roles as $role_id => $role_name) {
                $element->addOption($role_id, $role_name);
            }
            $element->setValue($groupperm_h->getItemIds($permName, $group_id, $moduleId));
            $form->addElement($element, $group_name);
        }
        return $form;
    }

    function _getRoles(&$context)
    {
        return array();
    }
}