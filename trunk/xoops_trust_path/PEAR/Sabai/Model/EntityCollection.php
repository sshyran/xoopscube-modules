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

require_once 'Sabai/Iterator.php';

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
class Sabai_Model_EntityCollection extends Sabai_Iterator
{
    var $_name;
    var $_model;
    var $_array;

    function Sabai_Model_EntityCollection(&$model, $name)
    {
        $this->_name = $name;
        $this->_model =& $model;
    }

    function getName()
    {
        return $this->_name;
    }

    function &getModel()
    {
        return $this->_model;
    }

    function &with($decoration)
    {
        $decorated =& $this->_model->decorate($this, $decoration);
        if (1 < $num = func_num_args()) {
            $args = func_get_args();
            $arr_current = $decorated->getArray();
            $with_current = array_shift($args);
            while ($with_next = array_shift($args)) {
                $method = '_fetch' . $with_current;
                $arr_next = array();
                foreach (array_keys($arr_current) as $i) {
                    if ($obj =& $arr_current[$i]->$method()) {
                        if (is_a($obj, 'Sabai_Model_EntityCollection')) {
                            while ($_obj =& $obj->getNext()) {
                                $arr_next[] =& $_obj;
                            }
                        } else {
                            $arr_next[] =& $obj;
                        }
                    }
                }
                if (empty($arr_next)) {
                    break;
                }
                // need to retrieve entity name like this since not all decoration names are an entity name (e.g. LastXxxxx)
                $entity_name = $arr_next[0]->getName();
                $_decorated =& $this->_model->decorate($this->_model->createCollection($entity_name, $arr_next), $with_next);

                // need to call this to actually decorate the entities
                $_decorated->getArray();

                $with_current = $with_next;
                $arr_current = $arr_next;
            }
        }
        return $decorated;
    }

    function size()
    {
        return 0;
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    function getAllIds()
    {
        return array_keys($this->getArray());
    }

    function getArray()
    {
        if (isset($this->_array)) {
            return $this->_array;
        }
        $this->_array = array();
        $this->rewind();
        while ($entity =& $this->getNext()) {
            $this->_array[$entity->getId()] =& $entity;
            unset($entity);
        }
        return $this->_array;
    }

    /**
     * Updates values of all the entities within the collection
     *
     * @param array $values
     */
    function update($values)
    {
        $this->rewind();
        while ($entity =& $this->getNext()) {
            $entity->setVars($values);
            unset($entity);
        }
    }

    /**
     * Mark all the entities within the collection from as removed
     */
    function delete()
    {
        $this->rewind();
        while ($entity =& $this->getNext()) {
            $entity->markRemoved();
            unset($entity);
        }
    }
}