<?php
eval('
function ' . $module_dirname . '_search($keywords, $andor, $limit, $offset, $userid)
{
    return xigg_xoops_search_base("' . $module_dirname . '", $keywords, $andor, $limit, $offset, $userid);
}
');

if (!function_exists('xigg_xoops_search_base')) {
    function xigg_xoops_search_base($module_dirname, $keywords, $andor, $limit, $offset, $userid)
    {
        require dirname(__FILE__) . '/common.php';
        $model =& $xigg->locator->getService('Model');
        $criteria =& $model->createCriteria('Node');
        foreach ((array)$keywords as $keyword) {
            $keyword = stripslashes($keyword);
            $keyword_criteria =& Sabai_Model_Criteria::createComposite(array(Sabai_Model_Criteria::createString('node_teaser_html', $keyword)));
            $keyword_criteria->addOr(Sabai_Model_Criteria::createString('node_body_html', $keyword));
            $keyword_criteria->addOr(Sabai_Model_Criteria::createString('node_title', $keyword));
            if ($andor == 'AND') {
                $criteria->addAnd($keyword_criteria);
            } else {
                $criteria->addOr($keyword_criteria);
            }
            unset($keyword_criteria);
        }
        if (!empty($userid)) {
            $criteria->useridIs($userid);
        }
        $node_r =& $model->getRepository('Node');
        $nodes =& $node_r->fetchByCriteria($criteria, $limit, $offset, 'node_created', 'DESC');
        $ret = array();
        while ($node =& $nodes->getNext()) {
        $ret[] = array('link'  => 'index.php/node/' . $node->getId(),
                       'title' => $node->getLabel(),
                       'time'  => $node->getTimeCreated(),
                       'uid'   => $node->getUserId(),
		   );
        }
        return $ret;
    }
}