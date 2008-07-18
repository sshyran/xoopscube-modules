<?php
class Xigg_Main_ShowUpcomingNodesByTag extends Sabai_Controller
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
        if (($tags =& $tag_r->fetchByCriteria($criteria->nameIs($tag_name))) && $tags->size()) {
            $vars['tag'] =& $tags->getFirst();
            $vars['route'] = '/tag/' . rawurlencode($tag_name);
            $criteria =& $model->createCriteria('Node');
            $criteria->statusIs(XIGG_NODE_STATUS_UPCOMING);
            $criteria->hiddenIs(0);
            $sort_req = $context->request->getAsStr('sort');
            switch ($sort_req) {
                case 'vote':
                    $sort = array('node_vote_count', 'node_created');
                    $order = array('DESC', 'DESC');
                    break;
                case 'voteup':
                    $sort = array('node_vote_count', 'node_created');
                    $order = array('ASC', 'DESC');
                    break;
                case 'comment':
                    $sort = array('node_comment_count', 'node_created');
                    $order = array('DESC', 'DESC');
                    break;
                case 'old':
                    $sort = 'node_created';
                    $order = 'ASC';
                    break;
                case 'new':
                default:
                    $sort_req = 'new';
                    $sort = 'node_created';
                    $order = 'DESC';
                    break;
            }
            $perpage = $context->application->config->get('numberOfNodesOnTop');
            $pages =& $node_r->paginateByTagAndCriteria($vars['tag']->getId(),
                                                        $criteria,
                                                        $perpage,
                                                        $sort,
                                                        $order);
        } else {
            $this->_parent->forward('', $context);
            return;
        }
        $vars['vote_allowed'] = false;
        $vars['nodes_voted'] = array();
        if ($pages->getElementCount() > 0) {
            $vars['nodes'] =& $vars['page']->getElements();
            if ($context->user->isAuthenticated()) {
                if ($context->user->hasPermission('vote submit')) {
                    $vars['vote_allowed'] = true;
                    $vote_r =& $model->getRepository('Vote');
                    $vars['nodes_voted'] = $vote_r->checkByNodesAndUser($vars['nodes']->getAllIds(), $context->user);
                }
            } elseif ($context->application->config->get('guestVotesAllowed')) {
                if ($user_ip = $this->_parent->getClientIP()) {
                    $vars['vote_allowed'] = true;
                    $vote_r =& $model->getRepository('Vote');
                    $vars['nodes_voted'] = $vote_r->checkByNodesAndUser($vars['nodes']->getAllIds(), $context->user, $user_ip);
                }
            }
        }


        $criteria =& $model->createCriteria('Node');
        $criteria->statusIs(XIGG_NODE_STATUS_PUBLISHED);
        $criteria->hiddenIs(0);
        $vars['popular_count'] = $node_r->countByTagAndCriteria($vars['tag']->getId(), $criteria);
        $vars['pages'] =& $pages;
        $vars['page'] =& $pages->getValidPage($context->request->getAsInt('page', 1, null, 0));
        $vars['requested_sort'] = $sort_req;
        $vars['sorts'] = $context->application->config->get('useVotingFeature') ?
                           array('new'     => _('Newest'),
                                 'old'     => _('Oldest'),
                                 'vote'    => _('Most voted'),
                                 'voteup'  => _('Least voted'),
                                 'comment' => _('Most commented')) :
                           array('new'     => _('Newest'),
                                 'old'     => _('Oldest'),
                                 'comment' => _('Most commented'));
        $context->response->setVars($vars);
    }
}