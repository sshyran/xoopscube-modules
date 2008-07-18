<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Decorator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Form/Decorator.php';
require_once 'Sabai/Form/Element/InputHidden.php';
require_once 'Sabai/Token.php';
require_once 'Sabai/Validator/Token.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Decorator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Form_Decorator_Token extends Sabai_Form_Decorator
{
    /**
     * @var string
     */
    var $_tokenID;
    /**
     * @var int
     */
    var $_tokenLifetime;
    /**
     * @var string
     */
    var $_tokenSalt;

    function Sabai_Form_Decorator_Token(&$form, $tokenID, $tokenLifetime = 1800, $tokenSalt = SABAI_TOKEN_SALT)
    {
        parent::Sabai_Form_Decorator($form);
        $this->_tokenID = $tokenID;
        $this->_tokenLifetime = $tokenLifetime;
        $this->_tokenSalt = $tokenSalt;
        $token_ele =& new Sabai_Form_Element_InputHidden(SABAI_TOKEN_NAME);
        $token_ele->addValidator(new Sabai_Validator_Token($tokenID, $tokenLifetime, $tokenSalt),
                                 'Failed to validate token');
        $this->addElement($token_ele);
    }

    function onView()
    {
        parent::onView();
        $this->_initToken();
    }

    function _initToken()
    {
        $token =& Sabai_Token::create($this->_tokenID);
        $token->salt($this->_tokenSalt);
        $this->setValueFor(SABAI_TOKEN_NAME, $token->getValue());
    }

    function printHTMLForToken()
    {
        $this->printHTMLFor(SABAI_TOKEN_NAME);
    }
}