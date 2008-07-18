<?php
class Xigg_Main_RSS_ShowVotes extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$node =& $this->_parent->getNodeById($context, 'node_id')) {
            $context->response->setError(_('Invalid node'), array('base' => '/rss'));
            return;
        }
        $vote_view = $context->request->getAsStr('vote_view', 'newest');
        $perpage = $context->application->config->get('numberOfVotesOnPage');
        $pages =& $node->paginateVotes($perpage, 'vote_created', 'DESC');
        $page =& $pages->getValidPage($context->request->getAsInt('vote_page', 1));
        $context->response->setVars(array('node'       => &$node,
                                 'votes'      => $page->getElements()));
    }
}