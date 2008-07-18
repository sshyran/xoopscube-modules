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
class Sabai_Model_EntityRepository
{
    /**
     * @access private
     * @var string
     */
    var $_name;
    /**
     * @access protected
     * @var Sabai_Model
     */
    var $_model;
    /**
     * @access private
     * @var array
     */
    var $_entityCache = array();

    function Sabai_Model_EntityRepository($name, &$model)
    {
        $this->_name = $name;
        $this->_model =& $model;
    }

    /**
     * @return string
     */
    function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $id
     * @return bool
     */
    function &isEntityCached($id)
    {
        if (isset($this->_entityCache[$id])) {
            return $this->_entityCache[$id];
        }
        $ret = false;
        return $ret;
    }

    /**
     * @param Sabai_Model_Entity
     */
    function cacheEntity(&$entity)
    {
        $this->_entityCache[$entity->getId()] =& $entity;
    }

    /**
     */
    function clearCache()
    {
        $this->_entityCache = array();
    }

    /**
     * @param string $id
     * @return Sabai_Model_Entity
     */
    function &fetchById($id)
    {
        if (!$entity =& $this->isEntityCached($id)) {
            if (!$entity =& $this->_model->isCached($this->getName(), $id)) {
                $gateway =& $this->_model->getGateway($this->getName());
                $it =& $this->_getCollection($gateway->selectById($id));
                $entity =& $it->getNext();
            }
        }
        return $entity;
    }

