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

require_once 'Sabai/Page/Collection.php';

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
class Sabai_Page_Collection_Custom extends Sabai_Page_Collection
{
    var $_getElementCountFunc;
    var $_getElementsFunc;
    var $_extraParams;

    function Sabai_Page_Collection_Custom($getElementCountFunc, $getElementsFunc, $perpage, $extraParams = array(), $key = 0)
    {
        parent::Sabai_Page_Collection($perpage, $key);
        $this->_getElementCountFunc = $getElementCountFunc;
        $this->_getElementsFunc = $getElementsFunc;
        $this->_extraParams = $extraParams;
    }

    function &_getPage($pageNum, $limit, $offset)
    {
        require_once 'Sabai/Page/Custom.php';
        $page =& new Sabai_Page_Custom($this->_getElementsFunc, $this->_extraParams, $pageNum, $limit, $offset);
        return $page;
    }

    function _getElementCount()
    {
        return call_user_func_array($this->_getElementCountFunc, $this->_extraParams);
    }
}