<?php
class Xigg_Admin_Role_Member_Submit extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $error_url = $success_url = array('base' => '/role/' . $context->request->getAsInt('role_id'));
        if (!$context->request->isPost()) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        if (!$members = $context->request->getAsArray('members')) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_role_member_submit');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        if (false === $num = $this->_remove($context, $members)) {
            $context->response->setError(_('Could not remove selected members'), $error_url);
        } else {
            $context->response->setSuccess(Sabai_I18N::__('%d members(s) removed successfully', $num), $success_url);
        }
    }

    function _remove(&$context, $members)
    {
        $model =& $context->application->locator->getService('Model');
        $member_r =& $model->getRepository('Member');
        $members =& $member_r->fetchByCriteria(Sabai_Model_Criteria::createIn('member_id', $members));
        while ($member =& $members->getNext()) {
            $member->markRemoved();
        }
        return $model->commit();
    }
}