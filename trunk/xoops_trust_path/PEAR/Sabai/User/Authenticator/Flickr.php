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
 * Sabai_User_Authenticator
 */
require_once 'Sabai/User/Authenticator.php';
/**
 * phpFlickr
 */
require_once SABAI_PATH_LIB . '/phpFlickr/phpFlickr.php';

/**
 * Authenticates Flickr users
 *
 * Authenticates Flickr users
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
class Sabai_User_Authenticator_Flickr extends Sabai_User_Authenticator
{
    /**
     * @access protected
     * @var string
     */
    var $_apiKey;
    /**
     * @access protected
     * @var string
     */
    var $_apiSecret;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $apiSecret
     * @return Sabai_User_Authenticator_Flickr
     */
    function Sabai_User_Authenticator_Flickr($apiKey, $apiSecret)
    {
        $this->_apiKey = $apiKey;
        $this->_apiSecret = $apiSecret;
    }

    /**
     * Authenticates a user
     *
     * @param Sabai_Request $request
     * @return Sabai_User_Identity on success, false on failure
     */
    function &authenticate(&$request)
    {
        $flickr_api =& new phpFlickr($this->_apiKey, $this->_apiSecret);
        if (!$frob = $request->getAsStr('frob', false)) {
            // auth() will return perms when already authenticated with phpFlickr, otherwise redirected to flickr site
            if ($perms = $flickr_api->auth()) {
                if (false === $auth_token = $flickr_api->auth_checkToken()) {
                    return false;
                }
            }
        } else {
            if (false === $auth_token = $flickr_api->auth_getToken($frob)) {
                return false;
            }
	    }
	    $identity =& new Sabai_User_Identity($auth_token['user']['nsid']);
        $identity->setName($auth_token['user']['username']);
        return $identity;
    }

    /**
     * Deauthenticates a user
     *
     */
    function deauthenticate()
    {
        unset($_SESSION['phpFlickr_auth_token']);
    }
}