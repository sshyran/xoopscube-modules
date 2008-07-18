<?php
class Xigg_Main_RSS_ShowUpcomingNodesByTag extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        $node_r =& $model->getRepository('Node');
        if (!$tag_name = $context->request->getAsStr('tag_name')) {
            $this->_parent->forward('/rss', $context);
            return;
        }
        $tag_name = rawurldecode($tag_name);
        $tag_r =& $model->getRepository('Tag');
        $criteria =& $model->createCriteria('Tag');
        if (($tags =& $tag_r->fetchByCriteria($criteria->nameIs($tag_name))) && $tags->size()) {
            $vars['tag'] =& $tags->getFirst();
            $vars['route'] = '/tag/' . rawurlencode($tag_name);
            $criteria =& $model->createCriteria('Node');
            $criteria->statusIs(XIGG_NODE_STATUS_UPCOMING);
            $criteria->hiddenIs(0);
            $sort = 'node_created';
            $order = 'DESC';
            $pages =& $node_r->paginateByTagAndCriteria($vars['tag']->getId(),
                                                        $criteria,
                                                        $context->application->config->get('numberOfNodesOnTop'),
                                                        $sort,
                                                        $order);
        } else {
            $this->_parent->forward('/rss', $context);
            return;
        }
        $page =& $pages->getValidPage($context->request->getAsInt('page', 1, null, 0));
        $vars['nodes'] =& $page->getElements();
        $context->response->setVars($vars);
    }
}