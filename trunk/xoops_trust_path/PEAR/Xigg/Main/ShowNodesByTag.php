<?php
class Xigg_Main_ShowNodesByTag extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        $node_r =& $model->getRepository('Node');
        if (!$tag_name = $context->request->getAsStr('tag_name')) {
            $this->_parent->forward('', $context);
            return;
        }
        $tag_name = mb_convert_encoding(rawurldecode($tag_name), SABAI_CHARSET, 'auto');
        $tag_r =& $model->getRepository('Tag');
        $criteria =& $model->createCriteria('Tag');
        $tags =& $tag_r->fetchByCriteria($criteria->nameIs($tag_name));
        if ($tags->size() <= 0) {
            $this->_parent->forward('', $context);
            return;
        }
        $tag =& $tags->getFirst();
        $criteria =& $model->createCriteria('Node');
        $criteria->statusIs(XIGG_NODE_STATUS_PUBLISHED);
        $criteria->hiddenIs(0);
        $sort = array('node_vote_count', 'node_published');
        $order = array('DESC', 'DESC');
        $period = $context->request->getAsStr('period', $context->application->config->get('defaultNodesPeriod'));
        switch ($period) {
            case 'all':
                break;
            case 'day':
                $criteria->publishedIsOrGreaterThan(time() - 86400);
                break;
            case 'week':
                $criteria->publishedIsOrGreaterThan(time() - 604800);
                break;
            case 'month':
                $criteria->publishedIsOrGreaterThan(time() - 2592000);
                break;
            case 'comments':
                $sort = array('node_comment_last', 'node_published');
                $order = array('DESC', 'DESC');
                break;
            case 'active':
                $sort = array('node_comment_lasttime', 'node_published');
                $order = array('DESC', 'DESC');
                break;
            default:
                $sort = array('node_priority', 'node_published');
                $order = array('DESC', 'DESC');
                $period = 'new';
                break;
        }
        $perpage = $context->application->config->get('numberOfNodesOnTop');
        $pages =& $node_r->paginateByTagAndCriteria($tag->getId(),
                                                    $criteria,
                                                    $perpage,
                                                    $sort,
                                                    $order);
        $page =& $pages->getValidPage($context->request->getAsInt('page', 1, null, 0));
        $nodes = null;
        $vote_allowed = false;
        $nodes_voted = $node_lastviews = array();
        if ($pages->getElementCount() > 0) {
            $nodes =& $page->getElements();
            if ($context->user->isAuthenticated()) {
                if ($context->user->hasPermission('vote submit')) {
                    $vote_allowed = true;
                    $vote_r =& $model->getRepository('Vote');
                    $nodes_voted = $vote_r->checkByNodesAndUser($nodes->getAllIds(), $context->user);
                }
                $view_r =& $model->getRepository('View');
                $node_lastviews = $view_r->checkByNodesAndUser($nodes->getAllIds(), $context->user);
            } elseif ($context->application->config->get('guestVotesAllowed')) {
                if ($user_ip = $this->_parent->getClientIP()) {
                    $vote_allowed = true;
                    $vote_r =& $model->getRepository('Vote');
                    $nodes_voted = $vote_r->checkByNodesAndUser($nodes->getAllIds(), $context->user, $user_ip);
                }
            }
        }

        $criteria =& $model->createCriteria('Node');
        $criteria->statusIs(XIGG_NODE_STATUS_UPCOMING);
        $criteria->hiddenIs(0);
        $context->response->setVars(array('pages'            => &$pages,
                                 'page'             => &$page,
                                 'nodes'            => &$nodes,
                                 'requested_period' => $period,
                                 'upcoming_count'   => $node_r->countByTagAndCriteria($tag->getId(), $criteria),
                                 'route'            => '/tag/' . rawurlencode($tag_name),
                                 'tag'              => &$tag,
                                 'vote_allowed'     => $vote_allowed,
                                 'nodes_voted'      => $nodes_voted,
                                 'node_lastviews'   => $node_lastviews,
                                 'sorts'            => $context->application->config->get('useVotingFeature') ?
                                                           array('new'      => _('Newly popular'),
                                                                 'comments' => _('Newly commented'),
                                                                 'active'   => _('Last active'),
                                                                 'day'      => _('Top in 24 hours'),
                                                                 'week'     => _('Top in 7 days'),
                                                                 'month'    => _('Top in 30 days'),
                                                                 'all'      => _('Top in all period')
                                                                 ) :
                                                           array('new'      => _('Date posted'),
                                                                 'comments' => _('Date commented'),
                                                                 'active'   => _('Last active')
                                                                 )));
    }
}