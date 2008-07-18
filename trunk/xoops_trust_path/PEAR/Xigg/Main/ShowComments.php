<?php
class Xigg_Main_ShowComments extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        $comment_view = $context->request->getAsStr('comment_view');
        $comment_perpage = $context->application->config->get('numberOfCommentsOnPage');
        switch ($comment_view) {
            case 'nested':
                $pages =& $node->paginateCommentsByParentComment('NULL', $comment_perpage, false);
                break;
            case 'newest':
                $pages =& $node->paginateComments($comment_perpage, 'comment_created', 'DESC');
                break;
            case 'oldest':
            default:
                $pages =& $node->paginateComments($comment_perpage, 'comment_created', 'ASC');
                $comment_view = 'oldest';
                break;
        }
        $page =& $pages->getValidPage($context->request->getAsInt('comment_page', 1));
        $comment_form_show = $comment_form = false;
        if ($node->get('allow_comments')) {
            if ($context->user->isAuthenticated() || $context->application->config->get('guestCommentsAllowed')) {
                $comment_form_show = true;
                $comment_new =& $node->createComment();
                $comment_form =& $comment_new->toTokenForm('Comment_submit');
                $comment_form->removeElements(array('Node', 'body_html', 'content_syntax', 'allow_edit'));
                $comment_form->onView();
            }
        }
        $comments =& $page->getElements();
        $context->response->setVars(array(
                                      'node'              => &$node,
                                      'comment_pages'     => &$pages,
                                      'comment_page'      => &$page,
                                      'comment_form_show' => $comment_form_show,
                                      'comment_form'      => &$comment_form,
                                      'comment_view'      => $comment_view,
                                      'comments'          => &$comments,
                                      'comment_ids'       => $comments->getAllIds()));
    }
}