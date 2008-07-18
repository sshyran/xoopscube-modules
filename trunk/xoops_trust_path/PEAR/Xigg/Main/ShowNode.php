<?php
class Xigg_Main_ShowNode extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $vars = array();
        $vars['node'] =& $node;
        $context->response->setPageTitle($node->getLabel());

        // user view
        $vars['view_count'] = $node->getViewCount() + 1; // +1 for node owner
        if (!$node->isOwnedBy($context->user)) {
            $node->set('views', $node->get('views') + 1);
            $node->commit();
            if ($context->user->isAuthenticated()) {
                $vars['view_count'] = $vars['view_count'] + $this->_updateNodeViewByUser($context, $node, $context->user);
            }
        }

        // comments
        $vars['comment_form_show'] = false;
        if ($context->application->config->get('useCommentFeature')) {
            $comment_page = $context->request->getAsInt('comment_page', 1);
            $comment_perpage = $context->application->config->get('numberOfCommentsOnPage');
            $vars['comment_view'] = $context->request->getAsStr('comment_view');
            $vars['comments_replies'] = array();
            if ($comment_id = $context->request->getAsInt('comment_id', false)) {
                $comment_r =& $model->getRepository('Comment');
                // make sure comment exists and that it belongs to the requested node
                if (($comment =& $comment_r->fetchById($comment_id)) && ($comment->getVar('node_id') == $node->getId())) {
                    $vars['comment_view'] = 'nested';
                    if ($comment->getVar('parent') != 0) {
                        // get the top parent comment
                        $parent_comments =& $comment->parents();
                        while ($comment =& $parent_comments->getNext()) {
                            if ($comment->getVar('parent') == 0) {
                                break;
                            }
                        }
                    }
                    $vars['comments_replies'][$comment->getId()] =& $model->decorate($comment->descendantsAsTree(), 'User');
                    $criteria =& $model->createCriteria('Comment');
                    $criteria->createdIsSmallerThan($comment->getTimeCreated());
                    $criteria->parentIs('NULL');
                    if ($comment_count = $comment_r->countByNodeAndCriteria($node->getId(), $criteria)) {
                        $comment_page = intval(ceil(($comment_count + 1) / $comment_perpage));
                    }
                }
            }
            switch ($vars['comment_view']) {
                case 'nested':
                    $comment_pages =& $node->paginateCommentsByParentComment('NULL', $comment_perpage);
                    break;
                case 'newest':
                    $comment_pages =& $node->paginateComments($comment_perpage, 'comment_created', 'DESC');
                    break;
                case 'oldest':
                default:
                    $comment_pages =& $node->paginateComments($comment_perpage, 'comment_created', 'ASC');
                    $vars['comment_view'] = 'oldest';
                    break;
            }
            $vars['comment_pages'] =& $comment_pages;
            $vars['comment_page'] =& $vars['comment_pages']->getValidPage($comment_page);
            $vars['comments'] =& $model->decorate($vars['comment_page']->getElements(), 'User');
            $vars['comment_ids'] = $vars['comments']->getAllIds();
            if ($node->get('allow_comments')) {
                if ($context->user->isAuthenticated() || $context->application->config->get('guestCommentsAllowed')) {
                    $comment_new =& $node->createComment();
                    $vars['comment_form_show'] = true;
                    $vars['comment_form'] =& $comment_new->toTokenForm('Comment_submit');
                    $vars['comment_form']->removeElements(array('Node', 'body_html', 'content_syntax', 'allow_edit'));
                    $node_title = trim($node->getLabel());
                    $comment_title = !preg_match('/^Re:/i', $node_title) ? 'Re: ' . $node_title : $node_title;
                    $vars['comment_form']->setValueFor('title', $comment_title);
                    $vars['comment_form']->onView();
                    $plugin_mngr =& $context->application->locator->getService('PluginManager');
                    $plugin_mngr->dispatch('ShowCommentForm', array(&$vars['comment_form'], /*$isReply*/ false));
                }
            }
        }

        // trackbacks
        if ($context->application->config->get('useTrackbackFeature')) {
            $trackback_page = $context->request->getAsInt('trackback_page', 1);
            $trackback_perpage = $context->application->config->get('numberOfTrackbacksOnPage');
            $vars['trackback_view'] = $context->request->getAsStr('trackback_view', 'newest');
            if ($trackback_id = $context->request->getAsInt('trackback_id', false)) {
                $trackback_r =& $model->getRepository('Trackback');
                // make sure trackback exists and that it belongs to the requested node
                if (($trackback =& $trackback_r->fetchById($trackback_id)) && ($trackback->getVar('node_id') == $node->getId())) {
                    $criteria =& $model->createCriteria('Trackback');
                    if ($vars['trackback_view'] == 'oldest') {
                        $criteria->createdIsSmallerThan($trackback->getTimeCreated());
                    } else {
                        $criteria->createdIsGreaterThan($trackback->getTimeCreated());
                    }
                    if ($trackback_count = $trackback_r->countByCriteria($criteria)) {
                        $trackback_page = ceil(($trackback_count + 1) / $trackback_perpage);
                    }
                }
            }
            if ($vars['trackback_view'] == 'oldest') {
                $vars['trackback_pages'] =& $node->paginateTrackbacks($trackback_perpage, 'trackback_created', 'ASC');
            } else {
                $vars['trackback_view'] = 'newest';
                $vars['trackback_pages'] =& $node->paginateTrackbacks($trackback_perpage, 'trackback_created', 'DESC');
            }
            $vars['trackback_page'] =& $vars['trackback_pages']->getValidPage($trackback_page);
        }

        // votes
        if ($context->application->config->get('useVotingFeature')) {
            $vote_page = $context->request->getAsInt('vote_page', 1);
            $vote_perpage = $context->application->config->get('numberOfVotesOnPage');
            $vars['vote_view'] = $context->request->getAsStr('vote_view', 'newest');
            if ($vote_id = $context->request->getAsInt('vote_id', false)) {
                $vote_r =& $model->getRepository('Vote');
                // make sure vote exists and that it belongs to the requested node
                if (($vote =& $vote_r->fetchById($vote_id)) && ($vote->getVar('node_id') == $node->getId())) {
                    $criteria =& $model->createCriteria('Vote');
                    if ($vars['vote_view'] == 'oldest') {
                        $criteria->createdIsSmallerThan($vote->getTimeCreated());
                    } else {
                        $criteria->createdIsGreaterThan($vote->getTimeCreated());
                    }
                    if ($vote_count = $vote_r->countByCriteria($criteria)) {
                        $vote_page = ceil(($vote_count + 1) / $vote_perpage);
                    }
                }
            }
            if ($vars['vote_view'] == 'oldest') {
                $vars['vote_pages'] =& $node->paginateVotes($vote_perpage, 'vote_created', 'ASC');
            } else {
                $vars['vote_view'] = 'newest';
                $vars['vote_pages'] =& $node->paginateVotes($vote_perpage, 'vote_created', 'DESC');
            }
            $vote_page =& $vars['vote_pages']->getValidPage($vote_page);
            $vars['votes'] =& $model->decorate($vote_page->getElements(), 'User');
            $vars['vote_page'] = $vote_page->getPageNumber();
            $vars['vote_enable'] = true;
            if (!$context->user->isAuthenticated()) {
                if ($context->application->config->get('guestVotesAllowed')) {
                    if ($user_ip = $this->_parent->getClientIP()) {
                        $criteria =& $model->createCriteria('Vote');
                        $criteria->userIdIs('');
                        $criteria->ipIs($user_ip);
                        $vote_r =& $model->getRepository('Vote');
                        $vars['voted'] = $vote_r->countByNodeAndCriteria($node->getId(), $criteria);
                    } else {
                        $vars['vote_enable'] = false;
                    }
                } else {
                    $vars['vote_enable'] = false;
                }
            } else {
                $vote_r =& $model->getRepository('Vote');
                $vars['voted'] = $vote_r->countByNodeAndUser($node->getId(), $context->user);
            }
        }

        $context->response->setVars($vars);
    }

    function _updateNodeViewByUser(&$context, &$node, &$user)
    {
        $model =& $context->application->locator->getService('Model');
        $view_r =& $model->getRepository('View');
        $criteria =& $model->createCriteria('View');
        $criteria->uidIs($user->getId());
        if (($view_it =& $view_r->fetchByCriteria($criteria->node_idIs($node->getId()), 1))
                && ($view_it->size() > 0)) {
            $view =& $view_it->getNext();
            $ret = 0;
        } else {
            $view =& $node->createView();
            $view->set('uid', $user->getId());
            $view->markNew();
            $ret = 1;
        }
        $view->set('last', time());
        $view->commit();
        return $ret;
    }
}