<?php
class Xigg_Admin_Node_Vote_Submit extends Sabai_Controller
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
        if (!$vote_ids = $context->request->getAsArray('votes')) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_node_vote_submit');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $vote_r =& $model->getRepository('Vote');
        $votes =& $vote_r->fetchByCriteria(Sabai_Model_Criteria::createIn('vote_id', $vote_ids));
        while ($vote =& $votes->getNext()) {
            $vote->markRemoved();
        }
        if (false === $deleted = $model->commit()) {
            $context->response->setError(_('Could not delete selected votes'), $url);
        } else {
            $context->response->setSuccess(Sabai_I18N::__('%d vote(s) deleted successfully', $deleted), $url);
        }
    }
}