<?php
class Xigg_Main_SubmitVote extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$context->request->isPost()) {
            $context->response->setError(_('Invalid request method'));
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        if ((!$token_value = $context->request->getAsStr(SABAI_TOKEN_NAME, false)) ||
            (!$node_id = $context->request->getAsInt('node_id', false))) {
            $context->response->setError(_('Invalid request'));
            return;
        }
        $validator =& new Sabai_Validator_Token('Vote_submit_' . $node_id);
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'));
            return;
        }
        if (!$node =& $this->_parent->getNodeById($context, 'node_id')) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $vote_r =& $model->getRepository('Vote');
        $user_ip = $this->_parent->getClientIP();
        if ($context->user->isAuthenticated()) {
            $user_vote_count = $vote_r->countByNodeAndUser($node_id, $context->user);
        } else {
            if (!$user_ip) {
                $context->response->setError(_('Invalid IP address. Guest votes require a valid IP address.'), array('base' => '/node/' . $node->getId()));
                return;
            }
            $criteria =& $model->createCriteria('Vote');
            $criteria->userIdIs('');
            $criteria->ipIs($user_ip);
            $user_vote_count = $vote_r->countByNodeAndCriteria($node_id, $criteria);
        }
        if (!empty($user_vote_count)) {
            $context->response->setError(_('Already voted'), array('base' => '/node/' . $node->getId()));
            return;
        }
        $vote =& $node->createVote();
        $vote->assignUser($context->user);
        if ($user_ip) {
            $vote->set('ip', $user_ip);
        }
        $vote->set('score', 1);
        $vote->markNew();
        if (!$vote->commit()) {
            $context->response->setError(_('Failed operation'), array('base' => '/node/' . $node->getId()));
            return;
        }
        $node_votes = $node->countVotes();
        if ($context->request->getAsBool('echo', false)) {
            $msg = $node_votes;
        } else {
            $msg = _('Voted successfully');
        }
        if (!$node->isPublished()) {
            // make the article published if more than required votes
            if ($node_votes > $context->application->config->get('numberOfVotesForPopular')) {
                $node->publish();
            }
        }
        $context->response->setSuccess($msg, array('base' => '/node/' . $node->getId()));
    }
}