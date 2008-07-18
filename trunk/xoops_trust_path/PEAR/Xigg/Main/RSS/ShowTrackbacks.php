<?php
class Xigg_Main_RSS_ShowTrackbacks extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$node =& $this->_parent->getNodeById($context, 'node_id')) {
            $context->response->setError(_('Invalid node'), array('base' => '/rss'));
            return;
        }
        $trackback_view = $context->request->getAsStr('trackback_view', 'newest');
        $perpage = $context->application->config->get('numberOfTrackbacksOnPage');
        $pages =& $node->paginateTrackbacks($perpage, 'trackback_created', 'DESC');
        $page =& $pages->getValidPage($context->request->getAsInt('trackback_page', 1));
        $context->response->setVars(array('node'            => &$node,
                                 'trackbacks'      => $page->getElements()));
    }
}