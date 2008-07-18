<?php
class Xigg_Admin_Tag_Submit extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$context->request->isPost()) {
            $context->response->setError(_('Invalid request'), array('base' => '/tag'));
            return;
        }
        if (!$tags = $context->request->getAsArray('tags')) {
            $context->response->setError(_('Invalid request'), array('base' => '/tag'));
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), array('base' => '/tag'));
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_tag_submit');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), array('base' => '/tag'));
            return;
        }
        $action = '';
        foreach (array('empty', 'delete') as $_action) {
            if ($context->request->getAsBool($_action, false)) {
                $action = $_action;
                break;
            }
        }
        switch ($action) {
            case 'empty':
                if (!$this->_empty($context, $tags)) {
                    $context->response->setError(_('Could not empty selected tags'), array('base' => '/tag'));
                } else {
                    $context->response->setSuccess(_('Selected tags emptied successfully'), array('base' => '/tag'));
                }
                break;
            case 'delete':
                if (!$this->_delete($context, $tags)) {
                    $context->response->setError(_('Could not delete selected tags'), array('base' => '/tag'));
                } else {
                    $context->response->setSuccess(_('Selected tags deleted successfully'), array('base' => '/tag'));
                }
                break;
            default:
                $context->response->setError(_('Invalid request'), array('base' => '/tag'));
        }
    }

    function _empty(&$context, $tags)
    {
        $model =& $context->application->locator->getService('Model');
        $tag_r =& $model->getRepository('Tag');
        $tags =& $tag_r->fetchByCriteria(Sabai_Model_Criteria::createIn('tag_id', $tags));
        while ($tag =& $tags->getNext()) {
            $tag->unlinkNodes();
        }
        return $model->commit();
    }

    function _delete(&$context, $tags)
    {
        $model =& $context->application->locator->getService('Model');
        $tag_r =& $model->getRepository('Tag');
        $tags =& $tag_r->fetchByCriteria(Sabai_Model_Criteria::createIn('tag_id', $tags));
        while ($tag =& $tags->getNext()) {
            $tag->markRemoved();
        }
        return $model->commit();
    }
}