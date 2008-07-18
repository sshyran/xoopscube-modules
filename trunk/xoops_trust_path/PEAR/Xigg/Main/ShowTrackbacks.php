<?php
class Xigg_Main_ShowTrackbacks extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        $trackback_view = $context->request->getAsStr('trackback_view', 'newest');
        $perpage = $context->application->config->get('numberOfTrackbacksOnPage');
        if ($trackback_view == 'oldest') {
            $pages =& $node->paginateTrackbacks($perpage, 'trackback_created', 'ASC');
        } else {
            $trackback_view = 'newest';
            $pages =& $node->paginateTrackbacks($perpage, 'trackback_created', 'DESC');
        }
        $page =& $pages->getValidPage($context->request->getAsInt('trackback_page', 1));
        $context->response->setVars(array('node'            => &$node,
                                 'trackback_pages' => &$pages,
                                 'trackback_page'  => &$page,
                                 'trackback_view'  => $trackback_view));
    }
}