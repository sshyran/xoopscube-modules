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
class Sabai_Model_EntityCollection_Decorator_AssocEntities extends Sabai_Model_EntityCollection_Decorator
{
    var $_linkEntityName;
    var $_linkSelfKey;
    var $_assocEntityTable;
    var $_assocEntityName;
    var $_assocEntityNamePlural;
    var $_assocEntities;

    function Sabai_Model_EntityCollection_Decorator_AssocEntities($linkEntityName,
                                                                  $linkSelfKey,
                                                                  $assocEntityTable,
                                                                  $assocEntityName,
                                                                  &$collection)
    {
        parent::Sabai_Model_EntityCollection_Decorator($collection);
        $this->_linkEntityName = $linkEntityName;
        $this->_linkSelfKey = $linkSelfKey;
        $this->_assocEntityTable = $assocEntityTable;
        $this->_assocEntityName = $assocEntityName;
        $this->_assocEntityNamePlural = pluralize($assocEntityName);
    }

    function rewind()
    {
        $this->_collection->rewind();
        if (!isset($this->_assocEntities)) {
            $this->_assocEntities = array();
            if ($this->_collection->size() > 0) {
                $link_gw =& $this->_model->getGateway($this->_linkEntityName);
                $rs =& $link_gw->selectByCriteria(Sabai_Model_Criteria::createIn($this->_linkSelfKey,
                                                                                 $this->_collection->getAllIds()),
                                                                                 array(
                                                                                   $this->_linkSelfKey,
                                                                                   $this->_assocEntityTable . '.*'));
                while ($row = $rs->fetchAssoc()) {
                    $entity =& $this->_model->create($this->_assocEntityName);
                    $entity->initVars($row);
                    $this->_assocEntities[$row[$this->_linkSelfKey]][] =& $entity;
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
        $entities = !empty($this->_assocEntities[$id]) ? $this->_assocEntities[$id] : array();
        $current->setObject($this->_assocEntityNamePlural, $this->_model->createCollection($this->_assocEntityName, $entities));
        return $current;
    }
}