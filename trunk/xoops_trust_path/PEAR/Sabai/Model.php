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

define('SABAI_MODEL_COMMIT_ERROR_NONE', 0);
define('SABAI_MODEL_COMMIT_ERROR_NEW', 1);
define('SABAI_MODEL_COMMIT_ERROR_DIRTY', 2);
define('SABAI_MODEL_COMMIT_ERROR_REMOVED', 3);

define('SABAI_MODEL_KEY_TYPE_INT', 1);
define('SABAI_MODEL_KEY_TYPE_INT_NULL', 2);
define('SABAI_MODEL_KEY_TYPE_CHAR', 5);
define('SABAI_MODEL_KEY_TYPE_VARCHAR', 7);
define('SABAI_MODEL_KEY_TYPE_TEXT', 10);
define('SABAI_MODEL_KEY_TYPE_FLOAT', 15);
define('SABAI_MODEL_KEY_TYPE_BOOL', 20);
define('SABAI_MODEL_KEY_TYPE_BLOB', 25);

/**
 * Sabai_Model_Entity
 */
require 'Sabai/Model/Entity.php';
/**
 * Sabai_Model_EntityRepository
 */
require 'Sabai/Model/EntityRepository.php';
/**
 * Sabai_Model_EntityCollection_Rowset
 */
require 'Sabai/Model/EntityCollection/Array.php';
/**
 * Sabai_Model_EntityCollection_Rowset
 */
require 'Sabai/Model/EntityCollection/Rowset.php';
/**
 * Sabai_Model_Criteria
 */
require 'Sabai/Model/Criteria.php';
/**
 * Sabai_Model_Gateway
 */
require 'Sabai/Model/Gateway.php';

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
class Sabai_Model
{
    /**
     * @access private
     * @var Sabai_DB
     */
    var $_db;
    /**
     * @access private
     * @var array
     */
    var $_repositories = array();
    /**
     * @access private
     * @var array
     */
    var $_gateways = array();
    /**
     * @access private
     * @var array
     */
    var $_cache = array();
    /**
     * @access private
     * @var array
     */
    var $_entities = array();
    /**
     * @access private
     * @var array
     */
    var $_entityForms;
    /**
     * @access private
     * @var Sabai_Model_Entity
     */
    var $_commitErrorEntity;
    /**
     * @access private
     * @var int
     */
    var $_commitErrorType = SABAI_MODEL_COMMIT_ERROR_NONE;
    /**
     * @access protected
     * @var string
     */
    var $_modelPrefix;
    /**
     * Path to directory where compiled/custom model files are located
     *
     * @var string
     */
    var $_modelDir;
    /**
     * @access private
     * @var array
     */
    var $_serializedEntityNames;
    /**
     * @access private
     * @var array
     */
    var $_serializedEntities;
    /**
     * @access  private
     * @var  Sabai_User_IdentityFetcher
     */
    var $_userIdentityFetcher;

    /**
     * Constructor
     *
     * @param string $modelDir
     * @param string $modelPrefix
     * @return Sabai_Model
     */
    function Sabai_Model($modelDir, $modelPrefix)
    {
        $this->_modelDir = $modelDir;
        $this->_modelPrefix = $modelPrefix;
    }

    /**
     * Sets the directory where model files are stored, and returns the previous setting
     *
     * @param string $modelDir
     * @return string
     */
    function setModelDir($modelDir)
    {
        $previous = $this->_modelDir;
        $this->_modelDir = $modelDir;
        return $previous;
    }

    /**
     * PHP magic method called upon serialize()
     *
     * @return array
     */
    function __sleep()
    {
        $this->_serializedEntityNames = $this->_serializedEntities = array();
        foreach (array_keys($this->_entities) as $type) {
            foreach (array_keys($this->_entities[$type]) as $name) {
                $this->_serializedEntityNames[] = $name;
                foreach (array_keys($this->_entities[$type][$name]) as $id) {
                    if (is_object($this->_entities[$type][$name][$id])) {
                        // unset $_model to avoid recursive serialization, which will be set back upon __wakeup()
                        unset($this->_entities[$type][$name][$id]->_model);
                        $this->_serializedEntities[$type][$name][$id] = serialize($this->_entities[$type][$name][$id]);
                    }
                }
            }
        }
        return array('_cache', '_serializedEntityNames', '_serializedEntities', '_modelDir', '_modelPrefix');
    }

