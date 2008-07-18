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
 * @since      File available since Release 0.1.1
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
 * @since      Class available since Release 0.1.1
 */
class Sabai_Iterator
{
    function rewind(){}

    /**
     * @return bool
     */
    function valid(){
        return false;
    }

    function next(){}

    /**
     * @return mixed
     */
    function &current(){
        $ret = null;
        return $ret;
    }

    /**
     * @return int
     */
    function key(){
        return 0;
    }

    /**
     * @return mixed
     */
    function &getFirst()
    {
        $ret = false;
        $this->rewind();
        if ($this->valid()) {
            $ret =& $this->current();
        }
        return $ret;
    }

    /**
     * @return mixed
     */
    function &getNext()
    {
        $ret = false;
        if ($this->valid()) {
            $ret =& $this->current();
            $this->next();
        }
        return $ret;
    }
}