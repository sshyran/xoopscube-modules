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
class Sabai_DB_Rowset_SQLite extends Sabai_DB_Rowset
{
    function fetchColumn($index = 0)
    {
        $ret = '';
        if ($row = sqlite_fetch_row($this->_rs)) {
            if (isset($row[$index])) {
                $ret = $row[$index];
            }
        }
        return $ret;
    }

    function fetchSingle()
    {
        return sqlite_fetch_single($this->_rs);
    }

    function fetchRow()
    {
        return sqlite_fetch_array($this->_rs, SQLITE_NUM);
    }

    function fetchAssoc()
    {
        return sqlite_fetch_array($this->_rs, SQLITE_ASSOC);
    }

    function fetchAll($mode = SABAI_DB_ROWSET_FETCHASSOC)
    {
        if (SABAI_DB_ROWSET_FETCHNUM == $mode) {
            return sqlite_fecth_all(SQLITE_NUM);
        } else {
            return sqlite_fetch_all(SQLITE_ASSOC);
        }
    }

    function seek($rowNum = 0)
    {
        sqlite_seek($rowNum);
    }

    function columnCount()
    {
        return sqlite_num_fields($this->_rs);
    }

    function rowCount()
    {
        return sqlite_num_rows($this->_rs);
    }
}