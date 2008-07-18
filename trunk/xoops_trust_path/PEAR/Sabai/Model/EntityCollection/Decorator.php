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

require_once 'Sabai/Model/EntityCollection.php';

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
class Sabai_Model_EntityCollection_Decorator extends Sabai_Model_EntityCollection
{
    /**
     * @access protected
     * @var Sabai_Model_EntityCollection
     */
    var $_collection;

    /**
     * Constructor
     *
     * @param Sabai_Model_EntityCollection $collection
     * @param Sabai_Model $model
     * @return Sabai_Model_EntityCollection_Decorator
     */
    function Sabai_Model_EntityCollection_Decorator(&$collection)
    {
        parent::Sabai_Model_EntityCollection($collection->getModel(), $collection->getName());
        $this->_collection =& $collection;
    }

    /**
     * Forwards a method call to the decorated object
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    function __call($method, $args)
    {
      return call_user_func_array(array($this->_collection, $method), $args);
    }

    function size()
    {
        return $this->_collection->size();
    }

    function rewind()
    {
        $this->_collection->rewind();
    }

    function valid()
    {
        return $this->_collection->valid();
    }

    function next()
    {
        return $this->_collection->next();
    }

    function key()
    {
        return $this->_collection->key();
    }

    function &current()
    {
        $current =& $this->_collection->current();
        return $current;
    }

    function update($values)
    {
        $this->_collection->update($values);
    }

    function delete()
    {
        $this->_collection->delete();
    }

    function getAllIds()
    {
        return $this->_collection->getAllIds();
    }

    function getObject($decorateName)
    {
        while ($entity =& $this->getNext()) {
            $ret =& $entity->get($decorateName);
        }
    }
}