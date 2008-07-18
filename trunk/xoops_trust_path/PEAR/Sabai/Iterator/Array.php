<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Iterator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.2.1
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Iterator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.2.1
 */
class Sabai_Iterator_Array extends Sabai_Iterator
{
    var $_array;
    var $_key = 0;

    function Sabai_Iterator_Array($array)
    {
        $this->_array = $array;
    }

    function rewind()
    {
        $this->_key = 0;
    }

    /**
     * @return bool
     */
    function valid()
    {
        return array_key_exists($this->_key, $this->_array);
    }

    function next()
    {
        ++$this->_key;
    }

    /**
     * @return mixed
     */
    function &current()
    {
        return $this->_array[$this->_key];
    }

    /**
     * @return int
     */
    function key()
    {
        return $this->_key;
    }
}