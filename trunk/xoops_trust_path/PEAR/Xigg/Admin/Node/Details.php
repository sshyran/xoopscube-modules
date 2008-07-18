<?php
class Xigg_Admin_Node_Details extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $vars = $context->response->getVars();
        $node =& $vars['node'];
        $model =& $context->application->locator->getService('Model');
        $comment_r =& $model->getRepository('Comment');
        $comment_pages =& $comment_r->paginateByNodeAndCriteria($node->getId(), Sabai_Model_Criteria::createValue('comment_parent', 'NULL'), 10, 'comment_created', 'DESC');
        $comment_page =& $comment_pages->getValidPage(1);
        $comments =& $comment_page->getElements();
        $comments =& $comments->with('User');
        $comments =& $comments->with('DescendantsCount');
        $trackback_pages =& $node->paginateTrackbacks(10, 'trackback_created', 'DESC');
        $trackback_page =& $trackback_pages->getValidPage(1);
        $trackbacks =& $trackback_page->getElements();
        $vote_pages =& $node->paginateVotes(10, 'vote_created', 'DESC');
        $vote_page =& $vote_pages->getValidPage(1);
        $votes =& $vote_page->getElements();
        $votes =& $votes->with('User');
        $context->response->setVars(array(
                                      'comment_pages'            => &$comment_pages,
                                      'comment_objects'          => &$comments,
                                      'comment_page_requested'   => 1,
                                      'comment_sortby'           => '',
                                      'trackback_pages'          => &$trackback_pages,
                                      'trackback_objects'        => $trackbacks,
                                      'trackback_page_requested' => 1,
                                      'trackback_sortby'         => '',
                                      'vote_pages'               => &$vote_pages,
                                      'vote_objects'             => $votes,
                                      'vote_page_requested'      => 1,
                                      'vote_sortby'              => ''
                                    ));
    }
}