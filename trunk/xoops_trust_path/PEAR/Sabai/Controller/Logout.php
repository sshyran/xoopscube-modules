<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.8
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.8
 * @abstract
 */
class Sabai_Controller_Logout extends Sabai_Controller
{
    /**
     * @access protected
     * @var array
     */
    var $_successURL;
    /**
     * @access protected
     * @var string
     */
    var $_returnURLVar;
    /**
     * @access protected
     * @var string
     */
    var $_errorURL;
    /**
     * @access protected
     * @var string
     */
    var $_successMsg;
    /**
     * @access protected
     * @var string
     */
    var $_errorMsg;

    /**
     * Constructor
     *
     * @param Sabai_User_Authenticator $auth
     * @param array $successURL
     * @param string $errorURL
     * @param string $returnURLVar
     * @return Sabai_Controller_Logout
     */
    function Sabai_Controller_Logout($successURL = null, $errorURL = null, $returnURLVar = null)
    {
        $this->_successURL = $successURL;
        $this->_errorURL = $errorURL;
        $this->_returnURLVar = $returnURLVar;
        $this->_successMsg = 'You have been logged out';
        $this->_errorMsg = 'You are not logged in';
    }

    /**
     * Sets the message displayed upon successful logout
     *
     * @param string $successMsg
     */
    function setSuccessMsg($successMsg)
    {
        $this->_successMsg = $successMsg;
    }

    /**
     * Sets the message displayed upon logout error
     *
     * @param string $errorMsg
     */
    function setErrorMsg($errorMsg)
    {
        $this->_errorMsg = $errorMsg;
    }

    /**
     * Executes the action
     *
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
        if ($context->user->isAuthenticated()) {
            $success_url = $this->_successURL;
            if (isset($this->_returnURLVar)) {
                if ($url = $context->request->getAsStr($this->_returnURLVar, false)) {
                    $success_url = $url;
                }
            }
            $auth =& $this->_getAuthenticator($context);
            $auth->deauthenticate();
            $context->user->setAuthenticated(false);
            $context->user->endSession();
            $context->response->setSuccess($this->_successMsg, $success_url);
            return;
        }
        $context->response->setError($this->_errorMsg, $this->_errorURL);
    }

    /**
     * Gets an authentication object
     *
     * @abstract
     * @return Sabai_User_Authenticator
     * @param Sabai_Controller_Context $context
     */
    function &_getAuthenticator(&$context)
    {

    }
}