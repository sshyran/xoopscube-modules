<?php
class Xigg_Model_View extends Xigg_Model_ViewBase
{
    function Xigg_Model_View(&$model)
    {
        parent::Xigg_Model_ViewBase($model);
    }
}

class Xigg_Model_ViewRepository extends Xigg_Model_ViewRepositoryBase
{
    function Xigg_Model_ViewRepository(&$model)
    {
        parent::Xigg_Model_ViewRepositoryBase($model);
    }

    /**
     * Checks which nodes has been viewed by a user
     *
     * @param array $nodeIds
     * @param Sabai_User $user
     * @return array
     */
    function checkByNodesAndUser($nodeIds, &$user)
    {
        $criteria =& Sabai_Model_Criteria::createValue('view_uid', $user->getId());
        $criterion =& Sabai_Model_Criteria::createComposite(array(&$criteria));
        $criterion->addAnd(Sabai_Model_Criteria::createIn('view_node_id', $nodeIds));
        $it =& $this->fetchByCriteria($criterion);
        $node_lastviews = array();
        while ($view =& $it->getNext()) {
            $node_lastviews[$view->getVar('node_id')] = $view->getVar('last');
        }
        return $node_lastviews;
    }
}