<?php
/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @link
 * @since      Class available since Release 0.1.9a3
 */
class Sabai_Controller_Context
{
    /**
     * @access private
     * @var array
     */
    var $_context = array();

    /**
     * Constructor for PHP4 only
     *
     * @param array $context
     * @return Sabai_Controller_Context
     */
    function Sabai_Controller_Context($context = array())
    {
        foreach (array_keys($context) as $k) {
            $this->set($k, $context[$k]);
        }
    }

    /**
     * PHP magic __get() method
     *
     * @param string $name
     * @return mixed
     */
    function __get($name)
    {
        if (array_key_exists($name, $this->_context)) {
            return $this->_context[$name];
        }
        return null;
    }

    /**
     * PHP magic method
     *
     * @param string $name
     * @param bool
     */
    function __isset($name)
    {
        return isset($this->_context[$name]);
    }

    /**
     * PHP magic method
     *
     * @param string $name
     */
    function __unset($name)
    {
        unset($this->_context[$name]);
    }

    function set($name, &$object)
    {
        $this->_context[$name] =& $object;
        if (!is_php5()) {
            $this->$name =& $object;
        }
    }
}