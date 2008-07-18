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
 * Sabai_Request
 */
require 'Sabai/Request.php';

define('SABAI_REQUEST_WEB_ROUTE_METHOD_NORMAL', 1);
define('SABAI_REQUEST_WEB_ROUTE_METHOD_PATHINFO', 2);

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
class Sabai_Request_Web extends Sabai_Request
{
    var $_pathInfo ='';
    var $_request;
    var $_cookie;
    var $_routeMethod = SABAI_REQUEST_WEB_ROUTE_METHOD_NORMAL;
    var $_routeParam = 'q';
    var $_server;

    /**
     * Constructor
     *
     * @return Sabai_Request_Web
     * @param string $scriptUri
     */
    function Sabai_Request_Web($scriptUri = null)
    {
        // Init reqeust variables.. always use a copy of global variables to avoid interference among multiple instances
        $path_info = !empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : @$_SERVER['PATH_INFO'];
        $this->_pathInfo = strtr(trim($path_info, '/'), array('<'  => '%3C', '>'  => '%3E',  "'"  => '%27', '"'  => '%22', "\r" => '', "\n" => ''));
        $this->_request = array_merge($_GET, $_POST);
        $this->_cookie = $_COOKIE;
        if (get_magic_quotes_gpc()) {
            $this->_request = Sabai_Request_Web::stripSlashes($this->_request);
            $this->_cookie = Sabai_Request_Web::stripSlashes($this->_cookie);
        }

        $scheme = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $host = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        $this->_server = $scheme . $host;

        // Init script Uri if not set
        if (!isset($scriptUri)) {
            $script_filename = strpos($_SERVER['SCRIPT_FILENAME'], 'php.cgi') ? $_SERVER['PATH_TRANSLATED'] : $_SERVER['SCRIPT_FILENAME'];
            // Is $_SERVER['DOCUMENT_ROOT'] reliable??
            $scriptUri = $this->_server . str_replace($_SERVER['DOCUMENT_ROOT'], '', $script_filename);
        }

        // Filter malicious user inputs
        $globals = array('GLOBALS', '_REQUEST', '_COOKIE', '_ENV', '_FILES', '_SERVER', '_SESSION');
        Sabai_Request_Web::filterUserData($this->_request, $globals);
        Sabai_Request_Web::filterUserData($this->_cookie, $globals);

        parent::Sabai_Request($scriptUri);
    }

    /**
     * @static
     * @param mixed $var
     */
    function stripSlashes($var)
    {
        if (is_array($var)) {
            return array_map(array(__CLASS__, __FUNCTION__), $var);
        } else {
            return stripslashes($var);
        }
    }

    /**
     * @static
     * @param mixed $var
     * @param array $globalKeys
     */
    function filterUserData(&$var, $globalKeys = array())
    {
        if (is_array($var)) {
            $var_keys = array_keys($var);
            if (array_intersect($globalKeys, $var_keys)) {
                $var = array();
            } else {
                foreach ($var_keys as $key) {
                    Sabai_Request_Web::filterUserData($var[$key], $globalKeys);
                }
            }
        } else {
            $var = str_replace("\x00", '', $var);
        }
    }

    function setRouteMethod($method, $param = 'q')
    {
        $this->_routeMethod = $method;
        $this->_routeParam = $param;
    }

    function getRouteMethod()
    {
        return $this->_routeMethod;
    }

    function getRouteParam()
    {
        return $this->_routeParam;
    }

    function getAll()
    {
        return $this->_request;
    }

    function _has($name)
    {
        return array_key_exists($name, $this->_request);
    }

    function _get($name)
    {
        return $this->_request[$name];
    }

    function _set($name, $value)
    {
        $this->_request[$name] = $value;
    }

    function hasCookie($name)
    {
        return isset($this->_cookie[$name]);
    }

    function getCookie($name)
    {
        return $this->_cookie[$name];
    }

    function isPost()
    {
        return strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0;
    }

    function _getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return $this->_server . $_SERVER['REQUEST_URI'];
        }
        switch ($this->_routeMethod) {
            case SABAI_REQUEST_WEB_ROUTE_METHOD_PATHINFO:
                $uri = $this->_scriptUri . '/' . $this->_pathInfo . '?';
                break;
            default:
                $uri = $this->_scriptUri . '?' . $this->_routeParam . '=' . urlencode($this->getAsStr($this->_routeParam)) . '&';
        }
        if (!$this->isPost()) {
            $qs = array();
            foreach ($this->getAll() as $k => $v) {
                $qs[] = urlencode($k) . '=' . urlencode($v);
            }
            $uri .= implode($qs, '&');
        }
        return $uri;
    }

    function _getRoute()
    {
        switch ($this->_routeMethod) {
            case SABAI_REQUEST_WEB_ROUTE_METHOD_PATHINFO:
                return ($this->_pathInfo != '') ? $this->_pathInfo : $this->getAsStr($this->_routeParam);
            default:
                return ($route = $this->getAsStr($this->_routeParam)) ? $route : $this->_pathInfo;
        }
    }

    /**
     * Creates a URL from an array of options.
     *
     * @param array $options
     * @return string
     */
    function createUri($options = array())
    {
        $default = array('base'     => '',
                         'params'   => array(),
                         'fragment' => '',
                         'script'   => $this->_scriptUri,
                         'query'    => array());
        $options = array_merge($default, $options);
        if (!empty($options['params'])) {
            foreach ($options['params'] as $k => $v) {
                if (is_array($v)) {
                    $k .= '[]';
                    foreach ($v as $_v) {
                        array_push($options['query'], urlencode($k) . '=' . urlencode($_v));
                    }
                } else {
                    array_push($options['query'], urlencode($k) . '=' . urlencode($v));
                }
            }
        }
        $query = implode('&amp;', $options['query']);
        switch ($this->_routeMethod) {
            case SABAI_REQUEST_WEB_ROUTE_METHOD_PATHINFO:
                $url = !empty($query) ? $options['script'] . $options['base'] . '?' . $query : $options['script'] . $options['base'];
                break;
            default:
                $url = $options['script'] . '?' . $query . '&amp;' . $this->_routeParam . '=' . urlencode($options['base']);
        }
        if (!empty($options['fragment'])) {
            return $url . '#' . $options['fragment'];
        }
        return $url;
    }
}