<?php
class Xigg_Main_RSS_ShowUpcomingNodes extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        $category_r =& $model->getRepository('Category');
        $node_r =& $model->getRepository('Node');
        $criteria =& $model->createCriteria('Node');
        $criteria->statusIs(XIGG_NODE_STATUS_UPCOMING);
        $criteria->hiddenIs(0);
        if ($keyword_req = $context->request->getAsStr('keyword', '')) {
            $keyword_req = trim(preg_replace(array('/\s\s+/'), array(' '), str_replace(_(' '), ' ', $keyword_req)));
        	foreach (explode(' ', $keyword_req) as $keyword) {
        	    $keyword_criteria =& Sabai_Model_Criteria::createComposite(array(Sabai_Model_Criteria::createString('node_teaser_html', $keyword)));
                $keyword_criteria->addOr(Sabai_Model_Criteria::createString('node_body_html', $keyword));
                $keyword_criteria->addOr(Sabai_Model_Criteria::createString('node_title', $keyword));
                $criteria->addAnd($keyword_criteria);
                unset($keyword_criteria);
        	}
        }
        $sort = 'node_created';
        $order = 'DESC';
        $perpage = $context->application->config->get('numberOfNodesOnTop');
        if (($category_id = $context->request->getAsInt('category_id')) && ($requested_category =& $category_r->fetchById($category_id))) {
            $context->response->setVarRef('requested_category', $requested_category);
            $descendants =& $requested_category->descendants();
            $cat_ids = array_merge(array($category_id), $descendants->getAllIds());
            $pages =& $node_r->paginateByCategoryAndCriteria($cat_ids, $criteria, $perpage, $sort, $order);
        } else {
            $pages =& $node_r->paginateByCriteria($criteria, $perpage, $sort, $order);
        }
        $nodes = null;
        if ($pages->getElementCount() > 0) {
            $page =& $pages->getValidPage($context->request->getAsInt('page', 1, null, 0));
            $nodes =& $page->getElements();
        }
        $context->response->setVars(array('requested_category' => &$requested_category,
                                 'requested_keyword'  => $keyword_req,
                                 'nodes'              => &$nodes,
                                 ));
    }
}