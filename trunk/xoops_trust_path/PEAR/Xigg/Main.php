<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Main extends Sabai_Controller_Front
{
    function Xigg_Main()
    {
        parent::Sabai_Controller_Front('Index', 'Xigg_Main_', dirname(__FILE__) . '/Main');
        $this->addFilter('_global');
        $this->addControllerFilter(array('DeleteCommentForm',
                                         'DeleteNodeForm',
                                         'DeleteTrackbackForm',
                                         'EditCommentForm',
                                         'EditNodeForm',
                                         'EditTrackbackForm',
                                         'MoveCommentForm',
                                         'PublishNodeForm',
                                         'Logout'), '_isAuthenticated');
        $this->addControllerFilter(array('ShowUpcomingNodes',
                                         'ShowUpcomingNodesByTag'), '_isUpcomingFeatureEnabled');
        $this->addControllerFilter(array('SubmitCommentForm',
                                         'SubmitCommentReplyForm',
                                         'ShowCommentReplyForm',
                                         'ShowComments',
                                         'ShowComment',
                                         'ShowCommentReplies',
                                         'EditCommentForm',
                                         'MoveCommentForm',
                                         'DeleteCommentForm'), '_isCommentFeatureEnabled');
        $this->addControllerFilter(array('ShowTrackbacks',
                                         'ShowTrackback',
                                         'PostTrackback',
                                         'EditTrackbackForm',
                                         'DeleteTrackbackForm'), '_isTrackbackFeatureEnabled');
        $this->addControllerFilter(array('ShowVote',
                                         'ShowVotes',
                                         'ShowVoteForm',
                                         'SubmitVote'), '_isVotingFeatureEnabled');
        $this->addControllerFilter(array('ShowCommentForm',
                                         'ShowCommentReplyForm',
                                         'SubmitCommentForm',
                                         'SubmitCommentReplyForm'), '_isSubmitCommentAllowed');
        $this->addControllerFilter(array('ShowVoteForm',
                                         'SubmitVote'), '_isSubmitVoteAllowed');
        $this->addControllerFilter(array('SubmitNodeForm'), '_isSubmitArticleAllowed');
    }

    function _getRoutes(&$context)
    {
        $routes = array(
                    'node/upcoming' => array('controller' => 'ShowUpcomingNodes'),
                    'node/:node_id/votes' => array('controller'   => 'ShowVotes',
                                                   'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/voteform' => array('controller'   => 'ShowVoteForm',
                                                      'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/vote' => array('controller'   => 'SubmitVote',
                                                  'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/comments' => array('controller'   => 'ShowComments',
                                                      'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/commentform' => array('controller'   => 'ShowCommentForm',
                                                         'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/comment' => array('controller'   => 'SubmitCommentForm',
                                                     'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/trackbacks' => array('controller'   => 'ShowTrackbacks',
                                                        'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/publish' => array('controller'   => 'PublishNodeForm',
                                                     'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/edit' => array('controller'   => 'EditNodeForm',
                                                  'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/delete' => array('controller'   => 'DeleteNodeForm',
                                                    'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id/trackback' => array('controller'   => 'PostTrackback',
                                                       'requirements' => array(':node_id' => '\d+')),
                    'node/:node_id' => array('controller'   => 'ShowNode',
                                             'requirements' => array(':node_id' => '\d+')),
                    'node/submit' => array('controller' => 'SubmitNodeForm'),
                    'node' => array('controller'   => 'ShowNodes'),
                    'comment/:comment_id/replyform' => array('controller'   => 'ShowCommentReplyForm',
                                                             'requirements' => array(':comment_id' => '\d+')),
                    'comment/:comment_id/reply' => array('controller'   => 'SubmitCommentReplyForm',
                                                         'requirements' => array(':comment_id' => '\d+')),
                    'comment/:comment_id/replies' => array('controller'   => 'ShowCommentReplies',
                                                           'requirements' => array(':comment_id' => '\d+')),
                    'comment/:comment_id/delete' => array('controller'   => 'DeleteCommentForm',
                                                          'requirements' => array(':comment_id' => '\d+')),
                    'comment/:comment_id/edit' => array('controller'   => 'EditCommentForm',
                                                        'requirements' => array(':comment_id' => '\d+')),
                    'comment/:comment_id/move' => array('controller'   => 'MoveCommentForm',
                                                        'requirements' => array(':comment_id' => '\d+')),
                    'comment/:comment_id' => array('controller'   => 'ShowComment',
                                                   'requirements' => array(':comment_id' => '\d+')),
                    'tag/:tag_name/upcoming' => array('controller'   => 'ShowUpcomingNodesByTag',
                                                      'requirements' => array(':tag_name' => '.+')),
                    'tag/:tag_name' => array('controller'   => 'ShowNodesByTag',
                                             'requirements' => array(':tag_name' => '.+')),
                    'tag' => array('controller' => 'ListTags'),
                    'trackback/:trackback_id/delete' => array('controller'   => 'DeleteTrackbackForm',
                                                            'requirements' => array(':trackback_id' => '\d+')),
                    'trackback/:trackback_id/edit' => array('controller'   => 'EditTrackbackForm',
                                                            'requirements' => array(':trackback_id' => '\d+')),
                    'trackback/:trackback_id' => array('controller'   => 'ShowTrackback',
                                                       'requirements' => array(':trackback_id' => '\d+')),
                    'vote/:vote_id' => array('controller'   => 'ShowVote',
                                             'requirements' => array(':vote_id' => '\d+')),
                    'plugin/:plugin_name' => array('controller'   => 'Plugin',
                                                   'requirements' => array(':plugin_name' => '[a-zA-Z]+[a-zA-Z0-9_]*[a-zA-Z0-9]+')),
                    'submit' => array('forward' => '/node/submit'),
                    'rss' => array('controller' => 'RSS'),
                    'login' => array('controller' => 'Login'),
                    'logout' => array('controller' => 'Logout')
                  );
        return $routes;
    }

    /**
	 * Override the parent method to invoke plugins
	 *
	 * @param string $controllerName
	 * @param Sabai_Context $context
	 * @param array $controllerArgs
	 * @param string $controllerFile
	 */
	function _doExecuteController($controllerName, &$context, $controllerArgs, $controllerFile)
	{
	    $plugin_manager =& $context->application->locator->getService('PluginManager');
        $plugin_manager->dispatch('MainExecute', array($controllerName));
        parent::_doExecuteController($controllerName, $context, $controllerArgs, $controllerFile);
	}

    function &getNodeById(&$context, $nodeIdVar = 'node_id')
    {
        $ret = false;
        if (0 < $node_id = $context->request->getAsInt($nodeIdVar)) {
            $model =& $context->application->locator->getService('Model');
            $node_r =& $model->getRepository('Node');
            if (false !== $node =& $node_r->fetchById($node_id)) {
                $ret =& $node;
            }
        }
        return $ret;
    }

    function _globalBeforeFilter(&$context)
    {
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        $plugin_manager->dispatch('MainEnter');
    }

    function _globalAfterFilter(&$context)
    {
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        $plugin_manager->dispatch('MainExit');
    }

    function _isAuthenticatedBeforeFilter(&$context)
    {
        if (!$context->user->isAuthenticated()) {
            $context->response->setError(_('Authentication required to perform this operation'), array('base' => '/login'));
            $context->response->send($context->request);
            exit;
        }
    }

    function _isAuthorizedBeforeFilter(&$context, $perms)
    {
        $this->_isAuthenticatedBeforeFilter($context);
        if (!$context->user->hasPermission($perms)) {
            $context->response->setError(_('You are not authorized to perform this operation'), array('base' => '/login'));
            $context->response->send($context->request);
            exit;
        }
    }

    function _isSubmitArticleAllowedBeforeFilter(&$context)
    {
        $this->_isAuthorizedBeforeFilter($context, array('article post'));
    }

    function _isSubmitVoteAllowedBeforeFilter(&$context)
    {
        if (!$context->application->config->get('guestVotesAllowed')) {
            if (!$context->user->isAuthenticated()) {
                $context->response->setError(_('You must login to submit a vote'), array('base' => '/login'));
                $context->response->send($context->request);
                exit;
            } else {
                $this->_isAuthorizedBeforeFilter($context, array('vote submit'));
            }
        }
    }

    function _isSubmitCommentAllowedBeforeFilter(&$context)
    {
        if (!$context->application->config->get('guestCommentsAllowed')) {
            if (!$context->user->isAuthenticated()) {
                $context->response->setError(_('You must login to post comments'), array('base' => '/login'));
                $context->response->send($context->request);
                exit;
            } else {
                $this->_isAuthorizedBeforeFilter($context, array('comment post'));
            }
        }
    }

    function _isUpcomingFeatureEnabledBeforeFilter(&$context)
    {
        $this->_isFeatureEnabledBeforeFilter('useUpcomingFeature', $context);
    }

    function _isCommentFeatureEnabledBeforeFilter(&$context)
    {
        $this->_isFeatureEnabledBeforeFilter('useCommentFeature', $context);
    }

    function _isTrackbackFeatureEnabledBeforeFilter(&$context)
    {
        $this->_isFeatureEnabledBeforeFilter('useTrackbackFeature', $context);
    }

    function _isVotingFeatureEnabledBeforeFilter(&$context)
    {
        $this->_isFeatureEnabledBeforeFilter('useVotingFeature', $context);
    }

    function _isFeatureEnabledBeforeFilter($feature, &$context)
    {
        if (!$context->application->config->get($feature)) {
            $context->response->setError(_('Access denied'));
            $context->response->send($context->request);
            exit;
        }
    }

    function getClientIP()
    {
        require_once 'Net/CheckIP.php';
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR') as $key) {
            if (!empty($_SERVER[$key]) && ($_SERVER[$key] != 'unknown') && Net_CheckIP::check_ip($_SERVER[$key])) {
                return $_SERVER[$key];
            }
        }
        return false;
    }
}