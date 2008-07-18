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
class Sabai_Model_EntityCollection_Rowset extends Sabai_Model_EntityCollection
{
    /**
     * @access protected
     */
    var $_rs;
    var $_emptyEntity;
    var $_key;
    var $_entities;
    var $_size;

    function Sabai_Model_EntityCollection_Rowset($name, &$rs, &$emptyEntity, &$model, $key = 0)
    {
        parent::Sabai_Model_EntityCollection($model, $name);
        $this->_rs =& $rs;
        $this->_emptyEntity =& $emptyEntity;
        $this->_key = $key;
    }

    function size()
    {
        if (!is_object($this->_rs)) {
            return 0;
        }
        if (!isset($this->_size)) {
            $this->_size = $this->_rs->rowCount();
        }
        return $this->_size;
    }

    function rewind()
    {
        $this->_key = 0;
    }

    function valid()
    {
        if (!is_object($this->_rs)) {
            return false;
        }
        if (!isset($this->_entities[$this->_key])) {
            if (!$this->_rs->seek($this->_key)) {
                return false;
            }
            $this->_entities[$this->_key] = clone($this->_emptyEntity);
            $this->_loadRow($this->_entities[$this->_key], $this->_rs->fetchAssoc());
        }
        return true;
    }

    function next()
    {
        ++$this->_key;
    }

    function &current()
    {
        return $this->_entities[$this->_key];
    }

    function _loadRow(&$entity, $row){}

    function key()
    {
        return $this->_key;
    }
}