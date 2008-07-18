<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Response
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

define('SABAI_RESPONSE_ERROR', 1);
define('SABAI_RESPONSE_SUCCESS', 2);
define('SABAI_RESPONSE_CONTENT', 3);

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Response
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Response
{
    /**
     * The status of response
     *
     * @var int
     * @access private
     */
    var $_status = SABAI_RESPONSE_CONTENT;
    /**
     * An error message
     *
     * @var string
     * @access private
     */
    var $_errorMsg;
    /**
     * Uri of the error result
     *
     * @var array
     * @access private
     */
    var $_errorUri;
    /**
     * A successful result message
     *
     * @var string
     * @access private
     */
    var $_successMsg;
    /**
     * Uri of the successful result
     *
     * @var array
     * @access private
     */
    var $_successUri;
    /**
     * Names for the content
     *
     * @var array
     */
    var $_contentNames = array();
    /**
     * Content variables
     *
     * @var array
     * @access private
     */
    var $_vars = array();
    /**
     * Predefined content variables that can not be overwritten
     *
     * @var array
     * @access private
     */
    var $_predefinedVars = array();
    /**
     * Contents to display on next response
     *
     * @var array
     * @access private
     */
    var $_flash = array();

    /**
     * Checks if the response status is success
     *
     * @return bool
     */
    function isSuccess()
    {
        return $this->_status == SABAI_RESPONSE_SUCCESS;
    }

    /**
     * Checks if the response status is error
     *
     * @return bool
     */
    function isError()
    {
        return $this->_status == SABAI_RESPONSE_ERROR;
    }

    /**
     * Sets error data for the response
     *
     * @param string $msg
     * @param array $uri
     */
    function setError($msg, $uri = array())
    {
        $this->_errorMsg = $msg;
        $this->_errorUri = $uri;
        $this->_status = SABAI_RESPONSE_ERROR;
    }

    /**
     * Sets successful result data for the response
     *
     * @param string $msg
     * @param string $uri
     */
    function setSuccess($msg, $uri = array())
    {
        $this->_successMsg = $msg;
        $this->_successUri = $uri;
        $this->_status = SABAI_RESPONSE_SUCCESS;
    }

    /**
     * Adds the name of content
     *
     * @param mixed $contentName string or array
     */
    function pushContentName($contentName)
    {
        array_unshift($this->_contentNames, $contentName);
    }

    /**
     * Removes the last content name
     *
     * @return mixed string or array
     */
    function popContentName()
    {
        return array_shift($this->_contentNames);
    }

    /**
     * Sets the value of a variable to be used in content
     *
     * @param string $name
     * @param mized $value
     */
    function setVar($name, $value)
    {
        $this->_vars[$name] = $value;
    }

    /**
     * Sets a variable to be used in content via reference
     *
     * @param string $name
     * @param mixed $value
     */
    function setVarRef($name, &$value)
    {
        $this->_vars[$name] =& $value;
    }

    /**
     * Sets multiple content variables in one call
     *
     * @param array $vars
     */
    function setVars($vars = array())
    {
        $this->_vars = array_merge($this->_vars, $vars);
    }

    /**
     * Sets multiple predefined content variables in one call
     *
     * @param array $vars
     */
    function setPredefinedVars($vars = array())
    {
        $this->_predefinedVars = array_merge($this->_predefinedVars, $vars);
    }

    /**
     * Gets all content variables already set
     *
     * @return array
     */
    function getVars()
    {
        return $this->_vars;
    }

    /**
     * Sends a response according to its status
     *
     * @param Sabai_Request $request
     */
    function send(&$request)
    {
        switch ($this->_status) {
            case SABAI_RESPONSE_ERROR:
                $this->_sendError($request, $this->_errorMsg, $this->_errorUri);
                Sabai_Log::info(sprintf('An error occured: %s', $this->_errorMsg));
                break;
            case SABAI_RESPONSE_SUCCESS:
                $this->_sendSuccess($request, $this->_successMsg, $this->_successUri);
                break;
            case SABAI_RESPONSE_CONTENT:
            default:
                // predefined vars overwrite the user defined vars
                $vars = array_merge($this->_vars, $this->_predefinedVars);
                $vars['CONTENT'] = '';
                $vars['FLASH'] = empty($_SESSION['Sabai_Response_flash']) ? array() : $_SESSION['Sabai_Response_flash'];
                $this->_sendContent($request, $this->_contentNames, $vars);
                break;
        }
        $_SESSION['Sabai_Response_flash'] = $this->_flash;
    }

    /**
     * Adds a flash message
     *
     * @param string$flashMsg
     * @param bool $isError
     */
    function addFlash($flashMsg, $isError = false)
    {
        $this->_flash[] = array('msg' => $flashMsg, 'error' => $isError);
    }

    /**
     * Sends an error response
     *
     * @abstract
     * @access protected
     * @param string $errorMsg
     * @param array $errorUri
     */
    function _sendError(&$request, $errorMsg, $errorUri){}

    /**
     * Sends a successful response
     *
     * @abstract
     * @access protected
     * @param string $successMsg
     * @param array $successUri
     */
    function _sendSuccess(&$request, $successMsg, $successUri){}

    /**
     * Sends a content response
     *
     * @abstract
     * @access protected
     * @param array $contentNames
     * @param array $vars
     */
    function _sendContent(&$request, $contentNames, $vars){}
}