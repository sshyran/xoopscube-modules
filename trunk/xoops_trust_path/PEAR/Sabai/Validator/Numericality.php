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
class Sabai_Validator_Numericality extends Sabai_Validator
{
    /**
     * Enter description here...
     *
     * @var bool
     * @access protected
     */
    var $_onlyInt;

    /**
     * Constructor
     *
     * @param bool $onlyInt
     * @return Sabai_Validator_Numericality
     */
    function Sabai_Validator_Numericality($onlyInt = false)
    {
        $this->_onlyInt = $onlyInt;
    }

    /**
     * Validates a value
     *
     * @param mixed $value
     * @return bool
     */
    function validate($value)
    {
        if ($this->_onlyInt) {
            return is_int($value);
        }
        return is_nummeric($value);
    }
}