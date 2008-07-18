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
class Sabai_Model_EntityCollection_Decorator_ForeignEntity extends Sabai_Model_EntityCollection_Decorator
{
    var $_foreignKey;
    var $_foreignEntityName;
    var $_foreignEntityPrimaryKey;
    var $_foreignEntities;

    function Sabai_Model_EntityCollection_Decorator_ForeignEntity($foreignKey,
                                                                  $foreignEntityName,
                                                                  $foreignEntityPrimaryKey,
                                                                  &$collection)
    {
        parent::Sabai_Model_EntityCollection_Decorator($collection);
        $this->_foreignKey = $foreignKey;
        $this->_foreignEntityName = $foreignEntityName;
        $this->_foreignEntityPrimaryKey = $foreignEntityPrimaryKey;
    }

    function rewind()
    {
        $this->_collection->rewind();
        if (!isset($this->_foreignEntities)) {
            $this->_foreignEntities = array();
            if ($this->_collection->size() > 0) {
                while ($entity =& $this->_collection->getNext()) {
                    $foreign_ids[$entity->getVar($this->_foreignKey)] = true;
                    unset($entity);
                }
                $foreign_r =& $this->_model->getRepository($this->_foreignEntityName);
                $it =& $foreign_r->fetchByCriteria(Sabai_Model_Criteria::createIn($this->_foreignEntityPrimaryKey,
                                                                               array_keys($foreign_ids)));
                $this->_foreignEntities = $it->getArray();
                $this->_collection->rewind();
            }
        }
    }

    function &current()
    {
        $current =& $this->_collection->current();
        $foreign_id = $current->getVar($this->_foreignKey);
        if (isset($this->_foreignEntities[$foreign_id])) {
            $current->setObject($this->_foreignEntityName, $this->_foreignEntities[$foreign_id]);
        }
        return $current;
    }
}