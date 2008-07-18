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

// mysql_affeceted_rows() returns 0 if no data is modified
// even there was a match, not desirable for implementing
// the optimistic offline locking pattern. We can change this
// by supplying the following constant to mysql_connect()
if (!defined('MYSQL_CLIENT_FOUND_ROWS')) {
    define('MYSQL_CLIENT_FOUND_ROWS', 2);
}

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
class Sabai_DB_MySQL extends Sabai_DB
{
    /**
     * @access protected
     * @var string
     */
    var $_charset;
    var $_resourceHost;
    var $_resourceUser;
    var $_resourceUserPassword;

    /**
     * Constructor
     *
     * @return Sabai_DB_MySQL
     */
    function Sabai_DB_MySQL()
    {
        parent::Sabai_DB('MySQL');
    }

    /**
     * Connects to the mysql server and DB
     *
     * @access protected
     * @param array $config
     */
    function _connect($config)
    {
        $link = mysql_connect($config['host'], $config['user'], $config['pass'], true, MYSQL_CLIENT_FOUND_ROWS);
        if ($link === false) {
            trigger_error(sprintf('Unable to connect to database server @%s', $config['host']), E_USER_WARNING);
            return false;
        }
        if (!mysql_select_db($config['dbname'], $link)) {
            trigger_error(sprintf('Unable to connect to database %s', $config['dbname']), E_USER_WARNING);
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
        static $mysql_charsets = array('BIG5'       => 'big5',
                                       'EUC-JP'     => 'ujis',
                                       'EUC-KR'     => 'euckr',
                                       'GB2312'     => 'gb2312',
                                       'UTF-8'      => 'utf8',
                                       'TIS-620'    => 'tis620',
                                       'ISO-8859-2' => 'latin2',
                                       'SHIFT_JIS'  => 'sjis');
        if (empty($encoding)) {
            return true;
        }
        $encoding = strtoupper($encoding);
        if (isset($mysql_charsets[$encoding])) {
            $this->_charset = $mysql_charsets[$encoding];
            return mysql_query('SET NAMES ' . $this->_charset, $this->_resourceId);
        }
        return true;
    }

    /**
     * Begins transaction
     *
     * @return bool
     */
    function beginTransaction()
    {
        return mysql_query('START TRANSACTION', $this->_resourceId);
    }

    /**
     * Commits changes made to the database
     *
     * @return bool
     */
    function commit()
    {
        return mysql_query('COMMIT', $this->_resourceId);
    }

    /**
     * Rollbacks the commit
     *
     * @return bool
     */
    function rollback()
    {
        return mysql_query('ROLLBACK', $this->_resourceId);
    }

    /**
     * Queries the database
     *
     * @param string $sql
     * @param int $limit
     * @param int $offset
     * @return Sabai_DB_Rowset_MySQL
     */
    function &query($sql, $limit = 0, $offset = 0)
    {
        $ret = false;
        if (intval($limit) > 0) {
            $sql .=  sprintf(' LIMIT %d, %d', $offset, $limit);
        }
        if ($rs = mysql_query($sql, $this->_resourceId)) {
            require_once 'Sabai/DB/Rowset/MySQL.php';
            $ret =& new Sabai_DB_Rowset_MySQL($rs);
            Sabai_Log::info(sprintf('SQL "%s" executed', $sql));
        } else {
            Sabai_Log::warn(sprintf('SQL "%s" failed. Error: "%s"', $sql, $this->lastError()));
        }
        return $ret;
    }

    /**
     * Executes an SQL query against the DB
     *
     * @param string $sql
     * @param bool $useAffectedRows
     * @return bool
     */
    function exec($sql, $useAffectedRows = true)
    {
        if (!mysql_query($sql, $this->_resourceId)) {
            Sabai_Log::warn(sprintf('SQL "%s" failed. Error: "%s"', $sql, $this->lastError()));
            return false;
        }
        Sabai_Log::info(sprintf('SQL "%s" executed', $sql));
        if ($useAffectedRows) {
            // updating 0 row will also return true, so need to count the affected rows
            return mysql_affected_rows($this->_resourceId);
        }
        return true;
    }

    /**
     * Gets the primary key of te last inserted row
     *
     * @param string $tableName
     * @param string $keyName
     * @return string
     */
    function lastInsertId($tableName, $keyName)
    {
        if (!$id = mysql_insert_id($this->_resourceId)) {
            // return false when $id is 0 or false
            return false;
        }
        return $id;
    }

    /**
     * Gets the number of affected rows
     *
     * @return int
     */
    function affectedRows()
    {
        return mysql_affected_rows($this->_resourceId);
    }

    /**
     * Gets the last error occurred
     *
     * @return string
     */
    function lastError()
    {
        return sprintf('%s(%s)', mysql_error($this->_resourceId), mysql_errno($this->_resourceId));
    }

    /**
     * Escapes a boolean value for MySQL DB
     *
     * @param bool $value
     * @return int
     */
    function escapeBool($value)
    {
        return intval($value);
    }

    /**
     * Escapes a string value for MySQL DB
     *
     * @param string $value
     * @return string
     */
    function escapeString($value)
    {
        return "'" . mysql_real_escape_string($value, $this->_resourceId) . "'";
    }

    /**
     * Escapes a blob value for MySQL DB
     *
     * @param string $value
     * @return string
     */
    function escapeBlob($value)
    {
        return $this->escapeString($value);
    }

    /**
     * Checks if the server version is at least the requested version
     *
     * @protected
     * @param string $base
     * @return bool
     */
    function _checkVersion($base) {
        static $version;
        if (!isset($version)) {
            $version = mysql_get_server_info($this->_resourceId);
            $version = explode('.', substr($version, 0, strpos($version, '-')));
            $version = $version[0] * 10000 + $version[1] * 100 + $version[2];
        }
        if (false !== strpos($base, '.')) {
            $base = explode('.', $base);
            $base = $base[0] * 10000 + $base[1] * 100 + $base[2];
        }
        return $version >= $base;
    }

    function isTriggerEnabled()
    {
        return false;
        return $this->_checkVersion(50106);
    }

    function getMDB2SchemaDSN()
    {
        return sprintf('mysql://%s:%s@%s/%s',
                       rawurlencode($this->_resourceUser),
                       rawurlencode($this->_resourceUserPassword),
                       rawurlencode($this->_resourceHost),
                       rawurlencode($this->_resourceName));
    }

    /**
     * Returns optional config varaibles for creating database tables, used by MDB2_Schema
     *
     * @return array
     */
    function getMDB2CreateTableOptions()
    {
        // Character set support is from MySQL 4.1.0
        // MDB2 does not check the version, so it must be done here
        if ($this->_checkVersion(40100)) {
            return array('type' => 'InnoDB', 'charset' => $this->_charset, 'collate' => null);
        }
        return array('type' => 'InnoDB');
    }
}
function sabai_db_unescapeBlob($value)
{
    return $value;
}