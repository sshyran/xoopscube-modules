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
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Form_Element_Decorator
{
    var $_element;

    function Sabai_Form_Element_Decorator(&$element)
    {
        $this->_element =& $element;
    }

    function getName()
    {
        return $this->_element->getName();
    }

    function getValue()
    {
        return $this->_element->getValue();
    }

    function setValue($value)
    {
        $this->_element->setValue($value);
    }

    function addValidator(&$validatorHandle, $errorMsg = '')
    {
        $this->_element->addValidator($validatorHandle, $errorMsg);
    }

    function addValidationError($errorMsg)
    {
        $this->_element->addValidationError($errorMsg);
    }

    function getValidationErrors()
    {
        return $this->_element->getValidationErrors();
    }

    function validate()
    {
        $this->_element->validate();
    }

    function isValid()
    {
        return $this->_element->isValid();
    }

    function isHidden()
    {
        return $this->_element->isHidden();
    }

    function onView()
    {
        $this->_element->onView();
    }

    function getHTML($attr)
    {
        return $this->_element->getHTML($attr);
    }
}