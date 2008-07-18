<?php
class Xigg_Admin_Node_Comment_Submit extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        // this node should be valid at this point
        $node_id = $context->request->getAsInt('node_id');
        $url = array('base' => '/node/' . $node_id);
        if (!$context->request->isPost()) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        if (!$comment_ids = $context->request->getAsArray('comments')) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_node_comment_submit');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $comment_r =& $model->getRepository('Comment');
        $comments =& $comment_r->fetchByCriteria(Sabai_Model_Criteria::createIn('comment_id', $comment_ids));
        while ($comment =& $comments->getNext()) {
            $comment->markRemoved();
        }
        if (false === $deleted = $model->commit()) {
            $context->response->setError(_('Could not delete selected comments'), $url);
        } else {
            $context->response->setSuccess(Sabai_I18N::__('%d comment(s) deleted successfully', $deleted), $url);
        }
    }
}