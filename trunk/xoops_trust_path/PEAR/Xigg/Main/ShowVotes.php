<?php
class Xigg_Main_ShowVotes extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        $vote_view = $context->request->getAsStr('vote_view', 'newest');
        $perpage = $context->application->config->get('numberOfVotesOnPage');
        if ($vote_view == 'oldest') {
            $pages =& $node->paginateVotes($perpage, 'vote_created', 'ASC');
        } else {
            $vote_view = 'newest';
            $pages =& $node->paginateVotes($perpage, 'vote_created', 'DESC');
        }
        $page =& $pages->getValidPage($context->request->getAsInt('vote_page', 1));
        $votes =& $page->getElements();
        $votes =& $votes->with('User');
        $context->response->setVars(array('node'       => &$node,
                                 'vote_pages' => &$pages,
                                 'votes'      => &$votes,
                                 'vote_view'  => $vote_view,
                                 'vote_page'  => $page->getPageNumber()));
    }
}