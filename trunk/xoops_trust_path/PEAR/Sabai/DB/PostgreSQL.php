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
class Sabai_DB_PostgreSQL extends Sabai_DB
{
    var $_affectedRows;
    var $_resourceHost;
    var $_resourceUser;
    var $_resourceUserPassword;
    var $_resourcePort;

    /**
     * Constructor
     *
     * @return Sabai_DB_PostgreSQL
     */
    function Sabai_DB_PostgreSQL()
    {
        parent::Sabai_DB('PostgreSQL');
    }

    /**
     * @access protected
     */
    function _connect($config)
    {
        $this->_resourcePort = isset($config['port']) ? intval($config['port']) : 5432;
        $conn_str = sprintf('host=%s dbname=%s user=%s password=%s port=%d', $config['host'], $config['dbname'], $config['user'], $config['pass'], $this->_resourcePort);
        if (!$link = pg_connect($conn_str)) {
            trigger_error('Unable to connect to database server', E_USER_WARNING);
            return false;
        }
        $this->_resourceId = $link;
        $this->_resourceName = $config['dbname'];
        $this->_resourceHost = $config['host'];
        $this->_resourceUser = $config['user'];
        $this->_resourceUserPassword = $config['pass'];
        return true;
    }

    function setClientEncoding($encoding)
    {
        if (empty($encoding)) {
            return true;
        }
        //pg_set_client_encoding($this->_resourceId, $encoding);
        return true;
    }

    function beginTransaction()
    {
        return pg_query($this->_resourceId, 'BEGIN');
    }

    function commit()
    {
        return pg_query($this->_resourceId, 'COMMIT');
    }

    function rollback()
    {
        return pg_query($this->_resourceId, 'ROLLBACK');
    }

    function &query($sql, $limit = 0, $offset = 0)
    {
        $ret = false;
        if (intval($limit) > 0) {
            $sql .=  sprintf(' LIMIT %d OFFSET %d', $limit, $offset);
        }
        if ($rs = pg_query($this->_resourceId, $sql)) {
            require_once 'Sabai/DB/Rowset/PostgreSQL.php';
            $ret =& new Sabai_DB_Rowset_PostgreSQL($rs);
        }
        Sabai_Log::info(sprintf('SQL "%s" executed', $sql));
        return $ret;
    }

    function exec($sql)
    {
        if (!$result = pg_query($this->_resourceId, $sql)) {
            return false;
        }
        Sabai_Log::info(sprintf('SQL "%s" executed', $sql));
        $this->_affectedRows = pg_affected_rows($result);
        return true;
    }

    function affectedRows()
    {
        return $this->_affectedRows;
    }

    function lastInsertId($tableName, $keyName)
    {
        $sql = sprintf('SELECT last_value FROM %s_%s_seq', $tableName, $keyName);
        if (!$result = pg_query($sql)) {
            return false;
        }
        if (!$row = pg_fetch_row($result)) {
            return false;
        }
        return $row[0];
    }

    function lastError()
    {
        return pg_last_error($this->_resourceId);
    }

    function escapeBool($value)
    {
        return intval($value);
    }

    function escapeString($value)
    {
        return "'" . pg_escape_string($value) . "'";
    }

    function escapeBlob($value)
    {
        return "'" . pg_escape_bytea($value) . "'";
    }

    function getMDB2SchemaDSN()
    {
        return sprintf('pgsql://%s:%s@%s:%d/%s',
                       rawurlencode($this->_resourceUser),
                       rawurlencode($this->_resourceUserPassword),
                       rawurlencode($this->_resourceHost),
                       $this->_resourcePort,
                       rawurlencode($this->_resourceName));
    }
}

function sabai_db_unescapeBlob($value)
{
    return pg_unescape_bytea($value);
}