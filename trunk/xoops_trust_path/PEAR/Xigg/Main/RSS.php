<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Main_RSS extends Sabai_Controller_Front
{
	function Xigg_Main_RSS()
	{
		parent::Sabai_Controller_Front('ShowNodes', 'Xigg_Main_RSS_', dirname(__FILE__) . '/RSS');
		$this->addFilter('_makeRSSResponse');
	}

	function _getRoutes(&$context)
	{
        $routes['rss/upcoming'] = array('controller' => 'ShowUpcomingNodes');
        $routes['rss/tag/:tag_name/upcoming'] = array('controller' => 'ShowUpcomingNodesByTag',
                                                      'requirements' => array(':tag_name' => '.+'));
        $routes['rss/tag/:tag_name'] = array('controller'   => 'ShowNodesByTag',
                                             'requirements' => array(':tag_name' => '.+'));
        $routes['rss/node/:node_id/comments'] = array('controller'   => 'ShowComments',
                                                      'requirements' => array(':node_id' => '\d+'));
        $routes['rss/node/:node_id/trackbacks'] = array('controller'   => 'ShowTrackbacks',
                                                        'requirements' => array(':node_id' => '\d+'));
        $routes['rss/node/:node_id/votes'] = array('controller'   => 'ShowVotes',
                                                   'requirements' => array(':node_id' => '\d+'));
        return $routes;
	}

	function &getNodeById(&$context, $nodeIdVar = 'node_id')
	{
        $node =& $this->_parent->getNodeById($context, $nodeIdVar);
        return $node;
	}

	function _makeRSSResponseBeforeFilter(&$context)
	{
	    $context->response->setVar('sitename', $context->application->config->get('siteTitle'));
        $context->response->noLayout();
        $context->response->setCharset('UTF-8');
	}
}