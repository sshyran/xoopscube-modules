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
 * @since      File available since Release 0.2.0
*/

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
 * @since      Class available since Release 0.2.0
 */
class Sabai_User_Decorator
{
    /**
     * @var Sabai_User
     * @access protected
     */
    var $_user;

    /**
     * Constructor
     *
     * @access protected
     * @param Sabai_User $user
     * @return Sabai_User_Decorator
     */
    function Sabai_User_Decorator(&$user)
    {
        $this->_user =& $user;
    }

    /**
     * Returns a string identifier of this user
     *
     * @return string
     */
    function getId()
    {
        return $this->_user->getId();
    }

    /**
     * Returns an identy object for the user
     *
     * @return Sabai_User_Identity
     */
    function &getIdentity()
    {
        $identity =& $this->_user->getIdentity();
        return $identity;
    }

    /**
     * Sets an identity object for the user
     *
     * @param Sabai_User_Identity $identity
     */
    function setIdentity(&$identity)
    {
        $this->_user->setIdentity($identity);
    }

    /**
     * Sets whether the user is authenticated or not
     *
     * @param bool $flag
     */
    function setAuthenticated($flag)
    {
        $this->_user->setAuthenticated($flag);
    }

    /**
     * Checks whether this user is authenticated
     *
     * @return bool
     */
    function isAuthenticated()
    {
        return $this->_user->isAuthenticated();
    }

    /**
     * Starts a user session
     *
     */
    function startSession()
    {
        $this->_user->startSession();
    }

    /**
     * Ends the current user session
     *
     */
    function endSession()
    {
        $this->_user->endSession();
    }

    function _shutdown()
    {
        $this->_user->_shutdown();
    }

    function hasAttribute($name)
    {
        return $this->_user->hasAttribute($name);
    }

    function getAttribute($name)
    {
        return $this->_user->getAttribute($name);
    }

    function setAttribute($name, $value)
    {
        $this->_user->setAttribute($name, $value);
    }
}