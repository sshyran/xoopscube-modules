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
 * Auth_JugemKey
 */
require_once SABAI_PATH_LIB . 'auth_jugemkey.php';

/**
 * Authenticats XOOPS users
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
class Sabai_User_Authenticator_JugemKey extends Sabai_User_Authenticator
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
     * @return Sabai_User_Authenticator_JugemKey
     */
    function Sabai_User_Authenticator_JugemKey($apiKey, $apiSecret)
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
        $jugemkey_api =& new Auth_JugemKey($this->_apiKey, $this->_apiSecret);
        if ($frob = $request->getAsStr('frob', false)) {
            if ($token = $jugemkey_api->getToken($frob)) {
                $identity =& new Sabai_User_Identity($token['title']);
                return $identity;
            }
        }
        header('Location: ' . $jugem_api->getLoginUrl($request->getUri()));
        exit;
    }
}