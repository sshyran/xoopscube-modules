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
class Sabai_DB_SQLite extends Sabai_DB
{
    var $_resourceMode;

    /**
     * Constructor
     *
     * @return Sabai_DB_SQLite
     */
    function Sabai_DB_SQLite()
    {
        parent::Sabai_DB('SQLite');
    }

    /**
     * @access protected
     */
    function _connect($config)
    {
        $this->_resourceMode = isset($config['mode']) ? $config['mode'] : 0666;
        if (false === $link = sqlite_open($config['dbname'], $this->_resourceMode, $error)) {
            trigger_error(sprintf('Unable to connect to database server. ERROR: %s', $error), E_USER_WARNING);
            return false;
        }
        $this->_resourceId = $link;
        $this->_resourceName = $config['dbname'];
        return true;
    }

    function setClientEncoding($encoding)
    {
    }

    function beginTransaction()
    {
        return sqlite_exec($this->_resourceId, 'BEGIN');
    }

    function commit()
    {
        return sqlite_exec($this->_resourceId, 'COMMIT');
    }

    function rollback()
    {
        return sqlite_exec($this->_resourceId, 'ROLLBACK');
    }

    function &query($sql, $limit = 0, $offset = 0)
    {
        $ret = false;
        if (intval($limit) > 0) {
            $sql .=  sprintf(' OFFSET %d LIMIT %d', $offset, $limit);
        }
        if ($rs = sqlite_query($this->_resourceId, $sql)) {
            require_once 'Sabai/DB/Rowset/SQLite.php';
            $ret =& new Sabai_DB_Rowset_SQLite($rs);
        }
        return $ret;
    }

    function exec($sql)
    {
        if (!sqlite_exec($this->_resourceId, $sql)) {
            return false;
        }
        return true;
    }

    function affectedRows()
    {
        return sqlite_changes($this->_resourceId);
    }

    function lastInsertId($tableName, $keyName)
    {
        if (!$id = sqlite_last_insert_rowid($this->_resourceId)) {
            return false;
        }
        return $id;
    }

    function lastError()
    {
        $code = sqlite_last_error($this->_resourceId);
        return sprintf('%s(%s)', sqlite_error_string($code), $code);
    }

    function escapeBool($value)
    {
        return intval($value);
    }

    function escapeString($value)
    {
        return "'" . sqlite_escape_string($value) . "'";
    }

    function getMDB2SchemaDSN()
    {
        return sprintf('sqlite:///%s?mode=%s', rawurlencode($this->_resourceName), rawurlencode($this->_resourceMode));
    }
}

function sabai_db_unescapeBlob($value)
{
    return $value;
}