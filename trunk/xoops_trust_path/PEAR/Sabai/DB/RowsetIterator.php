<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_DB
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
 * @package    Sabai_DB
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_DB_RowsetIterator extends Sabai_Iterator
{
    var $_rs;
    var $_key;
    var $_rows;

    function Sabai_DB_RowsetIterator(/*Sabai_DB_Rowset */&$rs)
    {
        $this->_rs =& $rs;
        $this->_key = 0;
        $this->_rows = array();
    }

    function rewind()
    {
        $this->_key = 0;
    }

    function valid()
    {
        return $this->_rs->seek($this->_key);
    }

    function next()
    {
        ++$this->_key;
    }

    function current()
    {
        return $this->_rs->fetchAssoc();
    }

    function key()
    {
        return $this->_key;
    }
}