<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Validator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.5
*/

/**
 * Sabai_Validator
 */
require_once 'Sabai/Validator.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Validator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.5
 */
class Sabai_Validator_Callback extends Sabai_Validator
{
    /**
     * @var mixed
     * @access protected
     */
    var $_callback;
    /**
     * Extra parameters passed to the callback function
     *
     * @var array
     */
    var $_callbackParams;

    /**
     * Constructor
     *
     * @param mixed $callback string or array
     * @param array $callbackParams
     * @return Sabai_Validator_Callback
     */
    function Sabai_Validator_Callback($callback, $callbackParams = array())
    {
        $this->_callback = $callback;
        $this->_callbackParams = $callbackParams;
    }

    /**
     * Validates a value
     *
     * @param string $value
     * @return bool
     */
    function validate($value)
    {
        return call_user_func_array($this->_callback, array_merge(array($value), $this->_callbackParams));
    }
}