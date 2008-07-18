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
 * @since      File available since Release 0.1.5
*/

/**
 * Sabai_User_Authenticator
 */
require_once 'Sabai/User/Authenticator.php';

/**
 * Authenticates OpenID users
 *
 * Authenticates OpenID users
 *
 * @category   Sabai
 * @package    Sabai_User
 * @subpackage Authenticator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.5
 */
class Sabai_User_Authenticator_OpenID extends Sabai_User_Authenticator
{
    /**
     * @access protected
     * @var string
     */
    var $_storePath;
    var $_randSource;
    var $_identityURLVar;
    var $_returnURL;
    var $_showFormFunc;

    /**
     * Constructor
     *
     * @param string $storePath
     * @param string $randSource
     * @param string $identityURLVar
     * @return Sabai_User_Authenticator_OpenID
     */
    function Sabai_User_Authenticator_OpenID($storePath, $randSource = '/dev/urandom', $identityURLVar = 'openid_url')
    {
        $this->_storePath = $storePath;
        $this->_randSource = $randSource;
        $this->_identityURLVar = $identityURLVar;
    }

    function setReturnURL($returnURL)
    {
        $this->_returnURL = $returnURL;
    }

    function setShowFormFunc($showFormFunc)
    {
        $this->_showFormFunc = $showFormFunc;
    }

    /**
     * Authenticates a user
     *
     * @param Sabai_Request $request
     * @return mixed Sabai_User_Identity on success, false or null on failure
     */
    function &authenticate(&$request)
    {
        if ($request->isPost()) {
            if ($openid_url = $request->getAsStr($this->_identityURLVar, false)) {
                $openid_consumer =& $this->_getConsumer();
                if ($openid_request = $openid_consumer->begin($openid_url)) {
                    $return_url = isset($this->_returnURL) ? $this->_returnURL : $request->getUri();
                    $redirect_url = $openid_request->redirectURL($request->getScriptUriDir(), $return_url);
                    header('Location: ' . $redirect_url);
                    exit;
                }
            }
        } else {
            $openid_consumer =& $this->_getConsumer();
            $openid_response = $openid_consumer->complete($request->getAll());
            if ($openid_response->status == Auth_OpenID_SUCCESS) {
                $identity =& new Sabai_User_Identity($openid_response->identity_url);
                $identity->setProfileURL($openid_response->identity_url);
                return $identity;
            }
        }
        $this->_showForm();
        $ret = false; return $ret;
    }

    function &_getConsumer()
    {
        if (!$fp = @fopen($this->_randSource, 'r')) {
            trigger_error(sprintf('%s is not readable.. using an insecure random number generator', $this->_randSource));
            define('Auth_OpenID_RAND_SOURCE', null);
        }
        require_once 'Auth/OpenID/Consumer.php';
        require_once 'Auth/OpenID/FileStore.php';
        $store =& new Auth_OpenID_FileStore($this->_storePath);
        $consumer =& new Auth_OpenID_Consumer($store);
        return $consumer;
    }

    function _showForm()
    {
        if (isset($this->_showFormFunc) && is_callable($this->_showFormFunc)) {
            call_user_func_array($this->_showFormFunc, array($this->_identityURLVar));
        } else {
            printf('<form method="post">URL:<input type="text" name="%s" value="" /><input type="submit" /></form>', $this->_identityURLVar);
        }
    }
}