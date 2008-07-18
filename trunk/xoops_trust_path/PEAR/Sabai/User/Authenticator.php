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
 * @abstract
 */
class Sabai_User_Authenticator
{
    /**
     * Authenticates a user
     *
     * @abstract
     * @param Sabai_Request $request
     * @return Sabai_User_Identity on success, false on failure
     */
    function &authenticate(&$request){}

    /**
     * Deauthenticates a user
     *
     * @abstract
     */
    function deauthenticate(){}

    /**
     * Checks whether the authenticator has a view of its own
     *
     * @return bool
     */
    function hasView()
    {
        return true;
    }

    /**
     * Gets an authentication error message
     *
     * @return string
     */
    function getAuthError()
    {
        return '';
    }

    /**
     * Gets the username field name used in authentication
     *
     * @return string
     */
    function getAuthUsernameField()
    {
        return 'username';
    }

    /**
     * Gets the password field name used in authentication
     *
     * @return string
     */
    function getAuthPasswordField()
    {
        return 'password';
    }
}