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
class Sabai_Handle_FactoryMethod extends Sabai_Handle
{
    /**
     * @var mixed
     * @access protected
     */
    var $_factoryFunc;
    /**
     * @var array
     * @access protected
     */
    var $_params;

    /**
     * Constructor
     *
     * @param mixed $factoryFunc
     * @param array $params
     */
    function Sabai_Handle_FactoryMethod($factoryFunc, $params = array())
    {
        $this->_factoryFunc = $factoryFunc;
        $this->_params = $params;
    }

    /**
     * Creates an instance
     *
     * @return object
     */
    function &instantiate()
    {
        $params_str = '';
        if ($count = count($this->_params)) {
            $params_str = '$this->_params[' . implode('], $this->_params[', range(0, $count - 1)) . ']';
        }
        if (!is_array($this->_factoryFunc)) {
            $func = $this->_factoryFunc;
            eval("\$ret =& $func($params_str);");
        } else {
            $method = $this->_factoryFunc[1];
            if (is_object($this->_factoryFunc[0])) {
                eval("\$ret =& \$this->_factoryFunc[0]->$method($params_str);");
            } else {
                $class = $this->_factoryFunc[0];
                eval("\$ret =& $class::$method($params_str);");
            }
        }
        return $ret;
    }
}