<?php
class Xigg_Model_CategoryGateway extends Xigg_Model_CategoryGatewayBase
{
    function getNodeCountSumById($categoryId)
    {
        $sql = sprintf('SELECT c2.tree_id, SUM(c3.category_node_count)
                        FROM %1$scategory_tree c1
                         INNER JOIN %1$scategory_tree c2
                          ON c1.tree_left BETWEEN c2.tree_left AND c2.tree_right
                         INNER JOIN %1$scategory c3
                          ON c1.tree_id = c3.category_id
                        WHERE c2.tree_id IN (%2$s)
                        GROUP BY c2.tree_id',
                        $this->_db->getResourcePrefix(),
                        implode(',', array_map('intval', (array)$categoryId)));
        if (!$rs =& $this->_db->query($sql)) {
            return false;
        }
        while ($row = $rs->fetchRow()) {
            $ret[$row[0]] = $row[1];
        }
        return $ret;
    }
}