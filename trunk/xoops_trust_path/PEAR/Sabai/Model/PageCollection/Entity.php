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
 * @subpackage PageCollection
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Model/PageCollection.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @subpackage PageCollection
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Model_PageCollection_Entity extends Sabai_Model_PageCollection
{
    var $_entityName;
    var $_entityId;

    function Sabai_Model_PageCollection_Entity(&$repository, $entityName, $entityId, $perpage, $sort, $order)
    {
        parent::Sabai_Model_PageCollection($repository, $perpage, $sort, $order);
        $this->_entityName = $entityName;
        $this->_entityId = $entityId;
    }

    function &_getPage($pageNum, $limit, $offset)
    {
        require_once 'Sabai/Model/EntityPage.php';
        $page =& new Sabai_Model_EntityPage($pageNum,
                                            $this->_repository,
                                            $this->_entityName,
                                            $this->_entityId,
                                            $this->_sort,
                                            $this->_order,
                                            $limit,
                                            $offset);
        return $page;
    }

    function _getElementCount()
    {
        $method = 'countBy' . $this->_entityName;
        return $this->_repository->$method($this->_entityId);
    }
}