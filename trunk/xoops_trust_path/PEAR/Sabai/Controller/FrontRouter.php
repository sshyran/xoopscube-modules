<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_FrontController
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
 * @package    Sabai_FrontController
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.8
 */
class Sabai_Controller_FrontRouter
{
    /**
     * @var string
     * @access protected
     */
    var $_controllerRegex;
    /**
     * @var array
     * @access protected
     */
    var $_routes = array();
    /**
     * @var string
     * @access protected
     */
    var $_controller;
    /**
     * @var string
     * @access protected
     */
    var $_params = array();
    /**
     * @var string
     * @access protected
     */
    var $_routeMatched = '';
    /**
     * @var string
     * @access protected
     */
    var $_forward;
    /**
     * @var string
     * @access protected
     */
    var $_file;
    /**
     * @var array
     * @access protected
     */
    var $_args;

    /**
     * Constructor
     *
     * @param string $controllerRegex
     * @return Sabai_Controller_FrontRouter
     */
    function Sabai_Controller_FrontRouter($controllerRegex = '([a-zA-Z][a-zA-Z0-9_]*)')
    {
    	$this->_controllerRegex = $controllerRegex;
    }

    /**
     * Gets the name of requested controller found in route
     *
     * @return string
     */
    function getController()
    {
        return $this->_controller;
    }

    /**
     * Gets the values of extra parameters
     *
     * @return array
     */
    function getParams()
    {
        return $this->_params;
    }

    /**
     * Returns the route matched for the request
     *
     * @return string
     */
    function getRouteMatched()
    {
        return $this->_routeMatched;
    }

    /**
     * Returns a route to forward request to
     *
     * @return string
     */
    function getForward()
    {
        return $this->_forward;
    }

    /**
     * Returns controller file path
     *
     * @return string
     */
    function getFile()
    {
        return $this->_file;
    }

    /**
     * Returns controller constructor paramters
     *
     * @return array
     */
    function getArgs()
    {
        return $this->_args;
    }

    /**
     * Adds a valid route
     *
     * @param string $routeStr
     * @param array $routeData
     */
    function setRoute($routeStr, $routeData = array())
    {
        $default = array('controller'   => null,
                         'params'       => array(),
                         'requirements' => array(),
                         'file'         => null,
                         'forward'      => null,
                         'args'         => array()
                    );
        $this->_routes[$routeStr] = array_merge($default, $routeData);
    }

    /**
     * Finds the best matched route available for the requested path
     *
     * @param string $route
     * @return bool true if route found, false otherwise
     */
    function isRoutable($route)
    {
        $route = trim($route, '/');
        $path_parts_count = count(explode('/', $route));
        if ($path_parts_count < 1) {
            // no requested route
            return false;
        }
        foreach ($this->_routes as $route_str => $route_data) {
            $route_str = trim($route_str, '/');
            $route_parts = explode('/', $route_str);
            $route_parts_count = count($route_parts);
            if ($route_parts_count > $path_parts_count) {
                // defined route string is longer than pathinfo
                continue;
            }
            $regex_parts = array();
            foreach (array_keys($route_parts) as $i) {
                if (0 === strpos($route_parts[$i], ':')) {
                    if (!empty($route_data['requirements'][$route_parts[$i]])) {
                        $regex_parts[$i] = '(' . str_replace('#', '\#', $route_data['requirements'][$route_parts[$i]]) . ')';
                    } elseif ($route_parts[$i] == ':controller') {
                        $regex_parts[$i] = $this->_controllerRegex;
                    } else {
                        $regex_parts[$i] = '([a-zA-Z0-9~\s\.:_\-]+)';
                    }
                } else {
                    $regex_parts[$i] = '(' . $route_parts[$i] . ')';
                }
            }
            $regex = implode('/', $regex_parts);
            if (preg_match('#^' . $regex . '/#i', $route . '/', $matches)) {
                // get the route that matched
                $this->_routeMatched = trim(array_shift($matches), '/');
                $this->_forward = isset($route_data['forward']) ? $route_data['forward'] : '';
                Sabai_Log::info(sprintf('Route %s matched with requested path %s', $regex, $route), __FILE__, __LINE__);
                for ($i = 0; $i < $route_parts_count; $i++) {
                    // :controller is handled differently
                    if ($route_parts[$i] == ':controller') {
                        $this->_controller = $matches[$i];
                    } elseif (0 === strpos($route_parts[$i], ':')) {
                        $this->_params[str_replace(':', '', $route_parts[$i])] = $matches[$i];
                        $this->_forward = str_replace($route_parts[$i], $matches[$i], $this->_forward);
                    }
                }
                $this->_controller = $route_data['controller'];
                foreach ($route_data['params'] as $name => $value) {
                    $this->_params[$name] = $value;
                }
                $this->_file = $route_data['file'];
                $this->_args = $route_data['args'];
                return true;
            }
        }
        return false;
    }
}