    /**
     * Magic method called upon unserialize()
     *
     */
    function __wakeup()
    {
        foreach ($this->_serializedEntityNames as $name) {
            $this->getRepository($name);
        }
        foreach (array_keys($this->_serializedEntities) as $type) {
            foreach (array_keys($this->_serializedEntities[$type]) as $name) {
                foreach (array_keys($this->_serializedEntities[$type][$name]) as $id) {
                    $this->_entities[$type][$name][$id] = unserialize($this->_serializedEntities[$type][$name][$id]);
                    $this->_entities[$type][$name][$id]->_model =& $this;
                }
            }
        }
        unset($this->_serializedEntityNames, $this->_serializedEntities);
    }

    /**
     * PHP magic method
     *
     * @param string $name
     * @return mixed
     */
    function __get($name)
    {
        $repository = $this->getRepository($name);
        return $repository;
    }

    /**
     * Sets an instance of Sabai_DB used in model
     *
     * @param Sabai_DB $db
     */
    function setDB(&$db)
    {
        $this->_db =& $db;
    }

    /**
     * Gets an instance of Sabai_Model_EntityRepository
     *
     * @param string $name
     * @return Sabai_Model_EntityRepository
     */
    function &getRepository($name)
    {
        $name_lc = strtolower($name);
        if (!isset($this->_repositories[$name_lc])) {
            $this->_repositories[$name_lc] =& $this->_getRepository($name);
        }
        return $this->_repositories[$name_lc];
    }

    /**
     * Gets an instance of Sabai_Model_EntityRepository
     *
     * @access protected
     * @param string $name
     * @return Sabai_Model_EntityRepository
     */
    function &_getRepository($name)
    {
        $class = $this->_modelPrefix . $name . 'Repository';
        if (!class_exists($class)) {
            $base = $this->_modelDir . '/' . $name;
            require $base . 'Base.php';
            require $base . '.php';
        }
        $repository =& new $class($this);
        return $repository;
    }

    /**
     * Gets an instance of Sabai_Model_Gateway
     *
     * @param string $name
     * @return Sabai_Model_Gateway
     */
    function &getGateway($name)
    {
        $name_lc = strtolower($name);
        if (!isset($this->_gateways[$name_lc])) {
            $this->_loadGateway($name, $name_lc);
        }
        return $this->_gateways[$name_lc];
    }

    /**
     * Loads an instance of Sabai_Model_Gateway
     *
     * @access protected
     * @param string $name
     * @param string $as
     * @return Sabai_Model_Gateway
     */
    function _loadGateway($name, $as)
    {
        $class = $this->_modelPrefix . $name . 'Gateway';
        if (!class_exists($class)) {
            $base = $this->_modelDir . '/' . $name;
            require $base . 'GatewayBase.php';
            require $base . 'Gateway.php';
        }
        $this->_gateways[$as] =& new $class();
        $this->_gateways[$as]->setDB($this->_db);
    }

    /**
     * Creates a collection of entity objects
     *
     * @param string $name
     * @param array $entities
     * @return Sabai_Model_EntityCollection
     */
    function &createCollection($name, $entities = array())
    {
        $repository =& $this->getRepository($name);
        $collection =& $repository->createCollection($entities);
        return $collection;
    }

    /**
     * Decorates a collection of entity objects
     *
     * @param Sabai_Model_EntityCollection $collection
     * @param string $with
     * @return Sabai_Model_EntityCollection
     */
    function &decorate(&$collection, $with)
    {
        $class = $this->_modelPrefix . $collection->getName() . 'With' . $with . 'Base';
        if (!class_exists($class)) {
            require $this->_modelDir . '/' . $collection->getName() . 'With' . $with . 'Base.php';
        }
        $collection =& new $class($collection);
        return $collection;
    }

    /**
     * Sets object to fetch user data
     *
     * @param Sabai_User_IdentityFetcher $userIdentityFetcher
     */
    function setUserIdentityFetcher(&$userIdentityFetcher)
    {
        // allow define only once
        if (!isset($this->_userIdentityFetcher)) {
            $this->_userIdentityFetcher =& $userIdentityFetcher;
        }
    }

