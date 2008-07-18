<?php
class Xigg_Model_Vote extends Xigg_Model_VoteBase
{
    function Xigg_Model_Vote(&$model)
    {
        parent::Xigg_Model_VoteBase($model);
    }
}

class Xigg_Model_VoteRepository extends Xigg_Model_VoteRepositoryBase
{
    function Xigg_Model_VoteRepository(&$model)
    {
        parent::Xigg_Model_VoteRepositoryBase($model);
    }

    /**
     * Counts number of votes based on node and user
     *
     * @param int $nodeId
     * @param Sabai_User $user
     * @return int
     */
    function countByNodeAndUser($nodeId, &$user)
    {
        $criteria =& Sabai_Model_Criteria::createValue('vote_userid', $user->getId());
        return $this->countByNodeAndCriteria($nodeId, $criteria);
    }

    /**
     * Checks which nodes has been voted by a user
     *
     * @param array $nodeIds
     * @param Sabai_User $user
     * @param string $ip
     * @return array
     */
    function checkByNodesAndUser($nodeIds, &$user, $ip = null)
    {
        $criteria =& Sabai_Model_Criteria::createValue('vote_userid', $user->getId());
        $criterion =& Sabai_Model_Criteria::createComposite(array(&$criteria));
        $criterion->addAnd(Sabai_Model_Criteria::createIn('vote_node_id', $nodeIds));
        if (!empty($ip)) {
            $criterion->addAnd(Sabai_Model_Criteria::createValue('vote_ip', $ip));
        }
        $it =& $this->fetchByCriteria($criterion);
        $node_ids = array();
        while ($vote =& $it->getNext()) {
            $node_ids[] = $vote->getVar('node_id');
        }
        return $node_ids;
    }
}