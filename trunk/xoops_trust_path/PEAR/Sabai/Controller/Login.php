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
class Sabai_Controller_Login extends Sabai_Controller
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
    var $_successMsg;

    /**
     * Constructor
     *
     * @param array $successURL
     * @param string $returnURLVar
     * @return Sabai_Controller_Login
     */
    function Sabai_Controller_Login($successURL = null, $returnURLVar = null)
    {
        $this->_successURL = $successURL;
        $this->_returnURLVar = $returnURLVar;
        $this->_successMsg = 'You have logged in as %s';
    }

    /**
     * Sets the message displayed upon successful login
     *
     * @param string $successMsg
     */
    function setSuccessMsg($successMsg)
    {
        $this->_successMsg = $successMsg;
    }

    /**
     * Executes the login action
     *
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
        if (!$context->user->isAuthenticated()) {
            $auth =& $this->_getAuthenticator($context);
            if (!$identity =& $auth->authenticate($context->request)) {
                if (!$auth->hasView()) {
                    $uname_field = $auth->getAuthUsernameField();
                    $context->response->setVars(array(
                                                  'uname_field' => $uname_field,
                                                  'pwd_field'   => $auth->getAuthPasswordField(),
                                                  'auth_error'  => $auth->getAuthError(),
                                                  'uname'       => $context->request->getAsStr($uname_field)
                                                ));
                }
                return;
            }
            $context->user->setIdentity($identity);
            $context->user->startSession();
        }
        $success_url = $this->_successURL;
        if (isset($this->_returnURLVar)) {
            if ($url = $context->request->getAsStr($this->_returnURLVar, false)) {
                $success_url = $url;
            }
        }
        $identity =& $context->user->getIdentity();
        $context->response->setSuccess(sprintf($this->_successMsg, $identity->getName()), $success_url);
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