    /**
     * Loads an identity object for each user
     *
     * @param array $userIds
     * @return array
     */
    function fetchUserIdentities($userIds)
    {
        // use default if not set
        if (!isset($this->_userIdentityFetcher)) {
            require_once 'Sabai/User/IdentityFetcher/Default.php';
            $this->_userIdentityFetcher =& new Sabai_User_IdentityFetcher_Default();
        }
        Sabai_Log::info('Sabai_Model::fetchUserIdentities() called for user id ' . implode(',', $userIds));
        return $this->_userIdentityFetcher->fetchUserIdentities($userIds);
    }

    /**
     * Converts Sabai_Model_Entity to Sabai_Model_EntityForm
     *
     * @param Sabai_Model_Entity $entity
     * @return Sabai_Model_EntityForm
     */
    function &toForm(&$entity, $params = array(), $force = false)
    {
        $name = $entity->getName();
        if (!isset($this->_entityForms[$name]) || $force) {
            $class = $this->_modelPrefix . $name . 'Form';
            if (!class_exists($class)) {
                require_once 'Sabai/Model/EntityForm.php';
                $base = $this->_modelDir . '/' . $name;
                require $base . 'FormBase.php';
                require $base . 'Form.php';
            }
            $this->_entityForms[$name] =& new $class($this);
            $this->_entityForms[$name]->onInit($params);
        }
        $form = clone($this->_entityForms[$name]);
        $form->setEntityId($entity->getId());
        $form->onEntity($entity);
        return $form;
    }

    /**
     * Gets an instance of Sabai_Model_EntityCriteria
     *
     * @param string $name
     * @return Sabai_Model_EntityCriteria
     */
    function &createCriteria($name)
    {
        $class = $this->_modelPrefix . $name . 'CriteriaBase';
        if (!class_exists($class)) {
            $base = $this->_modelDir . '/' . $name;
            require $base . 'CriteriaBase.php';
        }
        $criteria =& new $class();
        return $criteria;
    }

    /**
     * Gets an array of property names defined for a Sabai_Model_Entity class
     *
     * @param string $entityName
     * @return array
     */
    function getPropertyNamesFor($entityName)
    {
        $this->getRepository($entityName);
        $class = $this->_modelPrefix . $entityName . 'Base';
        return call_user_func(array($class, 'propertyNames'));
    }

    /**
     * Gets an array of local property names defined for a Sabai_Model_Entity class
     *
     * @param string $entityName
     * @return array
     */
    function getLocalPropertyNamesFor($entityName, $filter = array())
    {
        $this->getRepository($entityName);
        $class = $this->_modelPrefix . $entityName . 'Base';
        $ret = call_user_func(array($class, 'localPropertyNames'));
        if (!empty($filter)) {
            $ret = array_intersect_key($ret, array_flip($filter));
        }
        return $ret;
    }

    /**
     * Creates a new entity
     *
     * @param string $entityName
     * @return Sabai_Model_Entity
     */
    function &create($entityName)
    {
        $this->getRepository($entityName);
        $class = $this->_modelPrefix . $entityName;
        $entity =& new $class($this);
        return $entity;
    }

    /**
     * Caches an instance of Sabai_Model_Entity
     *
     * @param Sabai_Model_Entity $entity
     */
    function cache(&$entity)
    {
        if (!$id = $entity->getId()) {
            // invalid
            trigger_error('Cannot cache non-existent entity', E_USER_WARNING);
            return;
        }
        $this->_cache[$entity->getName()][$id] = $entity->getVars();
    }

    /**
     * Checks if an instance of Sabai_Model_Entity is cached by its ID
     *
     * @param string $entityName
     * @param string $id
     * @return mixed Sabai_Model_Entity if already cached, false if not
     */
    function &isCached($entityName, $id)
    {
        $ret = false;
        if (isset($this->_cache[$entityName][$id])) {
            $ret =& $this->create($entityName);
            $ret->initVars($this->_cache[$entityName][$id]);
        }
        return $ret;
    }

    /**
     * Clears cached instances of Sabai_Model_Entity
     *
     * @param string $entityName
     * @param string $id
     */
    function clearCache($entityName = null, $id = null)
    {
        if (isset($entityName)) {
            if (isset($id)) {
                unset($this->_cache[$entityName][$id]);
            } else {
                unset($this->_cache[$entityName]);
            }
        } else {
            $this->_cache = array();
        }
    }

