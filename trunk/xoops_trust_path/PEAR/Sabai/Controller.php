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
 */
class Sabai_Controller
{
    /**
     * Array of global filters
     *
     * @access private
     * @var array
     */
    var $_filters = array();
    /**
     * @access protected
     * @var Sabai_Controller_Front
     */
    var $_parent;

    /**
     * Sets the parent controller
     *
     * @param Sabai_Controller_Front $controller
     */
    function setParent(&$controller)
    {
    	$this->_parent =& $controller;
    }

    /**
     * Gets the parent controller
     *
     * @return Sabai_Controller_Front
     */
    function &getParent()
    {
    	return $this->_parent;
    }

    /**
     * Adds a filter for all actions in the controller
     *
     * @param mixed $filter Sabai_Handle object or string
     */
    function addFilter($filter)
    {
        $this->_filters[] = $filter;
    }

    /**
     * Adds a filter to the first index for all actions in the controller
     *
     * @param mixed $filter Sabai_Handle object or string
     */
    function prependFilter($filter)
    {
        array_unshift($this->_filters, $filter);
    }

    /**
     * Sets filters for all actions in the controller
     *
     * @param array $filters
     */
    function setFilters($filters)
    {
        $this->_filters = $filters;
    }

    /**
     * Adds a Sabai_Handle filter object by reference, for PHP4
     *
     * @param object $filterHandle Sabai_Handle
     */
    function addFilterHandle(&$filterHandle, $perpend = false)
    {
        $this->_filters[] =& $filterHandle;
    }

    /**
     * Adds a Sabai_Handle filter object by reference, for PHP4
     *
     * @param object $filterHandle Sabai_Handle
     */
    function prependFilterHandle(&$filterHandle)
    {
        $this->_filters = array_merge(array(&$filterHandle), $this->_filters);
    }

    /**
     * Executes the controller
     *
     * @param Sabai_Controller_Context $context
     */
    function execute(&$context)
    {
        $this->_filterBefore($this->_filters, $context);
        $this->_doExecute($context);
        $this->_filterAfter(array_reverse($this->_filters), $context);
    }

    /**
     * Executes the controller
     *
     * @abstract
     * @access protected
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
    }

    /**
     * Executes pre-filters
     *
     * @access private
     * @param array $filters
     * @param Sabai_Controller_Context $context
     */
    function _filterBefore($filters, &$context)
    {
        foreach (array_keys($filters) as $i) {
            if (is_object($filters[$i])) {
                $filter =& $filters[$i]->instantiate();
                $filter->before($context);
            } else {
                $method = $filters[$i] . 'BeforeFilter';
                if (method_exists($this, $method)) {
                    $this->$method($context);
                }
            }
        }
    }

    /**
     * Executes post-filters
     *
     * @access private
     * @param array $filters
     * @param Sabai_Controller_Context $context
     */
    function _filterAfter($filters, &$context)
    {
        foreach (array_keys($filters) as $i) {
            if (is_object($filters[$i])) {
                $filter =& $filters[$i]->instantiate();
                $filter->after($context);
            } else {
                $method = $filters[$i] . 'AfterFilter';
                if (method_exists($this, $method)) {
                    $this->$method($context);
                }
            }
        }
    }
}