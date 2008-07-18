<?php
class Xigg_Admin_User_Submit extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$context->request->isPost()) {
            $context->response->setError(_('Invalid request'), array('base' => '/user'));
            return;
        }
        if (!$users = $context->request->getAsArray('users')) {
            $context->response->setError(_('Invalid request'), array('base' => '/user'));
            return;
        }
        if (!$action = $context->request->getAsStr('action')) {
            $context->response->setError(_('Invalid request'), array('base' => '/user'));
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), array('base' => '/user'));
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_user_submit');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), array('base' => '/user'));
            return;
        }
        if ((!$action = explode(',', $action)) || (count($action) != 2) || (!in_array($action[0], array('assign', 'remove')))) {
            $context->response->setError(_('Invalid request'), array('base' => '/user'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $role_r =& $model->getRepository('Role');
        if ((!$role_id = intval($action[1])) || (!$role =& $role_r->fetchById($role_id))) {
            $context->response->setError(_('Invalid role'), array('base' => '/user'));
            return;
        }
        $success_url = $error_url = array('base' => '/user', 'params' => array('sortby' => $context->request->getAsStr('sortby'), 'page' => $context->request->getAsInt('page')));
        switch ($action[0]) {
            case 'assign':
                if (false === $num = $this->_assign($context, $role, $users)) {
                    $context->response->setError(_('Could not assign role to selected users'), $error_url);
                } else {
                    $context->response->setSuccess(Sabai_I18N::__('%d users(s) assigned role successfully', $num), $success_url);
                }
                break;
            case 'remove':
                if (false === $num = $this->_remove($context, $role, $users)) {
                    $context->response->setError(_('Could not remove role from selected users'), $error_url);
                } else {
                    $context->response->setSuccess(Sabai_I18N::__('%d users(s) removed role successfully', $num), $success_url);
                }
                break;
        }
    }

    function _assign(&$role, $userIds)
    {
        $model =& $context->application->locator->getService('Model');
        $member_r =& $model->getRepository('Member');
        $members =& $member_r->fetchByRoleAndCriteria($role->getId(), Sabai_Model_Criteria::createIn('member_userid', $userIds));
        while ($member =& $members->getNext()) {
            // already assigned
            unset($userIds[$member->getUserId()]);
        }
        foreach ($userIds as $user_id) {
            $new_member[$user_id] =& $model->create('Member');
            $new_member[$user_id]->assignRole($role);
            $new_member[$user_id]->setVar('userid', $user_id);
            $new_member[$user_id]->markNew();
        }
        return $model->commit();
    }

    function _remove(&$role, $userIds)
    {
        $model =& $context->application->locator->getService('Model');
        $member_r =& $model->getRepository('Member');
        $members =& $member_r->fetchByRoleAndCriteria($role->getId(), Sabai_Model_Criteria::createIn('member_userid', $userIds));
        while ($member =& $members->getNext()) {
            $member->markRemoved();
        }
        return $model->commit();
    }
}