    /**
     * Registers a new instance of Sabai_Model_Entity
     *
     * @param Sabai_Model_Entity $entity
     */
    function registerNew(&$entity)
    {
        if ($entity->getId()) {
            trigger_error(sprintf('Cannot add existent entity(ID:%s) as new', $entity->getId()), E_USER_WARNING);
            return;
        }
        if ($entity->getTempId()) {
            // already registered as new
            return;
        }
        $name = $entity->getName();
        if (!isset($this->_entities['new'][$name])) {
            $this->_entities['new'][$name] = array();
            $temp_id = 1;
        } else {
            $temp_id = count($this->_entities['new'][$name]) + 1;
        }
        $entity->setTempId($temp_id);
        $this->_entities['new'][$name][$temp_id] =& $entity;
    }

    /**
     * Registers a modified(drity) instance of Sabai_Model_Entity
     *
     * @param Sabai_Model_Entity $entity
     */
    function registerDirty(&$entity)
    {
        if ($entity->getTempId()) {
            // already registered as new
            return;
        }
        if (!$id = $entity->getId()) {
            // invalid
            return;
        }
        $name = $entity->getName();
        if (isset($this->_entities['removed'][$name][$id])) {
            // already removed
            return;
        }
        $this->_entities['dirty'][$name][$id] =& $entity;
    }

    /**
     * Registers a deleted instance of Sabai_Model_Entity
     *
     * @param Sabai_Model_Entity $entity
     */
    function registerRemoved(&$entity)
    {
        $name = $entity->getName();
        if ($temp_id = $entity->getTempId()) {
            // registered as new, so remove it from there
            unset($this->_entities['new'][$name][$temp_id]);
            return;
        }
        if (!$id = $entity->getId()) {
            // invalid
            trigger_error('Cannot register non-existent entity as removed', E_USER_WARNING);
            return;
        }
        if (isset($this->_entities['dirty'][$name][$id])) {
            unset($this->_entities['dirty'][$name][$id]);
        }
        $this->_entities['removed'][$name][$id] = & $entity;
    }

    /**
     * Commits pending Sabai_Model_Entity instances to the datasource
     *
     * @return mixed integer if success, false otherwise
     */
    function commit()
    {
        $this->_db->beginTransaction();
        // new entities should be commited first to properly create foreign key mapping
        if ((false === $new = $this->_commitNew()) ||
            (false === $removed = $this->_commitRemoved()) ||
            (false === $dirty = $this->_commitDirty())) {
            $this->_db->rollback();
            return false;
        }
        $this->_db->commit();
        $this->_entities = array();
        foreach (array_keys($this->_repositories) as $i) {
            $this->_repositories[$i]->clearCache();
        }
        $this->clearCache();
        return $new + $removed + $dirty;
    }

    function commitOne(&$entity)
    {
        $result = true;
        $name = $entity->getName();
        $this->_db->beginTransaction();
        if ($temp_id = $entity->getTempId()) {
            if (isset($this->_entities['new'][$name][$temp_id])) {
                unset($this->_entities['new'][$name][$temp_id]);
                $result = $this->_commitOneNew($this->getGateway($name), $entity);
            }
        } elseif ($id = $entity->getId()) {
            if (isset($this->_entities['dirty'][$name][$id])) {
                unset($this->_entities['dirty'][$name][$id]);
                $result = $this->_commitOneDirty($this->getGateway($name), $entity);
            } elseif (isset($this->_entities['removed'][$name][$id])) {
                unset($this->_entities['removed'][$name][$id]);
                $result = $this->_commitOneRemoved($this->getGateway($name), $entity);
            }
        }
        if (!$result) {
            $this->_db->rollback();
            return false;
        }
        $this->_db->commit();
        return 1;
    }

    function _commitOneNew(&$gateway, &$entity)
    {
        if (!$insert_id = $gateway->insert($entity->getVars())) {
            $this->_commitErrorEntity =& $entity;
            $this->_commitErrorType = SABAI_MODEL_COMMIT_ERROR_NEW;
            return false;
        }
        $entity->setVar('id', $insert_id, false);
        $this->_commitNewEntityAssign($entity);
        $entity->setTempId(false);
        return true;
    }

