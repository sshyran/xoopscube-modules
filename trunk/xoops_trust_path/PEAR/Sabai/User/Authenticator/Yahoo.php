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
 * Authenticates Yahoo.com users
 *
 * Authenticates Yahoo.com users
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
class Sabai_User_Authenticator_Yahoo extends Sabai_User_Authenticator
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
     * @return Sabai_User_Authenticator_YahooBBAuth
     */
    function Sabai_User_Authenticator_Yahoo($apiKey, $apiSecret)
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
        if (is_php5()) {
	       require_once SABAI_PATH_LIB . '/YahooBBAuth/ybrowserauth.class.php5';
        } else {
	       require_once SABAI_PATH_LIB . '/YahooBBAuth/ybrowserauth.class.php4';
        }
        $yahoo_api =& new YBrowserAuth($this->_apiKey, $this->_apiSecret);
        if (!$token = $request->getAsStr('token', false)) {
            header('Location: ' . $yahoo_api->getAuthURL(null, true));
            exit;
        }
        $identity = false;
        if ($yahoo_api->validate_sig($request->getAsStr('ts'), $request->getAsStr('sig'))) {
            $identity =& new Sabai_User_Identity($yahoo_api->userhash);
        }
        return $identity;
    }
}