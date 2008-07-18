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

require_once 'Sabai/Page/Collection.php';

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
class Sabai_Model_PageCollection extends Sabai_Page_Collection
{
    var $_repository;
    var $_sort;
    var $_order;

    function Sabai_Model_PageCollection(&$repository, $perpage, $sort, $order, $key = 0)
    {
        parent::Sabai_Page_Collection($perpage, $key);
        $this->_repository =& $repository;
        $this->_sort = $sort;
        $this->_order = $order;
    }

    function &_getEmptyPage($pageNum)
    {
        require_once 'Sabai/Model/EmptyPage.php';
        $page =& new Sabai_Model_EmptyPage($pageNum, $this->_repository, $this->_sort, $this->_order, 0, 0);
        return $page;
    }
}