<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Page
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
 * @package    Sabai_Page
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Page_Collection extends Sabai_Iterator
{
    var $_perpage;
    var $_key;
    var $_elementCount;

    function Sabai_Page_Collection($perpage, $key = 0)
    {
        $this->_perpage = intval($perpage) ? $perpage : 10;
        $this->_key = $key;
    }

    /**
     * Gets the number of items per page
     *
     * @return int
     */
    function getPerPage()
    {
        return $this->_perpage;
    }

    /**
     * Gets a valid page. Returns the 1st page if the requested page does not exist.
     * Returns an empty page if no page exists.
     *
     * @param int $pageNum
     * @return Sabai_Page_Page
     */
    function &getValidPage($pageNum)
    {
        if (!$this->hasPage($pageNum)) {
            if (!$this->hasPage(1)) {
                $page =& $this->_getEmptyPage(1);
            } else {
                $page =& $this->getPage(1);
            }
        } else {
            $page =& $this->getPage($pageNum);
        }
        return $page;
    }

    function hasPage($pageNum)
    {
        if (0 >= $pageNum = intval($pageNum)) {
            return false;
        }
        $count = $this->getElementCount();
        return $count > ($pageNum - 1) * $this->_perpage;
    }

    function &getPage($pageNum)
    {
        $page = false;
        $count = $this->getElementCount();
        $offset = ($pageNum - 1) * $this->_perpage;
        if ($limit = ($count < $offset + $this->_perpage) ? $count - $offset : $this->_perpage) {
            $page =& $this->_getPage($pageNum, $limit, $offset);
        }
        return $page;
    }

    function getElementCount($recount = false)
    {
        if (!isset($this->_elementCount) || $recount) {
            $this->_elementCount = $this->_getElementCount();
        }
        return $this->_elementCount;
    }

    function getPageCount($recount = false)
    {
        return ceil($this->getElementCount($recount) / $this->_perpage);
    }

    function size()
    {
        return $this->getPageCount();
    }

    function rewind()
    {
        $this->_key = 0;
    }

    function valid()
    {
        return $this->hasPage($this->key() + 1);
    }

    function next()
    {
        ++$this->_key;
    }

    function &current(){
        $page =& $this->getPage($this->key() + 1);
        return $page;
    }

    function key(){
        return $this->_key;
    }

    function &_getEmptyPage($pageNum)
    {
        require_once 'Sabai/Page/Null.php';
        $page =& new Sabai_Page_Null($pageNum);
        return $page;
    }

    /**
     * @abstract
     */
    function &_getPage($pageNum, $limit, $offset){}
    function _getElementCount(){}
}