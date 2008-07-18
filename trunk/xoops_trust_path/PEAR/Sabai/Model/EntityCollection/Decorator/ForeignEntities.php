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
class Sabai_Model_EntityCollection_Decorator_ForeignEntities extends Sabai_Model_EntityCollection_Decorator
{
    var $_foreignSelfKey;
    var $_foreignEntityName;
    var $_foreignEntityNamePlural;
    var $_foreignEntities;

    function Sabai_Model_EntityCollection_Decorator_ForeignEntities($foreignSelfKey,
                                                                    $foreignEntityName,
                                                                    &$collection)
    {
        parent::Sabai_Model_EntityCollection_Decorator($collection);
        $this->_foreignSelfKey = $foreignSelfKey;
        $this->_foreignEntityName = $foreignEntityName;
        $this->_foreignEntityNamePlural = pluralize($foreignEntityName);
    }

    function rewind()
    {
        $this->_collection->rewind();
        if (!isset($this->_foreignEntities)) {
            $this->_foreignEntities = array();
            if ($this->_collection->size() > 0) {
                $foreign_r =& $this->_model->getRepository($this->_foreignEntityName);
                $it =& $foreign_r->fetchByCriteria(Sabai_Model_Criteria::createIn($this->_foreignSelfKey,
                                                                                  $this->_collection->getAllIds()));
                $foreign_var = substr($this->_foreignSelfKey, strpos('_', $this->_foreignSelfKey + 1));
                while ($entity =& $it->getNext()) {
                    $this->_foreignEntities[$entity->getVar($foreign_var)][] =& $entity;
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
        $entities = !empty($this->_foreignEntities[$id]) ? $this->_foreignEntities[$id] : array();
        $current->setObject($this->_foreignEntityNamePlural, $this->_model->createCollection($this->_foreignEntityName, $entities));
        return $current;
    }
}