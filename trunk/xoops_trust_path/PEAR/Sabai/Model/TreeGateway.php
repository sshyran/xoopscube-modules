<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Model/Gateway.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Model_TreeGateway extends Sabai_Model_Gateway
{
    function &selectByCriteria(&$criteria, $fields = array(), $limit = 0, $offset = 0, $sort = null,
                               $order = null, $group = null)
    {
        $ret = parent::selectByCriteria($criteria, $fields, $limit, $offset, array_merge((array)$sort, array('t1.tree_left')), array_merge((array)$order, array('ASC')));
        return $ret;
    }

    /**
     * @param string $id
     * @param array $fields
     * @return Sabai_DB_Rowset
     */
    function &selectDescendants($id, $fields = array())
    {
        $rs =& $this->selectBySQL($this->_getSelectDescendantsQuery($id, $fields), 0, 0, 't1.tree_left', 'ASC');
        return $rs;
    }

    /**
     * @param string $id
     * @param array $fields
     * @return Sabai_DB_Rowset
     */
    function &selectDescendantsAsTree($id, $fields = array())
    {
        $rs =& $this->selectBySQL($this->_getSelectDescendantsAsTreeQuery($id, $fields), 0, 0, 't1.tree_left', 'ASC');
        return $rs;
    }

    /**
     * @param string $id
     * @return int
     */
    function countDescendants($id)
    {
        $rs =& $this->_db->query($this->_getCountDescendantsQuery($id));
        return $rs->fetchSingle();
    }

    /**
     * @param array $ids
     * @return Sabai_DB_Rowset
     */
    function &countDescendantsByIds($ids)
    {
        $rs =& $this->_db->query($this->_getCountDescendantsByIdsQuery($ids));
        return $rs;
    }

    /**
     * @param string $id
     * @param array $fields
     * @return Sabai_DB_Rowset
     */
    function &selectParents($id, $fields = array())
    {
        $rs =& $this->selectBySQL($this->_getSelectParentsQuery($id, $fields), 0, 0, 't1.tree_left', 'ASC');
        return $rs;
    }

    /**
     * @param string $id
     * @return int
     */
    function countParents($id)
    {
        $rs =& $this->_db->query($this->_getCountParentsQuery($id));
        return $rs->fetchSingle();
    }

    /**
     * @param array $ids
     * @return Sabai_DB_Rowset
     */
    function &countParentsByIds($ids)
    {
        $rs =& $this->_db->query($this->_getCountParentsByIdsQuery($ids));
        return $rs;
    }
}