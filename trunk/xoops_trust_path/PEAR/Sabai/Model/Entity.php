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
class Sabai_Model_Entity
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
     * @var bool
     */
    var $_autoMarkDirty = true;
    /**
     * @access private
     * @var array
     */
    var $_vars = array();
    /**
     * @access private
     * @var array
     */
    var $_objects = array();
    /**
     * @access private
     * @var string
     */
    var $_tempId = false;
    /**
     * Entities that this entity should be assigned on commit
     * @access private
     * @var array
     */
    var $_entitiesToAssign = array();
    /**
     * Emtities that should be assigned to this entity on commit
     * @access protected
     * @var array
     */
    var $_entitiesToBeAssigned = array();

    /**
     * Constructor
     *
     * @param string $name
     * @param Sabai_Model $model
     * @return Sabai_Model_Entity
     */
    function Sabai_Model_Entity($name, &$model)
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
     * Shortcut method for getting the related Sabai_Model_EntityRepository object
     *
     * @access protected
     * @return Sabai_Model_EntityRepository
     */
    function &_getRepository()
    {
        $repository =& $this->_model->getRepository($this->getName());
        return $repository;
    }

    /**
     * @param string $value
     */
    function setTempId($value)
    {
        $this->_tempId = $value;
    }

    /**
     * @return string
     */
    function getTempId()
    {
        return $this->_tempId;
    }

    /**
     * @param string $key
     * @return mixed
     */
    function &get($key)
    {
        $ret =& $this->__get($key);
        return $ret;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    function set($key, $value)
    {
        $this->__set($key, $value);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function getVar($name)
    {
        return $this->_getVar($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param bool $markDirty
     */
    function setVar($name, $value, $markDirty = true)
    {
        if ($this->_setVar($name, $value)) {
            if ($markDirty && $this->_autoMarkDirty) {
                $this->markDirty();
            }
        }
    }

    /**
     * Sets an object related to this entity
     *
     * @param string $name
     * @param object $object
     */
    function setObject($name, &$object)
    {
        $this->_objects[$name] =& $object;
    }

    /**
     * Workaround for setting an entity object in PHP4
     *
     * @param string $key
     * @param Sabai_Model_Entity $entity
     */
    function setEntity($key, &$entity)
    {
        $this->__set($key, array(&$entity));
    }

    /**
     * @param bool $value
     */
    function setAutoMarkDirty($value = true)
    {
        $this->_autoMarkDirty = $value;
    }

    /**
     * @return bool
     */
    function getAutoMarkDirty()
    {
        return $this->_autoMarkDirty;
    }

    /**
     */
    function markNew()
    {
        $this->_model->registerNew($this);
    }

    /**
     */
    function markDirty()
    {
        $this->_model->registerDirty($this);
    }

    /**
     */
    function markRemoved()
    {
        $this->_model->registerRemoved($this);
        // this is so that no entities can be assigned during commit
        $this->_entitiesToBeAssigned = array();
    }

    /**
     */
    function cache()
    {
        $repository =& $this->_getRepository();
        $repository->cacheEntity($this);
    }

    /**
     * @return array
     */
    function getVars()
    {
        return $this->_vars;
    }

    /**
     * @param array $arr
     */
    function setVars($arr)
    {
        if (!$this->getAutoMarkDirty()) {
            $this->_setVars($arr);
        } else {
            $this->setAutoMarkDirty(false);
            $this->_setVars($arr);
            $this->markDirty();
            $this->setAutoMarkDirty(true);
        }
    }

    /**
     * @access protected
     * @param array $arr
     */
    function _setVars($arr)
    {
        foreach (array_keys($arr) as $name) {
            $this->setVar($name, $arr[$name]);
        }
    }

    /**
     * @param array $arr
     */
    function initVars($arr)
    {
        foreach (array_keys($arr) as $name) {
            $this->initVar($name, $arr[$name]);
        }
    }

    /**
     * @abstract
     */
    function loadRow($row = array()){}
    function getId(){}
    function setId($value){}
    function getLabel(){}
    function setLabel($value){}
    function getTimeUpdated(){}

    /**
     * @return Sabai_Form
     * @param array $params
     * @param bool $force
     */
    function &toForm($params = array(), $force = false)
    {
        $form =& $this->_model->toForm($this, $params, $force);
        return $form;
    }

    /**
     * @access protected
     * @param string $entityName
     * @param string $foreignKey
     * @return Sabai_Model_Entity
     */
    function &_fetchEntity($entityName, $foreignKey)
    {
        $entity = false;
        if ($id = $this->getVar($foreignKey)) {
            $r =& $this->_model->getRepository($entityName);
            if (!$entity =& $r->fetchById($id)) {
                // warn because this should not happen usually
                Sabai_Log::warn(sprintf('%s entity with ID %d does not exist', $entityName, $id), __FILE__, __LINE__);
            }
        } else {
            Sabai_Log::info(sprintf('No %s entity assigned for the requested entity', $entityName), __FILE__, __LINE__);
        }
        return $entity;
    }

    /**
     * @access protected
     * @param string $foreignKey
     * @param Sabai_Model_Entity $entity
     */
    function _assignEntity($foreignKey, &$entity)
    {
        if (!$id = $entity->getId()) {
            if (!$temp_id = $entity->getTempId()) {
                $entity->markNew();
                $temp_id = $entity->getTempId();
            }
            $entity->addEntityToAssign($this);
            $this->_entitiesToBeAssigned[$foreignKey] = $temp_id;
        } else {
            if ($this->getVar($foreignKey) == $id) {
                trigger_error(sprintf('Trying to assign an already assigned %s entity, skipping operation',
                                      $entity->getName()),
                              E_USER_NOTICE);
            } else {
                if ($temp_id = $entity->getTempId()) {
                    // temp id is set, meaning that the entity is being assigned on commit
                    // check if we are really allowed to assgin this entity
                    if (!isset($this->_entitiesToBeAssigned[$foreignKey]) ||
                               $this->_entitiesToBeAssigned[$foreignKey] != $temp_id) {
                        return;
                    }
                }
                $this->setVar($foreignKey, $id);
            }
        }
    }

    /**
     * @access protected
     * @return bool
     */
    function _unassignEntity($foreignKey)
    {
        if (isset($this->_entitiesToBeAssigned[$foreignKey])) {
            unset($this->_entitiesToBeAssigned[$foreignKey]);
        }
        $this->set($foreignKey, null);
        return true;
    }

    /**
     * @access protected
     * @param string $entityName
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_EntityCollection_Rowset
     */
    function &_fetchEntities($entityName, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $repository =& $this->_model->getRepository($entityName);
        $method = 'fetchBy' . $this->getName();
        $it =& $repository->$method($this->getId(), $limit, $offset, $sort, $order);
        return $it;
    }

    /**
     * @access protected
     * @param string $entityName
     * @param int $perpage
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_PageCollection_Entity
     */
    function &_paginateEntities($entityName, $perpage = 10, $sort = null, $order = null)
    {
        $repository =& $this->_model->getRepository($entityName);
        $method = 'paginateBy' . $this->getName();
        $it =& $repository->$method($this->getId(), $perpage, $sort, $order);
        return $it;
    }

    /**
     * @access protected
     * @param string $entityName
     * @return int
     */
    function _countEntities($entityName)
    {
        if (!$id = $this->getId()) {
            return 0;
        }
        $repository =& $this->_model->getRepository($entityName);
        $method = 'countBy' . $this->getName();
        return $repository->$method($id);
    }

    /**
     * @access protected
     * @param Sabai_Model_Entity $entity
     * @return bool
     */
    function _addEntity(&$entity)
    {
        $method = 'assign' . $this->getName();
        $entity->$method($this);
    }

    /**
     * @access protected
     * @param string $targetPrimaryKey
     * @param string $entityName
     * @param string $id
     * @return int
     */
    function _removeEntityById($targetPrimaryKey, $entityName, $id)
    {
        $repository =& $this->_model->getRepository($entityName);
        $method = 'fetchBy' . $this->getName() . 'AndCriteria';
        $it =& $repository->$method($this->getId(), Sabai_Model_Criteria::createValue($targetPrimaryKey, $id));
        while ($target =& $it->getNext()) {
            $method = 'unassign' . $this->getName();
            $target->$method($this);
            unset($target);
        }
        return $it->size();
    }

    /**
     * @access protected
     * @param string $entityName
     * @return int
     */
    function _removeEntities($entityName)
    {
        $it =& $this->_fetchEntities($entityName);
        $method = 'unassign' . $this->getName();
        while ($entity =& $it->getNext()) {
            $entity->$method($this);
            unset($entity);
        }
        return $it->size();
    }

    /**
     * @access protected
     * @param string $entityName
     * @return Sabai_Model_Entity
     */
    function &_createEntity($entityName)
    {
        $entity =& $this->_model->create($entityName);
        $method = 'add' . $entityName;
        $this->$method($entity);
        return $entity;
    }

    /**
     * @access protected
     * @param string $linkEntityName
     * @param string $linkTargetKey
     * @param string $id
     * @return object Sabai_Model_Entity
     */
    function &_linkEntityById($linkEntityName, $linkTargetKey, $id)
    {
        if (!$id = intval($id)) {
            trigger_error('Invalid entity ID', E_USER_ERROR);
        }
        $link =& $this->_model->create($linkEntityName);
        $method = 'assign' . $this->getName();
        $link->$method($this);
        $link->setVar($linkTargetKey, $id);
        $link->markNew();
        return $link;
    }

    /**
     * @access protected
     * @param string $linkEntityName
     * @param string $linkSelfKey
     * @param string $linkTargetKey
     * @param string $id
     */
    function _unlinkEntityById($linkEntityName, $linkSelfKey, $linkTargetKey, $id)
    {
        if (!$id = intval($id)) {
            trigger_error('Invalid entity ID', E_USER_ERROR);
        }
        $repository =& $this->_model->getRepository($linkEntityName);
        $criteria =& Sabai_Model_Criteria::createComposite();
        $criteria->addAnd(Sabai_Model_Criteria::createValue($linkSelfKey, $this->getId()));
        $criteria->addAnd(Sabai_Model_Criteria::createValue($linkTargetKey, $id));
        $it =& $repository->fetchByCriteria($criteria);
        while ($link =& $it->getNext()) {
            $link->markRemoved();
            unset($link);
        }
        return $it->size();
    }

    /**
     * @access protected
     * @param string $linkEntityName
     */
    function _unlinkEntities($linkEntityName)
    {
        $repository =& $this->_model->getRepository($linkEntityName);
        $method = 'fetchBy' . $this->getName();
        $it =& $repository->$method($this->getId());
        while ($link =& $it->getNext()) {
            $link->markRemoved();
            unset($link);
        }
        return $it->size();
    }

    /**
     * @param Sabai_Model_Entity $entity
     */
    function addEntityToAssign(&$entity)
    {
        $this->_entitiesToAssign[] =& $entity;
    }

    /**
     */
    function clearEntitiesToAssign()
    {
        $this->_entitiesToAssign = array();
    }

    /**
     * @return array
     */
    function getEntitiesToAssign()
    {
        return $this->_entitiesToAssign;
    }

    /**
     * Commits the changes made to this entity. You must call markNew() or markRemoved()
     * prior to this method to insert or delete this entity.
     *
     * @return bool
     */
    function commit()
    {
        return $this->_model->commitOne($this) === 1;
    }

    /**
     * Fill entity with form values
     *
     * @param Sabai_Model_EntityForm $form
     */
    function applyForm(&$form)
    {
        // A dirty way to call a method on a decorated object.
        // This should not be needed in PHP5 + __call()
        while (is_a($form, 'sabai_form_decorator')) {
            $form =& $form->undecorate();
        }
        $form->onFillEntity($this);
    }

    /**
     * A quick utility method to creates a form with an embedded token
     *
     * @param string $tokenId
     * @param array $params
     * @param bool $force
     * @return Sabai_Form_Decorator_Token
     */
    function &toTokenForm($tokenId, $params = array(), $force = false)
    {
        $form =& $this->toForm($params, $force);
        require_once 'Sabai/Form/Decorator/Token.php';
        $form =& new Sabai_Form_Decorator_Token($form, $tokenId);
        return $form;
    }
}