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
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Sabai_User_Identity
 */
require 'Sabai/User/Identity.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_User
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_User
{
    /**
     * @var Sabai_User_Identity
     * @access protected
     */
    var $_identity;
    /**
     * @access protected
     * @var bool
     */
    var $_authenticated;
    /**
     * @access protected;
     * @var bool;
     */
    var $_sessionActive = false;
    /**
     * @access protected
     * @var array
     */
    var $_attributes = array();

    /**
     * Constructor
     *
     * @access protected
     * @param Sabai_User_Identity $identity
     * @param bool $authenticated
     * @return Sabai_User
     */
    function Sabai_User(&$identity, $authenticated = false)
    {
        $this->_identity =& $identity;
        $this->setAuthenticated($authenticated);
    }

    /**
     * Returns the current logged in user
     *
     * @static
     * @return Sabai_User
     */
    function &getCurrentUser($guestName = 'Guest', $guestId = '')
    {
        if (!$user =& Sabai_User::hasCurrentUser()) {
            $identity =& new Sabai_User_Identity($guestId);
            $identity->setName($guestName);
            $user =& new Sabai_User($identity, false);
        }
        return $user;
    }

    /**
     * Checks if an user object already exists in current session
     *
     * @static
     * @return mixed Sabai_User if exists, false if not
     */
    function &hasCurrentUser()
    {
        $user = false;
        if (!empty($_SESSION['Sabai_User'])) {
            if (!$user = unserialize($_SESSION['Sabai_User'])) {
                unset($_SESSION['Sabai_User']);
            } else {
                register_shutdown_function(array(&$user, '_shutdown'));
            }
        }
        return $user;
    }

    /**
     * Returns a string identifier of this user
     *
     * @return string
     */
    function getId()
    {
        return $this->_identity->getId();
    }

    /**
     * Returns an identy object for the user
     *
     * @return Sabai_User_Identity
     */
    function &getIdentity()
    {
        return $this->_identity;
    }

    /**
     * Sets an identity object for the user
     *
     * @param Sabai_User_Identity $identity
     */
    function setIdentity(&$identity)
    {
        $this->_identity =& $identity;
    }

    /**
     * Sets whether the user is authenticated or not
     *
     * @param bool $flag
     */
    function setAuthenticated($flag)
    {
        $this->_authenticated = (bool)$flag;
    }

    /**
     * Checks whether this user is authenticated
     *
     * @return bool
     */
    function isAuthenticated()
    {
        return $this->_authenticated;
    }

    /**
     * Starts a user session
     *
     */
    function startSession()
    {
        if (!$this->_sessionActive) {
            register_shutdown_function(array(&$this, '_shutdown'));
            $this->_sessionActive = true;
        }
    }

    /**
     * Ends the current user session
     *
     */
    function endSession()
    {
        $this->_sessionActive = false;
    }

    /**
     * Saves the current user object to the session
     *
     */
    function _shutdown()
    {
        if ($this->isAuthenticated() && $this->_sessionActive) {
            $_SESSION['Sabai_User'] = serialize($this);
        } else {
            unset($_SESSION['Sabai_User']);
        }
    }

    /**
     * Checks if an attribute is set
     *
     * @param string $name
     * @return bool
     */
    function hasAttribute($name)
    {
        return array_key_exists($name, $this->_attributes);
    }

    /**
     * Gets a value of an attribute
     *
     * @param string $name
     * @return mixed
     */
    function getAttribute($name)
    {
        return $this->_attributes[$name];
    }

    /**
     * Sets a value of an attribute
     *
     * @param string $name
     * @param mixed $value
     */
    function setAttribute($name, $value)
    {
        $this->_attributes[$name] = $value;
    }
}