    /**
     * @param Sabai_Model_Criteria
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_EntityCollection_Rowset
     */
    function &fetchByCriteria(&$criteria, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        $it =& $this->_getCollection($gateway->selectByCriteria($criteria,
                                                                array(),
                                                                $limit,
                                                                $offset,
                                                                $sort,
                                                                $order));
        return $it;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_EntityCollection_Rowset
     */
    function &fetchAll($limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $ret =& $this->fetchByCriteria(Sabai_Model_Criteria::createEmpty(), $limit, $offset, $sort, $order);
        return $ret;
    }

    /**
     * @param Sabai_Model_Criteria
     * @param string $group
     * @return int
     */
    function countByCriteria(&$criteria, $group = null)
    {
        $gateway =& $this->_model->getGateway($this->getName());
        return $gateway->countByCriteria($criteria, $group);
    }

    /**
     * @return int
     * @param string $group
     */
    function countAll($group = null)
    {
        return $this->countByCriteria(Sabai_Model_Criteria::createEmpty(), $group);
    }

    /**
     * @param Sabai_Model_Criteria $criteria
     * @param int $perpage
     * @param string $sort
     * @param string $order
     * @param string $group
     * @return Sabai_Model_PageCollection_Criteria
     */
    function &paginateByCriteria(&$criteria, $perpage = 10, $sort = null, $order = null)
    {
        require_once 'Sabai/Model/PageCollection/Criteria.php';
        $it =& new Sabai_Model_PageCollection_Criteria($this, $criteria, $perpage, $sort, $order);
        return $it;
    }

    /**
     * @param Sabai_Model_Criteria $criteria
     * @param int $perpage
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_PageCollection_Criteria
     */
    function &paginateAll($perpage = 10, $sort = null, $order = null)
    {
        $it =& $this->paginateByCriteria(Sabai_Model_Criteria::createEmpty(), $perpage, $sort, $order);
        return $it;
    }

    /**
     * Helper method for fetching entitie pages by foreign key relationship
     *
     * @access protected
     * @param string $entityName
     * @param string $id
     * @param int $perpage
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_PageCollection_Entity
     */
    function &_paginateByEntity($entityName, $id, $perpage = 10, $sort = null, $order = null)
    {
        require_once 'Sabai/Model/PageCollection/Entity.php';
        $it =& new Sabai_Model_PageCollection_Entity($this, $entityName, $id, $perpage, $sort, $order);
        return $it;
    }

    /**
     * Helper method for fetching entitie pages by entitiy id and criteria
     *
     * @access protected
     * @param string $entityName
     * @param string $id
     * @param Sabai_Model_Criteria
     * @param int $perpage
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_PageCollection_Entity
     */
    function &_paginateByEntityAndCriteria($entityName, $id, &$criteria, $perpage = 10, $sort = null, $order = null)
    {
        require_once 'Sabai/Model/PageCollection/EntityCriteria.php';
        $it =& new Sabai_Model_PageCollection_EntityCriteria($this, $entityName, $id, $criteria, $perpage, $sort, $order);
        return $it;
    }

    /**
     * Helper method for fetching entities by foreign key relationship
     *
     * @access protected
     * @param string $foreignKey
     * @param string $id
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_PageCollection_Entity
     */
    function &_fetchByForeign($foreignKey, $id, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        if (is_array($id)) {
            $criteria =& Sabai_Model_Criteria::createIn($foreignKey, $id);
        } else {
            $criteria =& Sabai_Model_Criteria::createValue($foreignKey, $id);
        }
        $it =& $this->fetchByCriteria($criteria, $limit, $offset, $sort, $order);
        return $it;
    }

    /**
     * Helper method for counting entities by foreign key relationship
     *
     * @access protected
     * @param string $foreignKey
     * @param string $id
     * @param string $group
     * @return int
     */
    function _countByForeign($foreignKey, $id, $group = null)
    {
        if (is_array($id)) {
            $criteria =& Sabai_Model_Criteria::createIn($foreignKey, $id);
        } else {
            $criteria =& Sabai_Model_Criteria::createValue($foreignKey, $id);
        }
        return $this->countByCriteria($criteria, $group);
    }

    /**
     * Helper method for fetching entities by foreign key relationship
     *
     * @access protected
     * @param string $foreignKey
     * @param string $id
     * @param Sabai_Model_Criteria $criteria
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_PageCollection_Entity
     */
    function &_fetchByForeignAndCriteria($foreignKey, $id, &$criteria, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $criterion =& Sabai_Model_Criteria::createComposite(array(&$criteria));
        if (is_array($id)) {
            $criterion->addAnd(Sabai_Model_Criteria::createIn($foreignKey, $id));
        } else {
            $criterion->addAnd(Sabai_Model_Criteria::createValue($foreignKey, $id));
        }
        $it =& $this->fetchByCriteria($criterion, $limit, $offset, $sort, $order);
        return $it;
    }

    /**
     * Helper method for counting entities by foreign key relationship
     *
     * @access protected
     * @param string $foreignKey
     * @param string $id
     * @param Sabai_Model_Criteria
     * @param string $group
     * @return int
     */
    function _countByForeignAndCriteria($foreignKey, $id, &$criteria, $group = null)
    {
        $criterion =& Sabai_Model_Criteria::createComposite(array(&$criteria));
        if (is_array($id)) {
            $criterion->addAnd(Sabai_Model_Criteria::createIn($foreignKey, $id));
        } else {
            $criterion->addAnd(Sabai_Model_Criteria::createValue($foreignKey, $id));
        }
        return $this->countByCriteria($criterion, $group);
    }

    /**
     * Helper method for fetching entities by association table relationship
     *
     * @access protected
     * @param string $selfTable
     * @param string $assocEntity
     * @param string $assocTargetKey
     * @param string $id
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_EntityCollection_Rowset
     */
    function &_fetchByAssoc($selfTable,
                            $assocEntity,
                            $assocTargetKey,
                            $id,
                            $limit = 0,
                            $offset = 0,
                            $sort = null,
                            $order = null)
    {
        $gateway =& $this->_model->getGateway($assocEntity);
        if (is_array($id)) {
            $criteria =& Sabai_Model_Criteria::createIn($assocTargetKey, $id);
        } else {
            $criteria =& Sabai_Model_Criteria::createValue($assocTargetKey, $id);
        }
        $it =& $this->_getCollection($gateway->selectByCriteria($criteria,
                                                                array('DISTINCT ' . $selfTable . '.*'),
                                                                $limit,
                                                                $offset,
                                                                $sort,
                                                                $order));
        return $it;
    }

    /**
     * Helper method for counting entities by association table relationship
     *
     * @access protected
     * @param string $selfTableId
     * @param string $assocEntity
     * @param string $id
     * @param string $group
     * @return int
     */
    function _countByAssoc($selfTableId, $assocEntity, $assocTargetKey, $id, $group = null)
    {
        $gateway =& $this->_model->getGateway($assocEntity);
        if (is_array($id)) {
            $criteria =& Sabai_Model_Criteria::createIn($assocTargetKey , $id);
        } else {
            $criteria =& Sabai_Model_Criteria::createValue($assocTargetKey, $id);
        }
        $rs =& $gateway->selectByCriteria($criteria, array('COUNT(DISTINCT '. $selfTableId .')'));
        return $rs->fetchSingle();
    }

    /**
     * Helper method for fetching entities by association table relationship
     * and additional criteria
     *
     * @access protected
     * @param string $selfTable
     * @param string $assocEntity
     * @param string $assocTargetKey
     * @param string $id
     * @param Sabai_Model_Criteria
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @param string $group
     * @return Sabai_Model_EntityCollection_Rowset
     */
    function &_fetchByAssocAndCriteria($selfTable, $assocEntity, $assocTargetKey, $id, &$criteria, $limit = 0,
                                       $offset = 0, $sort = null, $order = null)
    {
        $gateway =& $this->_model->getGateway($assocEntity);
        $criterion =& Sabai_Model_Criteria::createComposite(array(&$criteria));
        if (is_array($id)) {
            $criterion->addAnd(Sabai_Model_Criteria::createIn($assocTargetKey, $id));
        } else {
            $criterion->addAnd(Sabai_Model_Criteria::createValue($assocTargetKey, $id));
        }
        $it =& $this->_getCollection($gateway->selectByCriteria($criterion,
                                                                array('DISTINCT ' . $selfTable . '.*'),
                                                                $limit,
                                                                $offset,
                                                                $sort,
                                                                $order));
        return $it;
    }

    /**
     * Helper method for counting entities by association table relationship
     * and additional criteria
     *
     * @access protected
     * @param string $selfTableId
     * @param string $assocEntity
     * @param string $id
     * @param Sabai_Model_Criteria
     * @param string $group
     * @return Sabai_Model_EntityCollection_Rowset
     */
    function _countByAssocAndCriteria($selfTableId, $assocEntity, $assocTargetKey, $id, &$criteria, $group = null)
    {
        $gateway =& $this->_model->getGateway($assocEntity);
        $criterion =& Sabai_Model_Criteria::createComposite(array(&$criteria));
        if (is_array($id)) {
            $criterion->addAnd(Sabai_Model_Criteria::createIn($assocTargetKey, $id));
        } else {
            $criterion->addAnd(Sabai_Model_Criteria::createValue($assocTargetKey, $id));
        }
        $rs =& $gateway->selectByCriteria($criterion, array('COUNT(DISTINCT '. $selfTableId .')'), $group);
        return $rs->fetchSingle();
    }

    function &_getCollection(&$rs)
    {
        if (!$rs) {
            $collection =& $this->createCollection();
        } else {
            $collection =& $this->_getCollectionByRowset($rs);
        }
        return $collection;
    }

    /**
     * @abstract
     * @access protected
     * @param Sabai_DB_Rowset $rs
     * @return Sabai_Model_EntityCollection
     */
    function &_getCollectionByRowset(&$rs){}
    /**
     * @abstract
     * @access protected
     * @param array $entities
     * @return Sabai_Model_EntityCollection
     */
    function &createCollection($entities = array()){}
}