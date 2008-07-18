<?php
class Xigg_Admin_Tag_DeleteEmptyTags extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$context->request->isPost()) {
            $context->response->setError(_('Invalid request'), array('base' => '/tag'));
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), array('base' => '/tag'));
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_tag_delete_empty_tags');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), array('base' => '/tag'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $tag_gw =& $model->getGateway('Tag');
        if (false === $affected = $tag_gw->deleteEmptyTags()) {
            $context->response->setError(_('An error occurred while deleting empty tags'), array('base' => '/tag/list'));
        } else {
            $context->response->setSuccess(Sabai_I18N::__('Deleted %s empty tag(s)', $affected), array('base' => '/tag/list'));
        }
    }
}