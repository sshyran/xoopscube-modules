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
class Sabai_DB
{
    /**
     * @var resource
     * @access protected
     */
    var $_resourceId;
    /**
     * @var string
     * @access protected
     */
    var $_resourceName;
    /**
     * @var string
     * @access protected
     */
    var $_resourcePrefix;

    /**
     * Createa an instance of Sabai_DB
     *
     * @static
     * @param string $scheme
     * @param string $prefix
     * @param string $clientEncoding
     * @param array $params
     * @param bool $triggerFatal
     * @return Sabai_DB
     */
    function &factory($scheme, $prefix, $clientEncoding = null, $params = array(), $triggerFatal = true)
    {
        $scheme = str_replace('sql', 'SQL', ucfirst(strtolower($scheme)));
        $class = 'Sabai_DB_' . $scheme;
        if (!class_exists($class)) {
            $file = 'Sabai/DB/' . $scheme . '.php';
            require $file;
        }
        $db =& new $class();
        if (!$db->_connect($params)) {
            trigger_error('Error occurred while connecting the database', E_USER_ERROR);
            $ret = false; return $ret;
        }
        $db->setResourcePrefix($prefix);
        $db->setClientEncoding($clientEncoding);
        return $db;
    }

    function Sabai_DB($scheme)
    {
        $this->_scheme = $scheme;
    }

    /**
     * Gets the name of database scheme
     *
     * @return resource
     */
    function getScheme()
    {
        return $this->_scheme;
    }

    /**
     * Gets the resource handle of datasource
     *
     * @return resource
     */
    function getResourceId()
    {
        return $this->_resourceId;
    }

    /**
     * Gets the name of datasource
     *
     * @return string
     */
    function getResourceName()
    {
        return $this->_resourceName;
    }

    /**
     * Gets the name of prefix used in datasource
     *
     * @return string
     */
    function getResourcePrefix()
    {
        return $this->_resourcePrefix;
    }

    /**
     * Sets the name of prefix used in datasource
     *
     * @param string $prefix
     */
    function setResourcePrefix($prefix)
    {
        $this->_resourcePrefix = $prefix;
    }

    /**
     * Checks whether triggers can be used
     *
     * @return bool
     */
    function isTriggerEnabled()
    {
        return true;
    }

    /**
     * Returns optional config varaibles for creating database tables, used by MDB2_Schema
     *
     * @return array
     */
    function getMDB2CreateTableOptions()
    {
        return array();
    }

    /**
     * @abstract
     */
    function _connect($params){}
    function beginTransaction(){}
    function commit(){}
    function rollback(){}
    function &query($sql, $limit = 0, $offset = 0){}
    function exec($sql, $useAffectedRows = true){}
    function affectedRows(){}
    function lastInsertId($tableName, $keyName){}
    function lastError(){}
    function escapeBool($value){}
    function escapeString($value){}
    function escapeBlob($value){}
    function setClientEncoding($encoding){}
    function getMDB2SchemaDSN(){}
}