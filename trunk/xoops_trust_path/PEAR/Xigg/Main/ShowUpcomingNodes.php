<?php
class Xigg_Main_ShowUpcomingNodes extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        $category_r =& $model->getRepository('Category');
        $category_it =& $category_r->fetchAllAsTree();
        $category_options = $categories = array();
        $category_options[0] = _('All News');
        while ($category =& $category_it->getNext()) {
            $category_options[$category->getId()] = str_repeat('--', $category->parentsCount() + 1) . $category->getLabel();
            $categories[$category->getId()] =& $category;
        }
        $node_r =& $model->getRepository('Node');
        $criteria =& $model->createCriteria('Node');
        $criteria->statusIs(XIGG_NODE_STATUS_UPCOMING);
        $criteria->hiddenIs(0);
        $criteria2 =& $model->createCriteria('Node');
        $criteria2->statusIs(XIGG_NODE_STATUS_PUBLISHED);
        $criteria2->hiddenIs(0);

        $user_req = null;
        if ($user_id = $context->request->getAsInt('user_id')) {
            if ($users = $model->fetchUserIdentities(array($user_id))) {
                $user_req =& $users[$user_id];
                $criteria->useridIs($user_id);
                $criteria2->useridIs($user_id);
            }
        }


        if ($keyword_req = $context->request->getAsStr('keyword', '')) {
            // need to convert encoding since AJAX with Form.serialize() comes with UTF-8
            if (SABAI_CHARSET != 'UTF-8') {
                $keyword_req = mb_convert_encoding($keyword_req, SABAI_CHARSET, array(SABAI_CHARSET, 'UTF-8'));
            }
            $keyword_req = trim(preg_replace(array('/\s\s+/'), array(' '), str_replace(_(' '), ' ', $keyword_req)));
        }
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
        $requested_category = null;
        $perpage = $context->application->config->get('numberOfNodesOnTop');
        if (($category_id = $context->request->getAsInt('category_id')) && ($requested_category =& $category_r->fetchById($category_id))) {
            $context->response->setVarRef('requested_category', $requested_category);
            $descendants =& $requested_category->descendants();
            $cat_ids = array_merge(array($category_id), $descendants->getAllIds());
            if (!empty($keyword_req)) {
                $pages =& $node_r->paginateByCriteriaKeywordAndCategory($criteria, $keyword_req, $cat_ids, $perpage, $sort, $order);
                $popular_count = $node_r->countByCriteriaKeywordAndCategory($criteria2, $keyword_req, $cat_ids);
            } else {
                $pages =& $node_r->paginateByCategoryAndCriteria($cat_ids, $criteria, $perpage, $sort, $order);
                $popular_count = $node_r->countByCategoryAndCriteria($cat_ids, $criteria2);
            }
        } else {
            if (!empty($keyword_req)) {
                $pages =& $node_r->paginateByCriteriaKeywordAndCategory($criteria, $keyword_req, null, $perpage, $sort, $order);
                $popular_count = $node_r->countByCriteriaKeywordAndCategory($criteria2, $keyword_req, null);
            } else {
                $pages =& $node_r->paginateByCriteria($criteria, $perpage, $sort, $order);
                $popular_count = $node_r->countByCriteria($criteria2);
            }
        }
        $page =& $pages->getValidPage($context->request->getAsInt('page', 1, null, 0));
        $nodes = null;
        $vote_allowed = false;
        $nodes_voted = array();
        if ($pages->getElementCount() > 0) {
            $nodes =& $page->getElements();
            if ($context->user->isAuthenticated()) {
                if ($context->user->hasPermission('vote submit')) {
                    $vote_allowed = true;
                    $vote_r =& $model->getRepository('Vote');
                    $nodes_voted = $vote_r->checkByNodesAndUser($nodes->getAllIds(), $context->user);
                }
            } elseif ($context->application->config->get('guestVotesAllowed')) {
                if ($user_ip = $this->_parent->getClientIP()) {
                    $vote_allowed = true;
                    $vote_r =& $model->getRepository('Vote');
                    $nodes_voted = $vote_r->checkByNodesAndUser($nodes->getAllIds(), $context->user, $user_ip);
                }
            }
        }

        $context->response->setVars(array('requested_category' => &$requested_category,
                                 'requested_user'     => &$user_req,
                                 'requested_user_id'  => $user_req ? $user_req->getId() : '',
                                 'requested_keyword'  => $keyword_req,
                                 'pages'              => &$pages,
                                 'page'               => &$page,
                                 'nodes'              => &$nodes,
                                 'requested_sort'     => $sort_req,
                                 'popular_count'      => $popular_count,
                                 'vote_allowed'       => $vote_allowed,
                                 'nodes_voted'        => $nodes_voted,
                                 'categories'         => $categories,
                                 'category_list'      => $category_options,
                                 'sorts'              => $context->application->config->get('useVotingFeature') ?
                                                       array('new'     => _('Newest'),
                                                             'old'     => _('Oldest'),
                                                             'vote'    => _('Most voted'),
                                                             'voteup'  => _('Least voted'),
                                                             'comment' => _('Most commented')) :
                                                       array('new'     => _('Newest'),
                                                             'old'     => _('Oldest'),
                                                             'comment' => _('Most commented'))));
    }
}