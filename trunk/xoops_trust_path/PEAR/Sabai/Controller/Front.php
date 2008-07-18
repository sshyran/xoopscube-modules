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
 * Sabai_Controller
 */
require_once 'Sabai/Controller.php';

/**
 * Front Controller
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
 */
class Sabai_Controller_Front extends Sabai_Controller
{
    /**
     * Name of the default controller
     *
     * @access private
     * @var string
     */
    var $_defaultController;
    /**
     * Class prefix for controllers
     *
     * @access private
     * @var string
     */
    var $_controllerPrefix;
    /**
     * Path to directory where controller class files are located
     *
     * @access private
     * @var string
     */
    var $_controllerDir;
    /**
     * Array of Sabai_Handle filter objects
     *
     * @access private
     * @var array
     */
    var $_controllerFilters = array();
    /**
     * Array of previously routed routes
     *
     * @access private
     * @var array
     */
    var $_usedRoutes = array();
    /**
     * Front router
     *
     * @var Sabai_Controller_Front_Router
     */
    var $_router;

    /**
     * Constructor
     *
     * @param string $defaultController
     * @param string $controllerPrefix
     * @param string $controllerDir
     * @return Sabai_Controller_Front
     */
    function Sabai_Controller_Front($defaultController, $controllerPrefix, $controllerDir)
    {
        $this->_defaultController = $defaultController;
        $this->_controllerPrefix = $controllerPrefix;
        $this->_controllerDir = $controllerDir;
    }

    /**
     * Adds a filter for a specific controller
     *
     * @param mixed $controllerName string or array
     * @param mixed $filter Sabai_Handle object or string
     */
    function addControllerFilter($controllerName, $filter)
    {
        foreach ((array)$controllerName as $controller_name) {
            $this->_controllerFilters[$controller_name][] = $filter;
        }
    }

    /**
     * Sets filters for a specific controller
     *
     * @param mixed $controllerName string or array
     * @param array $filters
     */
    function setControllerFilters($controllerName, $filters)
    {
        foreach ((array)$controllerName as $controller_name) {
            $this->_controllerFilters[$controller_name] = $filters;
        }
    }

    /**
     * Adds a Sabai_Handle filter object for a specific controller by reference, for PHP4
     *
     * @param mixed $controllerName string or array
     * @param object $filterHandle Sabai_Handle
     */
    function addControllerFilterHandle($controllerName, &$filterHandle)
    {
        foreach ((array)$controllerName as $controller_name) {
            $this->_controllerFilters[$controller_name][] =& $filterHandle;
        }
    }

    /**
     * Runs the controller
     *
     * @access protected
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
        $router =& $this->getRouter($context);
        if ($router->isRoutable($context->request->getRoute())) {
            $this->_usedRoutes[] = $router->getRouteMatched();
            if ($controller_name = $router->getController()) {
                foreach ($router->getParams() as $key => $value) {
                    $context->request->set($key, $value);
                }
                $this->_executeController($controller_name, $context, $router->getArgs(), $router->getFile());
            } elseif ($forward = $router->getForward()) {
                $this->_doForward($forward, $context);
            }
        } else {
            $this->_executeController($this->_defaultController, $context);
        }
    }

    /**
     * Forwards request to another route
     *
     * @param string $route
     * @param Sabai_Controller_Context $context
     * @param bool $stackContentName
     */
    function forward($route, &$context, $stackContentName = false)
    {
        Sabai_Log::info(sprintf('Forwarding request to route "%s"', $route), __FILE__, __LINE__);
        if (!$stackContentName) {
            $context->response->popContentName();
        }
        $this->_doForward($route, $context);
    }

