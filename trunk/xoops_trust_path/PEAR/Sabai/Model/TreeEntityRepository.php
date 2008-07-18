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

require_once 'Sabai/Model/EntityRepository.php';

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
class Sabai_Model_TreeEntityRepository extends Sabai_Model_EntityRepository
{
    /**
     * Constructor
     *
     * @param string $name
     * @param Sabai_Model $model
     * @return Sabai_Model_TreeEntityRepository
     */
    function Sabai_Model_TreeEntityRepository($name, &$model)
    {
        parent::Sabai_Model_EntityRepository($name, $model);
    }

    /**
     * Fetches all children entities
     *
     * @param string $id
     * @return Sabai_Model_EntityCollection
     */
    function &fetchDescendantsByParent($id)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        $it =& $this->_getCollection($gateway->selectDescendants($id, array()));
        return $it;
    }

    /**
     * Fetches all children entities with a 'level' value
     *
     * @param string $id
     * @return Sabai_Model_EntityCollection
     */
    function &fetchDescendantsAsTreeByParent($id)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        $it =& $this->_getCollection($gateway->selectDescendants($id, array()));
        require_once 'Sabai/Model/EntityCollection/Decorator/ParentEntitiesCount.php';
        $it =& new Sabai_Model_EntityCollection_Decorator_ParentEntitiesCount($this->getName(), $it, $this->_model);
        $it->rewind();
        // below uses subquery which is not supported in < MySQL 4.1
        // should we check version here?
        //$it =& $this->_getCollection($gateway->selectDescendantsAsTree($id, array()));
        return $it;
    }

    /**
     * Fetches all entities with a 'level' value
     *
     * @return Sabai_Model_EntityCollection
     */
    function &fetchAllAsTree()
    {
        $it =& $this->fetchAll();
        require_once 'Sabai/Model/EntityCollection/Decorator/ParentEntitiesCount.php';
        $it =& new Sabai_Model_EntityCollection_Decorator_ParentEntitiesCount($this->getName(), $it, $this->_model);
        $it->rewind();
        return $it;
    }

    /**
     * Counts all children entities
     *
     * @param string $id
     * @return int
     */
    function countDescendantsByParent($id)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        return $gateway->countDescendants($id);
    }

    /**
     * Fethces all parent entities
     *
     * @param string $id
     * @return Sabai_Model_EntityCollection
     */
    function &fetchParents($id)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        $it =& $this->_getCollection($gateway->selectParents($id, array()));
        return $it;
    }

    /**
     * Counts all parent entities
     *
     * @param string $id
     * @return int
     */
    function countParents($id)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        return $gateway->countParents($id);
    }

    /**
     * Counts all parent entities
     *
     * @param array $ids
     * @return array
     */
    function countParentsByIds($ids)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        $ret = array();
        if ($rs =& $gateway->countParentsByIds($ids)) {
            while ($row = $rs->fetchRow()) {
                $ret[$row[0]] = $row[1];
            }
        }
        return $ret;
    }

    /**
     * Counts all descendant entities
     *
     * @param array $ids
     * @return array
     */
    function countDescendantsByIds($ids)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        $ret = array();
        if ($rs =& $gateway->countDescendantsByIds($ids)) {
            while ($row = $rs->fetchRow()) {
                $ret[$row[0]] = $row[1];
            }
        }
        return $ret;
    }
}