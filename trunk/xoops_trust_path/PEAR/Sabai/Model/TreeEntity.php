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

require_once 'Sabai/Model/Entity.php';

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
class Sabai_Model_TreeEntity extends Sabai_Model_Entity
{

    var $left;
    var $right;
    var $_parentsCount; // Sabai_Model_EntityCollection_Decorator_ParentEntitiesCount
    var $_descendantsCount; // Sabai_Model_EntityCollection_Decorator_DescendantEntitiesCount

    /**
     * Constructor
     *
     * @param string $name
     * @param Sabai_Model $model
     * @return Sabai_Model_TreeEntity
     */
    function Sabai_Model_TreeEntity($name, &$model)
    {
        parent::Sabai_Model_Entity($name, $model);
    }

    function &children()
    {
        $children =& $this->_fetchChildren();
        return $children;
    }

    /**
     * This function is required for multi decorating using Sabai_Model_EntityCollection::with()
     */
    function &_fetchChildren()
    {
        if (!isset($this->_objects['Children'])) {
            $repository =& $this->_getRepository();
            $this->_objects['Children'] =& $repository->fetchByParent($this->getId());
        }
        return $this->_objects['Children'];
    }

    /**
     * Retrieves all child entities of this entity
     *
     * @return Sabai_Model_EntityCollection
     */
    function &descendants()
    {
        $repository =& $this->_getRepository();
        $it =& $repository->fetchDescendantsByParent($this->getId());
        return $it;
    }

    /**
     * Retrieves all child entities of this entity
     *
     * @return Sabai_Model_EntityCollection
     */
    function &descendantsAsTree()
    {
        $repository =& $this->_getRepository();
        $it =& $repository->fetchDescendantsAsTreeByParent($this->getId());
        return $it;
    }

    /**
     * Gets the number of all first-level child entities
     *
     * @return int
     */
    function childrenCount()
    {
        $repository =& $this->_getRepository();
        return $repository->countByParent($this->getId());
    }

    /**
     * Gets the number of all (or first-level) child entities
     *
     * @return int
     */
    function descendantsCount()
    {
        if (!isset($this->_descendantsCount)) {
            $repository =& $this->_getRepository();
            $this->_descendantsCount = $repository->countDescendantsByParent($this->getId());
        }
        return $this->_descendantsCount;
    }

    /**
     * Retrieves all parent entities of this entity
     *
     * @return Sabai_Model_EntityCollection
     */
    function &parents()
    {
        if (!isset($this->_objects['Parents'])) {
            $repository =& $this->_getRepository();
            $this->_objects['Parents'] =& $repository->fetchParents($this->getId());
        }
        return $this->_objects['Parents'];
    }

    /**
     * Gets the number of all parent entities for this entity
     *
     * @return int
     */
    function parentsCount()
    {
        if (!isset($this->_parentsCount)) {
            $repository =& $this->_getRepository();
            $this->_parentsCount = $repository->countParents($this->getId());
        }
        return $this->_parentsCount;
    }

    /**
     * Creates a new child entity
     *
     * @return mixed Sabai_Model_TreeEntity on success, false on failure
     */
    function &createChild()
    {
        if (!$this->getId()) {
            trigger_error(sprintf('Cannot create a new child entity for a non-existent %s entity',
                                  $this->getName()),
                          E_USER_WARNING);
            $ret = false; return $ret;
        }
        $child =& $this->_model->create($this->getName());
        $child->assignParent($this);
        return $child;
    }

    /**
     * Checks if the entity is a leaf node in the tree
     *
     * @return bool
     */
    function isLeaf()
    {
        return ($this->left + 1 == $this->right);
    }
}