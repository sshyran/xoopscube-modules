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
 * @subpackage EntityCollection
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Model/EntityCollection/Decorator.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @subpackage EntityCollection
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Model_EntityCollection_Decorator_ChildEntities extends Sabai_Model_EntityCollection_Decorator
{
    var $_parentKey;
    var $_entityName;
    var $_childEntities;

    function Sabai_Model_EntityCollection_Decorator_ChildEntities($entityName,
                                                                  $parentKey,
                                                                  &$collection)
    {
        parent::Sabai_Model_EntityCollection_Decorator($collection);
        $this->_parentKey = $parentKey;
        $this->_entityName = $entityName;
    }

    function rewind()
    {
        $this->_collection->rewind();
        if (!isset($this->_childEntities)) {
            $this->_childEntities = array();
            if ($this->_collection->size() > 0) {
                $child_r =& $this->_model->getRepository($this->_entityName);
                $it =& $child_r->fetchByCriteria(Sabai_Model_Criteria::createIn($this->_parentKey,
                                                                                $this->_collection->getAllIds()));
                while ($entity =& $it->getNext()) {
                    $this->_childEntities[$entity->getParentId()][] =& $entity;
                    unset($entity);
                }
                $this->_collection->rewind();
            }
        }
    }

    function &current()
    {
        $current =& $this->_collection->current();
        $id = $current->getId();
        $entities = !empty($this->_childEntities[$id]) ? $this->_childEntities[$id] : array();
        $current->setObject('Children', $this->_model->createCollection($this->_entityName, $entities));
        return $current;
    }
}