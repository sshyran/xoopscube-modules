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

define('SABAI_DB_ROWSET_FETCHNUM', 1);
define('SABAI_DB_ROWSET_FETCHASSOC', 2);

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
class Sabai_DB_Rowset /*implements IteratorAggregate*/
{
    /**
     * @access protected
     */
    var $_rs;

    /**
     * Constructor
     *
     * @access protected
     */
    function Sabai_DB_Rowset($rs)
    {
        $this->_rs = $rs;
    }

    /**
     * @return Sabai_Model_GatewayRecordsetIterator
     */
    function &getIterator()
    {
        require_once 'Sabai/DB/RowsetIterator.php';
        $it =& new Sabai_DB_RowsetIterator($this);
        return $it;
    }

    /**
     * @abstract
     * @param int $index
     * @return string
     */
    function fetchColumn($index){}
    /**
     * @abstract
     * @return string
     */
    function fetchSingle(){}
    /**
     * @abstract
     * @return array
     */
    function fetchAssoc(){}
    /**
     * @abstract
     * @return array
     */
    function fetchRow(){}
    /**
     * @abstract
     * @return array
     */
    function fetchAll($mode = SABAI_DB_ROWSET_FETCHASSOC){}
    /**
     * @abstract
     * @param int $rowNum
     * @return bool
     */
    function seek($rowNum = 0){}
    /**
     * @abstract
     * @return int
     */
    function columnCount(){}
    /**
     * @abstract
     * @return int
     */
    function rowCount(){}
}