    function _commitOneDirty(&$gateway, &$entity)
    {
        if (!$gateway->update($entity->getId(), $entity->getVars())) {
            $this->_commitErrorEntity =& $entity;
            $this->_commitErrorType = SABAI_MODEL_COMMIT_ERROR_DIRTY;
            return false;
        }
        return true;
    }

    function _commitOneRemoved(&$gateway, &$entity)
    {
        if (!$gateway->delete($entity->getId(), $entity->getVars())) {
            $this->_commitErrorEntity =& $entity;
            $this->_commitErrorType = SABAI_MODEL_COMMIT_ERROR_REMOVED;
            return false;
        }
        return true;
    }

    /**
     * Gets a type of error occurred on commit
     *
     * @return int
     */
    function getCommitErrorType()
    {
        return $this->_commitErrorType;
    }

    /**
     * Gets an instance of Sabai_Model_Entity that produced error on commit
     *
     * @return Sabai_Model_Entity
     */
    function &getCommitErrorEntity()
    {
        return $this->_commitErrorEntity;
    }

    /**
     * Commits new entities to the datasource
     *
     * @return integer if success, false otherwise
     * @access private
     */
    function _commitNew()
    {
        $count = 0;
        if (!empty($this->_entities['new'])) {
            foreach (array_keys($this->_entities['new']) as $name) {
                $gateway =& $this->getGateway($name);
                foreach (array_keys($this->_entities['new'][$name]) as $id) {
                    if (!$this->_commitOneNew($gateway, $this->_entities['new'][$name][$id])) {
                        unset($this->_entities['new'][$name][$id]);
                        return false;
                    }
                    ++$count;
                }
            }
        }
        return $count;
    }

    /**
     * Commits modified entities to the datasource
     *
     * @return integer if success, false otherwise
     * @access private
     */
    function _commitDirty()
    {
        $count = 0;
        if (!empty($this->_entities['dirty'])) {
            foreach (array_keys($this->_entities['dirty']) as $name) {
                $gateway =& $this->getGateway($name);
                foreach (array_keys($this->_entities['dirty'][$name]) as $id) {
                    if (!$this->_commitOneDirty($gateway, $this->_entities['dirty'][$name][$id])) {
                        unset($this->_entities['dirty'][$name][$id]);
                        return false;
                    }
                    ++$count;
                }
            }
        }
        return $count;
    }

    /**
     * Commits deleted entities to the datasource
     *
     * @return mixed integer if success, false otherwise
     * @access private
     */
    function _commitRemoved()
    {
        $count = 0;
        if (!empty($this->_entities['removed'])) {
            foreach (array_keys($this->_entities['removed']) as $name) {
                $gateway =& $this->getGateway($name);
                if ($this->_db->isTriggerEnabled()) {
                    // do batch deletion if trigger is handled by the database
                    $criteria =& $this->createCriteria($name);
                    if (false === $gateway->deleteByCriteria($criteria->idIn(array_keys($this->_entities['removed'][$name])))) {
                        $this->_commitErrorType = SABAI_MODEL_COMMIT_ERROR_REMOVED;
                        $this->_commitErrorEntity =& $this->_entities['removed'][$name][0];
                        unset($this->_entities['removed'][$name]);
                        return false;
                    }
                    $count = $count + count($this->_entities['removed'][$name]);
                } else {
                    foreach (array_keys($this->_entities['removed'][$name]) as $id) {
                        if (!$this->_commitOneRemoved($gateway, $this->_entities['removed'][$name][$id])) {
                            unset($this->_entities['removed'][$name][$id]);
                            return false;
                        }
                        ++$count;
                    }
                }
            }
        }
        return $count;
    }

    /**
     * Assigns an entity to entities that reference this entity so that the new ID
     * is propagated properly to the refereencing entities
     *
     * @param Sabai_Model_Entity $entity
     * @access private
     */
    function _commitNewEntityAssign(&$entity)
    {
        if ($entities_to_assign = $entity->getEntitiesToAssign()) {
            $method = 'assign' . $entity->getName();
            foreach (array_keys($entities_to_assign) as $i) {
                $entities_to_assign[$i]->$method($entity);
            }
            $entity->clearEntitiesToAssign();
        }
    }
}