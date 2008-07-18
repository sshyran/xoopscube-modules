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

require_once 'Sabai/DB/MySQL.php';

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
class Sabai_DB_MySQLi extends Sabai_DB_MySQL
{
    /**
     * @access protected
     */
    function _connect($config)
    {
        $link = mysqli_init();
        $this->_resourcePort = isset($config['port']) ? intval($config['port']) : 3306;
        if (!mysqli_real_connect($link, $config['host'], $config['user'], $config['pass'], $config['dbname'], $this->_resourcePort, null, MYSQLI_CLIENT_FOUND_ROWS)) {
            trigger_error(sprintf('Unable to connect to database server. Error: %s(%s)', mysqli_connect_error(), mysqli_connect_errno()), E_USER_WARNING);
            return false;
        }
        if (!empty($config['charset']) && !mysqli_set_charset($link, $config['charset'])) {
            trigger_error(sprintf('Unable to set client character set to %s. Error: %s', mysqli_error($link), E_USER_WARNING));
            return false;
        }
        mysqli_autocommit($this->_resourceId, true);
        $this->_resourceId = $link;
        $this->_resourceName = $config['dbname'];
        $this->_resourceHost = $config['host'];
        $this->_resourceUser = $config['user'];
        $this->_resourceUserPassword = $config['pass'];
        return true;
    }

    function beginTransaction()
    {
        return mysqli_autocommit($this->_resourceId, false);
    }

    function commit()
    {
        $ret = mysqli_commit($this->_resourceId);
        mysqli_autocommit($this->_resourceId, true);
        return $ret;
    }

    function rollback()
    {
        $ret = mysqli_rollback($this->_resourceId);
        mysqli_autocommit($this->_resourceId, true);
        return $ret;
    }

    function &query($sql, $limit = 0, $offset = 0)
    {
        $ret = false;
        if (intval($limit) > 0) {
            $sql .=  sprintf(' LIMIT %d, %d', $offset, $limit);
        }
        if ($rs = mysqli_query($sql, $this->_resourceId)) {
            require_once 'Sabai/DB/Rowset/MySQLi.php';
            $ret =& new Sabai_DB_Rowset_MySQLi($rs);
        }
        return $ret;
    }

    function exec($sql)
    {
        if (!mysqli_query($sql, $this->_resourceId)) {
            return false;
        }
        return true;
    }

    function affectedRows()
    {
        return mysqli_affected_rows($this->_resourceId);
    }

    function lastInsertId($tableName, $keyName)
    {
        if (!$id = mysqli_insert_id($this->_resourceId)) {
            return false;
        }
        return $id;
    }

    function lastError()
    {
        return sprintf('%s(%s)', mysqli_error($this->_resourceId), mysqli_errno($this->_resourceId));
    }

    /**
     * Checks if the server version is at least the requested version
     *
     * @protected
     * @param string $base
     * @return bool
     */
    function _checkVersion($base) {
        $version = mysqli_get_server_version($this->_resourceId);
        if (false !== strpos($base, '.')) {
            $base = explode('.', $base);
            $base = $base[0] * 10000 + $base[1] * 100 + $base[2];
        }
        return  $version >= $base;
    }

    function getMDB2SchemaDSN()
    {
        return sprintf('mysqli://%s:%s@%s:%d/%s',
                           rawurlencode($this->_resourceUser),
                           rawurlencode($this->_resourceUserPassword),
                           rawurlencode($this->_resourceHost),
                           $this->_resourcePort,
                           rawurlencode($this->_resourceName));
    }
}