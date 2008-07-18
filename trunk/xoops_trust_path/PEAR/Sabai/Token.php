<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Token
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * The name of token variables used in session
 */
define('SABAI_TOKEN_SESSION', 'Sabai_Token_');
/**
 * The name of token variable in user request
 */
if (!defined('SABAI_TOKEN_NAME')) {
    define('SABAI_TOKEN_NAME', '__T');
}

if (!defined('SABAI_TOKEN_SALT')) {
    define('SABAI_TOKEN_SALT', __FILE__);
}

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Token
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Token
{
    /**
     * @var string
     * @access protected
     */
    var $_value;
    /**
     * @var int
     * @access protected
     */
    var $_timestamp;

    /**
     * Constructor
     *
     * @access protected
     * @param string $value
     * @param int $timestamp
     * @return Sabai_Token
     */
    function Sabai_Token($value, $timestamp)
    {
        $this->_value = $value;
        $this->_timestamp = $timestamp;
    }

    /**
     * Creates a new Sabai_Token object
     *
     * @static
     * @staticvar $seeded
     * @return Sabai_Token
     * @param string $tokenID
     */
    function &create($tokenID)
    {
        static $seeded = false;
        if (!$seeded) {
            srand((double)microtime() * 100000);
            $seeded = true;
        }
        $token =& new Sabai_Token(md5(uniqid(rand(), true)), time());
        $session_key = SABAI_TOKEN_SESSION . $tokenID;
        //unset($_SESSION[SABAI_TOKEN_SESSION][$tokenID]);
        $_SESSION[$session_key] = serialize($token);
        return $token;
    }

    /**
     * Checks if a token with a certain ID exists
     *
     * @static
     * @param string $tokenID
     * @return mixed Sabai_Token if token exists, false otherwise
     */
    function &exists($tokenID)
    {
        $ret = false;
        $session_key = SABAI_TOKEN_SESSION . $tokenID;
        if (!empty($_SESSION[$session_key])) {
            $ret = unserialize($_SESSION[$session_key]);
        }
        return $ret;
    }

    /**
     * Destroys an existing token
     *
     * @static
     * @param string $tokenID
     */
    function destroy($tokenID)
    {
        $session_key = SABAI_TOKEN_SESSION . $tokenID;
        unset($_SESSION[$session_key]);
    }

    /**
     * Returns the value of this token
     *
     * @return string
     */
    function getValue()
    {
        return $this->_value;
    }

    /**
     * Returns the tiemstamp at which token was created
     *
     * @return int
     */
    function getTimestamp()
    {
        return $this->_timestamp;
    }

    /**
     * Applies salt to the value of token
     *
     * @param string $salt
     */
    function salt($salt = SABAI_TOKEN_SALT)
    {
        $this->_value =  md5($this->getValue() . $salt);
    }
}