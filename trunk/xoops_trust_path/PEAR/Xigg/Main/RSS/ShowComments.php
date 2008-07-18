<?php
class Xigg_Main_RSS_ShowComments extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$node =& $this->_parent->getNodeById($context, 'node_id')) {
            $context->response->setError(_('Invalid node'), array('base' => '/rss'));
            return;
        }
        $comment_view = $context->request->getAsStr('comment_view', 'newest');
        $comment_perpage = $context->application->config->get('numberOfCommentsOnPage');
        switch ($comment_view) {
            case 'oldest':
                $pages =& $node->paginateComments($comment_perpage, 'comment_created', 'ASC');
                break;
            case 'newest':
            default:
                $pages =& $node->paginateComments($comment_perpage, 'comment_created', 'DESC');
                $comment_view = 'newest';
            break;
        }
        $page =& $pages->getValidPage($context->request->getAsInt('comment_page', 1));
        $comments =& $page->getElements();
        $context->response->setVars(array('node'              => &$node,
                                 'comments'          => &$comments));
    }
}