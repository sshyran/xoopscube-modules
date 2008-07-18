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
class Sabai_Model_CriteriaPage extends Sabai_Model_Page
{
    /**
     * @var Sabai_Model_Criteria
     * @access protected
     */
    var $_criteria;

    /**
     * Constructor
     *
     * @param int $pageNumber
     * @param Sabai_Model_EntityRepository $repository
     * @param Sabai_Model_Criteria $criteria
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @return Sabai_Model_CriteriaPage
     */
    function Sabai_Model_CriteriaPage($pageNumber, &$repository, &$criteria, $sort, $order, $limit, $offset)
    {
        parent::Sabai_Model_Page($pageNumber, $repository, $sort, $order, $limit, $offset);
        $this->_criteria =& $criteria;
    }

    /**
     * Returns a collection of entities within the page
     *
     * @return Sabai_Model_EntityCollection
     */
    function &getElements()
    {
        $it =& $this->_repository->fetchByCriteria($this->_criteria,
                                                   $this->_limit,
                                                   $this->_offset,
                                                   $this->_sort,
                                                   $this->_order);
        return $it;
    }
}