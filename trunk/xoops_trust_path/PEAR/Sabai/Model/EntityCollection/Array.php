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
class Sabai_Model_EntityCollection_Array extends Sabai_Model_EntityCollection
{
    var $_entities;
    var $_index;

    function Sabai_Model_EntityCollection_Array(&$model, $name, $entities = array(), $index = 0)
    {
        parent::Sabai_Model_EntityCollection($model, $name);
        $this->_entities = $entities;
        $this->_index = $index;
    }

    function size()
    {
        return count($this->_entities);
    }

    function rewind()
    {
        $this->_index = 0;
    }

    /**
     * @return bool
     */
    function valid(){
        return array_key_exists($this->_index, $this->_entities);
    }

    function next()
    {
        ++$this->_index;
    }

    /**
     * @return Sabai_ModelEntity
     */
    function &current(){
        return $this->_entities[$this->_index];
    }

    /**
     * @return int
     */
    function key(){
        return $this->_index;
    }
}