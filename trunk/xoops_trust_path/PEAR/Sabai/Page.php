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
 * @since      File available since Release 0.1.10
*/

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
 * @since      Class available since Release 0.1.10
 */
class Sabai_Page
{
    var $_pageNumber;
    var $_limit;
    var $_offset;

    function Sabai_Page($pageNumber, $limit = 0, $offset = 0)
    {
        $this->_pageNumber = $pageNumber;
        $this->_limit = $limit;
        $this->_offset = $offset;
    }

    function getPageNumber()
    {
        return $this->_pageNumber;
    }

    function getLimit()
    {
        return $this->_limit;
    }

    function getOffset()
    {
        return $this->_offset;
    }

    function &getElements(){}
}