<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_User
 * @subpackage IdentityFetcher
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @link
 * @since      File available since Release 0.1.8
*/

/**
 * Sabai_User_IdentityFetcher
 */
require_once 'User/IdentityFetcher.php';

/**
 * Fetches xoops user identity objects
 *
 * Fetches xoops user identity objects
 *
 * @category   Sabai
 * @package    Sabai_User
 * @subpackage IdentityFetcher
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @link
 * @since      Class available since Release 0.1.8
 */
class Sabai_User_IdentityFetcher_XOOPS extends Sabai_User_IdentityFetcher
{
    /**
     * @var string
     * @access protected
     */
    var $_xoopsURL;
    /**
     * @var string
     * @access protected
     */
    var $_dbName;
    /**
     * @var string
     * @access protected
     */
    var $_dbUser;
    /**
     * @var string
     * @access protected
     */
    var $_dbPass;
    /**
     * @var string
     * @access protected
     */
    var $_dbHost;
    /**
     * @var string
     * @access protected
     */
    var $_dbScheme;
    /**
     * @var string
     * @access protected
     */
    var $_dbPrefix;
    /**
     * @var string
     * @access protected
     */
    var $_dbClientEncoding;
    /**
     * @var Sabai_DB
     * @access protected
     */
    var $_db;

    /**
     * Constructor
     *
     * @param string $xoopsURL
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     * @param string $dbPrefix
     * @param string $dbHost
     * @param string $dbScheme
     * @param string $dbClientEncoding
     * @return Sabai_User_IdentityFetcher_XOOPS
     */
    function Sabai_User_IdentityFetcher_XOOPS($xoopsURL, $dbUser = 'root', $dbPass = '', $dbName = 'xoops',
                                            $dbPrefix = 'xoops', $dbHost = 'localhost', $dbScheme = 'mysql',
                                            $dbClientEncoding = SABAI_CHARSET)
    {
        parent::Sabai_User_IdentityFetcher('uid', 'uname');
        $this->_xoopsURL = $xoopsURL;
        $this->_dbUser = $dbUser;
        $this->_dbPass = $dbPass;
        $this->_dbName = $dbName;
        $this->_dbPrefix = $dbPrefix;
        $this->_dbHost = $dbHost;
        $this->_dbScheme = $dbScheme;
        $this->_dbClientEncoding = $dbClientEncoding;
    }

    function &_getDB()
    {
        if (!isset($this->_db)) {
            $options = array('host'   => $this->_dbHost,
                         'user'   => $this->_dbUser,
                         'pass'   => $this->_dbPass,
                         'dbName' => $this->_dbName);
            $this->_db =& Sabai_DB::factory($this->_dbScheme, $this->_dbPrefix, $this->_dbClientEncoding, $options);
        }
        return $this->_db;
    }

    function _doFetchUserIdentities($userids)
    {
        $users = array();
        $db =& $this->_getDB();
        $rs =& $db->query(sprintf('SELECT uid, uname, email, url, user_avatar FROM %s_users WHERE uid IN(%s)'),
                                 $db->getResourcePrefix(),
                                 implode(',', array_map('intval', $userids)));
        while ($row = $rs->fetchRow()) {
            $identity =& Sabai_User_Identity($row[0]);
            $identity->setName($row[1]);
            $identity->setEmail($row[2]);
            $identity->setProfileURL($this->_xoopsURL . '/userinfo.php?uid=' . $row[0]);
            $identity->setURL($row[3]);
            $identity->setImage($this->_xoopsURL . '/uploads/' . $row[4]);
            $users[$row[0]] =& $identity;
            unset($identity);
        }
        return $users;
    }

    function _doFetchIdentities($limit, $offset, $sort, $order)
    {
        $users = array();
        $db =& $this->_getDB();
        $sql = sprintf('SELECT uid, uname, email, url, user_avatar FROM %s_users ORDER BY %s %s', $db->getResourcePrefix(), $sort, $order);
        if ($rs =& $db->query($limit, $offset)) {
            while ($row = $rs->fetchRow()) {
                $identity =& Sabai_User_Identity($row[0]);
                $identity->setName($row[1]);
                $identity->setEmail($row[2]);
                $identity->setProfileURL($this->_xoopsURL . '/userinfo.php?uid=' . $row[0]);
                $identity->setURL($row[3]);
                $identity->setImage($this->_xoopsURL . '/uploads/' . $row[4]);
                $users[] =& $identity;
                unset($identity);
            }
        }
        return $users;
    }

    function countIdentities()
    {
        $db =& $this->_getDB();
        if ($rs =& $db->query(sprintf('SELECT COUNT(*) FROM %s_users', $db->getResourcePrefix()))) {
            return $rs->fetchSingle();
        }
        return 0;
    }
}