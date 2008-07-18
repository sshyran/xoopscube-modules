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
 * @subpackage Validator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

// require_once 'Sabai/Form/Validator/Interface.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Validator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Form_Validator_Confirmation /*implements Sabai_Form_Validator_Interface*/
{
    var $_elementName;
    var $_confirmElementName;

    function Sabai_Form_Validator_Confirmation($elementName, $confirmElementName)
    {
        $this->_elementName = $elementName;
        $this->_confirmElementName = $confirmElementName;
    }

    function validate(&$form)
    {
        return $form->getValueFor($this->_elementName) == $form->getValueFor($this->_confirmElementName);
    }
}