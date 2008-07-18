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
 * Sabai_Token
 */
require_once 'Sabai/Token.php';

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
class Sabai_Validator_Token extends Sabai_Validator
{
    var $_tokenID;
    var $_tokenSalt;
    var $_tokenLifeTime;

    /**
     * Constructor
     *
     * @return Sabai_Validator_Email
     */
    function Sabai_Validator_Token($tokenID, $tokenLifeTime = 1800, $tokenSalt = SABAI_TOKEN_SALT)
    {
        $this->_tokenID = $tokenID;
        $this->_tokenLifeTime = $tokenLifeTime;
        $this->_tokenSalt = $tokenSalt;
    }

    function validate($value)
    {
        if (false === $token =& Sabai_Token::exists($this->_tokenID)) {
            Sabai_Log::info(sprintf('Invalid token %s requested', $this->_tokenID), __FILE__, __LINE__);
            return false;
        }
        Sabai_Token::destroy($this->_tokenID);
        if ($token->getTimestamp() + $this->_tokenLifeTime < time()) {
            Sabai_Log::info(sprintf('Token %s already expired', $this->_tokenID), __FILE__, __LINE__);
            return false;
        }
        $token->salt($this->_tokenSalt);
        if ($token->getValue() != $value) {
            Sabai_Log::info('Failed validating token', __FILE__, __LINE__);
            return false;
        }
        return true;
    }
}