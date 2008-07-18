<?php
class Xigg_Admin_Node_Trackback_Submit extends Sabai_Controller
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
        if (!$trackback_ids = $context->request->getAsArray('trackbacks')) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_node_trackback_submit');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), $url);
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $trackback_r =& $model->getRepository('Trackback');
        $trackbacks =& $trackback_r->fetchByCriteria(Sabai_Model_Criteria::createIn('trackback_id', $trackback_ids));
        while ($trackback =& $trackbacks->getNext()) {
            $trackback->markRemoved();
        }
        if (false === $deleted = $model->commit()) {
            $context->response->setError(_('Could not delete selected trackbacks'), $url);
        } else {
            $context->response->setSuccess(Sabai_I18N::__('%d trackback(s) deleted successfully', $deleted), $url);
        }
    }
}