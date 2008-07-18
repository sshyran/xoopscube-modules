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
class Sabai_Validator_Length extends Sabai_Validator
{
    /**
     * Enter description here...
     *
     * @var int
     * @access protected
     */
    var $_minLength;
    /**
     * Enter description here...
     *
     * @var int
     * @access protected
     */
    var $_maxLength;

    /**
     * Constructor
     *
     * @param int $minLength
     * @param int $maxLength
     * @return Sabai_Validator_Length
     */
    function Sabai_Validator_Length($minLength = 0, $maxLength = 0)
    {
        $this->_minLength = intval($minLength);
        $this->_maxLength = intval($maxLength);
    }

    /**
     * Validates a value
     *
     * @param string $value
     * @return bool
     */
    function validate($value)
    {
        $length = strlen($value);
        if (!empty($this->_maxLength)) {
            return  $length >= $this->_minLength && $length <= $this->_maxLength;
        }
        return $length >= $this->_minLength;
    }
}