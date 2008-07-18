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

require_once 'Sabai/Model/Page.php';

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
class Sabai_Model_EntityPage extends Sabai_Model_Page
{
    var $_entityName;
    var $_entityId;

    function Sabai_Model_EntityPage($pageNumber,
                                    &$repository,
                                    $entityName,
                                    $entityId,
                                    $sort,
                                    $order,
                                    $limit,
                                    $offset)
    {
        parent::Sabai_Model_Page($pageNumber, $repository, $sort, $order, $limit, $offset);
        $this->_entityName = $entityName;
        $this->_entityId = $entityId;
    }

    function &getElements()
    {
        $method = 'fetchBy' . $this->_entityName;
        $it =& $this->_repository->$method($this->_entityId,
                                           $this->_limit,
                                           $this->_offset,
                                           $this->_sort,
                                           $this->_order);
        return $it;
    }
}