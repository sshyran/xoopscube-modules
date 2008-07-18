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
class Sabai_Validator_Format extends Sabai_Validator
{
    /**
     * Enter description here...
     *
     * @var string
     * @access protected
     */
    var $_regex;

    /**
     * Constructor
     *
     * @param string $regex
     * @return Sabai_Validator_Format
     */
    function Sabai_Validator_Format($regex)
    {
        $this->_regex = $regex;
    }

    /**
     * Validates a value
     *
     * @param string $value
     * @return bool
     */
    function validate($value)
    {
        if (strlen($value) > 0) {
            return preg_match($this->_regex, $value);
        }
        // empty string should be validated by the Sabai_Validator_Presence
        return true;
    }
}