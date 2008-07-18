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
 * @subpackage Authenticator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Sabai_User_Authenticator_Auth
 */
require_once 'Sabai/User/Authenticator/Auth.php';

/**
 * Authenticates a XOOPS account
 *
 * This class uses PEAR Auth and DB_Lite Auth_Container to connect to local/remote database server
 * where XOOPS user data is hosted.
 *
 * @category   Sabai
 * @package    Sabai_User
 * @subpackage Authenticator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_User_Authenticator_Auth_XOOPS extends Sabai_User_Authenticator_Auth
{
    /**
     * Constructor
     *
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     * @param string $dbPrefix
     * @param string $dbHost
     * @param string $dbScheme
     * @return Sabai_User_Authenticator_Auth_XOOPS
     */
    function Sabai_User_Authenticator_Auth_XOOPS($dbUser = 'root', $dbPass = '', $dbName = 'xoops',
                                            $dbPrefix = 'xoops', $dbHost = 'localhost', $dbScheme = 'mysql')
    {
        $options = array('table'       => $dbPrefix . '_users',
                         'usernamecol' => 'uname',
                         'passwordcol' => 'pass',
                         'dsn'         => sprintf('%s://%s:%s@%s/%s', $dbScheme, $dbUser, $dbPass, $dbHost, $dbName),
                         'db_fields'   => '*');
        parent::Sabai_User_Authenticator_Auth(new Auth('DBLite', $options));
    }

    /**
     * Creates a user instance
     *
     * @access protected
     * @return Sabai_User_Identity
     * @param string $name
     */
    function &_getUserIdentity($name)
    {
        $id = $this->_auth->getAuthData('uid');
        $identity =& new Sabai_User_Identity($id);
        $identity->setName($name);
        $identity->setEmail($this->_auth->getAuthData('email'));
        $identity->setProfileURL(XOOPS_URL . '/userinfo.php?uid=' . $id);
        $identity->setURL($this->_auth->getAuthData('url'));
        $identity->setImage(XOOPS_URL . '/uploads/' . $this->_auth->getAuthData('user_avatar'));
        return $identity;
    }
}