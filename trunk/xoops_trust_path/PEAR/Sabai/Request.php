<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Request
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
 * @package    Sabai_Request
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Request
{
    /**
     * @var string
     * @access protected
     */
    var $_scriptUri;
    /**
     * @var string
     * @access protected
     */
    var $_scriptUriDir;
    /**
     * @var string
     * @access protected
     */
    var $_previousUri;
    /**
     * @var string
     * @access protected
     */
    var $_uri;
    /**
     * @var string
     * @access protected
     */
    var $_route;

    /**
     * Constructor
     *
     * @param string $scriptUri
     * @return Sabai_Request
     */
    function Sabai_Request($scriptUri)
    {
        $this->_scriptUri = $scriptUri;
        $this->_scriptUriDir = dirname($scriptUri);
        $this->_previousUri = @$_SESSION['Sabai_Request_Uri'];
        $_SESSION['Sabai_Request_Uri'] = $this->_uri = $this->_getUri();
    }

    /**
     * Gets the full URI of a script. Returns the URI of running script if no parameter.
     *
     * @param string $scriptFile
     * @return string
     */
    function getScriptUri($scriptFile = null)
    {
        return isset($scriptFile) ? $this->getScriptUriDir() . '/' . $scriptFile : $this->_scriptUri;
    }

    /**
     * Gets the directory URI of running script
     *
     * @return string
     */
    function getScriptUriDir()
    {
        return $this->_scriptUriDir;
    }

    /**
     * Gets the previously requested URI
     *
     * @return string
     */
    function getPreviousUri()
    {
        return $this->_previousUri;
    }

    /**
     * Gets the requested URI
     *
     * @return string
     */
    function getUri()
    {
        return $this->_uri;
    }

    /**
     * Gets the current route
     *
     * @abstract
     * @return string
     */
    function getRoute()
    {
        if (!isset($this->_route)) {
            $this->_route = $this->_getRoute();
        }
        return $this->_route;
    }

    /**
     * Sets a route as the current route
     *
     * @param string $route
     */
    function setRoute($route)
    {
        $this->_route = $route;
    }

    /**
     * Gets a request variable as a certain PHP type variable
     *
     * @access protected
     * @param string $type
     * @param string $name
     * @param mixed $default
     * @param array $include
     * @param array $exclude
     * @return mixed
     */
    function _getAs($type, $name, $default, $include = array(), $exclude = array())
    {
        $ret = $default;
        if ($this->_has($name)) {
            $ret = $this->_get($name);
            settype($ret, $type);
            if (!empty($exclude)) {
                if (in_array($ret, $exclude)) {
                    $ret = $default;
                }
            } elseif (!empty($include)) {
                if (!in_array($ret, $include)) {
                    $ret = $default;
                }
            }
        }
        return $ret;
    }

    /**
     * Gets a certain request variable as array
     *
     * @param string $name
     * @param array $default
     * @param array $include
     * @param array $exclude
     * @return array
     */
    function getAsArray($name, $default = array(), $include = array(), $exclude = array())
    {
        return $this->_getAs('array', $name, $default, $include, $exclude);
    }

    /**
     * Gets a certain request variable as string
     *
     * @param string $name
     * @param string $default
     * @param mixed $include
     * @param mixed $exclude
     * @return string
     */
    function getAsStr($name, $default = '', $include = null, $exclude = null)
    {
        return $this->_getAs('string', $name, $default, (array)$include, (array)$exclude);
    }

    /**
     * Gets a certain request variable as integer
     *
     * @param string $name
     * @param int $default
     * @param mixed $include
     * @param mixed $exclude
     * @return int
     */
    function getAsInt($name, $default = 0, $include = null, $exclude = null)
    {
        return $this->_getAs('integer', $name, $default, (array)$include, (array)$exclude);
    }

    /**
     * Gets a certain request variable as bool
     *
     * @param string $name
     * @param bool $default
     * @return bool
     */
    function getAsBool($name, $default = false)
    {
        return $this->_getAs('boolean', $name, $default);
    }

    /**
     * Gets a certain request variable as float
     *
     * @param string $name
     * @param float $default
     * @param mixed $include
     * @param mixed $exclude
     * @return float
     */
    function getAsFloat($name, $default = 0.0, $include = null, $exclude = null)
    {
        return $this->_getAs('float', $name, $default, (array)$include, (array)$exclude);
    }

    /**
     * Sets the value of a request parameter
     *
     * @final
     * @param string $name
     * @param mixed $value
     */
    function set($name, $value){
        $this->_set($name, $value);
    }

    /**
     * Checks if a cookie is set
     *
     * @param string $name
     * @return bool
     */
    function hasCookie($name)
    {
        return false;
    }

    /**
     * Gets a cookie variable
     *
     * @param string $name
     * @return mixed
     */
    function getCookie($name)
    {
        return null;
    }

    /**
     * Checks the request method used
     *
     * @return bool
     */
    function isPost()
    {
        return false;
    }

    /**
     * Gets all the request parameters
     *
     * @abstract
     * @return array
     */
    function getAll(){}
    /**
     * Checks if a request parameter is present
     *
     * @abstract
     * @access protected
     * @return bool
     */
    function _has($name){}
    /**
     * Gets the value of a request parameter
     *
     * @abstract
     * @access protected
     * @return mixed
     * @param string $name
     */
    function _get($name){}
    /**
     * Sets the value of a request parameter
     *
     * @abstract
     * @access protected
     * @param string $name
     * @param mixed $value
     */
    function _set($name, $value){}
    /**
     * Gets the requested route
     *
     * @abstract
     * @access protected
     * @return string
     */
    function _getRoute(){}
    /**
     * Gets the requested URI
     *
     * @abstract
     * @access protected
     * @return string
     */
    function _getUri(){}
    /**
     * Creates a URI from an array of URI parts
     *
     * @abstract
     * @return string
     * @param array $uriArray
     */
    function createUri($uriArray){}
}