<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Handle
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Sabai_Handle
 */
require_once 'Sabai/Handle.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Handle
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Handle_Class extends Sabai_Handle
{
    /**
     * @var string
     * @access private
     */
    var $_class;
    /**
     * @var array
     * @access protected
     */
    var $_params = array();

    /**
     * Constructor
     *
     * @param string $class
     * @param array $params
     */
    function Sabai_Handle_Class($class, $params = null)
    {
        $this->_class = strtolower($class);
        if (isset($params)) {
            $this->_params = (array)$params;
        }
    }

    /**
     * @return string
     */
    function getClass()
    {
        return $this->_class;
    }

    /**
     * Creates an instance
     *
     * @return object
     */
    function &instantiate()
    {
        $class = $this->getClass();
        $params_str = '';
        if ($count = count($this->_params)) {
            $params_str = '$this->_params[' . implode('], $this->_params[', range(0, $count - 1)) . ']';
        }
        eval("\$ret =& new $class($params_str);");
        return $ret;
    }
}