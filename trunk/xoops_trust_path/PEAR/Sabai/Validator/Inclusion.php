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
 * @since      File available since Release 0.1.1
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
 * @since      Class available since Release 0.1.1
 */
class Sabai_Validator_Inclusion extends Sabai_Validator
{
    /**
     * Enter description here...
     *
     * @var array
     * @access protected
     */
    var $_valuesAllowed;
    /**
     * Enter description here...
     *
     * @var bool
     * @access protected
     */
    var $_checkType;

    /**
     * Constructor
     *
     * @param array $valuesAllowed
     * @param bool $checkType
     * @return Sabai_Validator_Inclusion
     */
    function Sabai_Validator_Inclusion($valuesAllowed = array(), $checkType = false)
    {
        $this->_valuesAllowed = $valuesAllowed;
        $this->_checkType = $checkType;
    }

    /**
     * Validates a value
     *
     * @param mixed $value
     * @return bool
     */
    function validate($value)
    {
        return in_array($value, $this->_valuesAllowed, $this->_checkType);
    }
}