    /**
     * Forwards request to another route
     *
     * @access private
     * @param string $route
     * @param Sabai_Controller_Context $context
     */
    function _doForward($route, &$context)
    {
        if (in_array($route, $this->_usedRoutes)) {
            trigger_error(sprintf('Recursive routing to %s detected', $route), E_USER_ERROR);
        }
        $this->_usedRoutes[] = $route;
        $context->request->setRoute($route);
        $router =& $this->getRouter($context);
        if ($router->isRoutable($route)) {
            if ($controller_name = $router->getController()) {
                foreach ($router->getParams() as $key => $value) {
                    $context->request->set($key, $value);
                }
                $this->_executeController($controller_name, $context, $router->getArgs(), $router->getFile());
            } elseif ($forward = $router->getForward()) {
                $this->_doForward($forward, $context);
            }
        } else {
            // forward to the parent controller if any
            if (isset($this->_parent)) {
                $this->_parent->forward($route, $context);
            } else {
                // use the default route if no parent
                $this->_executeController($this->_defaultController, $context);
            }
        }
    }

    /**
     * Runs the controller
     *
     * @access private
     * @param string $controllerName
     * @param Sabai_Controller_Context $context
     * @param array $controllerArgs
     * @param string $controllerFile
     */
    function _executeController($controllerName, &$context, $controllerArgs = array(), $controllerFile = null)
    {
        if (!empty($this->_controllerFilters[$controllerName])) {
            $this->_filterBefore($this->_controllerFilters[$controllerName], $context);
            $this->_doExecuteController($controllerName, $context, $controllerArgs, $controllerFile);
            $this->_filterAfter(array_reverse($this->_controllerFilters[$controllerName]), $context);
        } else {
            $this->_doExecuteController($controllerName, $context, $controllerArgs, $controllerFile);
        }
    }

    /**
     * Runs the controller if any
     *
     * @access private
     * @param string $controllerName
     * @param Sabai_Controller_Context $context
     * @param array $controllerArgs
     * @param string $controllerFile
     */
    function _doExecuteController($controllerName, &$context, $controllerArgs = array(), $controllerFile = null)
    {
        if (!empty($controllerFile)) {
            $controller_class = $controllerName;
            $controller_class_file = $controllerFile;
        } else {
            $controller_class = $this->_controllerPrefix . $controllerName;
            $controller_class_file = $this->_controllerDir . '/' . $controllerName . '.php';
        }
        $context->response->pushContentName(strtolower($controller_class));
        if (file_exists($controller_class_file)) {
            Sabai_Log::info(sprintf('Executing controller %s(%s)', $controller_class, $controller_class_file), __FILE__, __LINE__);
            require_once $controller_class_file;
            $this->_doExecuteControllerInstance($context, $controller_class, $controllerArgs);
            Sabai_Log::info(sprintf('Controller %s(%s) executed', $controllerName, $controller_class), __FILE__, __LINE__);
        }
    }

    function _doExecuteControllerInstance(&$context, $controllerClass, $controllerArgs)
    {
        if (!empty($controllerArgs)) {
            $args_str = '$controllerArgs[' . implode('], $controllerArgs[', range(0, count($controllerArgs) - 1)) . ']';
            eval("\$controller =& new $controllerClass($args_str);");
        } else {
            $controller =& new $controllerClass();
        }
        $controller->setParent($this);
        $controller->execute($context);
    }

    /**
     * Returns a Sabai_Controller_FrontRouter
     *
     * @return Sabai_Controller_FrontRouter
     * @param Sabai_Controller_Context $context
     */
    function &getRouter(&$context)
    {
        if (!isset($this->_router)) {
            $this->_router =& $this->_doGetRouter($context);
        }
        return $this->_router;
    }

    /**
     * Returns a Sabai_Controller_FrontRouter instance
     *
     * @access protected
     * @return Sabai_Controller_FrontRouter
     * @param Sabai_Controller_Context $context
     */
    function &_doGetRouter(&$context)
    {
        require_once 'Sabai/Controller/FrontRouter.php';
        $router =& new Sabai_Controller_FrontRouter();
        foreach ($this->_getRoutes($context) as $routeStr => $routeData) {
            $router->setRoute($routeStr, $routeData);
        }
        return $router;
    }

    /**
     * Returns all route data for the default router as an associative array
     *
     * @access protected
     * @return array
     * @param Sabai_Controller_Context $context
     */
    function _getRoutes(&$context)
    {
        return array();
    }
}