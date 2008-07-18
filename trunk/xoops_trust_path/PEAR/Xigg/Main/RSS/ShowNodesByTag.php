<?php
class Xigg_Main_RSS_ShowNodesByTag extends Sabai_Controller
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
        $tags =& $tag_r->fetchByCriteria($criteria->nameIs($tag_name));
        if ($tags->size() <= 0) {
            $this->_parent->forward('/rss', $context);
            return;
        }
        $tag =& $tags->getFirst();
        $criteria =& $model->createCriteria('Node');
        $criteria->statusIs(XIGG_NODE_STATUS_PUBLISHED);
        $criteria->hiddenIs(0);
        $sort = 'node_published';
        $perpage = $context->application->config->get('numberOfNodesOnTop');
        $pages =& $node_r->paginateByTagAndCriteria($tag->getId(),
                                                    $criteria,
                                                    $perpage,
                                                    $sort,
                                                    'DESC');
        $page =& $pages->getValidPage($context->request->getAsInt('page', 1, null, 0));
        $nodes =& $page->getElements();
        $context->response->setVars(array('nodes'            => &$nodes,
                                 'route'            => '/tag/' . rawurlencode($tag_name),
                                 'tag'              => &$tag,
                                 ));
    }
}