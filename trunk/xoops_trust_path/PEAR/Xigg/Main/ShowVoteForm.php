<?php
class Xigg_Main_ShowVoteForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $vote =& $node->createVote();
        $vote_form =& $vote->toTokenForm('Vote_submit_' . $node->getId());
        $vote_form->removeElements(array('Node', 'ip', 'score'));
        $vote_form->onView();
        $context->response->setVars(array('vote_form' => &$vote_form, 'node' => &$node));
    }
}