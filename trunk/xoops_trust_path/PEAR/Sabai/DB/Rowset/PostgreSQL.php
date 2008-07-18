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
 * @subpackage Rowset
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/DB/Rowset.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_DB
 * @subpackage Rowset
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_DB_Rowset_PostgreSQL extends Sabai_DB_Rowset
{
    function fetchColumn($index = 0)
    {
        $ret = '';
        if ($row = pg_fetch_row($this->_rs)) {
            if (isset($row[$index])) {
                $ret = $row[$index];
            }
        }
        return $ret;
    }

    function fetchSingle()
    {
        return $this->fetchColumn(0);
    }

    function fetchRow()
    {
        return pg_fetch_row($this->_rs);
    }

    function fetchAssoc()
    {
        return pg_fetch_assoc($this->_rs);
    }

    function fetchAll($mode = SABAI_DB_ROWSET_FETCHASSOC)
    {
        $ret = array();
        switch ($mode) {
            case SABAI_DB_ROWSET_FETCHNUM:
                while ($row = pg_fetch_row($this->_rs)) {
                    $ret[] = $row;
                }
                break;
            default:
                if ($result = pg_fetch_all($this->_rs)) {
                    return $result;
                }
        }
        return $ret;
    }

    function seek($rowNum = 0)
    {
        return pg_result_seek($this->_rs, $rowNum);
    }

    function columnCount()
    {
        return pg_num_fields($this->_rs);
    }

    function rowCount()
    {
        return pg_num_rows($this->_rs);
    }
}