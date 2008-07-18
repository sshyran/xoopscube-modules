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
class Sabai_Model_EntityCollection_Decorator_ParentEntitiesCount extends Sabai_Model_EntityCollection_Decorator
{
    var $_entityName;
    var $_parentEntitiesCount;

    function Sabai_Model_EntityCollection_Decorator_ParentEntitiesCount($entityName, &$collection)
    {
        parent::Sabai_Model_EntityCollection_Decorator($collection);
        $this->_entityName = $entityName;
    }

    function rewind()
    {
        $this->_collection->rewind();
        if (!isset($this->_parentEntitiesCount)) {
            $this->_parentEntitiesCount = array();
            if ($this->_collection->size() > 0) {
                $entity_r =& $this->_model->getRepository($this->_entityName);
                $this->_parentEntitiesCount = $entity_r->countParentsByIds($this->_collection->getAllIds());
                $this->_collection->rewind();
            }
        }
    }

    function &current()
    {
        $current =& $this->_collection->current();
        $id = $current->getId();
        $current->_parentsCount = isset($this->_parentEntitiesCount[$id]) ? $this->_parentEntitiesCount[$id] : 0;
        return $current;
    }
}